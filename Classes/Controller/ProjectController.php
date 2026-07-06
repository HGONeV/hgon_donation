<?php

declare(strict_types=1);

namespace HGON\HgonDonation\Controller;

use HGON\HgonDonation\Domain\Model\Project;
use HGON\HgonDonation\Domain\Repository\ProjectRepository;
use HGON\HgonDonation\Service\ProjectLinkService;
use HGON\HgonDonation\Service\ProjectRelationService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ProjectController extends ActionController
{
    private const PROJECT_ARGUMENT_NAMESPACES = [
        'tx_hgondonation_projectdetail',
    ];

    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly ProjectLinkService $projectLinkService,
        private readonly ProjectRelationService $projectRelationService,
    ) {
    }

    public function listAction(): ResponseInterface
    {
        $projects = iterator_to_array($this->projectRepository->findAll());
        $categories = $this->projectRelationService->findCategoriesByProjects($projects);
        $projectItems = [];

        foreach ($projects as $project) {
            if (!$project instanceof Project) {
                continue;
            }

            $projectItems[] = [
                'project' => $project,
                'categories' => $categories['byProject'][(int)$project->getUid()] ?? [],
            ];
        }

        $this->view->assignMultiple([
            'projects' => $projectItems,
            'filterCategories' => $categories['filterCategories'],
        ]);

        return $this->htmlResponse();
    }

    public function showAction(?Project $project = null): ResponseInterface
    {
        if (!$project instanceof Project) {
            return $this->htmlResponse('');
        }

        $this->view->assignMultiple([
            'project' => $project,
            'donationUrl' => $this->projectLinkService->buildPayPalDonateUrl($project),
            'buttonText' => $this->projectLinkService->getButtonText($project),
            'relatedRecords' => $this->projectRelationService->findRelatedRecords($project),
        ]);

        return $this->htmlResponse();
    }

    public function buttonAction(): ResponseInterface
    {
        return $this->renderProjectTemplate();
    }

    public function teaserAction(): ResponseInterface
    {
        return $this->renderProjectTemplate();
    }

    public function headerAction(): ResponseInterface
    {
        $project = $this->resolveRequestedProject();

        if (!$project instanceof Project) {
            return $this->htmlResponse('');
        }

        $this->view->assign('project', $project);

        return $this->htmlResponse();
    }

    public function sidebarAction(): ResponseInterface
    {
        $project = $this->resolveRequestedProject();

        if (!$project instanceof Project) {
            return $this->htmlResponse('');
        }

        $this->view->assignMultiple([
            'project' => $project,
            'donationUrl' => $this->projectLinkService->buildPayPalDonateUrl($project),
            'buttonText' => $this->projectLinkService->getButtonText($project),
            'relatedRecords' => $this->projectRelationService->findRelatedRecords($project),
        ]);

        return $this->htmlResponse();
    }

    private function renderProjectTemplate(): ResponseInterface
    {
        $project = $this->resolveSelectedProject();

        if (!$project instanceof Project) {
            return $this->htmlResponse('');
        }

        $this->view->assignMultiple([
            'project' => $project,
            'donationUrl' => $this->projectLinkService->buildPayPalDonateUrl($project),
            'buttonText' => $this->projectLinkService->getButtonText($project),
        ]);

        return $this->htmlResponse();
    }

    private function resolveSelectedProject(): ?Project
    {
        return $this->findProjectByUid((int)($this->settings['project'] ?? 0));
    }

    private function resolveRequestedProject(): ?Project
    {
        if ($this->request->hasArgument('project')) {
            $project = $this->request->getArgument('project');
            if ($project instanceof Project) {
                return $project;
            }

            return $this->findProjectByUid((int)$project);
        }

        $projectUid = $this->findProjectUidInParams($this->request->getQueryParams());
        if ($projectUid > 0) {
            return $this->findProjectByUid($projectUid);
        }

        $routing = $this->request->getAttribute('routing');
        if ($routing instanceof PageArguments) {
            $projectUid = $this->findProjectUidInRouting($routing);
            if ($projectUid > 0) {
                return $this->findProjectByUid($projectUid);
            }
        }

        return null;
    }

    private function findProjectUidInRouting(PageArguments $routing): int
    {
        foreach (self::PROJECT_ARGUMENT_NAMESPACES as $pluginNamespace) {
            $projectUid = $this->findProjectUidInParams([
                $pluginNamespace => $routing->get($pluginNamespace),
            ]);
            if ($projectUid > 0) {
                return $projectUid;
            }
        }

        return (int)$routing->get('project');
    }

    private function findProjectUidInParams(array $params): int
    {
        foreach (self::PROJECT_ARGUMENT_NAMESPACES as $pluginNamespace) {
            $pluginArguments = $params[$pluginNamespace] ?? [];
            $projectUid = is_array($pluginArguments) ? (int)($pluginArguments['project'] ?? 0) : 0;
            if ($projectUid > 0) {
                return $projectUid;
            }
        }

        return (int)($params['project'] ?? 0);
    }

    private function findProjectByUid(int $projectUid): ?Project
    {
        if ($projectUid <= 0) {
            return null;
        }

        $project = $this->projectRepository->findByUid($projectUid);
        return $project instanceof Project ? $project : null;
    }

}
