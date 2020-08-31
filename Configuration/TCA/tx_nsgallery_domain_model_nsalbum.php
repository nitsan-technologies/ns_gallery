<?php
if (version_compare(TYPO3_branch, '9.0', '<')) {
    $langfile = 'LLL:EXT:lang/locallang_general.xlf:';
} else {
    $langfile = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';
}
return [
    'ctrl' => [
        'title' => 'LLL:EXT:ns_gallery/Resources/Private/Language/locallang_db.xlf:tx_nsgallery_domain_model_nsalbum',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
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
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, media',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, media, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => $langfile . 'LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        $langfile . 'LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => $langfile . 'LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_nsgallery_domain_model_nsalbum',
                'foreign_table_where' => 'AND {#tx_nsgallery_domain_model_nsalbum}.{#pid}=###CURRENT_PID### AND {#tx_nsgallery_domain_model_nsalbum}.{#sys_language_uid} IN (-1,0)',
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
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
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
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
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
                'eval' => 'trim,required'
            ],
        ],
        'media' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_gallery/Resources/Private/Language/locallang_db.xlf:tx_nsgallery_domain_model_nsalbum.media',
            'config' => [
                'type' => 'inline',
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
