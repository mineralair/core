// 2019-03-16
// "Show the «Sorry for the inconvenience» popup
// if a customer tries to use the PayPal or Amazon Pay payment method
// for an order with an «autoshipment» product": https://github.com/mineralair/core/issues/
define(['jquery', 'Magento_Ui/js/modal/modal'], function($) {return function() {
	var $content = $('<div>TEST</div>');
	// 2018-05-21
	// How is the `mage.modal` jQuery UI widget implemented and used?
	// https://mage2.pro/t/5518
	var m = $content.modal({
		buttons: [{
			class: 'action primary'
			,click: function () {m.modal('closeModal'); _super();}
			,text: $.mage.__('Continue')
		}]
		,modalClass: 'albumenvy-popup'
		,type: 'popup'
	});
	m.modal('openModal');
}});