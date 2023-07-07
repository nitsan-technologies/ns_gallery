<?php
defined('TYPO3') || die('Access denied.');

$_EXTKEY = 'ns_gallery';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ns_gallery/Configuration/TSconfig/ContentElementWizard.tsconfig">'
);

// @extensionScannerIgnoreLine
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsgallery_domain_model_nsalbum', 'EXT:ns_gallery/Resources/Private/Language/locallang_csh_tx_nsgallery_domain_model_nsalbum.xlf');
// @extensionScannerIgnoreLine
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nsgallery_domain_model_nsalbum');

// @extensionScannerIgnoreLine
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsgallery_domain_model_nsmedia', 'EXT:ns_gallery/Resources/Private/Language/locallang_csh_tx_nsgallery_domain_model_nsmedia.xlf');
// @extensionScannerIgnoreLine
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nsgallery_domain_model_nsmedia');
