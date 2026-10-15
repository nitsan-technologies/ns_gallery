<?php

use NITSAN\NsGallery\Controller\NsAlbumController;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die('Access denied.');

$_EXTKEY = 'ns_gallery';
ExtensionUtility::configurePlugin(
    'NsGallery',
    'Album',
    [
        NsAlbumController::class => 'list, show',
    ],
    // non-cacheable actions
    [
        NsAlbumController::class => 'list, show',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT

);

ExtensionUtility::configurePlugin(
    'NsGallery',
    'Googlesearchimage',
    [
        NsAlbumController::class => 'google',
    ],
    // non-cacheable actions
    [
        NsAlbumController::class => '',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeResolver'][1791976312] = [
    'nodeName' => 'flexFormNoTabsContainer',
    'priority' => 42,
    'class' => \NITSAN\NsGallery\Form\Resolver\PremiumStripFlexFormNoTabsContainerResolver::class,
];

