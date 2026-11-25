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

    /**
     * Allowed raw values for the lightGallery "controls" option (FlexForm + TypoScript).
     *
     * @var list<string>
     */
    private const CONTROLS_TRUE_VALUES = ['1', 'true', 'yes', 'on'];

    /**
     * @var list<string>
     */
    private const CONTROLS_FALSE_VALUES = ['0', 'false', 'no', 'off', ''];

    public function initializeObject()
    {
        // get the current settings
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        // change the default setting, whether the storage page ID is ignored by the plugins (FALSE) or not (TRUE - default setting)
        $querySettings->setRespectStoragePage(false);
        // store the new setting(s)
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * Build a safe lightGallery options fragment (e.g. "controls:true,").
     * Only boolean allow-listed values are emitted — never raw FlexForm/TS strings.
     *
     * @param array<string, mixed> $settings
     * @param array<string, mixed> $constant
     */
    public function setSettingsForGallery($settings, $constant): string
    {
        $txtSettings = '';
        if ($constant) {
            foreach ($constant as $key => $value) {
                if ($key === 'controls') {
                    $raw = (isset($settings[$key]) && $settings[$key] !== '')
                        ? $settings[$key]
                        : $constant[$key];
                    $txtSettings .= 'controls:' . ($this->normalizeControlsFlag($raw) ? 'true' : 'false') . ',';
                }
            }
        }
        return $txtSettings;
    }

    /**
     * Map FlexForm/TypoScript controls values to a boolean.
     * Unknown values default to false (safe for inline JS).
     */
    private function normalizeControlsFlag(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        if (is_int($value) || is_float($value)) {
            return (int)$value === 1;
        }

        $normalized = strtolower(trim((string)$value));
        if (in_array($normalized, self::CONTROLS_TRUE_VALUES, true)) {
            return true;
        }
        if (in_array($normalized, self::CONTROLS_FALSE_VALUES, true)) {
            return false;
        }

        return false;
    }
}
