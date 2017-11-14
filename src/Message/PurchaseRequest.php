<?php
namespace Omnipay\WorldPaySecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('amount', 'card');
        $data = array();

        $card = $this->getCard();
        $data['amount'] = $this->getAmount();
        if($card){
            $data['card'] = array(
                'number' => $card->getNumber(),
                'cvv' => $card->getCvv(), 
                "expirationDate" => ->getExpiryDate('m/Y'), 
                "address" => array(
                    "line1" => $card->getBillingAddress1().' '.$card->getBillingAddress2(),
                    "city" => $card->getBillingCity(),
                    "state" => $card->getBillingState(), 
                    "zip" => $card->getBillingPostcode()
                ),
                "firstName" => $card->getFirstName(),
                "lastName" => $card->getLastName()
            ),
        }
        
        return array_merge($this->getBaseData(), $data);
    }
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndPoint().'Payments/Charge';
    }
}