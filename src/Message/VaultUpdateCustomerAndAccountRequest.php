<?php
namespace Omnipay\Worldpaysecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class VaultUpdateCustomerAndAccountRequest extends VaultAbstractRequest
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
        
        if($this->getPrimary()){
            $data['primary'] = $this->getPrimary();
        }

        if($this->getCustomerId()){
            $data['customerId'] = $this->getCustomerId();    
        }

        if($this->getPaymentMethodId()){
            $data['paymentMethodId'] = $this->getPaymentMethodId();    
        }
        
        $data['firstName'] = $this->getFirstName();
        $data['lastName'] = $this->getLastName();

        $card = $this->getCard();
        if($card){
            $data["card"] = array(
                "number" => $card->getNumber(),
                "cvv" => $card->getCvv(), 
                "expirationDate" => $card->getExpiryDate('m/Y'), 
                "address" => array(
                    "line1" => $card->getBillingAddress1(),
                    "city" => $card->getBillingCity(),
                    "state" => $card->getBillingState(), 
                    "zip" => $card->getBillingPostcode()
                ),
                "firstName" => $card->getFirstName(),
                "lastName" => $card->getLastName()
            );
        }
        
        return array_merge($this->getBaseData(), $data);
    }
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndPoint()."Customers/".$this->getCustomerId()."Payments";
    }
    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return 'PUT';
    }
}