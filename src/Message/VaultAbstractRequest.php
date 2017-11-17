<?php
namespace Omnipay\Worldpaysecurenet\Message;
/**
 * WorldPay Purchase Request
 */
class VaultAbstractRequest extends AbstractRequest
{

    /**
     * Sets FirstName on the request object, not on the card object
     * @param String $value
     */
    public function setFirstName($value){
        $this->setParameter('firstName', $value);
    }
    /**
     * Gets FirstName from the request object, not from the card object
     * @return String
     */
    public function getFirstName(){
        $this->getParameter('firstName');
    }
    /**
     * Sets lastName on the request object, not on the card object
     * @param String $value
     */
    public function setLastName($value){
        $this->setParameter('lastName', $value);
    }
    /**
     * Gets lastName from the request object, not from the card object
     * @return String
     */
    public function getLastName(){
        $this->getParameter('lastName');
    }
    /**
     * Sets Billing Address Line 1 on the request object, not on the card object
     * @param String $value
     */
    public function setBillingAddress1($value){
        $this->setParameter('billingAddress1', $value);
    }
    /**
     * Gets Billing Address Line 1 from the request object, not from the card object
     * @return String
     */
    public function getBillingAddress1(){
        $this->getParameter('billingAddress1');
    }
    /**
     * Sets Billing Address Line 2 on the request object, not on the card object
     * @param String $value
     */
    public function setBillingAddress2($value){
        $this->setParameter('billingAddress2', $value);
    }   
    /**
     * Gets Billing Address Line 2 from the request object, not from the card object
     * @return String
     */
    public function getBillingAddress2(){
        $this->getParameter('billingAddress2');
    }
    /**
     * Sets City on the request object, not on the card object
     * @param String $value
     */
    public function setBillingCity($value){
        $this->setParameter('billingCity', $value);
    }   
    /**
     * Gets City from the request object, not from the card object
     * @return String
     */
    public function getBillingCity(){
        $this->getParameter('billingCity');
    }
    /**
     * Sets State on the request object, not on the card object
     * @param String $value
     */
    public function setBillingState($value){
        $this->setParameter('billingState', $value);
    }   
    /**
     * Gets State from the request object, not from the card object
     * @return String
     */
    public function getBillingState(){
        $this->getParameter('billingState');
    }
    /**
     * Sets Zip on the request object, not on the card object
     * @param String $value
     */
    public function setBillingPostcode($value){
        $this->setParameter('billingPostCode', $value);
    }   
    /**
     * Gets Zip from the request object, not from the card object
     * @return String
     */
    public function getBillingPostcode(){
        $this->getParameter('billingPostCode');
    }
    /**
     * Set Primary
     * @param String $value
     */
    public function setPrimary($value){
        return $this->setParameter('primary', $value);
    }

    /**
     * Get Primary
     * @param String $value
     */
    public function getPrimary(){
        return $this->getParameter('primary');
    }

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
     * Set CustomerID
     * @param String $value
     */
    public function setCustomerId($value){
        return $this->setParameter('customerId', $value);
    }

    /**
     * Get CustomerID
     * @param String $value
     */
    public function getCustomerId(){
        return $this->getParameter('customerId');
    }

    /**
     * Set PaymentMethodId
     * @param String $value
     */
    public function setPaymentMethodId($value){
        return $this->setParameter('paymentMethodId', $value);
    }

    /**
     * Get PaymentMethodId
     * @param String $value
     */
    public function getPaymentMethodId(){
        return $this->getParameter('paymentMethodId');
    }

    /**
     * Set up the refund-specific data
     *
     * @return mixed
     */
    public function getData()
    {
        $data = array();
        return array_merge($this->getBaseData(), $data);
    }
    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndPoint();
    }
    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\Worldpaysecurenet\Message\VaultResponse';
    }
}