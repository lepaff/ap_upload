<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_apupload_domain_model_record', 'EXT:ap_upload/Resources/Private/Language/locallang_csh_tx_apupload_domain_model_record.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_apupload_domain_model_record');
})();
