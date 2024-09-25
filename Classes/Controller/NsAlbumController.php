<?php

namespace NITSAN\NsGallery\Controller;

use NITSAN\NsGallery\Domain\Repository\NsAlbumRepository;
use NITSAN\NsGallery\Domain\Repository\NsMediaRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/***
 *
 * This file is part of the "[NITSAN] Gallery" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2023 T3: Himanshu Ramavat, T3: Nilesh Malankiya, QA: Krishna Dhapa <sanjay@nitsan.in>, NITSAN Technologies Pvt Ltd
 *
 ***/
/**
 * NsAlbumController
 */
/**
 * @param int $currentPage
 */
class NsAlbumController extends ActionController
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


    /**
     * @param NsAlbumRepository $nsAlbumRepository
     * @param NsMediaRepository $nsMediaRepository
     */
    public function __construct(
        NsAlbumRepository $nsAlbumRepository,
        NsMediaRepository $nsMediaRepository
    ) {
        $this->nsAlbumRepository = $nsAlbumRepository;
        $this->nsMediaRepository = $nsMediaRepository;
    }

    /**
     * action list
     *
     * @param int $currentPage
     * @return ResponseInterface
     */
    public function listAction(int $currentPage = 1): ResponseInterface
    {
        $response = $this->request->getQueryParams()['tx_nsgallery_album'] ?? '';
        if(!empty($response['currentPage'])) {
            $currentPage = $response['currentPage'];
        }
        $makeArray = GeneralUtility::trimExplode(',', $this->settings['records']);
        $nsAlbums = [];
        foreach ($makeArray as $value) {
            $nsAlbums[] = $this->nsAlbumRepository->findByUid($value);
        }
        $nsAlbums = array_filter($nsAlbums, function($value) {
            return !is_null($value);
        });
        $arrayPaginator = new ArrayPaginator($nsAlbums, $currentPage, (int)$this->settings['recordPerPage']);
        $pagination = new SimplePagination($arrayPaginator);
        $this->view->assignMultiple(
            [
                'paginator' => $arrayPaginator,
                'pagination' => $pagination,
                'pages' => range(1, $pagination->getLastPageNumber()),
                'nsAlbums' => $nsAlbums,
                'version' => 'custom',
                'action' => 'list',
            ]
        );
        $this->makeGalleryInitilization('general');
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @param int $currentPage
     * @return ResponseInterface
     */
    public function googleAction(int $currentPage = 1): ResponseInterface
    {
        $response = $this->request->getQueryParams()['tx_nsgallery_googlesearchimage'] ?? '';
        if(!empty($response['currentPage'])) {
            $currentPage = $response['currentPage'];
        }
        $makeArray = GeneralUtility::trimExplode(',', $this->settings['records']);
        $nsAlbums = [];
        foreach ($makeArray as $album) {
            $getAlbums = $this->nsAlbumRepository->findByUid($album);
            if (!empty($getAlbums)){
                foreach ($getAlbums->getMedia() as $values) {
                    foreach ($values->getMedia() as $value) {
                        $nsAlbums[] = $value;
                    }
                }
            }

        }
        $arrayPaginator = new ArrayPaginator($nsAlbums, $currentPage, $this->settings['recordPerPage']);
        $pagination = new SimplePagination($arrayPaginator);
        $this->view->assignMultiple(
            [
                'paginator' => $arrayPaginator,
                'pagination' => $pagination,
                'pages' => range(1, $pagination->getLastPageNumber()),
            ]
        );
        $this->view->assignMultiple(
            [
                'nsAlbums' => $nsAlbums,
                'version' => 'custom',
                'action' => 'google',
            ]
        );
        $this->makeGalleryInitilization('google');
        return $this->htmlResponse();
    }

    public function makeGalleryInitilization($gallery = ''): void
    {
        $currentContentObject = $this->request->getAttribute('currentContentObject');
        $getContentId = $currentContentObject->data['uid'];
        $this->view->assign('getContentId', $getContentId);
        if ($gallery == 'general') {
            $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
            $typoScriptSetup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
            $constant = $typoScriptSetup['plugin.']['tx_nsgallery_album.']['settings.'];
            $this->view->assign('constant', $constant);
            $jsSettings = $this->nsAlbumRepository->setSettingsForGallery($this->settings, $constant);
            $this->view->assign('jsSettings', $jsSettings);
            if (!array_key_exists(
                $this->request->getControllerExtensionKey(),
                $GLOBALS['TSFE']->additionalFooterData
            )) {
                $GLOBALS['TSFE']->additionalFooterData[$this->request->getControllerExtensionKey()] = null;
            }
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
        }
    }
}
