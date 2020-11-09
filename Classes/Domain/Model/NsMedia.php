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
 * NsMedia
 */
class NsMedia extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * uid
     *
     * @var int
     */
    protected $uid = 0;

    /**
     * disbig
     *
     * @var int
     */
    protected $disbig = null;

    /**
     * media
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $media = null;

    /**
     * poster
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $poster = null;

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
        $this->poster = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $medium
     * @return void
     */
    public function addMedium(\TYPO3\CMS\Extbase\Domain\Model\FileReference $medium)
    {
        $this->media->attach($medium);
        $this->poster->attach($medium);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $mediumToRemove The FileReference to be removed
     * @return void
     */
    public function removeMedium(\TYPO3\CMS\Extbase\Domain\Model\FileReference $mediumToRemove)
    {
        $this->media->detach($mediumToRemove);
        $this->poster->detach($mediumToRemove);
    }

    /**
     * Returns the media
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Sets the media
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
     * @return void
     */
    public function setMedia(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $media)
    {
        $this->media = $media;
    }

    /**
     * Sets the uid
     *
     * @param int $uid
     * @return void
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Returns the disbig
     *
     * @return int $disbig
     */
    public function getDisbig()
    {
        return $this->disbig;
    }

    /**
     * Sets the disbig
     *
     * @param int $disbig
     * @return void
     */
    public function setDisbig($disbig)
    {
        $this->disbig = $disbig;
    }

    /**
     * Returns the poster
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $poster
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Sets the poster
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $poster
     * @return void
     */
    public function setPoster(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $poster)
    {
        $this->poster = $poster;
    }
}
