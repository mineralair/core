<?php
namespace Mineralair\Core\Observer;
use Magento\Framework\DataObject as _DO;
use Magento\Framework\Event\Observer as Ob;
use Magento\Framework\Event\ObserverInterface;
use Magento\Payment\Model\Method\AbstractMethod as AbM;
use Magento\Payment\Model\Method\Adapter as AdM;
use Magento\Payment\Model\MethodInterface as IM;
use Magento\Quote\Model\Quote as Q;
use Magento\Quote\Model\Quote\Item as QI;
// 2019-03-14
// "Disable the PayPal or Amazon Pay payment methods on the frontend checkout page
// for orders with an «autoshipment» product":
// https://github.com/mineralair/core/issues/4
final class PaymentMethodIsActive implements ObserverInterface {
	/**
	 * 2019-03-14
	 * @override
	 * @see ObserverInterface::execute()
	 * @used-by \Magento\Framework\Event\Invoker\InvokerDefault::_callObserverMethod()
	 * @see \Magento\Payment\Model\Method\Adapter::isAvailable():
	 * @see \Magento\Payment\Model\Method\AbstractMethod::isAvailable():
	 *		$this->eventManager->dispatch(
	 *			'payment_method_is_active', [
	 *				'result' => $checkResult,
	 *				'method_instance' => $this,
	 *				'quote' => $quote
	 *			]
	 *		);
	 *		return $checkResult->getData('is_available');
	 * @param Ob $ob
	 */
	function execute(Ob $ob) {
		$m = $ob['method_instance']; /** @var AbM|AdM|IM $m */
		if (
			df_is_checkout()
			&& ($q = $ob['quote']) /** @var Q|null $q */
			&& (df_contains($m->getCode(), 'amazon') || 'paypal' === df_class_second_lc($m))
			&& mnr_recurring_has($q)
		) {
			$r = $ob['result']; /** @var _DO $r */
			$r['is_available'] = false;
		}
	}
}