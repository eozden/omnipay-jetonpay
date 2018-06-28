<?php

namespace Omnipay\JetonPay;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var \Omnipay\JetonPay\Gateway
     */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'apiKey'          => '12sldkmf2',
            'orderId'         => '1',
            'amount'          => '100',
            'currency'        => 'USD',
            'failRedirectUrl' => 'fail.url'
        ]);

        $this->assertInstanceOf('Omnipay\JetonPay\Message\PurchaseRequest', $request);
    }

    public function testFetchTransaction()
    {
        $request = $this->gateway->fetchTransaction([
            'apiKey'    => '12sldkmf2',
            'paymentId' => '1'
        ]);

        $this->assertInstanceOf('Omnipay\JetonPay\Message\FetchTransactionRequest', $request);
    }

    public function testRefund()
    {
        $request = $this->gateway->refund([
            'apiKey' => '12sldkmf2'
        ]);

        $this->assertInstanceOf('Omnipay\JetonPay\Message\RefundRequest', $request);
    }
}
