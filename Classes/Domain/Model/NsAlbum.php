<?php
namespace NITSAN\NsGallery\Domain\Model;

/***
 *
 * This file is part of the "[NITSAN] Gallery" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 T3: Milan <sanjay@nitsan.in>, NITSAN Technologies Pvt Ltd
 *
 ***/
/**
 * NsAlbum
 */
class NsAlbum extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * media
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NITSAN\NsGallery\Domain\Model\NsMedia>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $media = null;

    /**
     * __construct
     */
    public function __construct()
    {

        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->media = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Adds a NsMedia
     *
     * @param \NITSAN\NsGallery\Domain\Model\NsMedia $medium
     * @return void
     */
    public function addMedium(\NITSAN\NsGallery\Domain\Model\NsMedia $medium)
    {
        $this->media->attach($medium);
    }

    /**
     * Removes a NsMedia
     *
     * @param \NITSAN\NsGallery\Domain\Model\NsMedia $mediumToRemove The NsMedia to be removed
     * @return void
     */
    public function removeMedium(\NITSAN\NsGallery\Domain\Model\NsMedia $mediumToRemove)
    {
        $this->media->detach($mediumToRemove);
    }

    /**
     * Returns the media
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NITSAN\NsGallery\Domain\Model\NsMedia> $media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Sets the media
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NITSAN\NsGallery\Domain\Model\NsMedia> $media
     * @return void
     */
    public function setMedia(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $media)
    {
        $this->media = $media;
    }
}
