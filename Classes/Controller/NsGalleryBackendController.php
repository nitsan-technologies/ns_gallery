<?php

namespace NITSAN\NsGallery\Controller;

use NITSAN\NsGallery\NsConstantModule\ExtendedTemplateService;
use NITSAN\NsGallery\NsConstantModule\TypoScriptTemplateConstantEditorModuleFunctionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/***
 *
 * This file is part of the " Gallery" Extension for TYPO3 CMS.
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
class NsGalleryBackendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected $templateService;
    protected $constantObj;
    protected $constants;
    protected $contentObject = null;
    protected $pid = null;

    /**
     * @var TypoScriptTemplateConstantEditorModuleFunctionController
     */
    protected $pObj;
    /**
     * nsAlbumRepository
     *
     * @var \NITSAN\NsGallery\Domain\Repository\NsAlbumRepository
     */
    protected $nsAlbumRepository = null;

    /**
     * nsMediaRepository
     *
     * @var \NITSAN\NsGallery\Domain\Repository\NsMediaRepository
     */
    protected $nsMediaRepository = null;

    /**
     * nsAlbumRepository
     *
     * @var \NITSAN\NsGallery\Domain\Repository\NsGalleryBackendRepository
     */
    protected $nsGalleryBackendRepository = null;


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
     * @return void
     */
    public function listAction()
    {
        $bootstrapVariable = 'data';
        if (version_compare(TYPO3_branch, '11.0', '>')) {
            $bootstrapVariable = 'data-bs';
        }
        $galleryAlbums = $this->nsAlbumRepository->findAll();
        $assign = [
            'action' => 'list',
            'galleryAlbums' => $galleryAlbums,
            'bootstrapVariable' => $bootstrapVariable
        ];
        $this->view->assignMultiple($assign);
    }

    /**
     * Initializes this object
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $this->templateService = GeneralUtility::makeInstance(ExtendedTemplateService::class);
        $this->constantObj = GeneralUtility::makeInstance(TypoScriptTemplateConstantEditorModuleFunctionController::class);
    }

    /**
     * Initialize Action
     *
     * @return void
     */
    public function initializeAction()
    {
        parent::initializeAction();
        //GET CONSTANTs
        $this->constantObj->init($this->pObj);
        //@extensionScannerIgnoreLine
        $this->constants = $this->constantObj->main();
    }

    /**
     * action commonSettings
     *
     * @return void
     */
    public function commonSettingsAction()
    {
        $bootstrapVariable = 'data';
        if (version_compare(TYPO3_branch, '11.0', '>')) {
            $bootstrapVariable = 'data-bs';
        }
        $assign = [
            'action' => 'commonSettings',
            'constant' => $this->constants,
            'bootstrapVariable' => $bootstrapVariable
        ];
        $this->view->assignMultiple($assign);
    }

    /**
     * action dashboard
     *
     * @return void
     */
    public function dashboardAction()
    {
        $galleryAlbums = $this->nsAlbumRepository->findAll();
        $totalImage = $this->nsMediaRepository->findAll();
        $bootstrapVariable = 'data';
        if (version_compare(TYPO3_branch, '11.0', '>')) {
            $bootstrapVariable = 'data-bs';
        }
        $assign = [
            'action' => 'dashboard',
            'total' => count($galleryAlbums),
            'totalImage' => count($totalImage),
            'pid' => $this->pid,
            'bootstrapVariable' => $bootstrapVariable
        ];
        $this->view->assignMultiple($assign);
    }

    /**
     * action saveConstant
     */
    public function saveConstantAction()
    {
        // @extensionScannerIgnoreLine
        $this->constantObj->main();
        return false;
    }
}
