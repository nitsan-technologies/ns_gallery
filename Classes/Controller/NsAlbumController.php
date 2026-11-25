<?php

namespace NITSAN\NsGallery\Controller;

use NITSAN\NsGallery\Domain\Repository\NsAlbumRepository;
use NITSAN\NsGallery\Domain\Repository\NsMediaRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

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
        $response = $this->request->getQueryParams()['tx_nsgallery_album'] ?? [];
        if (is_array($response) && !empty($response['currentPage'])) {
            $currentPage = (int)$response['currentPage'];
        }
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $makeArray = GeneralUtility::trimExplode(',', (string)($this->settings['records'] ?? ''), true);
        $nsAlbums = [];
        foreach ($makeArray as $value) {
            $uid = (int)$value;
            if ($uid > 0) {
                $album = $this->nsAlbumRepository->findByUid($uid);
                if ($album !== null && $album->getMedia()->count() > 0) {
                    $nsAlbums[] = $album;
                }
            }
        }
        $nsAlbums = array_filter($nsAlbums, function ($value) {
            return !is_null($value);
        });
        $recordPerPage = max(1, (int)($this->settings['recordPerPage'] ?? 10));
        $arrayPaginator = new ArrayPaginator($nsAlbums, $currentPage, $recordPerPage);
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
        $response = $this->request->getQueryParams()['tx_nsgallery_googlesearchimage'] ?? [];
        if (is_array($response) && !empty($response['currentPage'])) {
            $currentPage = (int)$response['currentPage'];
        }
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $makeArray = GeneralUtility::trimExplode(',', (string)($this->settings['records'] ?? ''), true);
        $nsAlbums = [];
        foreach ($makeArray as $album) {
            $uid = (int)$album;
            if ($uid <= 0) {
                continue;
            }
            $getAlbums = $this->nsAlbumRepository->findByUid($uid);
            if (!empty($getAlbums)) {
                foreach ($getAlbums->getMedia() as $values) {
                    foreach ($values->getMedia() as $value) {
                        $nsAlbums[] = $value;
                    }
                }
            }
        }
        $recordPerPage = max(1, (int)($this->settings['recordPerPage'] ?? 10));
        $arrayPaginator = new ArrayPaginator($nsAlbums, $currentPage, $recordPerPage);
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
        $getContentId = 0;
        if ($currentContentObject instanceof ContentObjectRenderer) {
            // Public cObj record API; weak match is a false positive for GifBuilder->data.
            // @extensionScannerIgnoreLine
            $getContentId = (int)($currentContentObject->data['uid'] ?? 0);
        }
        $this->view->assign('getContentId', $getContentId);
        if ($gallery == 'general') {
            $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
            $typoScriptSetup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
            $constant = $typoScriptSetup['plugin.']['tx_nsgallery_album.']['settings.'] ?? [];
            $this->view->assign('constant', $constant);
            $jsSettings = $this->nsAlbumRepository->setSettingsForGallery($this->settings, $constant);
            $this->view->assign('jsSettings', $jsSettings);
            $assetCollector = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\AssetCollector::class);
            $assetCollector->addInlineJavaScript(
                'ns_gallery_' . $getContentId,
                '(function($) {
                    $(window).on("load", function(){
                        $(".nsGallery-' . $getContentId . '").lightGallery({
                            selector: ".ns-gallery-item",
                            ' . $jsSettings . '
                            addClass:"ns-gallery-arrow--icon-circle video-not-supported",
                            download:false,
                        });
                    });
                })(jQuery);',
                ['defer' => true]
            );
        }
    }
}
