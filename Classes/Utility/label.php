<?php
namespace NITSAN\NsGallery\Utility;

session_start();

class label
{

    /**
     * @return void
     */
    public function getObjectLabel(&$params, &$pObj)
    {
        if (empty($params)) {
        } else {
            if ($params['table'] != 'tx_nsgallery_domain_model_nsmedia') {
                return '';
            }

            $rec = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($params['table'], $params['row']['uid']);
            if ($rec['media'] > 0) {
                $totalMedia = $rec['media'];
            } else {
                $totalMedia = 0;
            }

            $params['title'] = 'Album Media (' . $rec['media'] . ')';
        }
    }
}
