<?php

namespace NITSAN\NsGallery\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/***
 *
 * This file is part of the "[NITSAN] Gallery" Extension for TYPO3 CMS.
 *
 * For the full copyrigsht and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 T3: Milan <sanjay@nitsan.in>, NITSAN Technologies Pvt Ltd
 *
 ***/

/**
 * The repository for NsAlbums
 */
class NsAlbumRepository extends Repository
{
    /**
     * @var array<non-empty-string, QueryInterface::ORDER_*>
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    public function initializeObject()
    {
        // get the current settings
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        // change the default setting, whether the storage page ID is ignored by the plugins (FALSE) or not (TRUE - default setting)
        $querySettings->setRespectStoragePage(false);
        // store the new setting(s)
        $this->setDefaultQuerySettings($querySettings);
    }

    public function setSettingsForGallery($settings, $constant): string
    {
        $txtSettings = '';
        if($constant) {
            foreach ($constant as $key => $value) {
                if ($key == 'controls') {
                    $txtSettings .= 'controls:' . (isset($settings[$key]) && $settings[$key] != '' ? $settings[$key] : $constant[$key]) . ',';
                }
            }
        }
        return $txtSettings;
    }
}
