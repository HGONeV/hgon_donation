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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * StandardController
 */
class StandardController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	/**
	 * donationTypeTimeRepository
	 *
	 * @var \HGON\HgonDonation\Domain\Repository\DonationTypeTimeRepository
	 * @inject
	 */
	protected $donationTypeTimeRepository = null;

    /**
     * pagesRepository
     *
     * @var \HGON\HgonTemplate\Domain\Repository\PagesRepository
     * @inject
     */
    protected $pagesRepository = null;

    /**
     * action newDonationTime
     * initial action. If no donationTypeTime is set, forward to list for choosing one
     *
     * @param \HGON\HgonDonation\Domain\Model\DonationTypeTime $donationTypeTime
     * @return void
     */
    public function newDonationTimeAction(\HGON\HgonDonation\Domain\Model\DonationTypeTime $donationTypeTime)
    {
        $templateDataArray = [];
        $templateDataArray['donationTypeTime'] = $donationTypeTime;

        // ugly function, because we don't have pages objects (we got a typolink)
        /** @var \HGON\HgonTemplate\Domain\Model\Projects $project */
        if ($donationTypeTime->getPages()) {
            $explodedLink = GeneralUtility::trimExplode('=', $donationTypeTime->getPages());
            $templateDataArray['pages'] = $this->pagesRepository->findByIdentifier(intval(end($explodedLink)));
        }


          if (GeneralUtility::_GP('type') == intval($this->settings['ajaxTypeNum'])) {

              // get JSON helper
              /** @var \RKW\RkwBasics\Helper\Json $jsonHelper */
              $jsonHelper = GeneralUtility::makeInstance('RKW\\RkwBasics\\Helper\\Json');

              // Content
              $jsonHelper->setHtml(
                  'donation-container',
                  $templateDataArray,
                  'replace',
                  'Ajax/DonationTime.html'
              );

              print (string)$jsonHelper;
              exit();
              //===

          } else {
              $this->view->assignMultiple($templateDataArray);
          }
    }



    /**
     * action listDonationTime
     * (alternative list for donation time popup in footer)
     *
     * @return void
     */
    public function listDonationTimeAction()
    {
        $this->view->assign('donationTypeTimeList', $this->donationTypeTimeRepository->findAll());
        $this->view->assign('ajaxTypeNum', $this->settings['ajaxTypeNum']);
    }



    /**
     * action showDonationTime
     *
     * @return void
     */
    public function showDonationTimeAction()
    {
        // not used yet
    }



    /**
     * action list
     *
     * @return void

    public function listDonationTimeAction()
    {
        $this->view->assign('donationTypeTimeList', $this->donationTypeTimeRepository->findAll());
        $this->view->assign('ajaxTypeNum', $this->settings['ajaxTypeNum']);
    }*/



	/**
	 * action createDonationTime
	 *
	 * @param array $formFields
	 * @return void
	 */
	public function createDonationTimeAction($formFields)
	{
        // get JSON helper
        /** @var \RKW\RkwBasics\Helper\Json $jsonHelper */
        $jsonHelper = GeneralUtility::makeInstance('RKW\\RkwBasics\\Helper\\Json');

        // Content
        $jsonHelper->setHtml(
            'donation-time-form',
            [],
            'replace',
            'Ajax/RegisterForm.html'
        );

        print (string)$jsonHelper;
        exit();
        //===

		// via Ajax?

		// just send a mail?
		// -> "Darunter gibt es die Möglichkeit, sich direkt per E-Mail auf den Job zu bewerben, wenn der Job noch aktiv ist"
		// ... an sich wäre ein eigenes Model und eine automatische Zuteilung auch nicht schlecht (und ein Redakteur
		// akzeptiert die Anmeldung und nimmt kontakt auf, oder lehnt ab)

		//$this->redirect('list');
	}



    /**
     * action supportOptions
     * - become a member form
     * - donate money
     * - donate time
     * -> Options are defined via flexForm
     *
     * @deprecated Moved to HGON DONATION
     * @return void
     */
    public function supportOptionsAction()
    {
        // do nothing else
    }



    /**
     * action supportOptionsLight
     * -> Gives no real forms. Only anchros for opening forms of "supportOptions" plugin, which is used as standard footer element
     *
     * @deprecated Moved to HGON DONATION
     * @return void
     */
    public function supportOptionsLightAction()
    {
        // do nothing else
    }
}
