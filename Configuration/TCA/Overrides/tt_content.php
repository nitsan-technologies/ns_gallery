<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$_EXTKEY = 'ns_gallery';

/***************
 * Plugin
 */
ExtensionUtility::registerPlugin(
    'NsGallery',
    'Album',
    'Album View'
);

ExtensionUtility::registerPlugin(
    'NsGallery',
    'Googlesearchimage',
    'Google Search View'
);

$pluginsPi = [
    'nsgallery_album' => 'galleryAlbum.xml',
    'nsgallery_googlesearchimage' => 'galleryGoogleImage.xml',
];
foreach ($pluginsPi as $listType => $pi_flexform) {
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$listType] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue($listType, 'FILE:EXT:ns_gallery/Configuration/FlexForms/'.$pi_flexform);
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$listType] = 'recursive,select_key,pages';
}
