<?php
namespace HGON\HgonDonation\Controller;

use HGON\HgonPayment\Session\BasketSessionService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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

/**
 * DonationController
 */
class DonationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected BasketSessionService $basketSessionService;

    protected \HGON\HgonDonation\Domain\Repository\DonationRepository $donationRepository;

    protected \HGON\HgonTemplate\Domain\Repository\PagesRepository $pagesRepository;

    protected \HGON\HgonTemplate\Domain\Repository\AuthorsRepository $authorsRepository;

    protected \TYPO3\CMS\Beuser\Domain\Repository\BackendUserRepository $backendUserRepository;

    protected \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObjectRenderer;


    public function __construct(
        ?BasketSessionService $basketSessionService = null,
        ?\HGON\HgonDonation\Domain\Repository\DonationRepository $donationRepository = null,
        ?\HGON\HgonTemplate\Domain\Repository\PagesRepository $pagesRepository = null,
        ?\HGON\HgonTemplate\Domain\Repository\AuthorsRepository $authorsRepository = null,
        ?\TYPO3\CMS\Beuser\Domain\Repository\BackendUserRepository $backendUserRepository = null,
        ?\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObjectRenderer = null
    ) {
        $this->basketSessionService = $basketSessionService ?? GeneralUtility::makeInstance(BasketSessionService::class);
        $this->donationRepository = $donationRepository ?? GeneralUtility::makeInstance(\HGON\HgonDonation\Domain\Repository\DonationRepository::class);
        $this->pagesRepository = $pagesRepository ?? GeneralUtility::makeInstance(\HGON\HgonTemplate\Domain\Repository\PagesRepository::class);
        $this->authorsRepository = $authorsRepository ?? GeneralUtility::makeInstance(\HGON\HgonTemplate\Domain\Repository\AuthorsRepository::class);
        $this->backendUserRepository = $backendUserRepository ?? GeneralUtility::makeInstance(\TYPO3\CMS\Beuser\Domain\Repository\BackendUserRepository::class);
        $this->contentObjectRenderer = $contentObjectRenderer ?? GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class);
    }

    public function injectDonationRepository(\HGON\HgonDonation\Domain\Repository\DonationRepository $donationRepository): void
    {
        $this->donationRepository = $donationRepository;
    }

    public function injectPagesRepository(\HGON\HgonTemplate\Domain\Repository\PagesRepository $pagesRepository): void
    {
        $this->pagesRepository = $pagesRepository;
    }

    public function injectAuthorsRepository(\HGON\HgonTemplate\Domain\Repository\AuthorsRepository $authorsRepository): void
    {
        $this->authorsRepository = $authorsRepository;
    }

    public function injectBackendUserRepository(\TYPO3\CMS\Beuser\Domain\Repository\BackendUserRepository $backendUserRepository): void
    {
        $this->backendUserRepository = $backendUserRepository;
    }

    public function injectContentObjectRenderer(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObjectRenderer): void
    {
        $this->contentObjectRenderer = $contentObjectRenderer;
    }

    public function addToBasketAction(): \Psr\Http\Message\ResponseInterface
    {
        $basket = $this->basketSessionService->getBasket();
        // ... basket anpassen ...
        // $this->basketSessionService->setBasket($basket);

        return $this->htmlResponse();
    }

    public function clearBasketAction(): \Psr\Http\Message\ResponseInterface
    {
        $this->basketSessionService->clearBasket();

        return $this->htmlResponse();
    }


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


    /**
     * initialize
     */
    public function initializeAction(): void
    {
        parent::initializeAction();

        // contentObjectRenderer ist in ActionController vorhanden (nach Initialisierung)
        $this->cObj = $this->contentObjectRenderer;
    }

        /**
     * action list
     * (alternative list for donation time popup in footer)
     *
     * @param array $filter
     * @param integer $page
     * @param integer $itemType for pager (which type is meant)
     * @return \Psr\Http\Message\ResponseInterface
         */
    public function listAction($filter = array(), $page = 0, $itemType = 0)
    {
        // initial page increase
        $page++;

        $isFilterRequest = $filter && $page <= 1;

        foreach ($filter as $key => $value) {
            $filter[$key] = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        $filter['type'] = 2;

        $donationListTotal = $this->donationRepository->findByFilter($filter, 1, PHP_INT_MAX)->count();
        $maximumReached = ($page * $this->settings['itemsPerPage']) >= (int)$this->settings['maximumShownResults'];
        if (($page * $this->settings['itemsPerPage']) < $donationListTotal && !$maximumReached) {
            $replacements['showMoreLinkDonationMoney'] = true;
        }
        $replacements['donationTypeMoneyList'] = $this->donationRepository->findByFilter($filter, $page, (int)$this->settings['itemsPerPage']);

        $replacements['page'] = $page;
        $replacements['settingsArray'] = $this->settings;

        $ajaxTypeNum = (int)($this->settings['ajaxTypeNum'] ?? 0);
        $type = (int)($this->request->getQueryParams()['type'] ?? 0);

        if ($type === $ajaxTypeNum) {
            /** @var \RKW\RkwBasics\Helper\Json $jsonHelper */
            $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\RKW\RkwBasics\Helper\Json::class);

            $replacements['requestType'] = $isFilterRequest ? 'replace' : 'append';
            $jsonHelper->setHtml(
                'donation-listing-money',
                $replacements,
                $replacements['requestType'],
                'Ajax/Donation/More.html'
            );
            $jsonHelper->setHtml(
                'donation-more-link-container-money',
                $replacements,
                'replace',
                'Ajax/Donation/MoreLink.html'
            );

            print (string)$jsonHelper;
            exit();
        }

        $this->view->assignMultiple($replacements);

        return $this->htmlResponse();

    }



    /**
     * action show
     *
     * @param \HGON\HgonDonation\Domain\Model\Donation $donation
     * @return \Psr\Http\Message\ResponseInterface
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
        $this->view->assign('similarDonationList', []);

        return $this->htmlResponse();
    }



    /**
     * action perform (called after submitting the form)
     *
     * @param \HGON\HgonDonation\Domain\Model\Donation $donation
     * @return \TYPO3\CMS\Extbase\Http\ForwardResponse
     */
    public function performAction(\HGON\HgonDonation\Domain\Model\Donation $donation)
    {
        // https://sitegeist.de/blog/typo3-blog/typo3-form-framework-formulare-in-eigenen-extensions-nutzen.html

        return new \TYPO3\CMS\Extbase\Http\ForwardResponse('show');

    }



    /**
     * action new
     * initial action. If no donationTypeTime is set, forward to list for choosing one
     *
     * @param \HGON\HgonDonation\Domain\Model\DonationTypeTime $donationTypeTime
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(\HGON\HgonDonation\Domain\Model\DonationTypeTime $donationTypeTime)
    {

        return $this->htmlResponse();
    }



    /**
     * action newMoney
     * action for donation money (PayPal)
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newMoneyAction()
    {
        return $this->htmlResponse();
    }



    /**
     * action createMoney
     * action for donation money (PayPal)
     *
     * @param array $moneyAmount
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createMoneyAction($moneyAmount)
    {
        /** @var \HGON\HgonPayment\Domain\Model\Basket $basket */
        $basket = GeneralUtility::makeInstance(\HGON\HgonPayment\Domain\Model\Basket::class);

        /** @var \HGON\HgonPayment\Domain\Model\Article $article */
        $article = GeneralUtility::makeInstance(\HGON\HgonPayment\Domain\Model\Article::class);
        $article->setDescription("Mein Beitrag für den Umweltschutz!");
        $article->setName('Allgemeine Spende');
        $article->setPrice(floatval($moneyAmount['amount']));
        $article->setSku('allgemein');
        $basket->addArticle($article);
        $this->basketSessionService->setBasket($basket);

        /** @var \HGON\HgonPayment\Api\PayPalApi $payPalApi */
        $payPalApi = GeneralUtility::makeInstance(\HGON\HgonPayment\Api\PayPalApi::class);

        $isPayPalPlus = true;
        if (!empty($moneyAmount['permanent'])) {
            // Subscription with PayPal (PayPalPlus does not support recurring payments)
            $result = $payPalApi->createSubscription($article);
            $isPayPalPlus = false;
        } else {
            // one time payment with PayPal Plus
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
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\RKW\RkwBasics\Helper\Json::class);
        // get new list
        $replacements = array (
            'approvalUrl' => $isPayPalPlus ? $approvalUrl[1]->href : $approvalUrl[0]->href,
            'isPayPalPlus' => $isPayPalPlus,
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

        return $this->htmlResponse();

    }



    /**
     * action preparePaymentAction
     * coming back from paypal with payment authorization
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function preparePaymentAction()
    {
        $qp = $this->request->getQueryParams();
        $basket = $this->basketSessionService->getBasket();
        $basket->setPaymentData([
            'paymentId' => preg_replace('/[^A-Z0-9-]/', '', (string)($qp['paymentId'] ?? '')),
            'token'     => preg_replace('/[^A-Z0-9-]/', '', (string)($qp['token'] ?? '')),
            'payerId'   => preg_replace('/[^A-Z0-9-]/', '', (string)($qp['PayerID'] ?? '')),
        ]);

        $this->basketSessionService->setBasket($basket);

        $this->view->assign('basket', $basket);

        return $this->htmlResponse();
    }



    /**
     * action executePaymentAction
     * action for executing donation money (PayPal)
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function executePaymentAction()
    {
        $qp = $this->request->getQueryParams();

        $paymentId = preg_replace('/[^A-Z0-9-]/', '', (string)($qp['paymentId'] ?? ''));
        $token     = preg_replace('/[^A-Z0-9-]/', '', (string)($qp['token'] ?? ''));
        $payerId   = preg_replace('/[^A-Z0-9-]/', '', (string)($qp['PayerID'] ?? ''));

        /** @var \HGON\HgonPayment\Api\PayPalApi $payPalApi */
        $payPalApi = GeneralUtility::makeInstance(\HGON\HgonPayment\Api\PayPalApi::class);
        $result = $payPalApi->executePayment($paymentId, $token, $payerId);

        return $this->htmlResponse();
    }



    /**
     * action bankAccountSidebar
     * shows bank data in a simple yellow box
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function bankAccountSidebarAction()
    {

        // @toDo: txRkwprojectsProjectUid does not longer exists

        // special case: If this page has a project: Show specific project bank account
        $pageId = (int)($this->request->getAttribute('frontend.page.information')?->getId() ?? 0);
        $pages = $this->pagesRepository->findByIdentifier($pageId);
        //if ($pages->getTxRkwprojectsProjectUid()) {
            // get HGON project type for correct getter and setter

            //$project = $this->projectsRepository->findByIdentifier($pages->getTxRkwprojectsProjectUid()->getUid());
            //DebuggerUtility::var_dump($project); exit;
          //  $this->view->assign('project', $project);
        //}

        return $this->htmlResponse();
    }



	/**
	 * action create
	 *
	 * @param array $formFields
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function createAction($formFields)
	{
        return $this->htmlResponse();
	}

    /**
     * action header
     * Template helper
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function headerAction()
    {

        $getParams = $this->request->getQueryParams()['tx_hgondonation_detail']
            ?? ($this->request->getParsedBody()['tx_hgondonation_detail'] ?? null);

        if ($getParams) {
            if (key_exists('donation', $getParams)) {
                $donationUid = preg_replace('/[^0-9]/', '', $getParams['donation']);
            } else {
                // Workground in relation to FormExt: Although we got this params here, the GP vars above delivers some crap
                $donationUid = preg_replace('/[^0-9]/', '', $_GET['tx_hgondonation_detail']['donation']);
            }
            $donation = $this->donationRepository->findByIdentifier(filter_var($donationUid, FILTER_SANITIZE_NUMBER_INT));

            $this->view->assign('donation', $donation);
        }

        return $this->htmlResponse();

    }



    /**
     * action sidebar
     * Template helper
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sidebarAction()
    {

        $getParams = $this->request->getQueryParams()['tx_hgondonation_detail']
            ?? ($this->request->getParsedBody()['tx_hgondonation_detail'] ?? null);

        if ($getParams) {
            if (key_exists('donation', $getParams)) {
                $donationUid = preg_replace('/[^0-9]/', '', $getParams['donation']);
            } else {
                // Workground in relation to FormExt: Although we got this params here, the GP vars above delivers some crap
                $donationUid = preg_replace('/[^0-9]/', '', $_GET['tx_hgondonation_detail']['donation']);
            }
            $donation = $this->donationRepository->findByIdentifier(filter_var($donationUid, FILTER_SANITIZE_NUMBER_INT));

            $this->view->assign('donation', $donation);
        }

        return $this->htmlResponse();
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
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\RKW\RkwBasics\Helper\Json::class);
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
    }

}
