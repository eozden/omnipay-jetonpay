<?php
namespace Omnipay\JetonPay;

use Omnipay\Common\AbstractGateway;

/**
 * JetonPay Gateway
 *
 * @link https://jeton5.com/jetonpay-documentation
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'JetonPay';
    }

    public function getDefaultParameters()
    {
        return [
            'apiKey'         => null,
            'testMode'       => false,
        ];
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\JetonPay\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\JetonPay\Message\CompletePurchaseRequest', $parameters);
    }

    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\JetonPay\Message\FetchTransactionRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\JetonPay\Message\RefundRequest', $parameters);
    }
}