<?php
namespace Omnipay\WorldPaySecurenet\Message;
/**
 * WorldPay Capture Request
 */
class CaptureRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $this->validate('transactionReference');
        $data = array();
        $data['amount'] = $this->getAmountInteger();
        $data['transactionId'] = $this->getTransactionReference();
        return array_merge($this->getBaseData(), $data);
    }
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndPoint().'Payments/Capture';
    }
}