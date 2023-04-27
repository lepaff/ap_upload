<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ApUpload',
        'Uploadform',
        [
            \AP\ApUpload\Controller\RecordController::class => 'index, list, new, create, edit, update'
        ],
        // non-cacheable actions
        [
            \AP\ApUpload\Controller\RecordController::class => 'create, update'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    uploadform {
                        iconIdentifier = ap_upload-plugin-uploadform
                        title = LLL:EXT:ap_upload/Resources/Private/Language/locallang_db.xlf:tx_ap_upload_uploadform.name
                        description = LLL:EXT:ap_upload/Resources/Private/Language/locallang_db.xlf:tx_ap_upload_uploadform.description
                        tt_content_defValues {
                            CType = list
                            list_type = apupload_uploadform
                        }
                    }
                }
                show = *
            }
       }'
    );
})();
