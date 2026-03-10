<?php
declare(strict_types=1);
namespace NITSAN\NsGallery\Upgrades;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
/*
 * This file is part of the "NsGallery" Extension for TYPO3 CMS.
 */
#[UpgradeWizard('NsGalleryCTypeMigration')]
class NsGalleryCTypeMigration implements UpgradeWizardInterface
{
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'nsgallery_album'             => 'nsgallery_album',
            'nsgallery_googlesearchimage' => 'nsgallery_googlesearchimage',
        ];
    }
    public function getTitle(): string
    {
        return 'Migrate "NS Gallery" plugins to content elements.';
    }
    public function getDescription(): string
    {
        return 'The "NS Gallery" plugins are now registered as content elements. Update migrates existing records and backend user permissions.';
    }
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }
    public function updateNecessary(): bool
    {
        return $this->checkIfWizardIsRequired();
    }
    public function executeUpdate(): bool
    {
        return $this->performMigration();
    }
    public function checkIfWizardIsRequired(): bool
    {
        return count($this->getMigrationRecords()) > 0;
    }
    public function performMigration(): bool
    {
        $records = $this->getMigrationRecords();
        foreach ($records as $record) {
            $this->updateRow($record);
        }
        return true;
    }
    protected function hasListTypeColumn(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tt_content');
        $columns = $connection->createSchemaManager()->listTableColumns('tt_content');
        return isset($columns['list_type']);
    }
    protected function getMigrationRecords(): array
    {
        if (!$this->hasListTypeColumn()) {
            return [];
        }
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        return $queryBuilder
            ->select('uid', 'list_type', 'CType')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'CType',
                    $queryBuilder->createNamedParameter('list')
                ),
                $queryBuilder->expr()->in(
                    'list_type',
                    $queryBuilder->createNamedParameter(
                        array_keys($this->getListTypeToCTypeMapping()),
                        Connection::PARAM_STR_ARRAY
                    )
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }
    protected function updateRow(array $row): void
    {
        $mapping = $this->getListTypeToCTypeMapping();
        $newCType = $mapping[$row['list_type']] ?? $row['list_type'];
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tt_content');
        $connection->update(
            'tt_content',
            ['CType' => $newCType],
            ['uid' => (int)$row['uid']]
        );
    }
}

