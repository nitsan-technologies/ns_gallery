<?php

namespace NITSAN\NsGallery\Utility;

session_start();

class label
{
    /**
     * @param $params
     * @return string|void
     */
    public function getObjectLabel(&$params)
    {
        if (!empty($params)) {
            if ($params['table'] != 'tx_nsgallery_domain_model_nsmedia') {
                return '';
            }
            $rec = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($params['table'], $params['row']['uid']);
            $media = $rec['media'] ?? null;
            $params['title'] = 'Album Media (' . $media . ')';
        }
    }
}
