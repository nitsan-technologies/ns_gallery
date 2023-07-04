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
    ]
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
    ]
);

$iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);

$iconRegistry->registerIcon(
    'ns_gallery-plugin-album',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:ns_gallery/Resources/Public/Icons/ns_gallery.svg']
);

$iconRegistry->registerIcon(
    'ns_gallery-plugin-googlesearchimage',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:ns_gallery/Resources/Public/Icons/ns_gallery.svg']
);
