<?php
namespace Omnipay\Worldpaysecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class VaultCreateCustomerRequest extends VaultAbstractRequest
{

    /**
     * Set up the refund-specific data
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('firstName', 'lastName');

        $data = array();

        if($this->getCustomerId()){
            $data['customerId'] = $this->getCustomerId();    
        }

        $data['firstName'] = $this->getParameter('firstName');
        $data['lastName'] = $this->getParameter('lastName');

        $data["address"] = array(
            "line1" => $this->getBillingAddress1(),
            "city" => $this->getBillingCity(),
            "state" => $this->getBillingState(),
            "zip" => $this->getBillingPostcode()
        );

        return array_merge($this->getBaseData(), $data);
    }
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndPoint()."Customers";
    }
}