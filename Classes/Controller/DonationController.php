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
     * projectsRepository
     *
     * @var \HGON\HgonTemplate\Domain\Repository\ProjectsRepository
     * @inject
     */
    protected $projectsRepository = null;

    /**
     * cacheManager
     *
     * @var \TYPO3\CMS\Core\Cache\CacheManager
     */
    protected $cacheManager;

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected $cObj;

    /**
     * cacheIdentifier
     *
     * @var string
     */
    protected $cacheIdentifier = "hgon_donation";

    private function initializeCache() {
        // initialize caching
        $this->cacheManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache($this->cacheIdentifier);
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $this->persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $this->cObj = $configurationManager->getContentObject();
    }

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->initializeCache();
    }

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


        // donation money
        if (
            !$filter['type']
            || $filter['type'] == 2
        ) {
            // set filter, if not set (to get only donation time data sets)
            $filter['type'] = 2;
            //$donationListTotal = $this->donationRepository->findByFilter($filter, 1, PHP_INT_MAX)->count();
            $donationListTotal = $this->projectsRepository->findByFilter(1, PHP_INT_MAX)->count();
            $maximumReached = ($page * $this->settings['itemsPerPage']) < intval($this->settings['maximumShownResults']) ? false : true;

            if (
                ($page * $this->settings['itemsPerPage']) < $donationListTotal
                && !$maximumReached
            ) {
                $replacements['showMoreLinkDonationMoney'] = true;
            }
            $replacements['donationTypeMoneyList'] = $this->projectsRepository->findByFilter($page, intval($this->settings['itemsPerPage']));
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

    //    DebuggerUtility::var_dump($this->donationRepository->findByDonationTxRkwprojectProject($donation, true)); exit;

        $this->view->assign('donation', $donation);
        $this->view->assign('similarDonationList', $this->donationRepository->findByDonationTxRkwprojectProject($donation, true));
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
     * action newMoney
     * action for donation money (PayPal)
     *
     * @param \HGON\HgonTemplate\Domain\Model\Projects $project
     * @return void
     */
    public function newMoneyAction(\HGON\HgonTemplate\Domain\Model\Projects $project = null)
    {
        // workaround - we have some parameter trouble while using ajax
        if (!$project) {
            $projectUid = intval(\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('project'));
            $project = $this->projectsRepository->findByIdentifier($projectUid);
        }

        $this->view->assign('project', $project);
    }



    /**
     * action createMoney
     * action for donation money (PayPal)
     *
     * @param array $moneyAmount
     * @param \HGON\HgonTemplate\Domain\Model\Projects $project
     * @return void
     */
    public function createMoneyAction($moneyAmount, \HGON\HgonTemplate\Domain\Model\Projects $project = null)
    {
        /** @var \HGON\HgonPayment\Domain\Model\Basket $basket */
        $basket = $this->objectManager->get('HGON\\HgonPayment\\Domain\\Model\\Basket');

        /** @var \HGON\HgonPayment\Domain\Model\Article $article */
        $article = $this->objectManager->get('HGON\\HgonPayment\\Domain\\Model\\Article');
        $article->setDescription("Mein Beitrag für den Umweltschutz!");
        $article->setName($project ? $project->getName() : 'Allgemein');
        $article->setPrice(floatval($moneyAmount['amount']));
        $article->setSku($project ? $project->getInternalName() : 'allgemein');
        $basket->addArticle($article);

        $GLOBALS['TSFE']->fe_user->setKey('ses', 'hgon_payment_basket', $basket);
        $GLOBALS['TSFE']->storeSessionData();

        /** @var \HGON\HgonPayment\Api\PayPalApi $payPalApi */
        $payPalApi = $this->objectManager->get('HGON\\HgonPayment\\Api\\PayPalApi');

        $isPayPalPlus = true;
        $isSepa = false;
        // create subscription
        if ($moneyAmount['permanent']) {

            if ($moneyAmount['type'] == 'paypal') {
                // Subscription with PayPal (PayPalPlus does not support recurring payments)
                $result = $payPalApi->createSubscription($article);
                $isPayPalPlus = false;
            } elseif ($moneyAmount['type'] == 'sepa') {

                // @toDo: Check data


                // add mollie as payment option
                /** @var \HGON\HgonPayment\Api\MollieApi $mollieApi */
                $mollieApi = $this->objectManager->get('HGON\\HgonPayment\\Api\\MollieApi');
                // create customer
                $mollieCustomer = $mollieApi->createCustomer($moneyAmount['customer']);
                // create customer mandate
                $mollieMandate = $mollieApi->createMandate($mollieCustomer, $moneyAmount['customer']);

                // if false, there is no mandate created. In most case because iban is not valid
                if (!$mollieMandate) {

                    $this->returnAjaxMessage(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_hgondonation_controller_donation.pleaseCheckData', 'hgon_donation'));
                }

                $this->cacheManager->set($mollieCustomer->id, $mollieCustomer);



             //   DebuggerUtility::var_dump($mollieMandate); exit;
                // create subscription for customer
            //    $result = $mollieApi->createSubscription($mollieCustomer, $article);

                $isSepa = true;
                $isPayPalPlus = false;
            //    DebuggerUtility::var_dump($moneyAmount); exit;
                $moneyAmount['customer']['customerId'] = $mollieCustomer->id;
                $result = $moneyAmount;
            }
        } else {
            // one time payment mit PayPalPlus
            $result = $payPalApi->createPayment($basket);
        }

        // check for error
        $requestIsInvalid = false;
        if ($result->name == "INVALID_REQUEST") {
            $requestIsInvalid = true;
        }

        // extract approval_url
        $approvalUrl = $result->links;
        //$this->view->assign('approvalUrl', $approvalUrl[1]->href);

        // get JSON helper
        /** @var \RKW\RkwBasics\Helper\Json $jsonHelper */
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwBasics\\Helper\\Json');
        // get new list
        $replacements = array (
            'approvalUrl' => $isPayPalPlus ? $approvalUrl[1]->href : $approvalUrl[0]->href,
            'isPayPalPlus' => $isPayPalPlus,
            'isSepa' => $isSepa,
            'requestIsInvalid' => $requestIsInvalid,
            'result' => $result
        );

        $jsonHelper->setHtml(
            'payment-container',
            $replacements,
            'replace',
            'Ajax/Donation/CreateMoney.html'
        );

        print (string) $jsonHelper;
        exit();
        //===
    }



    /**
     * action preparePaymentAction
     * coming back from paypal with payment authorization
     *
     * @return void
     */
    public function preparePaymentAction()
    {
        /** @var \HGON\HgonPayment\Domain\Model\Basket $basket */
        $basket = $GLOBALS['TSFE']->fe_user->getKey('ses','hgon_payment_basket');
        $basket->setPaymentData([
            'paymentId' =>  preg_replace('/[^A-Z0-9-]/', '', \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('paymentId')),
            'token' =>  preg_replace('/[^A-Z0-9-]/', '', \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('token')),
            'payerId' =>  preg_replace('/[^A-Z0-9-]/', '', \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('PayerID'))
        ]);

        $GLOBALS['TSFE']->fe_user->setKey('ses', 'hgon_payment_basket', $basket);
        $GLOBALS['TSFE']->storeSessionData();

        $this->view->assign('basket', $basket);
    }



    /**
     * action executePaymentAction
     * action for executing donation money (PayPal)
     *
     * @return void
     */
    public function executePaymentAction()
    {
        $paymentId = preg_replace('/[^A-Z0-9-]/', '', \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('paymentId'));
        $token = preg_replace('/[^A-Z0-9-]/', '', \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('token'));
        $payerId = preg_replace('/[^A-Z0-9-]/', '', \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('PayerID'));

        /** @var \HGON\HgonPayment\Api\PayPalApi $payPalApi */
        $payPalApi = $this->objectManager->get('HGON\\HgonPayment\\Api\\PayPalApi');
        $result = $payPalApi->executePayment($paymentId, $token, $payerId);
    }



    /**
     * action executeSepa
     *
     * @param array $customer
     * @return void
     */
    public function executeSepaAction($customer)
    {
        /** @var \HGON\HgonPayment\Domain\Model\Basket $basket */
        $basket = $GLOBALS['TSFE']->fe_user->getKey('ses','hgon_payment_basket');
        foreach ($basket->getArticle() as $articleSingle) {
            $article = $articleSingle;
            break;
        }

        $isPayed = false;

        /** @var \HGON\HgonPayment\Api\MollieApi $mollieApi */
        $mollieApi = $this->objectManager->get('HGON\\HgonPayment\\Api\\MollieApi');
        if ($this->cacheManager->has($customer['customerId'])) {
            $customer = $this->cacheManager->get($customer['customerId']);
            $result = $mollieApi->createSubscription($customer, $article);
            if ($result instanceof \Mollie\Api\Resources\Subscription) {
                if ($result->status == "active") {
                    $isPayed = true;

                    // @toDo: Send a mail to customer
                    /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
                    $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

                    /** @var \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser */
                    $frontendUser = $objectManager->get('RKW\\RkwRegistration\\Domain\\Model\\FrontendUser');
                    $frontendUser->setEmail($customer->email);
                    // We do not have first and lastname separately
                    $frontendUser->setLastName($customer->name);
                    /** @var \HGON\HgonDonation\Service\RkwMailService $rkwMailService */
                    $rkwMailService = $objectManager->get('HGON\\HgonDonation\\Service\\RkwMailService');
                    $rkwMailService->confirmSepaUser($frontendUser, $result);
                    //$rkwMailService->confirmSepaAdmin($backendUser, $result);
                }
            }
        } else {
            // @toDo: error log?
        }

        // get JSON helper
        /** @var \RKW\RkwBasics\Helper\Json $jsonHelper */
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwBasics\\Helper\\Json');
        // get new list
        $replacements = array (
            'isPayed' => $isPayed
        );

        $jsonHelper->setHtml(
            'payment-container',
            $replacements,
            'replace',
            'Ajax/Donation/SepaThankYou.html'
        );

        print (string) $jsonHelper;
        exit();
        //===
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



    /**
     * returnAjaxMessage
     *
     * @param $message
     */
    protected function returnAjaxMessage($message)
    {
        // get JSON helper
        /** @var \RKW\RkwBasics\Helper\Json $jsonHelper */
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwBasics\\Helper\\Json');
        // get new list
        $replacements = array (
            'message' => $message

        );

        $jsonHelper->setHtml(
            'message-container',
            $replacements,
            'replace',
            'Ajax/Donation/Message.html'
        );

        print (string) $jsonHelper;
        exit();
        //===
    }

}
