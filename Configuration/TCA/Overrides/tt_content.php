<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$_EXTKEY = 'ns_gallery';

/***************
 * Plugin
 */
$pluginSignatureList=  ExtensionUtility::registerPlugin(
    'NsGallery',
    'Album',
    'Album View',
    'ns_gallery-plugin-album',
    'ns-gallery'
);


ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;plugin,pi_flexform,',
    $pluginSignatureList,
    'after:subheader',
);
// @extensionScannerIgnoreLine
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:ns_gallery/Configuration/FlexForms/galleryAlbum.xml',
    $pluginSignatureList
);

$pluginSignatureListgoogle =ExtensionUtility::registerPlugin(
    'NsGallery',
    'Googlesearchimage',
    'Google Search View',
    'ns_gallery-plugin-album',
    'ns-gallery'
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;plugin,pi_flexform,',
    $pluginSignatureListgoogle,
    'after:subheader',
);
// @extensionScannerIgnoreLine
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:ns_gallery/Configuration/FlexForms/galleryGoogleImage.xml',
    $pluginSignatureListgoogle
);