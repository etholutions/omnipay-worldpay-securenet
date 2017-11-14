<?php
namespace Omnipay\WorldPaySecurenet\Message;
use Guzzle\Http\Message\Response as HttpResponse;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
/**
 * WorldPay Purchase Request
 */
class Response extends AbstractResponse
{
    /**
     * @var HttpResponse  HTTP response object
     */
    public $response;
    /**
     * Constructor
     *
     * @param RequestInterface $request   The initiating request
     * @param HttpResponse     $response  HTTP response object
     */
    public function __construct(RequestInterface $request, $response)
    {
        $this->response = $response;
        parent::__construct($request, json_decode($response->getBody(), true));
    }
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $code = $this->response->getStatusCode();
        if($code == 200 && $this->getCode() == 1){
            return true;
        }
        return false;
    }
    /**
     * @return string|null
     */
    public function getMessage()
    {
        if (isset($this->data['message'])) {
            return $this->data['message'];
        }
    }
    /**
     * @return string|null
     */
    public function getCode()
    {
        if (isset($this->data['responseCode'])) {
            return $this->data['responseCode'];
        }
    }
    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        if (isset($this->data['transaction']['transactionId'])) {
            return $this->data['transaction']['transactionId'];
        }
    }
    /**
     * @return string|null
     */
    public function getCardReference()
    {
        if (isset($this->data['transaction']['vaultData']['token'])) {
            return $this->data['transaction']['vaultData']['token'];
        }
    }
}