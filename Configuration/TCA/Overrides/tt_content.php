<?php
defined('TYPO3') or die();

$_EXTKEY = 'ns_gallery';

/***************
 * Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'NsGallery',
    'Album',
    'Album View'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'NsGallery',
    'Googlesearchimage',
    'Google Search View'
);

$pluginsPi = [
    'nsgallery_album' => 'galleryAlbum.xml',
    'nsgallery_googlesearchimage'=> 'galleryGoogleImage.xml',
];
foreach ($pluginsPi as $listType => $pi_flexform) {
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$listType] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($listType,'FILE:EXT:ns_gallery/Configuration/FlexForms/'.$pi_flexform);
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$listType] = 'recursive,select_key,pages';
}
