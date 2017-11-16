<?php
namespace Omnipay\Worldpaysecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class AuthorizeRequest extends PurchaseRequest
{

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return AbstractRequest::getEndPoint().'Payments/Authorize';
    }
}