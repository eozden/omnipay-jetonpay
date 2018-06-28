<?php

namespace Omnipay\JetonPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('apiKey');

        if(is_null($this->getTransactionId()) && is_null($this->getTransactionReference())) {
            throw new InvalidRequestException("The paymentId vs MerchantOrderId parameter is required.");
        }

        $data = [];
        if(!is_null($this->getTransactionId())) {
            $data['paymentId'] = $this->getTransactionId();
        }

        if(!is_null($this->getTransactionReference())) {
            $data['merchantOrderId'] = $this->getTransactionReference();
        }

        return $data;
    }

    public function sendData($data)
    {
        $response = $this->sendRequest('POST', '/payment/details', $data);

        return $this->response = new FetchTransactionResponse($this, $response);
    }
}