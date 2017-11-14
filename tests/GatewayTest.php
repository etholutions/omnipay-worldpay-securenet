<?php
namespace Omnipay\WorldPay\Securenet;
use Omnipay\Tests\GatewayTestCase;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setSKey('bar123');
        $this->options = array(
            'amount' => '5.00',
            'token' => 'TEST_RU_7a22d2ec-6725-48b7-b8e7-243f03914b27'
        );
    }
    public function testPurchase()
    {
        $request = $this->gateway->purchase($this->options);
        $this->assertInstanceOf('Omnipay\Worldpay\Securenet\Message\PurchaseRequest', $request);
        $this->assertEquals('TEST_RU_7a22d2ec-6725-48b7-b8e7-243f03914b27', $request->getToken());
        $this->assertEquals('500', $request->getAmountInteger());
    }
}