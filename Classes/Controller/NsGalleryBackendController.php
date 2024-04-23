<?php

namespace NITSAN\NsGallery\Controller;

use NITSAN\NsGallery\Domain\Repository\NsAlbumRepository;
use NITSAN\NsGallery\Domain\Repository\NsMediaRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/***
 *
 * This file is part of the "[NITSAN] Gallery" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 T3: Himanshu Ramavat, T3: Nilesh Malankiya, QA: Krishna Dhapa <sanjay@nitsan.in>, NITSAN Technologies Pvt Ltd
 *
 ***/
/**
 * NsGalleryBackendController
 */
class NsGalleryBackendController extends ActionController
{
    /**
     * nsAlbumRepository
     *
     * @var NsAlbumRepository
     *
     */
    protected NsAlbumRepository $nsAlbumRepository;
    /**
     * nsMediaRepository
     *
     * @var NsMediaRepository
     *
     */
    protected NsMediaRepository $nsMediaRepository;
    protected ModuleTemplateFactory $moduleTemplateFactory;
    protected $pid = null;
    public function __construct(
        ModuleTemplateFactory $moduleTemplateFactory,
        NsAlbumRepository $nsAlbumRepository,
        NsMediaRepository $nsMediaRepository,
    ) {
        $this->moduleTemplateFactory = $moduleTemplateFactory;
        $this->nsAlbumRepository = $nsAlbumRepository;
        $this->nsMediaRepository = $nsMediaRepository;
    }

    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);
        $galleryAlbums = $this->nsAlbumRepository->findAll();
        $assign = [
            'action' => 'list',
            'galleryAlbums' => $galleryAlbums,
            'settings' => $this->settings
        ];
        $view->assignMultiple($assign);
        return $view->renderResponse();
    }

    /**
     * action dashboard
     *
     * @return ResponseInterface
     */
    public function dashboardAction(): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);
        $galleryAlbums = $this->nsAlbumRepository->findAll();
        $totalImage = $this->nsMediaRepository->findAll();
        $assign = [
            'action' => 'dashboard',
            'total' => count($galleryAlbums),
            'totalImage' => count($totalImage),
            'pid' => $this->pid
        ];
        $view->assignMultiple($assign);
        return $view->renderResponse();
    }

    /**
     * Generates the action menu
     */
    protected function initializeModuleTemplate(
        ServerRequestInterface $request
    ): ModuleTemplate {
        return $this->moduleTemplateFactory->create($request);
    }
}
