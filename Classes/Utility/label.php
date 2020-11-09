<?php
namespace NITSAN\NsGallery\Utility;

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
            if (empty($rec)) {
            } else {
                $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
                $file = $resourceFactory->findByRelation('tx_nsgallery_domain_model_nsmedia', 'media', $params['row']['uid']);
                if ($file[0]) {
                    $fileName = $file[0]->getOriginalFile()->getName();
                    $params['title'] = $fileName;
                }
            }
        }
    }
}
