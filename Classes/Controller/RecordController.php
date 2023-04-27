<?php

declare(strict_types=1);

namespace AP\ApUpload\Controller;


use AP\ApUpload\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "File upload" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 
 */

/**
 * RecordController
 */
class RecordController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * recordRepository
     *
     * @var \AP\ApUpload\Domain\Repository\RecordRepository
     */
    protected $recordRepository = null;

    /**
     * @param \AP\ApUpload\Domain\Repository\RecordRepository $recordRepository
     */
    public function injectRecordRepository(\AP\ApUpload\Domain\Repository\RecordRepository $recordRepository)
    {
        $this->recordRepository = $recordRepository;
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        $this->redirect('list');
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $records = $this->recordRepository->findAll();
        $this->view->assign('records', $records);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeCreateAction()
    {
        if ($this->arguments->hasArgument('newRecord')) {
            if ($this->request->getArgument('newRecord')['files'][0]['size'] == 0) {
//                skip property?
            } else {
               $this->setTypeConverterConfigurationForImageUpload('newRecord');
            }
        }
    }

    /**
     * action create
     *
     * @param \AP\ApUpload\Domain\Model\Record $newRecord
     */
    public function createAction(\AP\ApUpload\Domain\Model\Record $newRecord)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->recordRepository->add($newRecord);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \AP\ApUpload\Domain\Model\Record $record
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("record")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\AP\ApUpload\Domain\Model\Record $record): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('record', $record);
        return $this->htmlResponse();
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeUpdateAction()
    {
        $deleteRecord = $this->request->getArgument('deleteImage');
        if (!isset($deleteRecord) || $deleteRecord === '') {
            $this->redirect('edit', 'Record', 'ApUpload',
                [
                    'record' => $this->request->getArgument('record')['__identity']
                ]
            );
        }

//        Delete existing image (if)

        if ($this->arguments->hasArgument('record')) {
            if ($this->request->getArgument('record')['files'][0]['size'] == 0) {
//                skip property?
            } else {
                $this->setTypeConverterConfigurationForImageUpload('record');
            }
        }


    }

    /**
     * action update
     *
     * @param \AP\ApUpload\Domain\Model\Record $record
     */
    public function updateAction(\AP\ApUpload\Domain\Model\Record $record)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->recordRepository->update($record);
        $this->redirect('list');
    }

    /**
     *
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName)
    {
        $typeConverter = GeneralUtility::makeInstance(UploadedFileReferenceConverter::class);
        /** @var PropertyMappingConfiguration $newExampleConfiguration */
        $newExampleConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();
        $newExampleConfiguration->forProperty('files')->setTypeConverter($typeConverter);
    }
}
