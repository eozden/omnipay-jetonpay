<?php

namespace Omnipay\JetonPay\Message;


class PurchaseRequest extends AbstractRequest
{

    public function getFailRedirectUrl()
    {
        return $this->getParameter('failRedirectUrl');
    }

    public function setFailRedirectUrl($value)
    {
        $this->setParameter('failRedirectUrl', $value);
    }

    public function getCustomerNumber()
    {
        return $this->getParameter('customerNumber');
    }

    public function setCustomerNumber($value)
    {
        $this->setParameter('customerNumber', $value);
    }

    public function getData()
    {
        $this->validate('apiKey', 'transactionReference', 'amount', 'currency');

        $data                       = [];
        $data['orderId']            = $this->getTransactionReference();
        $data['paymentAmount']      = $this->getAmount();
        $data['currencyCode']       = $this->getCurrency();

        if(!is_null($this->getCustomerNumber())) {
            $data['customerNumber'] = $this->getCustomerNumber();
        }

        if(!is_null($this->getReturnUrl())) {
            $data['successRedirectUrl'] = $this->getReturnUrl();
        }

        if(!is_null($this->getCancelUrl())) {
            $data['cancelRedirectUrl'] = $this->getCancelUrl();
        }

        if(!is_null($this->getFailRedirectUrl())) {
            $data['failRedirectUrl'] = $this->getFailRedirectUrl();
        }

        if(!is_null($this->getItems())) {

            foreach($this->getItems() as $item) {
                $data['paymentItems'][] = [
                    'amount'      => $item->getPrice(),
                    'count'       => $item->getQuantity(),
                    'description' => $item->getDescription()
                ];
            }
        }

        return $data;
    }

    public function sendData($data)
    {
        $response = $this->sendRequest('POST', '/initiate-payment', $data);

        return $this->response = new PurchaseResponse($this, $response);
    }

    protected function sendRequest($method, $endpoint, $data = null)
    {
        $response = $this->httpClient->request(
            $method,
            $this->endpoint . $endpoint,
            [
                'X-PAY-API-KEY' => $this->getApiKey(),
                'Content-Type' => 'application/json'
            ],
            json_encode($data)
        );

        return json_decode($response->getBody(), true);
    }
}