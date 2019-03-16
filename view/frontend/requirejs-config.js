// 2019-03-15
// "Show the «Sorry for the inconvenience» popup
// if a customer tries to use the PayPal or Amazon Pay payment method
// for an order with an «autoshipment» product": https://github.com/mineralair/core/issues/2
var config = {
	config: {mixins: {
		'Amazon_Payment/js/amazon-button': {'Mineralair_Core/amazon-button': true}
	}}
};