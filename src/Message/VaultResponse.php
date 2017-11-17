<?php
namespace Omnipay\Worldpaysecurenet\Message;
use Guzzle\Http\Message\Response as HttpResponse;
use Omnipay\Common\Message\RequestInterface;
/**
 * WorldPay Purchase Request
 */
class VaultResponse extends Response
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
        if (isset($this->data['vaultCustomer']['customerId'])) {
            return $this->data['vaultCustomer']['customerId'];
        }

        if (isset($this->data['vaultPaymentMethod']['customerId'])) {
            return $this->data['vaultPaymentMethod']['customerId'];
        }

    }

    /**
     * @return string|null
     */
    public function getPaymentMethodId()
    {
        if (isset($this->data['vaultPaymentMethod']['paymentId'])) {
            return $this->data['vaultPaymentMethod']['paymentId'];
        }
    }
}