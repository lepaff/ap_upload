<?php

declare(strict_types=1);

namespace AP\ApUpload\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class RecordTest extends UnitTestCase
{
    /**
     * @var \AP\ApUpload\Domain\Model\Record|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \AP\ApUpload\Domain\Model\Record::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle(): void
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('title'));
    }

    /**
     * @test
     */
    public function getFilesReturnsInitialValueForFileReference(): void
    {
        self::assertEquals(
            null,
            $this->subject->getFiles()
        );
    }

    /**
     * @test
     */
    public function setFilesForFileReferenceSetsFiles(): void
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setFiles($fileReferenceFixture);

        self::assertEquals($fileReferenceFixture, $this->subject->_get('files'));
    }
}
