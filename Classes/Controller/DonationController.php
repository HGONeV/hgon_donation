<?php
namespace HGON\HgonDonation\Controller;

use HGON\HgonPayment\Session\BasketSessionService;
use HGON\HgonTemplate\Utility\AjaxResponseBuilder;
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

    public function __construct(
        ?BasketSessionService $basketSessionService = null
    ) {
        $this->basketSessionService = $basketSessionService ?? GeneralUtility::makeInstance(BasketSessionService::class);
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

    public function bankAccountSidebarAction(): \Psr\Http\Message\ResponseInterface
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

        $replacements = array (
            'approvalUrl' => $isPayPalPlus ? $approvalUrl[1]->href : $approvalUrl[0]->href,
            'isPayPalPlus' => $isPayPalPlus,
            'requestIsInvalid' => $requestIsInvalid,
            'result' => $result
        );

        $json = GeneralUtility::makeInstance(AjaxResponseBuilder::class)->build(
            [
                [
                    'id' => 'payment-container',
                    'variables' => $replacements,
                    'mode' => 'replace',
                    'template' => 'Ajax/Donation/CreateMoney',
                ],
            ],
            $this->request,
            ['EXT:hgon_donation/Resources/Private/Templates/'],
            [
                'EXT:hgon_donation/Resources/Private/Partials/',
                'EXT:hgon_payment/Resources/Private/Partials/',
                'EXT:hgon_template/Resources/Private/Extension/HgonTemplate/Partials/',
            ],
            [
                'EXT:hgon_donation/Resources/Private/Layouts/',
                'EXT:hgon_template/Resources/Private/Extension/HgonTemplate/Layouts/',
            ],
            $this->settings
        );

        return $this->htmlResponse($json);

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



}
