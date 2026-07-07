<?php

declare(strict_types=1);

namespace HGON\HgonDonation\Service;

use HGON\HgonDonation\Domain\Model\Project;

class ProjectLinkService
{
    private const PAYPAL_DONATE_URL = 'https://www.paypal.com/donate/';
    private const PAYPAL_WEBSCR_URL = 'https://www.paypal.com/cgi-bin/webscr';

    public function buildPayPalDonateUrl(Project $project, array $paymentSettings = []): string
    {
        $hostedButtonId = (string)($paymentSettings['api']['paypal']['hostedButtonId'] ?? '');
        $business = (string)($paymentSettings['api']['paypal']['business'] ?? '');

        if ($hostedButtonId !== '') {
            return self::PAYPAL_DONATE_URL . '?' . http_build_query(
                [
                    'hosted_button_id' => $hostedButtonId,
                    'locale.x' => 'de_DE',
                ],
                '',
                '&',
                PHP_QUERY_RFC3986
            );
        }

        if ($business === '') {
            return '';
        }

        $parameters = [
            'cmd' => '_donations',
            'business' => $business,
            'item_name' => $project->getPaypalItemName() ?: $project->getTitle(),
            'item_number' => $project->getPaypalItemNumber() ?: $project->getProjectCode(),
            'currency_code' => 'EUR',
            'no_recurring' => '0',
        ];

        if ($project->getSuggestedAmount() > 0) {
            $parameters['amount'] = number_format($project->getSuggestedAmount(), 2, '.', '');
        }

        return self::PAYPAL_WEBSCR_URL . '?' . http_build_query(
            array_filter($parameters, static fn ($value): bool => $value !== ''),
            '',
            '&',
            PHP_QUERY_RFC3986
        );
    }

    public function hasPayPalDonateUrl(Project $project, array $paymentSettings = []): bool
    {
        return $this->buildPayPalDonateUrl($project, $paymentSettings) !== '';
    }

    public function getButtonText(Project $project): string
    {
        return $project->getButtonText() ?: 'Jetzt spenden';
    }
}
