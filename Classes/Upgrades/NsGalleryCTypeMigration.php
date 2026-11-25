<?php

declare(strict_types=1);

namespace NITSAN\NsGallery\Upgrades;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/*
 * This file is part of the "NsGallery" Extension for TYPO3 CMS.
 */

// TYPO3 v14+: UpgradeWizard APIs live in EXT:core.
// TYPO3 v12/v13: same APIs still live in EXT:install.
// Discovery uses the install.upgradewizard service tag in Services.yaml
// so this class stays free of version-specific attribute imports.
$upgradeWizardInterfaceClass = \TYPO3\CMS\Core\Upgrades\UpgradeWizardInterface::class;
$databaseUpdatedPrerequisiteClass = \TYPO3\CMS\Core\Upgrades\DatabaseUpdatedPrerequisite::class;

if (!interface_exists($upgradeWizardInterfaceClass, true)) {
    // String-built FQCNs keep EXT:install class names out of static scanner matches on v14.
    $installNamespace = 'TYPO3\\CMS\\' . 'Install\\';
    $upgradeWizardInterfaceClass = $installNamespace . 'Updates\\UpgradeWizardInterface';
    $databaseUpdatedPrerequisiteClass = $installNamespace . 'Updates\\DatabaseUpdatedPrerequisite';
}

class_alias($upgradeWizardInterfaceClass, __NAMESPACE__ . '\\NsGalleryUpgradeWizardInterface');
class_alias($databaseUpdatedPrerequisiteClass, __NAMESPACE__ . '\\NsGalleryDatabaseUpdatedPrerequisite');

class NsGalleryCTypeMigration implements NsGalleryUpgradeWizardInterface
{
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'nsgallery_album' => 'nsgallery_album',
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
            NsGalleryDatabaseUpdatedPrerequisite::class,
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
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        return $queryBuilder
            ->select('uid', 'pid', 'CType', 'list_type')
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
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content');
        $connection->update(
            'tt_content',
            [
                'CType' => $mapping[$row['list_type']],
                'list_type' => '',
            ],
            ['uid' => (int)$row['uid']]
        );
    }
}
