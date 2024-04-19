<?php

defined('TYPO3_MODE') || die('Access denied.');

if (version_compare(TYPO3_branch, '10.0', '>=')) {
    $moduleClass = \NITSAN\NsGallery\Controller\NsAlbumController::class;
} else {
    $moduleClass = 'NsAlbum';
}
$_EXTKEY = 'ns_gallery';
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NITSAN.NsGallery',
    'Album',
    [
        $moduleClass => 'list, show',
    ],
    // non-cacheable actions
    [
        $moduleClass => 'list, show',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NITSAN.NsGallery',
    'Googlesearchimage',
    [
        $moduleClass => 'google',
    ],
    // non-cacheable actions
    [
        $moduleClass => '',
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
