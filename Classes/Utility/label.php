<?php
namespace NITSAN\NsGallery\Utility;

use TYPO3\CMS\Backend\Utility\BackendUtility;

session_start();

class label
{

    /**
     * @return void|string
     */
    public function getObjectLabel(&$params, &$pObj)
    {
        if (!empty($params)) {
            if ($params['table'] != 'tx_nsgallery_domain_model_nsmedia') {
                return '';
            }

            $rec = BackendUtility::getRecord($params['table'], $params['row']['uid']);
            $media = $rec['media'] ?? null;
            if ($media > 0) {
                $totalMedia = $rec['media'];
            }

            $params['title'] = 'Album Media (' . $media . ')';
        }
    }
}
