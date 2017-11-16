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
        $this->gateway->setSKey('');
        $this->gateway->setSnId('');
        $this->gateway->setDeveloperApplication([
            'developerId' => '12345678',
            'version' => '1.2'
        ]);

        $authId = "Basic ".base64_encode($this->gateway->getSnId().':'.$this->gateway->getSKey());
        $this->options = array(
            'headers' => array(
                 'Authorization' => $authId,
                 'Content-Type' => 'application/json',
                 'Accept' => 'application/json',
            ),
        );
    }

    public function testRefund()
    {
        $this->options['transactionReference'] = '116085070';

        $request = $this->gateway->refund($this->options);
        
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\RefundRequest', $request);
        $this->assertEquals('116085070', $request->getTransactionReference());
        $this->assertEquals('0', $request->getAmountInteger());
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\Response', $response);
        var_dump($response->getData());
    }

    public function testPurchase()
    {
        $authId = "Basic ".base64_encode($this->gateway->getSnId().':'.$this->gateway->getSKey());
        $cardArray = [];
        $cardArray['firstName'] = "Jon";
        $cardArray['lastName'] = "Mesal";
        $cardArray['number'] = '4444333322221111';
        $cardArray['expiryMonth'] = "12";
        $cardArray['expiryYear'] = "2019";
        $cardArray['billingAddress1']="15202 Lakeview";
        $cardArray['billingAddress2']="Circle";
        $cardArray['billingCity']="Washington, D.C.";
        $cardArray['billingPostcode']='87787';
        $cardArray['billingState']="DC";

        $this->options['card'] = $cardArray;
        $this->options['amount'] = '12.00';

        $request = $this->gateway->purchase($this->options);
        
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\PurchaseRequest', $request);
        $this->assertEquals('4444333322221111', $request->getCard()->getNumber());
        $this->assertEquals('1200', $request->getAmountInteger());
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\Response', $response);
        var_dump($response->getData());
    }

    public function testAuthorize()
    {
        $authId = "Basic ".base64_encode($this->gateway->getSnId().':'.$this->gateway->getSKey());
        
        $cardArray = [];
        $cardArray['firstName'] = "Jon";
        $cardArray['lastName'] = "Mesal";
        $cardArray['number'] = '4444333322221111';
        $cardArray['expiryMonth'] = "12";
        $cardArray['expiryYear'] = "2019";
        $cardArray['billingAddress1']="15202 Lakeview";
        $cardArray['billingAddress2']="Circle";
        $cardArray['billingCity']="Washington, D.C.";
        $cardArray['billingPostcode']='87787';
        $cardArray['billingState']="DC";

        $this->options['card'] = $cardArray;
        $this->options['amount'] = '12.00';

        $request = $this->gateway->authorize($this->options);
        
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\AuthorizeRequest', $request);
        $this->assertEquals('4444333322221111', $request->getCard()->getNumber());
        $this->assertEquals('1200', $request->getAmountInteger());
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\Response', $response);
        var_dump($response->getData());
    }

    public function testCapture()
    {
        $this->options['transactionReference'] = '116084834';

        $request = $this->gateway->capture($this->options);
        
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\CaptureRequest', $request);
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\Response', $response);
        var_dump($response->getData());
    }
}