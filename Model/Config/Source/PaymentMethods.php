<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_PreSelectShippingAndPaymentMethod
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\PreSelectShippingAndPaymentMethod\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Payment\Helper\Data;

/**
 * Class PaymentMethods
 */
class PaymentMethods implements OptionSourceInterface
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $paymentMethods = $this->helper->getPaymentMethodList();
        $results = [['value' => '', 'label' => __('-- Please select --')]];
        foreach ($paymentMethods as $methodCode => $methodTitle) {
            $results[] = [
                'value' => $methodCode,
                'label' => $methodTitle
            ];
        }
        return $results;
    }
}
