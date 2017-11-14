<?php
namespace Omnipay\WorldPaySecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class RefundRequest extends AbstractRequest
{
    /**
     * Set up the refund-specific data
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('transactionReference');
        $data = array();
        $data['amount'] = $this->getAmount();
        $data['transactionId'] = $this->getTransactionReference();
        return array_merge($this->getBaseData(), $data);
    }
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndPoint().'Payments/Refund';
    }
}