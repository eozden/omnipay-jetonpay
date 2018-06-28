<?php

namespace Omnipay\JetonPay\Message;

class PurchaseResponse extends AbstractResponse
{

    /**
     * When you do a `purchase` the request is never successful because
     * you need to redirect off-site to complete the purchase.
     */
    public function isSuccessful()
    {
        return false;
    }

    public function getToken()
    {
        return isset($this->data['token'])?$this->data['token']:null;
    }

    public function getTransactionId()
    {
        return isset($this->data['paymentId'])?$this->data['paymentId']:null;
    }

    public function getRedirectUrl()
    {
        return isset($this->data['redirectUrl'])?$this->data['redirectUrl']:null;
    }

    public function isRedirect()
    {
        if(isset($this->data['redirectUrl'])) {
            return true;
        }

        return false;
    }
}