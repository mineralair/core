<?php
use Magento\Quote\Model\Quote as Q;
use Magento\Quote\Model\Quote\Item as QI;
/**
 * 2019-03-15
 * @used-by \Mineralair\Core\Observer\PaymentMethodIsActive::execute()
 * @param Q $q
 * @return bool
 */
function mnr_recurring(Q $q) {return df_find($q->getItems(), function(QI $i) {/** @var string $s */ return
	df_contains($s = $i->getSku(), 'delivery-schedule') && !df_ends_with($s, 'delivery-schedule-0')
;});}