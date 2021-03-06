<?php

namespace Omnipay\Worldpaysecurenet;

use Guzzle\Http\Client;
use Omnipay\Common\AbstractGateway;

/**
 * Worldpaysecurenet Gateway
 *
 * ### Dashboard
 *
 * For test payments you should be given a Login URL which will be
 * https://gwapi.demo.securenet.com/api/Payments/(Charge/Refund/Authorize/Capture)
 *
 * ... and some website credentials.  These will be:
 *
 * * SKEY
 * * SNID
 * * DEVELOPER_ID
 * * VERSION
 *
 * Secure Key - You can obtain the Secure Key by signing into the Virtual Terminal with the login credentials that you were emailed to you during the sign-up process. You will then need to navigate to Settings and click on the Key Management link.
 * 
 * Public Key - This is only used if you are going to make tokenization calls. It too can be obtained in your Virtual Terminal. Note that although they sound similar, the Public Key and Secure Key are two separate pieces of data used for different purposes.
 *
 * @link http://www.worldpay.com/us/developers/apidocs/getstarted.html
 */
class Gateway extends AbstractGateway
{
    /**
     * Name of the gateway
     *
     * @return string
     */
    public function getName()
    {
        return 'Worldpaysecurenet';
    }

    /**
     * Setup the default parameters
     *
     * @return string[]
     */
    public function getDefaultParameters()
    {
        return array(
            'snid' => '',
            'skey' => '',
            'developerApplication' => [],
        );
    }

    /**
     * Get the stored service key
     *
     * @return string
     */
    public function getSKey()
    {
        return $this->getParameter('skey');
    }

    /**
     * Set the stored service key
     *
     * @param string $value  Service key to store
     */
    public function setSKey($value)
    {
        return $this->setParameter('skey', $value);
    }

    /**
     * Get the stored Sn ID
     *
     * @return string
     */
    public function getSnId()
    {
        return $this->getParameter('snid');
    }

    /**
     * Set the stored Sn ID
     *
     * @param string $value  Merchant ID to store
     */
    public function setSnId($value)
    {
        return $this->setParameter('snid', $value);
    }

    /**
     * Gets the Developer ID
     * @return String
     */
    public function getDeveloperId(){
        $devApp = $this->getParameter('developerApplication');
        if(isset($devApp['developerId'])){
            return $devApp['developerId'];
        }
        return null;
    }

    /**
     * Sets the Developer ID
     * @params String
     */
    public function setDeveloperId($value){
        $existing = $this->getParameter('developerApplication');
        if(!$existing){
            $existing = [];
        }
        $existing['developerId'] = $value;
        return $this->setParameter('developerApplication', $existing);
    }

    /**
     * Gets the Developer Version
     * @return String
     */
    public function getDeveloperVersion(){
        $devApp = $this->getParameter('developerApplication');
        if(isset($devApp['version'])){
            return $devApp['version'];
        }
        return null;
    }

    /**
     * Sets the Developer Version
     * @params String
     */
    public function setDeveloperVersion($value){
        $existing = $this->getParameter('developerApplication');
        if(!$existing){
            $existing = [];
        }
        $existing['version'] = $value;
        return $this->setParameter('developerApplication', $existing);
    }

    /**
     * Gets the Developer Application
     *
     * Format:
     * [
     *     'developerId' => 
     *     'version' => 
     * ]
     * @return Array 
     */
    public function getDeveloperApplication(){
        return array(
            'developerId' => $this->getDeveloperId(),
            'version' => $this->getDeveloperVersion()
        );
    }

    /**
     * Sets the Developer Application parameter
     *
     * Format:
     * [
     *     'developerId' => 
     *     'version' => 
     * ]
     * @param Array $value
     */
    public function setDeveloperApplication($value){
        $idSet = false;
        if(isset($value['developerId'])){
            $idSet = $this->setDeveloperId($value['developerId']);
        }

        $versionSet = false;
        if(isset($value['version'])){
            $versionSet = $this->setDeveloperVersion($value['version']);
        }

        return ($idSet or $versionSet);
    }

    /**
     * Create purchase request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        $cardNotPresent = ( (!isset($parameters['card'])) || $parameters['card']==null );
        $cardReferencePresent = ( isset($parameters['cardReference']) && $parameters['cardReference']!=null );

        if($cardNotPresent && $cardReferencePresent){
            return $this->purchaseWithToken($parameters);
        }
        
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\PurchaseRequest', $parameters);
    }

    /**
     * Create authorize request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Create refund request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\RefundRequest', $parameters);
    }

    /**
     * Create capture request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\CaptureRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\CaptureRequest', $parameters);
    }

    /**
     * Create Customer request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\VaultCreateCustomerRequest
     */
    public function createCustomer(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\VaultCreateCustomerRequest', $parameters);
    }

    /**
     * Update Customer request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\VaultUpdateCustomerRequest
     */
    public function updateCustomer(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\VaultUpdateCustomerRequest', $parameters);
    }

    /**
     * Delete Customer request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\VaultDeleteCustomerRequest
     */
    public function deleteCustomer(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\VaultDeleteCustomerRequest', $parameters);
    }

    /**
     * Create Account request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\VaultCreateAccountRequest
     */
    public function createAccount(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\VaultCreateAccountRequest', $parameters);
    }

    /**
     * Update Account request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\VaultUpdateAccountRequest
     */
    public function updateAccount(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\VaultUpdateAccountRequest', $parameters);
    }

    /**
     * Delete Account request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\VaultDeleteAccountRequest
     */
    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\VaultDeleteAccountRequest', $parameters);
    }

    /**
     * Create Customer and Account request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\VaultCreateCustomerAndAccountRequest
     */
    public function createCustomerAndAccount(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\VaultCreateCustomerAndAccountRequest', $parameters);
    }

    /**
     * Update Customer and Account request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\VaultUpdateCustomerAndAccountRequest
     */
    public function updateCustomerAndAccount(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\VaultUpdateCustomerAndAccountRequest', $parameters);
    }

    /**
     * Charge and Create Account and Customer request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\VaultChargeAndCreateCustomerAndAccountRequest
     */
    public function chargeAndCreateCustomerAndAccount(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\VaultChargeAndCreateCustomerAndAccountRequest', $parameters);
    }

    /**
     * Creates token for future payments
     * @param  array  $parameters 
     * @return \Omnipay\Worldpaysecurenet\Message\CreateCardTokenRequest             
     */
    public function tokenizeCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\CreateCardTokenRequest', $parameters);
    }

    /**
     * Create purchase request from token
     *
     * @param array $parameters
     *
     * @return \Omnipay\Worldpaysecurenet\Message\PurchaseWithTokenRequest
     */
    public function purchaseWithToken(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Worldpaysecurenet\Message\PurchaseWithTokenRequest', $parameters);
    }

    protected function getDefaultHttpClient()
    {
        $guzzleClient = new Client;
        $guzzleClient->setConfig([
            'curl.options' => [
                CURLOPT_SSLVERSION => 6
            ]
        ]);
        return $guzzleClient;
    }
}