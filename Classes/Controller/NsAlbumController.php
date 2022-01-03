<?php
namespace NITSAN\NsGallery\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\Inject as inject;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;

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
/**
 * @param int $currentPage
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
     * @inject
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
     * action list
     *
     * @return void
     */
    public function listAction(int $currentPage = 1)
    {
        $response = GeneralUtility::_GP('tx_nsgallery_album');
        if(!empty($response['currentPage']))
        {
            $currentPage = $response['currentPage'];
        }
        if (version_compare(TYPO3_branch, '11.0', '>=')) {
            $version = 'custom';
        } else {
            $version = 'widget';
        }
        $makeArray = explode(',', $this->settings['records']);
        $nsAlbums = [];
        foreach ($makeArray as $key => $value) {
            $nsAlbums[] = $this->nsAlbumRepository->findByUid($value);
        }
        $arrayPaginator = new ArrayPaginator($nsAlbums, $currentPage, $this->settings['recordPerPage']);
        $pagination = new SimplePagination($arrayPaginator);
        $this->view->assignMultiple(
            [
                'nsAlbums' => $nsAlbums,
                'paginator' => $arrayPaginator,
                'pagination' => $pagination,
                'pages' => range(1, $pagination->getLastPageNumber()),
                'version' => $version,
                'action' => 'google',
            ]
        );
        $this->makeGalleryInitilization('general');
    }

    /**
     * action list
     *
     * @return void
     */
    public function googleAction(int $currentPage = 1)
    {
        $response = GeneralUtility::_GP('tx_nsgallery_googlesearchimage');
        if(!empty($response['currentPage']))
        {
            $currentPage = $response['currentPage'];
        }
        if (version_compare(TYPO3_branch, '11.0', '>=')) {
            $version = 'custom';
        } else {
            $version = 'widget';
        }
        $makeArray = explode(',', $this->settings['records']);
        $nsAlbums = [];
        foreach ($makeArray as $album) {
            $getAlbums = $this->nsAlbumRepository->findByUid($album);
            foreach ($getAlbums->getMedia() as $value) {
                foreach ($value->getMedia() as $value) {
                    $nsAlbums[] = $value;
                }
            }
        }
        $arrayPaginator = new ArrayPaginator($nsAlbums, $currentPage, $this->settings['recordPerPage']);
        $pagination = new SimplePagination($arrayPaginator);
        $this->view->assignMultiple(
            [
                'nsAlbums' => $nsAlbums,
                'paginator' => $arrayPaginator,
                'pagination' => $pagination,
                'pages' => range(1, $pagination->getLastPageNumber()),
                'version' => $version,
                'action' => 'google',
            ]
        );
    }

    public function makeGalleryInitilization($gallery = '')
    {
        $getContentId = $this->configurationManager->getContentObject()->data['uid'];
        $this->view->assign('getContentId', $getContentId);
        switch ($gallery) {
            case 'general':

                $constant = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_nsgallery_album.']['settings.'];
                $this->view->assign('constant', $constant);

                $jsSettings = $this->nsAlbumRepository->setSettingsForGallery($this->settings, $constant);

                $this->view->assign('jsSettings', $jsSettings);

                $this->view->assign('mode', $mode);
                $GLOBALS['TSFE']->additionalFooterData[$this->request->getControllerExtensionKey()] .= "
                <script>
                    (function($) {
                        $(window).on('load', function(){
                            $('.nsGallery-" . $getContentId . "').lightGallery({
                                selector: '.ns-gallery-item',   
                                " . $jsSettings . "
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
