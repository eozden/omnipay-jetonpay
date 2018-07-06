<?php
namespace Omnipay\JetonPay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'https://sandbox-walletapi.jeton5.com/api/v2/integration/merchant';

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        $this->setParameter('apiKey', $value);
    }

    public function getAuthorizationToken()
    {
        $response = $this->httpClient->request(
            'POST',
            $this->endpoint . '/authorize',
            [
                'Content-Type' => 'application/json'
            ],
            json_encode(['apiKey' => $this->getApiKey()])
        );

        return $response->getHeader('Authorization');
    }

    protected function sendRequest($method, $endpoint, $data = null)
    {
        $response = $this->httpClient->request(
            $method,
            $this->endpoint . $endpoint,
            [
                'Authorization' => $this->getAuthorizationToken(),
                'Content-Type' => 'application/json'
            ],
            json_encode($data)
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}