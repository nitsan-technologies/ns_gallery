<?php
namespace NITSAN\NsGallery\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

/***
 *
 * This file is part of the "[NITSAN] Gallery" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 T3: Milan <sanjay@nitsan.in>, NITSAN Technologies Pvt Ltd
 *
 ***/
/**
 * NsGalleryBackendController
 */
class NsGalleryBackendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory
    ) {
    }

    /**
     * nsAlbumRepository
     *
     * @var \NITSAN\NsGallery\Domain\Repository\NsAlbumRepository
     *
     */
    protected $nsAlbumRepository = null;

    /*
     * Inject a news repository to enable DI
     *
     * @param \NITSAN\NsGallery\Domain\Repository\NsAlbumRepository $nsAlbumRepository
     * @return void
     */
    public function injectNsAlbumRepository(\NITSAN\NsGallery\Domain\Repository\NsAlbumRepository $nsAlbumRepository)
    {
        $this->nsAlbumRepository = $nsAlbumRepository;
    }

    /**
     * nsMediaRepository
     *
     * @var \NITSAN\NsGallery\Domain\Repository\NsMediaRepository
     *
     */
    protected $nsMediaRepository = null;

    /*
     * Inject a news repository to enable DI
     *
     * @param \NITSAN\NsGallery\Domain\Repository\NsMediaRepository $nsMediaRepository
     * @return void
     */
    public function injectNsMediaRepository(\NITSAN\NsGallery\Domain\Repository\NsMediaRepository $nsMediaRepository)
    {
        $this->nsMediaRepository = $nsMediaRepository;
    }

    /**
     * nsAlbumRepository
     *
     * @var \NITSAN\NsGallery\Domain\Repository\NsGalleryBackendRepository
     */
    protected $nsGalleryBackendRepository = null;

    /*
     * Inject a news repository to enable DI
     *
     * @param \NITSAN\NsGallery\Domain\Repository\NsGalleryBackendRepository $nsGalleryBackendRepository
     * @return void
     */
    public function injectNsGalleryBackendRepository(\NITSAN\NsGallery\Domain\Repository\NsGalleryBackendRepository $nsGalleryBackendRepository)
    {
        $this->nsGalleryBackendRepository = $nsGalleryBackendRepository;
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

    protected $templateService;
    protected $constantObj;
    protected $sidebarData;
    protected $dashboardSupportData;
    protected $generalFooterData;
    protected $premiumExtensionData;
    protected $constants;
    protected $contentObject = null;
    protected $pid = null;

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
        $report = isset($report) ? $report : "";
        
        $assign = [
            'action' => 'dashboard',
            'total' => count($galleryAlbums),
            'totalImage' => count($totalImage),
            'pid' => $this->pid,
            'rightSide' => $this->sidebarData,
            'dashboardSupport' => $this->dashboardSupportData,
            'report' => $report,
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
