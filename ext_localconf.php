<?php
defined('TYPO3') || die('Access denied.');

$_EXTKEY = 'ns_gallery';
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NsGallery',
    'Album',
    [
        \NITSAN\NsGallery\Controller\NsAlbumController::class => 'list, show',
    ],
    // non-cacheable actions
    [
        \NITSAN\NsGallery\Controller\NsAlbumController::class => 'list, show',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NsGallery',
    'Googlesearchimage',
    [
        \NITSAN\NsGallery\Controller\NsAlbumController::class => 'google',
    ],
    // non-cacheable actions
    [
        \NITSAN\NsGallery\Controller\NsAlbumController::class => '',
    ]
);

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

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
