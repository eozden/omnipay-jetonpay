<?php

namespace Omnipay\JetonPay\Message;

class RefundResponse extends AbstractResponse
{

    public function getCode()
    {
        if(isset($this->data['header']) && isset($this->data['header']['statusCode']))
        {
            return $this->data['header']['statusCode'];
        }
    }

    public function isSuccessful()
    {
        return $this->getCode() == 200;
    }

    public function getMessage()
    {
        if (isset($this->data['header']) && isset($this->data['header']['errors'])) {
            return $this->data['header']['errors'];
        }
    }
}