<?php 

return [
    'nitsan_module' => [
        'labels' => 'LLL:EXT:ns_gallery/Resources/Private/Language/BackendModule.xlf',
        'icon' => 'EXT:ns_gallery/Resources/Public/Icons/module.svg',
        'navigationComponent' => '@typo3/backend/page-tree/page-tree-element',
        'position' => ['after' => 'web'],
    ],
    'ns_gallery_configuration' => [
        'parent' => 'nitsan_module',
        'position' => ['before' => 'top'],
        'access' => 'user',
        'path' => '/module/nitsan/NsGalleryConfiguration',
        'labels' => 'LLL:EXT:ns_gallery/Resources/Private/Language/BackendModule.xlf:ns_gallery_configuration',
        'icon' => 'EXT:ns_gallery/Resources/Public/Icons/user_mod_nsgallery.svg',
        'navigationComponent' => '@typo3/backend/page-tree/page-tree-element',
        'extensionName' => 'ns_gallery',
        'routes' => [
            '_default' => [
                'target' => \NITSAN\NsGallery\Controller\NsConstantEditorController::class . '::handleRequest',
            ],
        ],
        'moduleData' => [
            'selectedTemplatePerPage' => [],
            'selectedCategory' => '',
        ],
    ],
    'ns_gallery' => [
        'parent' => 'nitsan_module',
        'position' => ['before' => 'top'],
        'access' => 'user',
        'icon'   => 'EXT:ns_gallery/Resources/Public/Icons/user_mod_nsgallery.svg',
        'labels' => 'LLL:EXT:ns_gallery/Resources/Private/Language/locallang_nsgallery.xlf',
        'path' => '/module/web/NsGallery',
        'inheritNavigationComponentFromMainModule' => false,
        'extensionName' => 'ns_gallery',
        'navigationComponent' => '@typo3/backend/page-tree/page-tree-element',
        'controllerActions' => [
            \NITSAN\NsGallery\Controller\NsGalleryBackendController::class => 'dashboard, list, show',
        ],
    ],
];


?>