<?php

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileType;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

$typo3VersionArray = VersionNumberUtility::convertVersionStringToArray(
    VersionNumberUtility::getCurrentTypo3Version(),
);

$langfile = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';

if ($typo3VersionArray['version_main'] >= 14) {
    $startTimeConfig = [
        'type' => 'datetime',
    ];
    $endTimeConfig = [
        'type' => 'datetime',
    ];
    $imageSettingsFalMedia = [
        'behaviour' => [
            'allowLanguageSynchronization' => true,
        ],
        'appearance' => [
            'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.addFileReference',
            'enabledControls' => [
                'hide' => false,
            ],
        ],
        'overrideChildTca' => [
            'types' => [
                FileType::UNKNOWN->value => [
                    'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                ],
                FileType::TEXT->value => [
                    'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                ],
                FileType::IMAGE->value => [
                    'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                ],
                FileType::AUDIO->value => [
                    'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                ],
                FileType::VIDEO->value => [
                    'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                ],
                FileType::APPLICATION->value => [
                    'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                ],
            ],
        ],
    ];
} else {
    $startTimeConfig = [
        'type' => 'input',
        'renderType' => 'datetime',
        'eval' => 'datetime',
    ];
    $endTimeConfig = [
        'type' => 'input',
        'renderType' => 'datetime',
        'eval' => 'datetime',
    ];
    $imageSettingsFalMedia = [
        'behaviour' => [
            'allowLanguageSynchronization' => true,
        ],
        'appearance' => [
            'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.addFileReference',
            'enabledControls' => [
                'hide' => false,
            ],
        ],
        'overrideChildTca' => [
            'types' => [
                File::FILETYPE_UNKNOWN => [
                    'showitem' => '
                        LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;imageoverlayPalette,
                        --palette--;;filePalette',
                ],
                File::FILETYPE_TEXT => [
                    'showitem' => '
                        LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;imageoverlayPalette,
                        --palette--;;filePalette',
                ],
                File::FILETYPE_IMAGE => [
                    'showitem' => '
                        LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;imageoverlayPalette,
                        --palette--;;filePalette',
                ],
                File::FILETYPE_AUDIO => [
                    'showitem' => '
                        LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;audioOverlayPalette,
                        --palette--;;filePalette',
                ],
                File::FILETYPE_VIDEO => [
                    'showitem' => '
                        LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;videoOverlayPalette,
                        --palette--;;filePalette',
                ],
                File::FILETYPE_APPLICATION => [
                    'showitem' => '
                        LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;imageoverlayPalette,
                        --palette--;;filePalette',
                ],
            ],
        ],
    ];
}

return [
    'ctrl' => [
        'title' => 'LLL:EXT:ns_gallery/Resources/Private/Language/locallang_db.xlf:tx_nsgallery_domain_model_nsmedia',
        'label' => 'media',
        'label_userFunc' => 'NITSAN\NsGallery\Utility\label->getObjectLabel',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'hideTable' => true,
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => '',
        'iconfile' => 'EXT:ns_gallery/Resources/Public/Icons/tx_nsgallery_domain_model_nsmedia.gif',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_diffsource, hidden, media, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => $langfile . 'LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => $langfile . 'LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => $langfile . 'LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => $langfile . 'LGL.starttime',
            'config' => [
                ...$startTimeConfig,
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => $langfile . 'LGL.endtime',
            'config' => [
                ...$endTimeConfig,
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'media' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_gallery/Resources/Private/Language/locallang_db.xlf:tx_nsgallery_domain_model_nsmedia.media',
            'config' => [
                'minitems' => 1,
                'type' => 'file',
                'appearance' => $imageSettingsFalMedia['appearance'],
                'behaviour' => $imageSettingsFalMedia['behaviour'],
                'overrideChildTca' => $imageSettingsFalMedia['overrideChildTca'],
                'allowed' => 'jpg,jpeg,png,webp,gif',
            ],
        ],
        'nsalbum' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];