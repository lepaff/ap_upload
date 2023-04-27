<?php

declare(strict_types=1);

namespace AP\ApUpload\Domain\Model;


use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * This file is part of the "File upload" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 
 */

/**
 * Record
 */
class Record extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = null;

    /**
     * files
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $files= null;

    /**
     * Returns the title
     *
     * @return string
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
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Returns the files
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $files
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Sets the files
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $files
     * @return void
     */
    public function setFiles(\TYPO3\CMS\Extbase\Domain\Model\FileReference $files)
    {
        $this->files = $files;
    }
}
