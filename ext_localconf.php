<?php
defined('TYPO3_MODE') || die('Access denied.');

    $_EXTKEY = 'ns_gallery';
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'NITSAN.NsGallery',
        'Album',
        [
            'NsAlbum' => 'list, show',
        ],
        // non-cacheable actions
        [
            'NsAlbum' => 'list, show',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'NITSAN.NsGallery',
        'Googlesearchimage',
        [
            'NsAlbum' => 'google',
        ],
        // non-cacheable actions
        [
            'NsAlbum' => '',
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
