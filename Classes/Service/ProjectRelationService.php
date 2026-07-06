<?php

declare(strict_types=1);

namespace HGON\HgonDonation\Service;

use Doctrine\DBAL\Exception;
use HGON\HgonDonation\Domain\Model\Project;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ProjectRelationService
{
    public function findCategoriesByProjects(array $projects): array
    {
        if (!$this->tableExists('sys_category') || !$this->tableExists('sys_category_record_mm')) {
            return [
                'byProject' => [],
                'filterCategories' => [],
            ];
        }

        $projectUids = [];
        foreach ($projects as $project) {
            if ($project instanceof Project && (int)$project->getUid() > 0) {
                $projectUids[] = (int)$project->getUid();
            }
        }

        if ($projectUids === []) {
            return [
                'byProject' => [],
                'filterCategories' => [],
            ];
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category_record_mm');
        $projectUidParameters = array_map(
            static fn (int $projectUid): string => $queryBuilder->createNamedParameter($projectUid, \TYPO3\CMS\Core\Database\Connection::PARAM_INT),
            $projectUids
        );

        $rows = $queryBuilder
            ->selectLiteral('sys_category_record_mm.uid_foreign AS project_uid')
            ->addSelect('sys_category.uid', 'sys_category.title')
            ->from('sys_category_record_mm')
            ->innerJoin(
                'sys_category_record_mm',
                'sys_category',
                'sys_category',
                $queryBuilder->expr()->eq('sys_category.uid', $queryBuilder->quoteIdentifier('sys_category_record_mm.uid_local'))
            )
            ->where(
                $queryBuilder->expr()->eq(
                    'sys_category_record_mm.tablenames',
                    $queryBuilder->createNamedParameter('tx_hgondonation_domain_model_project')
                ),
                $queryBuilder->expr()->eq(
                    'sys_category_record_mm.fieldname',
                    $queryBuilder->createNamedParameter('categories')
                ),
                $queryBuilder->expr()->in('sys_category_record_mm.uid_foreign', $projectUidParameters)
            )
            ->orderBy('sys_category.sorting', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();

        $byProject = [];
        $filterCategories = [];

        foreach ($rows as $row) {
            $category = [
                'uid' => (int)$row['uid'],
                'title' => (string)$row['title'],
            ];

            $byProject[(int)$row['project_uid']][] = $category;
            $filterCategories[(int)$row['uid']] = $category;
        }

        uasort($filterCategories, static fn (array $a, array $b): int => strcasecmp($a['title'], $b['title']));

        return [
            'byProject' => $byProject,
            'filterCategories' => $filterCategories,
        ];
    }

    public function findRelatedRecords(Project $project): array
    {
        return [
            'pages' => $this->findPages($project),
            'news' => $this->findNews($project),
            'species' => $this->findSpecies($project),
            'events' => $this->findEvents($project),
        ];
    }

    private function findPages(Project $project): array
    {
        if (!$this->tableExists('pages')) {
            return [];
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');

        return $queryBuilder
            ->select('uid', 'title', 'slug')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq(
                    'tx_hgondonation_project',
                    $queryBuilder->createNamedParameter($project->getUid(), \TYPO3\CMS\Core\Database\Connection::PARAM_INT)
                )
            )
            ->orderBy('sorting', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function findNews(Project $project): array
    {
        if (!$this->tableExists('tx_news_domain_model_news')) {
            return [];
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_news_domain_model_news');

        return $queryBuilder
            ->select('uid', 'title', 'path_segment', 'datetime')
            ->from('tx_news_domain_model_news')
            ->where(
                $queryBuilder->expr()->eq(
                    'tx_hgondonation_project',
                    $queryBuilder->createNamedParameter($project->getUid(), \TYPO3\CMS\Core\Database\Connection::PARAM_INT)
                )
            )
            ->orderBy('datetime', 'DESC')
            ->setMaxResults(5)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function findSpecies(Project $project): array
    {
        if (!$this->tableExists('tx_hgonspecies_domain_model_species')) {
            return [];
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_hgonspecies_domain_model_species');

        return $queryBuilder
            ->select('uid', 'name', 'name_science', 'record_type')
            ->from('tx_hgonspecies_domain_model_species')
            ->where(
                $queryBuilder->expr()->eq(
                    'tx_hgondonation_project',
                    $queryBuilder->createNamedParameter($project->getUid(), \TYPO3\CMS\Core\Database\Connection::PARAM_INT)
                )
            )
            ->orderBy('name', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function findEvents(Project $project): array
    {
        if (!$this->tableExists('tx_sfeventmgt_domain_model_event')) {
            return [];
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_sfeventmgt_domain_model_event');

        return $queryBuilder
            ->select('uid', 'title', 'startdate', 'enddate')
            ->from('tx_sfeventmgt_domain_model_event')
            ->where(
                $queryBuilder->expr()->eq(
                    'tx_hgondonation_project',
                    $queryBuilder->createNamedParameter($project->getUid(), \TYPO3\CMS\Core\Database\Connection::PARAM_INT)
                )
            )
            ->orderBy('startdate', 'DESC')
            ->setMaxResults(5)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function tableExists(string $tableName): bool
    {
        try {
            $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($tableName);
            return $connection->createSchemaManager()->tablesExist([$tableName]);
        } catch (Exception) {
            return false;
        }
    }
}
