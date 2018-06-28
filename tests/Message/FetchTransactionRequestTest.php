<?php
namespace Omnipay\JetonPay\Message;

use Omnipay\Tests\TestCase;

class FetchTransactionRequestTest extends TestCase
{

    public function testGetDataWithoutApiKey()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidRequestException');

        $request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'paymentId' => 5,
        ));

        $data = $request->getData();
    }

    public function testGetDataWithoutPaymentIdAndMerchantOrderId()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidRequestException');

        $request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'apiKey' => 'myKey',
        ));

        $data = $request->getData();
    }

    public function testGetDataWithPaymentId()
    {
        $request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'apiKey' => 'myKey',
            'transactionId' => 5
        ));

        $data = $request->getData();

        $this->assertEquals($data['paymentId'], 5);
    }

    public function testGetDataWithMerchantOrderId()
    {
        $request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'apiKey' => 'myKey',
            'transactionReference' => 5
        ));

        $data = $request->getData();

        $this->assertEquals($data['merchantOrderId'], 5);
    }

    public function testSendSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('FetchTransactionSuccess.txt');
        $request = $this->getMockRequest();
        $data = json_decode($httpResponse->getBody()->getContents(), true);
        $response = new FetchTransactionResponse($request, $data);

        $this->assertInstanceOf('Omnipay\JetonPay\Message\FetchTransactionResponse', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isCancelled());
        $this->assertEquals($response->getTransactionReference(), 'ABC123DEF');
        $this->assertEquals($response->getTransactionId(), '1234');
        $this->assertEquals($response->getStatus(), 'PAID');
        $this->assertEquals($response->getAmount(), '15');
        $this->assertEquals($response->getCurrency(), 'EUR');
        $this->assertEquals($response->getCustomerNumber(), '11223344');
    }

    public function testSendInitialized()
    {
        $httpResponse = $this->getMockHttpResponse('FetchTransactionInitialized.txt');
        $request = $this->getMockRequest();
        $data = json_decode($httpResponse->getBody()->getContents(), true);
        $response = new FetchTransactionResponse($request, $data);

        $this->assertInstanceOf('Omnipay\JetonPay\Message\FetchTransactionResponse', $response);
        $this->assertTrue($response->isPending());
    }
}