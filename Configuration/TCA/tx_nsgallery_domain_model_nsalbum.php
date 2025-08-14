<?php

$langfile = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';
return [
    'ctrl' => [
        'title' => 'LLL:EXT:ns_gallery/Resources/Private/Language/locallang_db.xlf:tx_nsgallery_domain_model_nsalbum',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title',
        'iconfile' => 'EXT:ns_gallery/Resources/Public/Icons/tx_nsgallery_domain_model_nsalbum.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_diffsource, hidden, title, media, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'type' => 'input',
                'renderType' => 'datetime',
                'eval' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => $langfile . 'LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'datetime',
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_gallery/Resources/Private/Language/locallang_db.xlf:tx_nsgallery_domain_model_nsalbum.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'media' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_gallery/Resources/Private/Language/locallang_db.xlf:tx_nsgallery_domain_model_nsalbum.media',
            'config' => [
                'type' => 'inline',
                'minitems' => 1,
                'foreign_table' => 'tx_nsgallery_domain_model_nsmedia',
                'foreign_field' => 'nsalbum',
                'foreign_sortby' => 'sorting',
                'maxitems' => 9999,
                'appearance' => [
                    'useSortable' => true,
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'enabledControls' => [
                        'info' => true,
                        'new' => true,
                        'dragdrop' => true,
                        'sort' => true,
                        'hide' => true,
                        'delete' => true,
                        'localize' => true,
                    ],
                ],
            ],

        ],

    ],
];
