<?php

defined('TYPO3_MODE') or die();

$_EXTKEY = 'ns_gallery';

/***************
 * Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'NITSAN.NsGallery',
    'Album',
    'Album View'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'NITSAN.NsGallery',
    'Googlesearchimage',
    'Google Search View'
);

addFlexFile('nsgallery_album', 'galleryAlbum.xml');
addFlexFile('nsgallery_googlesearchimage', 'galleryGoogleImage.xml');

function addFlexFile($pluginSignature, $fileName)
{
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:ns_gallery/Configuration/FlexForms/' . $fileName);
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key,pages';
}
