<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_PreSelectShippingAndPaymentMethod
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\PreSelectShippingAndPaymentMethod\Model;

use Magento\Store\Model\ScopeInterface;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class CheckoutConfigProvider
 */
class CheckoutConfigProvider implements ConfigProviderInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        $isEnabledShipping =  $this->scopeConfig->isSetFlag('preSelectShippingPayment/shipping/enable', ScopeInterface::SCOPE_STORE);
        $isEnabledPayment =  $this->scopeConfig->isSetFlag('preSelectShippingPayment/payment/enable', ScopeInterface::SCOPE_STORE);

        $output = [];
        if ($isEnabledShipping) {
            $output['m2c']['shipping'] = [
                'default' => $this->scopeConfig->getValue('preSelectShippingPayment/shipping/default', ScopeInterface::SCOPE_STORE),
            ];
        }
        if ($isEnabledPayment) {
            $output['m2c']['payment'] = [
                'default' => $this->scopeConfig->getValue('preSelectShippingPayment/payment/default', ScopeInterface::SCOPE_STORE),
            ];
        }
        return $output;
    }
}
