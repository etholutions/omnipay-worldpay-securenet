<?php
namespace Omnipay\Worldpaysecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class VaultUpdateAccountRequest extends VaultAbstractRequest
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
        return parent::getEndPoint()."Customers/".$this->getCustomerId()."/PaymentMethod/".$this->getPaymentMethodId();
    }
    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return 'PUT';
    }
}