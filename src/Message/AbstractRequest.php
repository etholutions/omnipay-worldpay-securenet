<?php
namespace Omnipay\Worldpaysecurenet\Message;

use Guzzle\Http\Message\Response as HttpResponse;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    /**
     * @var string  API endpoint base to connect to
     */
    protected $testEndpoint = 'https://gwapi.demo.securenet.com/api/';
    protected $liveEndpoint = 'https://gwapi.securenet.com/api/';

    abstract public function getData();
    /**
     * Method required to override for getting the specific request endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return ($this->getTestMode()) ? $this->testEndpoint : $this->liveEndpoint;
    }
    /**
     * The HTTP method used to send data to the API endpoint
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
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
     * @param string $value  Sn ID to store
     */
    public function setSnId($value)
    {
        return $this->setParameter('snid', $value);
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
     * Returns the minimum required data that is required to be passed along with every single request.
     * @return Array 
     */
    public function getBaseData(){
        $data = array();
        $data['snid'] = $this->getSnId();
        $data['skey'] = $this->getSKey();
        $data['developerApplication'] = array(
            'developerId' => $this->getDeveloperId(),
            'version' => $this->getDeveloperVersion(),
        );
        $data['extendedInformation'] = array(
            'typeOfGoods' => 'DIGITAL',
        );

        $authId = "Basic ".base64_encode($this->getSnId().':'.$this->getSKey());
        $data['headers'] = array(
             'Authorization' => $authId,
             'Content-Type' => 'application/json',
             'Accept' => 'application/json',
        );
        
        return $data;
    }
    
    /**
     * Make the actual request to WorldPay
     *
     * @param mixed $data  The data to encode and send to the API endpoint
     *
     * @return \Psr\Http\Message\ResponseInterface HTTP response object
     */
    public function sendRequest($data)
    {
        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [],
            json_encode($data)
        );

        $authId = "Basic ".base64_encode($this->getSnId().':'.$this->getSKey());
        $httpRequest = $httpRequest
            ->setHeader('Authorization', $authId)
            ->setHeader('Content-type', 'application/json')
            ->setHeader('Accept', 'application/json');
        $httpResponse = $httpRequest->send();
        return $httpResponse;
    }
    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\Worldpaysecurenet\Message\Response';
    }
    /**
     * Send the request to the API then build the response object
     *
     * @param mixed $data  The data to encode and send to the API endpoint
     *
     * @return JsonResponse
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($data);
        $responseClass = $this->getResponseClassName();
        return $this->response = new $responseClass($this, $httpResponse);
    }
}