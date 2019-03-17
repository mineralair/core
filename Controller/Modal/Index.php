<?php
namespace Mineralair\Core\Controller\Modal;
use Magento\Framework\App\Response\Http as Response;
use Magento\Framework\App\ResponseInterface as IResponse;
use Magento\Framework\DataObject as _DO;
use Magento\Quote\Model\Quote as Q;
use Magento\Quote\Model\Quote\Item as QI;
use Magento\Quote\Model\Quote\Item\Option as IO;
/**
 * 2019-03-17
 * Convert all «autoshipment» products to their non-autoshipment counterparts
 * on the red «PLEASE CONVERT» button click": https://github.com/mineralair/core/issues/
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 */
class Index extends \Df\Framework\Action {
	/**
	 * 2019-03-17
	 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
	 * @override
	 * @see \Magento\Framework\App\Action\Action::execute()
	 * @used-by \Magento\Framework\App\Action\Action::dispatch():
	 * 		$result = $this->execute();
	 * https://github.com/magento/magento2/blob/2.2.1/lib/internal/Magento/Framework/App/Action/Action.php#L84-L125
	 * @return IResponse|Response
	 */
	function execute() {
		$q = df_quote(); /** @var Q $q */
		/** @var array(string => QI) $map */
		$map = df_map_r($q->getItems(), function(QI $i) {return [$i->getSku(), $i];});
		/** @uses mnr_recurring_is() */
		$ii = array_filter($q->getItems(), 'mnr_recurring_is'); /** @var array(int => QI) $i */
		foreach ($ii as $i) { /** @var QI $i */
			// 2019-03-17 «28MLMED-delivery-schedule-C30» => «28MLMED-delivery-schedule-0»
			$ciSku = df_cc('-', df_head(explode('-', $i->getSku())), 0); /** @var string $ciSku */
			/** @var QI|null $ci */
			if (!($ci = dfa($map, $ciSku))) {
				$i->setSku($ciSku);
				$o = $i->getOptionByCode('info_buyRequest'); /** @var IO $o */
				/**
				 * 2019-03-17
				 *	{
				 *		"uenc": "aHR0cHM6Ly9sb2NhbGhvc3QuY29tOjIwNTEvc2hvcC9taW5lcmFsLWZvdW5kYXRpb24tMjhtbC5odG1s",
				 *		"product": "347",
				 *		"selected_configurable_option": "",
				 *		"related_product": "",
				 *		"super_attribute": {
				 *			"92": "5"
				 *		},
				 *		"options": {
				 *			"28": "112"
				 *		},
				 *		"delivery-schedule": "1",
				 *		"switcher_options": {
				 *			"28": "112"
				 *		},
				 *		"qty": "1"
				 *	}
				 */
				$ov = df_json_decode($o->getValue()); /** @var array(string => mixed) $ov */
				$ov['delivery-schedule'] = 0;
				// 2019-03-17 {"28": "112"}
				/** @var array(string => string) $switcherOptions */
				$switcherOptions = $ov['switcher_options'];
				df_assert_eq(1, count($switcherOptions));
				$k = (int)df_first(array_keys($switcherOptions)); /** @var int $k */
				$o2 = $i->getOptionByCode("option_$k"); /** @var IO $o2 */
				$ov['options'][$k] = $ov['switcher_options'][$k] = $o2['value'] = df_fetch_one_int(
					'catalog_product_option_type_value', 'option_type_id', [
						'option_id' => $k, 'sku' => 'delivery-schedule-0'
					]
				);
				$o->setValue(df_json_encode($ov));
				$o->save();
				$o2->save();
				$i->save();
				$map[$ciSku] = $i;
			}
			else {
				$ci->setQty($ci->getQty() + $i->getQty());
				self::add($ci, $i,
					'base_row_total'
					,'base_row_total_incl_tax'
					,'row_total'
					,'row_total_incl_tax'
					,'row_total_with_discount'
					,'row_weight'
				);
				$cioA = $ci->getQtyOptions(); /** @var IO[] $cioA */
				$ioA = $i->getQtyOptions(); /** @var IO[] $ioA */
				foreach ($cioA as $id => $cio) { /** @var int $id */ /** @var IO $cio */
					$io = $ioA[$id]; /** @var IO $io */
					self::add($cio, $io, 'value');
					// 2019-03-17 It seems that we do not need it.
					$STOCK_STATE_RESULT = 'stock_state_result'; /** @var string $STOCK_STATE_RESULT */
					$cs = $cio[$STOCK_STATE_RESULT]; /** @var _DO $cs */
					$s = $io[$STOCK_STATE_RESULT]; /** @var _DO $s */
					self::add($cs, $s, 'item_qty', 'orig_qty');
				}
				$ci->save();
				$q->deleteItem($i);
			}
		}
		$q->save();
		return $this->_redirect('checkout/cart');
	}

	/**
	 * 2019-03-17
	 * @used-by execute()
	 * @param _DO $a
	 * @param _DO $b
	 * @param string[] $kk
	 */
	private static function add($a, $b, ...$kk) {
		foreach ($kk as $k) { /** @var string $k */
			$a[$k] = $a[$k] + $b[$k];
		}
	}
}