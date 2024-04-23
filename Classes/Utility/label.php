<?php

namespace NITSAN\NsGallery\Utility;

use TYPO3\CMS\Backend\Utility\BackendUtility;
class label
{
    /**
     * @return void|string
     */
    public function getObjectLabel(&$params)
    {
        if (!empty($params)) {
            if ($params['table'] != 'tx_nsgallery_domain_model_nsmedia') {
                return '';
            }
            $rec = BackendUtility::getRecord($params['table'], $params['row']['uid']);
            $media = $rec['media'] ?? null;
            $params['title'] = 'Album Media (' . $media . ')';
        }
    }
}
