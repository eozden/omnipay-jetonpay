<?php
namespace Omnipay\JetonPay\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{

    public function testGetDataWithoutStatus()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidRequestException');

        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'transactionId' => 5,
            'customerNumber' => 1223344
        ));

        $data = $request->getData();
    }

    public function testGetDataWithoutTransactionId()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidRequestException');

        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'status' => 'success',
            'customerNumber' => 1223344
        ));

        $data = $request->getData();
    }

    public function testGetDataWithoutCustomerNumber()
    {
        $this->expectException('Omnipay\Common\Exception\InvalidRequestException');

        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array(
            'status' => 'success',
            'transactionId' => 5,
        ));

        $data = $request->getData();
    }

    public function testGetData()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize([
            'status' => 'success',
            'transactionId' => 5,
            'customerNumber' => 1223344
        ]);

        $data = $request->getData();

        $this->assertEquals($data['status'], 'success');
        $this->assertEquals($data['paymentId'], 5);
        $this->assertEquals($data['customerNumber'], 1223344);
    }

    public function testSendDataSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('CompletePurchaseSuccess.txt');
        $request = $this->getMockRequest();
        $data = ['status' => 'success', 'paymentId' => 12, 'customerNumber' => 11223344];

        $response = new CompletePurchaseResponse($request, $data);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isCancelled());
        $this->assertEquals($response->getTransactionID(), 12);
        $this->assertEquals($response->getCustomerNumber(), 11223344);
    }
}