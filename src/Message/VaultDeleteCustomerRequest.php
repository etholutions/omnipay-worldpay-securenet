<?php
namespace Omnipay\Worldpaysecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class VaultDeleteCustomerRequest extends VaultAbstractRequest
{

    /**
     * Set up the refund-specific data
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('customerId');

        $data = array();
        $data['customerId'] = $this->getCustomerId();    
        
        return array_merge($this->getBaseData(), $data);
    }
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndPoint()."Customers/".$this->getCustomerId();
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return 'DELETE';
    }
}