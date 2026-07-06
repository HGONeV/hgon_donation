<?php

declare(strict_types=1);

defined('TYPO3') or die('Access denied.');

(static function (): void {
    if (!isset($GLOBALS['TCA']['tx_news_domain_model_news'])) {
        return;
    }

    $field = 'tx_hgondonation_project';

    $GLOBALS['TCA']['tx_news_domain_model_news']['columns'][$field] = [
        'exclude' => true,
        'label' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:field.tx_hgondonation_project',
        'description' => 'LLL:EXT:hgon_donation/Resources/Private/Language/locallang_db.xlf:field.tx_hgondonation_project.description',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tx_hgondonation_domain_model_project',
            'foreign_table_where' => 'AND tx_hgondonation_domain_model_project.sys_language_uid IN (-1,0) ORDER BY tx_hgondonation_domain_model_project.title ASC',
            'default' => 0,
            'items' => [
                [
                    'label' => '',
                    'value' => 0,
                ],
            ],
        ],
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_news_domain_model_news',
        $field,
        '',
        'before:related_links'
    );
})();
