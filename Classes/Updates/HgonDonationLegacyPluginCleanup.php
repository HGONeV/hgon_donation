<?php

declare(strict_types=1);

namespace HGON\HgonDonation\Updates;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\ParameterType;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('hgonDonationLegacyPluginCleanup')]
final class HgonDonationLegacyPluginCleanup implements UpgradeWizardInterface, RepeatableInterface
{
    private const EXT_KEY = 'hgon_donation';

    public function getTitle(): string
    {
        return 'HGON Donation: alte Zeitspenden-/Support-Plugins loeschen';
    }

    public function getDescription(): string
    {
        return 'Entfernt veraltete Donation-Inhaltselemente fuer Zeitspenden und Support-Optionen aus tt_content.';
    }

    public function executeUpdate(): bool
    {
        $signatures = $this->getLegacyPluginSignatures();
        if ($signatures === []) {
            return true;
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tt_content');

        $queryBuilder
            ->update('tt_content')
            ->set('deleted', 1)
            ->set('tstamp', time())
            ->where(
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)),
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->in('CType', $queryBuilder->createNamedParameter($signatures, ArrayParameterType::STRING)),
                    $queryBuilder->expr()->and(
                        $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('list')),
                        $queryBuilder->expr()->in('list_type', $queryBuilder->createNamedParameter($signatures, ArrayParameterType::STRING))
                    )
                )
            )
            ->executeStatement();

        return true;
    }

    public function updateNecessary(): bool
    {
        $signatures = $this->getLegacyPluginSignatures();
        if ($signatures === []) {
            return false;
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tt_content');

        $count = $queryBuilder
            ->count('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)),
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->in('CType', $queryBuilder->createNamedParameter($signatures, ArrayParameterType::STRING)),
                    $queryBuilder->expr()->and(
                        $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('list')),
                        $queryBuilder->expr()->in('list_type', $queryBuilder->createNamedParameter($signatures, ArrayParameterType::STRING))
                    )
                )
            )
            ->executeQuery()
            ->fetchOne();

        return (int)$count > 0;
    }

    public function getPrerequisites(): array
    {
        return [];
    }

    private function getLegacyPluginSignatures(): array
    {
        $extensionName = str_replace(' ', '', ucwords(str_replace('_', ' ', self::EXT_KEY)));
        $pluginNames = [
            'Donate',
            'SupportOptions',
            'SupportOptionsLight',
            'DonationProject',
        ];

        return array_map(
            static fn (string $pluginName): string => strtolower($extensionName . '_' . $pluginName),
            $pluginNames
        );
    }
}
