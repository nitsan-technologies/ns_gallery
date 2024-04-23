<?php

namespace NITSAN\NsGallery\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * NsMedia
 */
class NsMedia extends AbstractEntity
{

    /**
     * media
     *
     * @var ObjectStorage<FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ObjectStorage $media;

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
    protected function initStorageObjects(): void
    {
        $this->media = new ObjectStorage();
    }

    /**
     * Adds a FileReference
     *
     * @param FileReference $medium
     * @return void
     */
    public function addMedium(FileReference $medium): void
    {
        $this->media->attach($medium);
    }

    /**
     * Removes a FileReference
     *
     * @param FileReference $mediumToRemove The FileReference to be removed
     * @return void
     */
    public function removeMedium(FileReference $mediumToRemove): void
    {
        $this->media->detach($mediumToRemove);
    }

    /**
     * Returns the media
     *
     * @return ObjectStorage<FileReference> $media
     */
    public function getMedia(): ObjectStorage
    {
        return $this->media;
    }

    /**
     * Sets the media
     *
     * @param ObjectStorage<FileReference> $media
     * @return void
     */
    public function setMedia(ObjectStorage $media): void
    {
        $this->media = $media;
    }
}
