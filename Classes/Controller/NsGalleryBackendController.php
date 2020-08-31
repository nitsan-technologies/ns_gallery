<?php
namespace NITSAN\NsGallery\Controller;

use NITSAN\NsGallery\NsConstantModule\ExtendedTemplateService;
use NITSAN\NsGallery\NsConstantModule\TypoScriptTemplateConstantEditorModuleFunctionController;
use NITSAN\NsGallery\NsConstantModule\TypoScriptTemplateModuleController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\Inject as inject;


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

    /**
     * nsAlbumRepository
     * 
     * @var \NITSAN\NsGallery\Domain\Repository\NsAlbumRepository
     * @inject
     */
    protected $nsAlbumRepository = null;

    /**
     * nsMediaRepository
     * 
     * @var \NITSAN\NsGallery\Domain\Repository\NsMediaRepository
     * @inject
     */
    protected $nsMediaRepository = null;

    /**
     * nsAlbumRepository
     * 
     * @var \NITSAN\NsGallery\Domain\Repository\NsGalleryBackendRepository
     * @inject
     */
    protected $nsGalleryBackendRepository = null;
    
    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {   
        $galleryAlbums = $this->nsAlbumRepository->findAll();     
        $assign = [
            'action' => 'list',
            'galleryAlbums' => $galleryAlbums
        ];
        $this->view->assignMultiple($assign);
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
     * @var TypoScriptTemplateModuleController
     */
    protected $pObj;

    /**
     * Initializes this object
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->contentObject = GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
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
        //Links for the All Dashboard VIEW from API...
        $sidebarUrl = 'https://composer.t3terminal.com/API/ExtBackendModuleAPI.php?extKey=ns_gallery&blockName=DashboardRightSidebar';
        $dashboardSupportUrl = 'https://composer.t3terminal.com/API/ExtBackendModuleAPI.php?extKey=ns_gallery&blockName=DashboardSupport';
        $generalFooterUrl = 'https://composer.t3terminal.com/API/ExtBackendModuleAPI.php?extKey=ns_gallery&blockName=GeneralFooter';
        $premiumExtensionUrl = 'https://composer.t3terminal.com/API/ExtBackendModuleAPI.php?extKey=ns_gallery&blockName=PremiumExtension';

        $this->nsAlbumRepository->deleteOldApiData();
        $checkApiData = $this->nsAlbumRepository->checkApiData();
        if (!$checkApiData) {
            $this->sidebarData = $this->nsAlbumRepository->curlInitCall($sidebarUrl);
            $this->dashboardSupportData = $this->nsAlbumRepository->curlInitCall($dashboardSupportUrl);
            $this->generalFooterData = $this->nsAlbumRepository->curlInitCall($generalFooterUrl);
            $this->premiumExtensionData = $this->nsAlbumRepository->curlInitCall($premiumExtensionUrl);

            $data = [
                'right_sidebar_html' => $this->sidebarData,
                'support_html'=> $this->dashboardSupportData,
                'footer_html' => $this->generalFooterData,
                'premuim_extension_html' => $this->premiumExtensionData,
                'extension_key' => 'ns_gallery',
                'last_update' => date('Y-m-d')
            ];
            $this->nsAlbumRepository->insertNewData($data);
        } else {
            $this->sidebarData = $checkApiData['right_sidebar_html'];
            $this->dashboardSupportData = $checkApiData['support_html'];
            $this->premiumExtensionData = $checkApiData['premuim_extension_html'];
        }        

        //GET CONSTANTs
        $this->constantObj->init($this->pObj);
        $this->constants = $this->constantObj->main();
    }

    /**
     * action commonSettings
     *
     * @return void
     */
    public function commonSettingsAction()
    {
        $assign = [
            'action' => 'commonSettings',
            'constant' => $this->constants
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

        $assign = [
            'action' => 'dashboard',
            'total' => count($galleryAlbums),
            'totalImage' => count($totalImage),
            'pid' => $this->pid,
            'rightSide' => $this->sidebarData,
            'dashboardSupport' => $this->dashboardSupportData,
            'report' => $report
        ];
        $this->view->assignMultiple($assign);
    }

        /**
     * action premiumExtension
     *
     * @return void
     */
    public function premiumExtensionAction()
    {
        $assign = [
            'action' => 'premiumExtension',
            'premiumExdata' => $this->premiumExtensionData
        ];
        $this->view->assignMultiple($assign);
    }
    
    /**
     * action saveConstant
     */
    public function saveConstantAction()
    {
        $this->constantObj->main();
        $returnAction = $_REQUEST['tx_nsgallery_nitsan_nsgallerynsgallery']['__referrer']['@action']; //get action name
        return false;
    }
}
