<?php
namespace Omnipay\JetonPay\Message;

use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    /**
     * @var \Omnipay\JetonPay\Message\RefundRequest
     */
    protected $request;

    public function testGetDataWithoutCustomerNumberParameter()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidRequestException');

        $request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'apiKey' => 'mykey',
            'amount' => 1,
            'currency' => 'USD',
        ));

        $data = $request->getData();
    }

    public function testGetData()
    {
        $request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'apiKey' => 'mykey',
            'amount' => 1,
            'currency' => 'USD',
            'receiverCustomerNumber' => 1
        ));

        $data = $request->getData();

        $this->assertEquals("1", $data['createPendingWalletTransfer']['amount']);
        $this->assertEquals("USD", $data['createPendingWalletTransfer']['currencyCode']);
        $this->assertEquals("1", $data['createPendingWalletTransfer']['receiverCustomerNumber']);
    }

    public function testSendSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('RefundSuccess.txt');
        $request = $this->getMockRequest();
        $data = json_decode($httpResponse->getBody()->getContents(), true);
        $response = new RefundResponse($request, $data);

        $this->assertInstanceOf('Omnipay\JetonPay\Message\RefundResponse', $response);
        $this->assertTrue($response->isSuccessful());
    }

    public function testSendFail()
    {
        $httpResponse = $this->getMockHttpResponse('RefundFail.txt');
        $request = $this->getMockRequest();
        $data = json_decode($httpResponse->getBody()->getContents(), true);
        $response = new RefundResponse($request, $data);

        $this->assertInstanceOf('Omnipay\JetonPay\Message\RefundResponse', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals($response->getCode(), 400);
        $this->assertEquals($response->getMessage(), "Customer error");
    }
}