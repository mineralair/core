// 2019-03-16
// "Show the «Sorry for the inconvenience» popup
// if a customer tries to use the PayPal or Amazon Pay payment method
// for an order with an «autoshipment» product": https://github.com/mineralair/core/issues/2
define(['jquery', 'Magento_Ui/js/modal/modal'], function($) {return function() {
	var $content = $('.mnr-modal-content');
	// 2018-05-21
	// How is the `mage.modal` jQuery UI widget implemented and used?
	// https://mage2.pro/t/5518
	var m = $($content.clone().removeClass('df-hidden')).modal({
		buttons: [
			{
				class: 'action primary'
				,click: function () {m.modal('closeModal');}
				,text: $.mage.__('Yes, please convert my order<br/>to a single payment!')
			}
			,{
				class: 'action'
				,click: function () {m.modal('closeModal');}
				,text: $.mage.__('No, I will choose a different payment method')
			}
		]
		,modalClass: 'mnr-modal'
		,type: 'popup'
	});
	m.modal('openModal');
}});