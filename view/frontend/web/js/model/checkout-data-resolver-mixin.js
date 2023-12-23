/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_PreSelectShippingAndPaymentMethod
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

define([
    'underscore',
    'Magento_Checkout/js/checkout-data',
    'Magento_Checkout/js/model/payment-service',
    'Magento_Checkout/js/action/select-shipping-method',
    'Magento_Checkout/js/action/select-payment-method'
],function (_, checkoutData, paymentService, selectShippingMethodAction, selectPaymentMethodAction) {
    'use strict';

    return function (checkoutDataResolver) {
        var checkoutDataResolverShipping = checkoutDataResolver.resolveShippingRates,
            checkoutDataResolverPayment = checkoutDataResolver.resolvePaymentMethod,
            checkoutConfig = window.checkoutConfig;
        return _.extend(checkoutDataResolver, {
            /**
             * @inheritdoc
             */
            resolveShippingRates: function (ratesData) {
                var selectedShippingRate = checkoutData.getSelectedShippingRate();
                if (!_.isUndefined(checkoutConfig.m2c) && !_.isUndefined(checkoutConfig.m2c.shipping) && !selectedShippingRate && ratesData && ratesData.length > 1) {
                    var defaultShipping = checkoutConfig.m2c.shipping.default;
                    this._autoSelect(defaultShipping, ratesData, 'shipping');
                }
                return checkoutDataResolverShipping.apply(this, arguments);
            },

            /**
             * @inheritdoc
             */
            resolvePaymentMethod: function () {
                var availablePaymentMethods = paymentService.getAvailablePaymentMethods(),
                    selectedPaymentMethod = checkoutData.getSelectedPaymentMethod();
                if (!_.isUndefined(checkoutConfig.m2c) && !_.isUndefined(checkoutConfig.m2c.payment) && !selectedPaymentMethod && availablePaymentMethods
                    && availablePaymentMethods.length > 1) {
                    var defaultPayment = checkoutConfig.m2c.payment.default;
                    this._autoSelect(defaultPayment, availablePaymentMethods, 'payment');
                }
                return checkoutDataResolverPayment.apply(this);
            },

            /**
             * Auto select with config
             * @param {String} defaultMethod
             * @param {String} availableMethods
             * @param {String} step
             */
            _autoSelect: function (defaultMethod, availableMethods, step) {
                if (!_.isUndefined(defaultMethod) && defaultMethod) {
                    var selectMethod = '';
                    availableMethods.some(function (method) {
                        if ((step === 'payment' && method.method === defaultMethod) ||
                            (step === 'shipping' && (method.carrier_code + '_' + method.method_code === defaultMethod))
                        ) {
                            selectMethod = method;
                        }
                    });
                }
                if (selectMethod) {
                    if (step === 'shipping') {
                        selectShippingMethodAction(selectMethod);
                    } else {
                        selectPaymentMethodAction(selectMethod);
                    }
                } else {
                    if (step === 'shipping') {
                        selectShippingMethodAction(availableMethods[0]);
                    } else {
                        selectPaymentMethodAction(availableMethods[0]);
                    }

                }
            }
        });
    };
});
