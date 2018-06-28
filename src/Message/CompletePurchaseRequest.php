<?php

namespace Omnipay\JetonPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getCustomerNumber()
    {
        return $this->getParameter('customerNumber');
    }

    public function setCustomerNumber($value)
    {
        $this->setParameter('customerNumber', $value);
    }

    public function getStatus()
    {
        return $this->getParameter('status');
    }

    public function setStatus($value)
    {
        $this->setParameter('status', $value);
    }

    public function getData()
    {
        $this->validate('status', 'transactionId', 'customerNumber');

        $data['paymentId'] = $this->getTransactionId();
        $data['customerNumber'] = $this->getCustomerNumber();
        $data['status'] = $this->getStatus();

        return $data;
    }
    // @todo: check this naming convention,
    // is this logical maybe we need to use another method name
    public function sendData($data)
    {
        return $this->createResponse($data);
    }

    protected function createResponse($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}