<?php
namespace Omnipay\Worldpaysecurenet\Message;
use Guzzle\Http\Message\Response as HttpResponse;
use Omnipay\Common\Message\RequestInterface;
/**
 * WorldPay Purchase Request
 */
class CardTokenResponse extends Response
{
    /**
     * Constructor
     *
     * @param RequestInterface $request   The initiating request
     * @param HttpResponse     $response  HTTP response object
     */
    public function __construct(RequestInterface $request, $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        if (isset($this->data['customerId'])) {
            return $this->data['customerId'];
        }

    }

    /**
     * Gets Token
     * @return string|null
     */
    public function getToken()
    {
        if (isset($this->data['token'])) {
            return $this->data['token'];
        }
    }
}