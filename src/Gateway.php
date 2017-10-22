<?php

namespace Omnipay\Securenet;

use Omnipay\Common\AbstractGateway;

/**
 * WorldPay SecureNet Gateway
 *
 * @link https://www.worldpay.com/us/developers/apidocs/getstarted.html
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Securenet';
    }

    public function getDefaultParameters()
    {
       return array(
            'snid' => '',
            'skey' => '',
            'authId' => '',
            'installationId' => '',
            'accountId' => '',
            'secretWord' => '',
            'callbackPassword' => '',
            'testMode' => false,
            'noLanguageMenu' => false,
            'fixContact' => false,
            'hideContact' => false,
            'hideCurrency' => false,
            'signatureFields' => 'snid:skey',
        );
    }

    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    public function getAuthId()
    {
        return $this->getParameter('authId');
    }

    public function setAuthId($value)
    {
        return $this->setParameter('authId', $value);
    }

    public function getSkey()
    {
        return $this->getParameter('skey');
    }

    public function setSkey($value)
    {
        return $this->setParameter('skey', $value);
    }

    public function getSnid()
    {
        return $this->getParameter('snid');
    }

    public function setSnid($value)
    {
        return $this->setParameter('snid', $value);
    }

    public function getSignatureFields()
    {
        return $this->getParameter('signatureFields');
    }

    public function setSignatureFields($value)
    {
        return $this->setParameter('signatureFields', $value);
    }

    public function getInstallationId()
    {
        return $this->getParameter('installationId');
    }

    public function setInstallationId($value)
    {
        return $this->setParameter('installationId', $value);
    }

    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    public function getSecretWord()
    {
        return $this->getParameter('secretWord');
    }

    public function setSecretWord($value)
    {
        return $this->setParameter('secretWord', $value);
    }

    public function getCallbackPassword()
    {
        return $this->getParameter('callbackPassword');
    }

    public function setCallbackPassword($value)
    {
        return $this->setParameter('callbackPassword', $value);
    }

    /**
     * If true, hides WorldPay's language selection menu.
     *
     * @param boolean
     */
    public function getNoLanguageMenu()
    {
        return $this->getParameter('noLanguageMenu');
    }

    public function setNoLanguageMenu($value)
    {
        return $this->setParameter('noLanguageMenu', $value);
    }

    /**
     * If true, prevents editing of address details by user.
     *
     * @param boolean
     */
    public function getFixContact()
    {
        return $this->getParameter('fixContact');
    }

    public function setFixContact($value)
    {
        return $this->setParameter('fixContact', $value);
    }

    /**
     * If true, hides address details from user.
     *
     * @param boolean
     */
    public function getHideContact()
    {
        return $this->getParameter('hideContact');
    }

    public function setHideContact($value)
    {
        return $this->setParameter('hideContact', $value);
    }

    /**
     * If true, hides currency options from user.
     *
     * @param boolean
     */
    public function getHideCurrency()
    {
        return $this->getParameter('hideCurrency');
    }

    public function setHideCurrency($value)
    {
        return $this->setParameter('hideCurrency', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Securenet\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Securenet\Message\CompletePurchaseRequest', $parameters);
    }
}
