// 2019-03-15
// "Show the «Sorry for the inconvenience» popup
// if a customer tries to use the PayPal or Amazon Pay payment method
// for an order with an «autoshipment» product": https://github.com/mineralair/core/issues/
define(['jquery', 'domReady!'], function($) {return function() {
	$('a[data-action=paypal-in-context-checkout] > img').click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		alert('test');
	});
}});