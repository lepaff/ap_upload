<?php

declare(strict_types=1);

namespace AP\ApUpload\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 */
class RecordControllerTest extends UnitTestCase
{
    /**
     * @var \AP\ApUpload\Controller\RecordController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\AP\ApUpload\Controller\RecordController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllRecordsFromRepositoryAndAssignsThemToView(): void
    {
        $allRecords = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $recordRepository = $this->getMockBuilder(\AP\ApUpload\Domain\Repository\RecordRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $recordRepository->expects(self::once())->method('findAll')->will(self::returnValue($allRecords));
        $this->subject->_set('recordRepository', $recordRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('records', $allRecords);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenRecordToRecordRepository(): void
    {
        $record = new \AP\ApUpload\Domain\Model\Record();

        $recordRepository = $this->getMockBuilder(\AP\ApUpload\Domain\Repository\RecordRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $recordRepository->expects(self::once())->method('add')->with($record);
        $this->subject->_set('recordRepository', $recordRepository);

        $this->subject->createAction($record);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenRecordToView(): void
    {
        $record = new \AP\ApUpload\Domain\Model\Record();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('record', $record);

        $this->subject->editAction($record);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenRecordInRecordRepository(): void
    {
        $record = new \AP\ApUpload\Domain\Model\Record();

        $recordRepository = $this->getMockBuilder(\AP\ApUpload\Domain\Repository\RecordRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $recordRepository->expects(self::once())->method('update')->with($record);
        $this->subject->_set('recordRepository', $recordRepository);

        $this->subject->updateAction($record);
    }
}
