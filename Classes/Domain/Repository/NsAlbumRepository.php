<?php

namespace NITSAN\NsGallery\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***
 *
 * This file is part of the " Gallery" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 T3: Milan <sanjay@nitsan.in>, NITSAN Technologies Pvt Ltd
 *
 ***/
/**
 * The repository for NsAlbums
 */
class NsAlbumRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
    ];

    public function setSettingsForGallery($settings, $constant)
    {
        $txtSettings = '';

        if($constant) {
            foreach ($constant as $key => $value) {
                if ($key == 'arrowIcon' || $key == 'GlobalPagingPosition' || $key == 'paginationType' || $key == 'PagingPosition') {
                } else {
                    $txtSettings .= $key . ':' . (isset($settings[$key]) && $settings[$key] != '' ? $settings[$key] : $constant[$key]) . ',';
                }
            }
        }

        return $txtSettings;
    }

}
