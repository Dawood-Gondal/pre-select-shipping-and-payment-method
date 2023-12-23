<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_PreSelectShippingAndPaymentMethod
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\PreSelectShippingAndPaymentMethod\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Shipping\Model\Config\Source\Allmethods;

/**
 * Class ShippingMethods
 */
class ShippingMethods implements OptionSourceInterface
{
    /**
     * @var Allmethods
     */
    private $allShippingMethods;

    /**
     * @param Allmethods $allShippingMethods
     */
    public function __construct(
        Allmethods $allShippingMethods
    ) {
        $this->allShippingMethods = $allShippingMethods;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $results = $this->allShippingMethods->toOptionArray(true);
        if (isset($results[0]['label'])) {
            $results[0]['label'] = __('-- Please select --');
        }
        return $results;
    }
}
