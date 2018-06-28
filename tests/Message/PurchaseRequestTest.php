<?php
namespace Omnipay\JetonPay\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{

    public function testGetDataWithoutOrderId()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidRequestException');

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'apiKey' => 'mykey',
            'amount' => 5,
            'currency' => 'USD',
        ));

        $data = $request->getData();
    }

    public function testGetDataWithoutAmount()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidRequestException');

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'apiKey' => 'mykey',
            'transactionReference' => 1,
            'currency' => 'USD',
        ));

        $data = $request->getData();
    }

    public function testGetDataWithoutCurrency()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidRequestException');

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'apiKey' => 'mykey',
            'transactionReference' => 1,
            'amount' => 5,
        ));

        $data = $request->getData();
    }

    public function testGetDataWithoutApiKey()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidRequestException');

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'transactionReference' => 1,
            'amount' => 5,
            'currency' => 'USD',
        ));

        $data = $request->getData();
    }

    public function testGetData()
    {
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize([
            'apiKey'   => 'mykey',
            'transactionReference'  => 1,
            'amount'   => 5,
            'currency' => 'USD'
        ]);

        $data = $request->getData();

        $this->assertEquals($data['orderId'], 1);
        $this->assertEquals($data['paymentAmount'], 5);
        $this->assertEquals($data['currencyCode'], 'USD');
    }

    public function testSendRedirect()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseSuccess.txt');
        $request = $this->getMockRequest();
        $data = json_decode($httpResponse->getBody()->getContents(), true);
        $response = new PurchaseResponse($request, $data);

        $this->assertInstanceOf('Omnipay\JetonPay\Message\PurchaseResponse', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals($response->getToken(), 'eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIzIiwibWVyY2hhbnRJZCI6MywicGF5bWVudElkIjoyODAzLCJleHAiOjE0ODA1NDI0ODIsImlhdCI6MTQ4MDUzODg4Mn0.QkHg7gZRcs-TznU_gHJCOMgHeIVYqjlDL7gkH4hDzg4eB0JiLMA3o2zmRtNBW_aOt-quHHU8yJJQor9qgD2K_g');
        $this->assertEquals($response->getRedirectUrl(), 'https://sandbox-wallet.jeton.com/pay?token=eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIzIiwibWVyY2hhbnRJZCI6MywicGF5bWVudElkIjoyODAzLCJleHAiOjE0ODA1NDI0ODIsImlhdCI6MTQ4MDUzODg4Mn0.QkHg7gZRcs-TznU_gHJCOMgHeIVYqjlDL7gkH4hDzg4eB0JiLMA3o2zmRtNBW_aOt-quHHU8yJJQor9qgD2K_g');
        $this->assertEquals($response->getTransactionId(), 1234);
    }
}