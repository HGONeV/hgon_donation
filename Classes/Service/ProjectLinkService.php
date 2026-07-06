<?php

declare(strict_types=1);

namespace HGON\HgonDonation\Service;

use HGON\HgonDonation\Domain\Model\Project;

class ProjectLinkService
{
    private const PAYPAL_DONATE_URL = 'https://www.paypal.com/donate';

    public function buildPayPalDonateUrl(Project $project): string
    {
        $parameters = [];

        if ($project->getHostedButtonId() !== '') {
            $parameters['hosted_button_id'] = $project->getHostedButtonId();
        }

        if ($project->getPaypalBusiness() !== '') {
            $parameters['business'] = $project->getPaypalBusiness();
            $parameters['cmd'] = '_donations';
        }

        $parameters['item_name'] = $project->getPaypalItemName() ?: $project->getTitle();
        $parameters['item_number'] = $project->getPaypalItemNumber() ?: $project->getProjectCode();
        $parameters['currency_code'] = 'EUR';
        $parameters['no_recurring'] = '0';

        if ($project->getSuggestedAmount() > 0) {
            $parameters['amount'] = number_format($project->getSuggestedAmount(), 2, '.', '');
        }

        return self::PAYPAL_DONATE_URL . '?' . http_build_query(
            array_filter($parameters, static fn ($value): bool => $value !== ''),
            '',
            '&',
            PHP_QUERY_RFC3986
        );
    }

    public function getButtonText(Project $project): string
    {
        return $project->getButtonText() ?: 'Jetzt spenden';
    }
}
