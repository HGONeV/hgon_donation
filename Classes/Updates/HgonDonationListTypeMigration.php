<?php

declare(strict_types=1);

namespace HGON\HgonDonation\Updates;

use Doctrine\DBAL\ArrayParameterType;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('hgonDonationListTypeMigration')]
final class HgonDonationListTypeMigration implements UpgradeWizardInterface
{
    private const EXT_KEY = 'hgon_donation';

    public function getTitle(): string
    {
        return 'HGON Donation: list_type -> CType (erneut ausfuehrbar)';
    }

    public function getDescription(): string
    {
        return 'Migriert tt_content von list_type auf CType fuer alle HGON Donation Plugins.';
    }

    public function executeUpdate(): bool
    {
        $this->migrateListTypeToCType();
        return true;
    }

    public function updateNecessary(): bool
    {
        return $this->hasListTypeRows();
    }

    public function getPrerequisites(): array
    {
        return [];
    }

    private function migrateListTypeToCType(): void
    {
        $signatures = $this->getPluginSignatures();
        if ($signatures === []) {
            return;
        }

        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tt_content');

        foreach ($signatures as $signature) {
            $connection->executeStatement(
                'UPDATE tt_content SET CType = :ctype, list_type = :listType WHERE CType = :oldCType AND list_type = :signature',
                [
                    'ctype' => $signature,
                    'listType' => '',
                    'oldCType' => 'list',
                    'signature' => $signature,
                ]
            );
        }
    }

    private function hasListTypeRows(): bool
    {
        $signatures = $this->getPluginSignatures();
        if ($signatures === []) {
            return false;
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tt_content');

        $count = $queryBuilder
            ->count('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('list')),
                $queryBuilder->expr()->in('list_type', $queryBuilder->createNamedParameter($signatures, ArrayParameterType::STRING))
            )
            ->executeQuery()
            ->fetchOne();

        return (int)$count > 0;
    }

    private function getPluginSignatures(): array
    {
        $extensionName = str_replace(' ', '', ucwords(str_replace('_', ' ', self::EXT_KEY)));
        $pluginNames = [
            'Listing',
            'Detail',
            'BankAccountSidebar',
            'Header',
            'Sidebar',
            'Donate',
            'SupportOptions',
            'SupportOptionsLight',
        ];

        return array_map(
            static fn (string $pluginName): string => strtolower($extensionName . '_' . $pluginName),
            $pluginNames
        );
    }
}
