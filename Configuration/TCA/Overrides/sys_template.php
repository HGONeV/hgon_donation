<?php
defined('TYPO3') or die("Access denied.");

//=================================================================
// Add TypoScript
//=================================================================
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'hgon_donation',
    'Configuration/TypoScript',
    'HGON Donation'
);
