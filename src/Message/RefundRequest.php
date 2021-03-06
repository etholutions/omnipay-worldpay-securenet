<?php
namespace Omnipay\Worldpaysecurenet\Message;
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
        $amount = $this->getAmount();
        if($amount){
            $data['amount'] = $amount;    
        }
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