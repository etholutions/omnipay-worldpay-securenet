<?php
namespace Omnipay\WorldPay\Securenet\Message;
use Guzzle\Http\Message\Response as HttpResponse;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
abstract class AbstractRequest extends AbstractRequest
{
    /**
     * @var string  API endpoint base to connect to
     */
    protected $testEndpoint = 'https://gwapi.demo.securenet.com/api/';
    protected $liveEndpoint = 'https://gwapi.securenet.com/api/';
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

        $authId = "Basic ".base64_encode($this->getSnId().':'.$this->getSKey());

        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [],
            json_encode($data)
        );
        $httpRequest = $httpRequest
            ->withHeader('Authorization', $authId)
            ->withHeader('Content-type', 'application/json')
            ->withHeader('Accept', 'application/json');
        $httpResponse = $this->httpClient->sendRequest($httpRequest);
        return $httpResponse;
    }
    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return '\Omnipay\WorldPay\Securenet\Message\Response';
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