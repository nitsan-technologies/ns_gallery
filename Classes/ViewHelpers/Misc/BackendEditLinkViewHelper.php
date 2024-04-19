<?php

namespace NITSAN\NsGallery\ViewHelpers\Misc;

use NITSAN\NsGallery\Utility\BackendUtility;
use TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * BackendEditLinkViewHelper
 *
 */
class BackendEditLinkViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('tableName', 'string', '', true);
        $this->registerArgument('identifier', 'integer', '', true);
    }

    /**
     * Create a link for backend edit
     *
     * @return string
     * @throws RouteNotFoundException
     */
    public function render()
    {
        return BackendUtility::createEditUri($this->arguments['tableName'], $this->arguments['identifier'], true);
    }
}
