<?php

namespace NITSAN\NsGallery\Domain\Repository;

/***
 *
 * This file is part of the "[NITSAN] Gallery" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 T3: Milan <sanjay@nitsan.in>, NITSAN Technologies Pvt Ltd
 *
 ***/
/**
 * The repository for NsMedia
 */
class NsMediaRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
    ];
}
