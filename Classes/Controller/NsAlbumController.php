<?php
namespace NITSAN\NsGallery\Controller;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility as debug;
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
 * NsAlbumController
 */
class NsAlbumController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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
     * action list
     * 
     * @return void
     */
    public function listAction()
    {

        $makeArray = explode(",",$this->settings['records']);
        $nsAlbums = [];
        foreach ($makeArray as $key => $value) {
            $nsAlbums[] = $this->nsAlbumRepository->findByUid($value);
        }        
        $this->view->assign('nsAlbums', $nsAlbums);
        $this->makeGalleryInitilization('general');
    }
    

    /**
     * action list
     * 
     * @return void
     */
    public function googleAction()
    {       

        $makeArray = explode(",",$this->settings['records']);
        $nsAlbums = [];
        foreach ($makeArray as $album) {
            $getAlbums = $this->nsAlbumRepository->findByUid($album);
            foreach ($getAlbums->getMedia() as $value) {
                $nsAlbums[] = $value;
            }
        }
        $this->view->assign('nsAlbums', $nsAlbums);       
    }
   

    public function makeGalleryInitilization($gallery = ''){
        $getContentId = $this->configurationManager->getContentObject()->data['uid'];
        $this->view->assign('getContentId', $getContentId);
        switch ($gallery) {
            case 'general':
               
                $constant = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_nsgallery_album.']['settings.'];                
                $this->view->assign('constant', $constant);              
                
                $jsSettings = $this->nsAlbumRepository->setSettingsForGallery($this->settings,$constant);
                
                $this->view->assign('jsSettings', $jsSettings);
               
                $this->view->assign('mode', $mode);
                $GLOBALS['TSFE']->additionalFooterData[$this->request->getControllerExtensionKey()] .= "
                <script>
                    (function($) {
                        $(window).load(function() {                            
                            $('.nsGallery-".$getContentId."').lightGallery({
                                selector: '.ns-gallery-item',   
                                ".$jsSettings."
                                addClass:'ns-gallery-arrow--icon-circle video-not-supported',
                                download:false,
                            });
                        });
                    })(jQuery);
                </script>";
                break;
        }        
    }
}
