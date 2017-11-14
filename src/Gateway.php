<?php

namespace Omnipay\WorldPaySecurenet;

use Http\Adapter\Guzzle6\Client;
use Omnipay\Common\AbstractGateway;

/**
 * WorldPay Gateway
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
        return 'WorldPay Securenet';
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
     * Create purchase request
     *
     * @param array $parameters
     *
     * @return \Omnipay\WorldPay\Securenet\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPaySecurenet\Message\PurchaseRequest', $parameters);
    }

    /**
     * Create authorize request
     *
     * @param array $parameters
     *
     * @return \Omnipay\WorldPay\Securenet\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPaySecurenet\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Create refund request
     *
     * @param array $parameters
     *
     * @return \Omnipay\WorldPay\Securenet\Message\RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPaySecurenet\Message\RefundRequest', $parameters);
    }

    /**
     * Create capture request
     *
     * @param array $parameters
     *
     * @return \Omnipay\WorldPay\Securenet\Message\CaptureRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPaySecurenet\Message\CaptureRequest', $parameters);
    }

    protected function getDefaultHttpClient()
    {
        $guzzleClient = Client::createWithConfig([
            'curl.options' => [
                CURLOPT_SSLVERSION => 6
            ]
        ]);


        return new \Omnipay\Common\Http\Client($guzzleClient);
    }
}