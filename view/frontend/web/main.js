// 2019-03-15
// "Show the «Sorry for the inconvenience» popup
// if a customer tries to use the PayPal or Amazon Pay payment method
// for an order with an «autoshipment» product": https://github.com/mineralair/core/issues/
define(['jquery', 'Mineralair_Core/modal', 'domReady!'], function($, modal) {return function() {
	$('a[data-action=paypal-in-context-checkout] > img').click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		modal();
	});
}});