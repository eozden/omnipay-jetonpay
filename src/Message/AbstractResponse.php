<?php

namespace Omnipay\JetonPay\Message;

class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function isSuccessful()
    {
        return !$this->isRedirect() && !$this->isPending() && !$this->isCancelled();
    }
}
