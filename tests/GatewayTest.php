<?php
namespace Omnipay\Worldpaysecurenet;

// use Omnipay\Tests\GatewayTestCase;
use PHPUnit_Framework_TestCase;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class GatewayTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway();
        $this->gateway->initialize(array(
            'testMode' => true,
        ));
        $this->gateway->setSKey('IP7bSH068Ij3');
        $this->gateway->setSnId('8011016');
        $this->gateway->setDeveloperApplication([
            'developerId' => '12345678',
            'version' => '1.2'
        ]);

        $authId = "Basic ".base64_encode($this->gateway->getSnId().':'.$this->gateway->getSKey());
        $this->options = array(
            'transactionReference' => 'TEST_RU_7a22d2ec-6725-48b7-b8e7-243f03914b27',
            'headers' => array(
                 'Authorization' => $authId,
                 'Content-Type' => 'application/json',
                 'Accept' => 'application/json',
            ),
        );
    }
    public function testRefund()
    {
        $request = $this->gateway->refund($this->options);
        
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\RefundRequest', $request);
        $this->assertEquals('TEST_RU_7a22d2ec-6725-48b7-b8e7-243f03914b27', $request->getTransactionReference());
        $this->assertEquals('0', $request->getAmountInteger());
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\Response', $response);
        var_dump($response->getData());
    }
}