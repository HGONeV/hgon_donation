<?php
namespace HGON\HgonDonation\Helper;

/***
 *
 * This file is part of the "HGON Template" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Maximilian Fäßler <maximilian@faesslerweb.de>, Fäßler Web UG
 *
 ***/
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use HGON\HgonTemplate\Domain\Model\SysCategory;

/**
 * Donation
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright HGON
 * @package HGON_HgonDonation
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Donation implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * createDateTimeArray
     * for filter template
     *
     * @return array
     */
    public static function createDateTimeArray()
    {
        $resultArray = [];

        $resultArray[strtotime(date('Y-m-d', mktime(0, 0, 0, date('m'), date('j')+7, date('Y'))))] = '1 Woche';
        $resultArray[strtotime(date('Y-m-d', mktime(0, 0, 0, date('m')+1, date('j'), date('Y'))))] = '1 Monat';
        $resultArray[strtotime(date('Y-m-d', mktime(0, 0, 0, date('m'), date('j'), date('Y')+1)))] = '1 Jahr';

        return $resultArray;
        //===
    }
}