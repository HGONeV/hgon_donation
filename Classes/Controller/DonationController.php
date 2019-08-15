<?php
namespace HGON\HgonDonation\Controller;

/***
 *
 * This file is part of the "HGON Donation" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Maximilian Fäßler <maximilian@faesslerweb.de>, Fäßler Web UG
 *
 ***/
use HGON\HgonDonation\Helper\Donation as DonationHelper;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * DonationController
 */
class DonationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	/**
	 * donationRepository
	 *
	 * @var \HGON\HgonDonation\Domain\Repository\DonationRepository
	 * @inject
	 */
	protected $donationRepository = null;

    /**
     * pagesRepository
     *
     * @var \HGON\HgonTemplate\Domain\Repository\PagesRepository
     * @inject
     */
    protected $pagesRepository = null;

    /**
     * action list
     * (alternative list for donation time popup in footer)
     *
     * @param array $filter
     * @param integer $page
     * @param integer $itemType for pager (which type is meant)
     * @return void
     */
    public function listAction($filter = array(), $page = 0, $itemType = 0)
    {
        // initial page increase
        $page++;

        // if it's a filter request for new content (filter is also set in case of "more" functionality)
        $isFilterRequest = false;
        if ($filter && $page <= 1) {
            $isFilterRequest = true;
        }

        // filter the filterArray ;-)
        foreach ($filter as $key => $value) {
            $filter[$key] = filter_var($value, FILTER_SANITIZE_STRING);
        }

        $this->settings['itemsPerPage'] = 1;

        // for pagination - we set the type manually in the more-link
        if ($itemType) {
            $filter['type'] = intval($itemType);
        }
        $originalType = $filter['type'];
        // donation time
        if (
            !$filter['type']
            || $filter['type'] == 1
        ) {
            // set filter, if not set (to get only donation time data sets)
            $filter['type'] = 1;
            $donationListTotal = $this->donationRepository->findByFilter($filter, 1, PHP_INT_MAX)->count();
            $maximumReached = ($page * $this->settings['itemsPerPage']) < intval($this->settings['maximumShownResults']) ? false : true;
            if (
                ($page * $this->settings['itemsPerPage']) < $donationListTotal
                && !$maximumReached
            ) {
                $replacements['showMoreLinkDonationTime'] = true;
            }
            $replacements['donationTypeTimeList'] = $this->donationRepository->findByFilter($filter, $page, intval($this->settings['itemsPerPage']));

            // reset type to not disturbed code below
            $filter['type'] = $originalType;
        }


        // donation time
        if (
            !$filter['type']
            || $filter['type'] == 2
        ) {
            // set filter, if not set (to get only donation time data sets)
            $filter['type'] = 2;
            $donationListTotal = $this->donationRepository->findByFilter($filter, 1, PHP_INT_MAX)->count();
            $maximumReached = ($page * $this->settings['itemsPerPage']) < intval($this->settings['maximumShownResults']) ? false : true;
            if (
                ($page * $this->settings['itemsPerPage']) < $donationListTotal
                && !$maximumReached
            ) {
                $replacements['showMoreLinkDonationMoney'] = true;
            }
            $replacements['donationTypeMoneyList'] = $this->donationRepository->findByFilter($filter, $page, intval($this->settings['itemsPerPage']));
        }

        $replacements['page'] = $page;
        $replacements['settingsArray'] = $this->settings;

        // deprecated
        //$replacements['filterDateTimeArray'] = DonationHelper::createDateTimeArray();

        if (!\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('type') == intval($this->settings['ajaxTypeNum'])) {

            // standard view (non-ajax)
            $this->view->assignMultiple($replacements);

        } else {

            // get JSON helper
            /** @var \RKW\RkwBasics\Helper\Json $jsonHelper */
            $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwBasics\\Helper\\Json');

            // get new list
            $kindOfRequest = $isFilterRequest ? 'replace' : 'append';
            $containerIdAdd = $filter['type'] == 1 ? '-time' : '-money';
            $replacements['requestType'] = $kindOfRequest;
            $jsonHelper->setHtml(
                'donation-listing' . $containerIdAdd,
                $replacements,
                $kindOfRequest,
                'Ajax/Donation/More.html'
            );

            // More link replace
            $jsonHelper->setHtml(
                'donation-more-link-container' . $containerIdAdd,
                $replacements,
                'replace',
                'Ajax/Donation/MoreLink.html'
            );

            print (string)$jsonHelper;
            exit();
            //===
        }

    }



    /**
     * action show
     *
     * @param \HGON\HgonDonation\Domain\Model\Donation $donation
     * @return void
     */
    public function showAction(\HGON\HgonDonation\Domain\Model\Donation $donation)
    {
        // not used yet
        // ugly function, because we don't have pages objects (we got a typolink)
        /*
        if ($donation->getTypolink()) {
            $explodedLink = GeneralUtility::trimExplode('=', $donation->getTypolink());
            $this->view->assign('pages', $this->pagesRepository->findByIdentifier(intval(end($explodedLink))));
        }
        */
        $this->view->assign('donation', $donation);
    }



    /**
     * action new
     * initial action. If no donationTypeTime is set, forward to list for choosing one
     *
     * @param \HGON\HgonDonation\Domain\Model\DonationTypeTime $donationTypeTime
     * @return void
     */
    public function newAction(\HGON\HgonDonation\Domain\Model\DonationTypeTime $donationTypeTime)
    {

    }



    /**
     * action bankAccountSidebar
     * shows bank data in a simple yellow box
     *
     * @return void
     */
    public function bankAccountSidebarAction()
    {
        // do nothing else. Just show template
    }



	/**
	 * action create
	 *
	 * @param array $formFields
	 * @return void
	 */
	public function createAction($formFields)
	{

	}



    /**
     * action donationProject
     *
     * @return void
     */
    public function donationProjectAction()
    {
        /** @var \HGON\HgonTemplate\Domain\Model\Pages $pages */
        $pages = $this->pagesRepository->findByIdentifier(intval($GLOBALS['TSFE']->id));
        if ($pages->getTxRkwprojectsProjectUid()) {
            $donationList = $this->donationRepository->findByTxRkwprojectProject($pages->getTxRkwprojectsProjectUid());
            $this->view->assign('donationList', $donationList);
        }
    }

}
