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
        $this->validate('customerId', 'paymentMethodId');

        $data = array();
        $data['customerId'] = $this->getCustomerId();    
        $data['paymentMethodId'] = $this->getPaymentMethodId();    
        
        return array_merge($this->getBaseData(), $data);
    }
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndPoint()."Customers/".$this->getCustomerId()."/PaymentMethod/".$this->getPaymentMethodId();
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return 'DELETE';
    }
}