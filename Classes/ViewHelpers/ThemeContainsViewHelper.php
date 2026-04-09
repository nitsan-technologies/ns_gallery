<?php

namespace NITSAN\NsGallery\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ThemeContainsViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', '', true);
    }
    public function render(): bool
    {
        return str_starts_with($this->arguments['value'], 'ns_gallery');
    }
}
