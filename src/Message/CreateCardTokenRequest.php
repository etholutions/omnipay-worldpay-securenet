<?php
namespace Omnipay\Worldpaysecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class CreateCardTokenRequest extends AbstractRequest
{
    /**
     * Gets the origin, which will be the domain of the website. This will be added to the header in the request object.
     * @return String
     */
    public function getOrigin(){
        return $this->getParameter('origin');
    }
    /**
     * Sets the origin, which will be the domain of the website. This will be added to the header in the request object.
     * @param String
     */
    public function setOrigin($value){
        return $this->setParameter('origin', $value);
    }
	
    /**
     * Set up the refund-specific data
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('publicKey', 'card', 'origin');

        $data = array();
        $data['publicKey'] = $this->getPublicKey();
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
        
        $base_data = $this->getBaseData();
        $base_data['headers']['origin'] = $this->getOrigin();

        return array_merge($base_data, $data);
    }
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndPoint()."PreVault/Card";
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\Worldpaysecurenet\Message\CardTokenResponse';
    }
}