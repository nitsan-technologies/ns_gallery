<?php

declare(strict_types=1);

namespace NITSAN\NsGallery\Form\Resolver;

use NITSAN\NsGallery\Backend\PremiumStrip;
use NITSAN\NsGallery\Form\Container\PremiumStripFlexFormNoTabsContainer;
use TYPO3\CMS\Backend\Form\NodeFactory;
use TYPO3\CMS\Backend\Form\NodeResolverInterface;

/**
 * Uses PremiumStripFlexFormNoTabsContainer for the plugin options (pi_flexform) of the gallery content elements.
 */
final class PremiumStripFlexFormNoTabsContainerResolver implements NodeResolverInterface
{
    private array $data;

    /**
     * TYPO3 v12 passes the node factory and data to the constructor, v13+ calls setData().
     */
    public function __construct(?NodeFactory $nodeFactory = null, array $data = [])
    {
        $this->data = $data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function resolve(): ?string
    {
        if (($this->data['tableName'] ?? '') !== 'tt_content'
            || ($this->data['fieldName'] ?? '') !== 'pi_flexform'
            || !empty($this->data['isInlineChild'])
        ) {
            return null;
        }

        return in_array((string)($this->data['recordTypeValue'] ?? ''), PremiumStrip::PLUGIN_SIGNATURES, true)
            ? PremiumStripFlexFormNoTabsContainer::class
            : null;
    }
}
