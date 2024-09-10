<?php

$EM_CONF['ns_gallery'] = [
    'title' => 'All in One Gallery',
    'description' => 'Using the All In One TYPO3 Gallery Extension, you can easily create beautiful lightbox image and video galleries with various grid layouts right from the TYPO3 dashboard in just a few clicks. Try the best TYPO3 gallery extension for adding custom, unique and responsive galleries to your website.

    *** Live Demo: https://demo.t3planet.com/t3-extensions/gallery/ *** Premium Version, Documentation & Free Support: https://t3planet.com/typo3-gallery-extension',
    'category' => 'plugin',
    'author' => 'T3: Himanshu Ramavat, T3: Nilesh Malankiya, QA: Krishna Dhapa',
    'author_email' => 'sanjay@nitsan.in',
    'author_company' => 'T3Planet // NITSAN',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'version' => '13.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0-13.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'classmap' => ['Classes/']
    ]
];
