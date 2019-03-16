<?php
namespace Mineralair\Core;
use Magento\Framework\View\Element\AbstractBlock as _P;
/**
 * 2019-03-15
 * "Show the «Sorry for the inconvenience» popup
 * if a customer tries to use the PayPal or Amazon Pay payment method
 * for an order with an «autoshipment» product": https://github.com/mineralair/core/issues/2
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 */
class Js extends _P {
	/**
	 * 2019-03-15
	 * @override
	 * @see _P::_toHtml()
	 * @used-by _P::toHtml():
	 *		$html = $this->_loadCache();
	 *		if ($html === false) {
	 *			if ($this->hasData('translate_inline')) {
	 *				$this->inlineTranslation->suspend($this->getData('translate_inline'));
	 *			}
	 *			$this->_beforeToHtml();
	 *			$html = $this->_toHtml();
	 *			$this->_saveCache($html);
	 *			if ($this->hasData('translate_inline')) {
	 *				$this->inlineTranslation->resume();
	 *			}
	 *		}
	 *		$html = $this->_afterToHtml($html);
	 * https://github.com/magento/magento2/blob/2.2.0/lib/internal/Magento/Framework/View/Element/AbstractBlock.php#L643-L689
	 * @return string
	 */
	final protected function _toHtml() {return !mnr_recurring() ? '' : df_js(__CLASS__);}
}