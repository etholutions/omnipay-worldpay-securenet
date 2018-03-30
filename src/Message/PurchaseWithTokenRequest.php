<?php
namespace Omnipay\Worldpaysecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class PurchaseWithTokenRequest extends AbstractRequest
{
    /**
     * Set AddToVault
     * @param String $value
     */
    public function setAddToVault($value){
        return $this->setParameter('addToVault', $value);
    }

    /**
     * Get AddToVault
     * @param String $value
     */
    public function getAddToVault(){
        return $this->getParameter('addToVault');
    }

    /**
     * Sets the customer ID 
     * @param String CustomerId
     */
    public function setCustomerId(String $customerId)
    {
        $this->setParameter('customerId', $customerId);
    }

    /**
     * Gets the customerId
     * @return String 
     */
    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }
    
    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('amount', 'cardReference', 'publicKey');
        
        $data = array();
        $data['publicKey'] = $this->getPublicKey();
        $data['amount'] = $this->getAmount();
        $data['paymentVaultToken'] = array(
            "customerId" => $this->getCustomerId(),
            "paymentMethodId" => $this->getCardReference(),
            "publicKey" => $this->getPublicKey()
        );
        $data['addToVault'] = $this->getAddToVault();
        
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