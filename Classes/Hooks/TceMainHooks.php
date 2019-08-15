<?php

namespace HGON\HgonDonation\Hooks;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class TceMainHooks
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright HGON
 * @package HGON_HgonDonatino
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TceMainHooks
{

    /**
     * Fetches GeoData from RkwGeodata
     *
     * @param $status
     * @param $table
     * @param $id
     * @param $fieldArray
     * @param $reference
     * @return void
     */
    function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$reference)
    {
        // get pages from typolink (for easy working with objects - instead of converting typolink every time if needed)
        if ($table == 'tx_hgondonation_domain_model_donation') {
            if ($fieldArray['typolink']) {
                unset($fieldArray['pages']);
                // only use typo3 internal links (starts with "t3")
                if (preg_match('#^t3#', $fieldArray['typolink']) === 1) {
                    $explodedLink = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('=', $fieldArray['typolink']);
                    // we just need the pid. But we check, if the pid is really existing (to avoid any error)
                    $pagesDb = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('pages', intval(end($explodedLink)));
                    if ($pagesDb) {
                        $fieldArray['pages'] = $pagesDb['uid'];
                    }
                }
            }
        }


        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_geolocation')) {
            try {

                if ($table == 'tx_hgondonation_domain_model_donationplace') {

                    // set longitude and latitude into event location
                    $donationPlaceDb = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('tx_hgondonation_domain_model_donationplace', $id);
                    $donationPlace = array_merge($donationPlaceDb, $fieldArray);
                   
                    if (count($donationPlace)) {

                        /** @var \RKW\RkwGeolocation\Service\Geolocation $geoLocation */
                        $geoLocation = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwGeolocation\\Service\\Geolocation');

                        // set country
                        $staticCountry = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('static_countries', $donationPlace['country']);
                        if ($staticCountry['cn_short_en']) {
                            $geoLocation->setCountry($staticCountry['cn_short_en']);
                        }

                        // set address
                        $geoLocation->setAddress($donationPlace['address'] . ', ' . $donationPlace['zip'] . ' ' . $donationPlace['city']);

                        /** @var \RKW\RkwGeolocation\Domain\Model\Geolocation $geoData */
                        $geoData = $geoLocation->fetchGeoData();

                        if ($geoData) {
                            $fieldArray['longitude'] = $geoData->getLongitude();
                            $fieldArray['latitude'] = $geoData->getLatitude();

                            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Successfully fetched geodata for location "%s".', $geoLocation->getAddress() . ',' . $geoLocation->getCountry()));
                        } else {
                            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::WARNING, sprintf('Could not fetch geodata for location "%s".', $geoLocation->getAddress() . ',' . $geoLocation->getCountry()));
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('Could not set geodata for event. Reason: %s.', $e->getMessage()));
            }
        }
    }



    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger()
    {
        return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
        //===
    }
}

?>