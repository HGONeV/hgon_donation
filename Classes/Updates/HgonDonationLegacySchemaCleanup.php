<?php

declare(strict_types=1);

namespace HGON\HgonDonation\Updates;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('hgonDonationLegacySchemaCleanup')]
final class HgonDonationLegacySchemaCleanup implements UpgradeWizardInterface, RepeatableInterface
{
    private const LEGACY_TABLES = [
        'tx_hgondonation_domain_model_donation',
        'tx_hgondonation_domain_model_donationtypemoney',
        'tx_hgondonation_domain_model_donationtypetime',
        'tx_hgondonation_domain_model_donationplace',
    ];

    public function getTitle(): string
    {
        return 'HGON Donation: Legacy-Schema entfernen';
    }

    public function getDescription(): string
    {
        return 'Entfernt alte Donation-Verwaltungstabellen aus der Datenbankstruktur.';
    }

    public function executeUpdate(): bool
    {
        foreach (self::LEGACY_TABLES as $tableName) {
            $connection = $this->getConnection($tableName);
            if ($this->tableExists($connection, $tableName)) {
                $connection->executeStatement('DROP TABLE ' . $connection->quoteIdentifier($tableName));
            }
        }
        return true;
    }

    public function updateNecessary(): bool
    {
        foreach (self::LEGACY_TABLES as $tableName) {
            if ($this->tableExists($this->getConnection($tableName), $tableName)) {
                return true;
            }
        }
        return false;
    }

    public function getPrerequisites(): array
    {
        return [];
    }

    private function getConnection(string $tableName): Connection
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($tableName);
    }

    private function tableExists(Connection $connection, string $tableName): bool
    {
        try {
            return $connection->createSchemaManager()->tablesExist([$tableName]);
        } catch (Exception) {
            return false;
        }
    }
}
