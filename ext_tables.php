<?php
defined('TYPO3_MODE') || die('Access denied.');
    
    $_EXTKEY = 'ns_gallery';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ns_gallery/Configuration/TSconfig/ContentElementWizard.txt">'
    );

    if (TYPO3_MODE === 'BE') {
        $isVersion9Up = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 9000000;     
        if (!array_key_exists('nitsan', $GLOBALS['TBE_MODULES']) || $GLOBALS['TBE_MODULES']['nitsan'] =='') {
            if (version_compare(TYPO3_branch, '8.0', '>=')) {
                if (!isset($GLOBALS['TBE_MODULES']['nitsan'])) {
                    $temp_TBE_MODULES = [];
                    foreach ($GLOBALS['TBE_MODULES'] as $key => $val) {
                        if ($key == 'web') {
                            $temp_TBE_MODULES[$key] = $val;
                            $temp_TBE_MODULES['nitsan'] = '';
                        } else {
                            $temp_TBE_MODULES[$key] = $val;
                        }
                    }
                    $GLOBALS['TBE_MODULES'] = $temp_TBE_MODULES;
                    $GLOBALS['TBE_MODULES']['_configuration']['nitsan'] = [
                        'iconIdentifier' => 'module-nsgallery',
                        'labels' => 'LLL:EXT:ns_gallery/Resources/Private/Language/BackendModule.xlf',
                        'name' => 'nitsan'
                    ];
                }
            }
        }

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'NITSAN.NsGallery',
            'nitsan', // Make module a submodule of 'web'
            'nsgallery', // Submodule key
            '', // Position
            [
                'NsGalleryBackend' => 'dashboard, saveConstant, list, show, premiumExtension, appearanceSettings, fullFeedbackForm, popupSettings, commonSettings',
            ],
            [
                'access' => 'user,group',
                'icon'   => 'EXT:ns_gallery/Resources/Public/Icons/user_mod_nsgallery.svg',
                'labels' => 'LLL:EXT:ns_gallery/Resources/Private/Language/locallang_nsgallery.xlf',
                'navigationComponentId' => ($isVersion9Up ? 'TYPO3/CMS/Backend/PageTree/PageTreeElement' : 'typo3-pagetree'),
                'inheritNavigationComponentFromMainModule' => false  
            ]
        );
    }    

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsgallery_domain_model_nsalbum', 'EXT:ns_gallery/Resources/Private/Language/locallang_csh_tx_nsgallery_domain_model_nsalbum.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nsgallery_domain_model_nsalbum');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsgallery_domain_model_nsmedia', 'EXT:ns_gallery/Resources/Private/Language/locallang_csh_tx_nsgallery_domain_model_nsmedia.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nsgallery_domain_model_nsmedia');

    