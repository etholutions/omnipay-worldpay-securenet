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
        $this->gateway->setSnId('...');
        $this->gateway->setSKey('...');
        $this->gateway->setDeveloperApplication([
            'developerId' => '12345678',
            'version' => '1.2'
        ]);
    }

    public function testRefund()
    {
        $this->options['transactionReference'] = '...';

        $request = $this->gateway->refund($this->options);
        
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\RefundRequest', $request);
        $this->assertEquals('...', $request->getTransactionReference());
        $this->assertEquals('0', $request->getAmountInteger());
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\Response', $response);
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
    }

    public function testCapture()
    {
        $this->options['transactionReference'] = '....';

        $request = $this->gateway->capture($this->options);
        
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\CaptureRequest', $request);
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\Response', $response);
    }

    public function testCreateCustomer(){
        $this->options['firstName'] = '...';
        $this->options['lastName'] = '...';

        $request = $this->gateway->createCustomer($this->options);
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\VaultCreateCustomerRequest', $request);
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\VaultResponse', $response);
    }

    public function testUpdateCustomer(){
        $this->options['customerId'] = '5000017';
        $this->options['firstName'] = '...';

        $request = $this->gateway->updateCustomer($this->options);
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\VaultUpdateCustomerRequest', $request);
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\VaultResponse', $response);

    }

    public function testChargeAndCreateCustomerAndAccount(){
        $this->options['addToVault'] = true;
        $this->options['amount'] = '12.00';
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

        $request = $this->gateway->chargeAndCreateCustomerAndAccount($this->options);
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\VaultChargeAndCreateCustomerAndAccountRequest', $request);
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\VaultResponse', $response);
    }

    public function testTokenizeCard(){

        $this->options['addToVault'] = true;
        $this->options['publicKey'] = '...';
        
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

        $this->options['origin'] = 'www.core.dev';
        $request = $this->gateway->tokenizeCard($this->options);
        // var_dump($request->getData());
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\CreateCardTokenRequest', $request);
        $response = $request->send();
        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\CardTokenResponse', $response);
        var_dump($response->getToken());
    }

    public function testPurchaseWithToken(){
        $this->options['publicKey'] = '...';
        $this->options['amount'] = '12.00';
        $this->options['token'] = '...';
        $this->options['addToVault'] = 'true';

        $request = $this->gateway->purchaseWithToken($this->options);

        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\PurchaseWithTokenRequest', $request);
        $this->assertEquals('1200', $request->getAmountInteger());
        var_dump($request->getData());
        $response = $request->send();

        $this->assertInstanceOf('Omnipay\Worldpaysecurenet\Message\Response', $response);

        var_dump($response->getData());
    }

}