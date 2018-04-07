<?php
namespace Omnipay\Worldpaysecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class VaultDeleteAccountRequest extends VaultAbstractRequest
{

    /**
     * Set up the refund-specific data
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('customerId', 'cardReference');

        $data = array();
        $data['customerId'] = $this->getCustomerId();    
        $data['paymentMethodId'] = $this->getCardReference();
        return array_merge($this->getBaseData(), $data);
    }
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndPoint()."Customers/".$this->getCustomerId()."/PaymentMethod/".$this->getCardReference();
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return 'DELETE';
    }
}