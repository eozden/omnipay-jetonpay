<?php

namespace Omnipay\JetonPay\Message;


class RefundRequest extends AbstractRequest
{

    public function getReceiverCustomerNumber()
    {
        return $this->getParameter('receiverCustomerNumber');
    }

    public function setReceiverCustomerNumber($value)
    {
        $this->setParameter('receiverCustomerNumber', $value);
    }

    public function getData()
    {
        $this->validate('apiKey', 'receiverCustomerNumber', 'amount', 'currency');

        $data['createPendingWalletTransfer'] = [
            'receiverCustomerNumber' => $this->getReceiverCustomerNumber(),
            'amount'                 => $this->getAmount(),
            'currencyCode'           => $this->getCurrency(),
            'note'                   => $this->getDescription()
        ];

        return $data;
    }

    public function sendData($data)
    {
        $response = $this->sendRequest('POST', '/pay-out-transfer', $data);

        return $this->response = new RefundResponse($this, $response);
    }
}