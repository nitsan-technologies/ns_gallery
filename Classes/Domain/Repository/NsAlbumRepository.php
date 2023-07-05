<?php
namespace NITSAN\NsGallery\Domain\Repository;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/***
 *
 * This file is part of the "[NITSAN] Gallery" Extension for TYPO3 CMS.
 *
 * For the full copyrigsht and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 T3: Milan <sanjay@nitsan.in>, NITSAN Technologies Pvt Ltd
 *
 ***/

/**
 * The repository for NsAlbums
 */
class NsAlbumRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array<non-empty-string, QueryInterface::ORDER_*>
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    public function setSettingsForGallery($settings, $constant): string
    {
        $txtSettings = '';
        if($constant) {
            foreach ($constant as $key => $value) {
                if (!$key == 'arrowIcon'
                    || !$key == 'zoomIcon'
                    || !$key == 'loadingIcon'
                    || !$key == 'GlobalPagingPosition'
                    || !$key == 'layout'
                    || !$key == 'detailPageId'
                    || !$key == 'filterPosition'
                    || !$key == 'paginationType'
                    || !$key == 'addClass'
                    || !$key == 'PagingPosition') {
                    if ($key == 'videoControls') {
                        $txtSettings .= 'controls:' . (isset($settings[$key]) && $settings[$key] !='' ? $settings[$key] : $constant[$key]) . ',';
                    } else {
                        if ($key == 'cssEasing') {
                            $keyData = isset($settings[$key]) && $settings[$key] !='' ? $settings[$key] : $constant[$key];
                            switch ($keyData) {
                                case '1':
                                  $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.250, 0.250, 0.750, 0.750)',";
                                break;
                                case '2':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.250, 0.100, 0.250, 1.000)',";
                                break;
                                case '3':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.420, 0.000, 1.000, 1.000)',";
                                break;
                                case '4':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.000, 0.000, 0.580, 1.000)',";
                                break;
                                case '5':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.420, 0.000, 0.580, 1.000)',";
                                break;
                                case '6':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.550, 0.085, 0.680, 0.530)',";
                                break;
                                case '7':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.550, 0.055, 0.675, 0.190)',";
                                break;
                                case '8':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.895, 0.030, 0.685, 0.220)',";
                                break;
                                case '9':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.755, 0.050, 0.855, 0.060)',";
                                break;
                                case '10':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.470, 0.000, 0.745, 0.715)',";
                                break;
                                case '11':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.950, 0.050, 0.795, 0.035)',";
                                break;
                                case '12':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.600, 0.040, 0.980, 0.335)',";
                                break;
                                case '13':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.600, -0.280, 0.735, 0.045)',";
                                break;
                                case '14':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.250, 0.460, 0.450, 0.940)',";
                                break;
                                case '15':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.215, 0.610, 0.355, 1.000)',";
                                break;
                                case '16':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.165, 0.840, 0.440, 1.000)',";
                                break;
                                case '17':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.230, 1.000, 0.320, 1.000)',";
                                break;
                                case '18':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.390, 0.575, 0.565, 1.000)',";
                                break;
                                case '19':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.190, 1.000, 0.220, 1.000)',";
                                break;
                                case '20':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.075, 0.820, 0.165, 1.000)',";
                                break;
                                case '21':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.175, 0.885, 0.320, 1.275)',";
                                break;
                                case '22':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.455, 0.030, 0.515, 0.955)',";
                                break;
                                case '23':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.645, 0.045, 0.355, 1.000)',";
                                break;
                                case '24':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.770, 0.000, 0.175, 1.000)',";
                                break;
                                case '25':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.860, 0.000, 0.070, 1.000)',";
                                break;
                                case '26':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.445, 0.050, 0.550, 0.950)',";
                                break;
                                case '27':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(1.000, 0.000, 0.000, 1.000)',";
                                break;
                                case '28':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.785, 0.135, 0.150, 0.860)',";
                                break;
                                case '29':
                                    $txtSettings .= 'cssEasing:' . "'cubic-bezier(0.680, -0.550, 0.265, 1.550)',";
                                break;
                            }
                        } else {
                            $txtSettings .= $key . ':' . (isset($settings[$key]) && $settings[$key] !='' ? $settings[$key] : $constant[$key]) . ',';
                        }
                    }
                }
                if ($key == 'controls') {
                    $txtSettings .= 'controls:' . (isset($settings[$key]) && $settings[$key] !='' ? $settings[$key] : $constant[$key]) . ',';
                }
            }
            $getContentId = null;
            $textData = "<script>
                (function($) {
                    $(window).load(function() {
                        $('#nsGallery-" . $getContentId . "').lightGallery({
                            selector: '.ns-gallery-item',
                            " . $txtSettings . '
                        });
                    });
                })(jQuery);
            </script>';
        }

        return $txtSettings;
    }

    public function getFromAll()
    {
        $querySettings = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @throws Exception
     */
    public function checkApiData()
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nsgallery_domain_model_apidata');
        $queryBuilder
            ->select('*')
            ->from('tx_nsgallery_domain_model_apidata');
        $query = $queryBuilder->execute();
        return $query->fetch();
    }
    public function insertNewData($data)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nsgallery_domain_model_apidata');
        $row = $queryBuilder
            ->insert('tx_nsgallery_domain_model_apidata')
            ->values($data);

        $query = $queryBuilder->execute();
        return $query;
    }
    public function curlInitCall($url)
    {
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curlSession);
        curl_close($curlSession);

        return $data;
    }
    public function deleteOldApiData(): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nsgallery_domain_model_apidata');
        $queryBuilder
            ->delete('tx_nsgallery_domain_model_apidata')
            ->where(
                $queryBuilder->expr()->comparison('last_update', '<', 'DATE_SUB(NOW() , INTERVAL 1 DAY)')
            )
            ->execute();
    }

    public function getRatings($filterData = null): QueryResultInterface
    {
        $this->getFromAll();
        $query = $this->createQuery();
        $main = GeneralUtility::makeInstance(ConstraintInterface::class);

        $main[] =  $query->equals('pid', $filterData['pId']);
        if ($filterData['cid']) {
            $main[] = $query->equals('cid', (int)$filterData['cid']);
        }
        if ($filterData['userIp']) {
            $main[] =  $query->equals('user_ip', (string)$filterData['userIp']);
        }
        $main[] =  $query->equals('feedback_type', 2);
        $query->matching(
            $query->logicalAnd($main)
        );
        return $query->execute();
    }
}
