<?php
use Magento\Quote\Model\Quote as Q;
use Magento\Quote\Model\Quote\Item as QI;
/**
 * 2019-03-17
 * @uses mnr_recurring_is()
 * @used-by \Mineralair\Core\Js::_toHtml()
 * @used-by \Mineralair\Core\Observer\PaymentMethodIsActive::execute()
 * @param Q|null $q [optional]
 * @return array(int => QI)
 */
function mnr_recurring_filter(Q $q = null) {return array_filter(df_quote($q)->getItems(), 'mnr_recurring_is');}

/**
 * 2019-03-17
 * @used-by mnr_recurring_filter()
 * @used-by mnr_recurring_has()
 * @param QI $i
 * @return bool
 */
function mnr_recurring_is(QI $i) {return
	df_contains($s = $i->getSku(), 'delivery-schedule') && !df_ends_with($s, 'delivery-schedule-0')
;}


/**
 * 2019-03-15
 * @uses mnr_recurring_is()
 * @used-by \Mineralair\Core\Js::_toHtml()
 * @used-by \Mineralair\Core\Observer\PaymentMethodIsActive::execute()
 * @param Q|null $q [optional]
 * @return bool
 */
function mnr_recurring_has(Q $q = null) {return df_find(df_quote($q)->getItems(), 'mnr_recurring_is');}