/**
 * 2019-03-15
 * "Show the «Sorry for the inconvenience» popup
 * if a customer tries to use the PayPal or Amazon Pay payment method
 * for an order with an «autoshipment» product": https://github.com/mineralair/core/issues/2
 * 2) «How to rewrite widget function with mixins?» https://magento.stackexchange.com/a/144862
 */
define([
	'jquery', 'Mineralair_Core/modal'
], function($, modal) {return function(parent) {$.widget('amazon.AmazonButton', parent, {
	/**
	 * 2019-03-15
	 * @override
	 * @see Amazon_Payment/js/amazon-button::_renderAmazonButton()
	 * @private
	 */
	_renderAmazonButton: function() {
		OffAmazonPayments.Button(this.element.attr('id'), this.options.merchantId, {
			authorization: $.proxy(function() {modal();}, this)
			,color: this.options.buttonColor
			,language: this.options.buttonLanguage
			,size: this.options.buttonSize
			,type: this.options.buttonType
		});
		$('.amazon-button-container .field-tooltip').fadeIn();
	}
}); return $.amazon.AmazonButton;};});