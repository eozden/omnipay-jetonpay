<?php

namespace Omnipay\JetonPay\Message;


class CompletePurchaseResponse extends AbstractResponse
{

    public function isSuccessful()
    {
        return isset($this->data['status']) && 'success' === $this->data['status'];
    }

    public function isPending()
    {

        if($this->isSuccessful() || $this->isCanceled()) {
            return false;
        }

        return true;
    }

    public function isCancelled()
    {
        return isset($this->data['status']) && 'cancelled' === $this->data['status'];
    }

    public function getTransactionId()
    {
        if (isset($this->data['paymentId'])) {
            return $this->data['paymentId'];
        }
    }

    public function getCustomerNumber()
    {
        if (isset($this->data['customerNumber'])) {
            return $this->data['customerNumber'];
        }
    }
}