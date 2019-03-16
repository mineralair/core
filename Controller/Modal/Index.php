<?php
namespace Mineralair\Core\Controller\Modal;
use Df\Framework\W\Result\Json;
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
	 * @return Json
	 */
	function execute() {
		return Json::i([]);
	}
}