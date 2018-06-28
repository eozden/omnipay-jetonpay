<?php

namespace Omnipay\JetonPay\Message;

class FetchTransactionResponse extends AbstractResponse
{

    public function isPending()
    {
        if(isset($this->data['status'])) {
            return $this->data['status'] === 'INITIALIZED';
        }

        return false;
    }

    public function isCancelled()
    {
        return isset($this->data['status']) && 'cancelled' === $this->data['status'];
    }

    public function getTransactionReference()
    {
        if (isset($this->data['merchantOrderId'])) {
            return $this->data['merchantOrderId'];
        }
    }

    public function getTransactionId()
    {
        if (isset($this->data['paymentId'])) {
            return $this->data['paymentId'];
        }
    }

    public function getStatus()
    {
        if (isset($this->data['status'])) {
            return $this->data['status'];
        }
    }

    public function getAmount()
    {
        if (isset($this->data['paymentAmount'])) {
            return $this->data['paymentAmount'];
        }
    }

    public function getCurrency()
    {
        if (isset($this->data['currencyCode'])) {
            return $this->data['currencyCode'];
        }
    }

    public function getCustomerNumber()
    {
        if (isset($this->data['customerNumber'])) {
            return $this->data['customerNumber'];
        }
    }
}