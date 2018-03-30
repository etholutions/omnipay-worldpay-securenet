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
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('amount', 'cardReference', 'publicKey');
        $data = array();

        $data['amount'] = $this->getAmount();
        $data['customerId'] = $this->getCustomerId();

        $data['paymentVaultToken'] = array(
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