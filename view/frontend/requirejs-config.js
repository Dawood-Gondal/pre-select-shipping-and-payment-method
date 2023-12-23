/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_PreSelectShippingAndPaymentMethod
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/model/checkout-data-resolver': {
                'M2Commerce_PreSelectShippingAndPaymentMethod/js/model/checkout-data-resolver-mixin': true
            }
        }
    }
};
