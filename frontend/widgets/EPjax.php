<?php 
namespace frontend\widgets;
use yii\widgets\Pjax;
use yii\helpers\Json;

class EPjax extends Pjax
{
	/**
	 * Registers the needed JavaScript.
	 */
	public function registerClientScript()
	{
		$id = $this->options['id'];
		$this->clientOptions['push'] = $this->enablePushState;
		$this->clientOptions['replace'] = $this->enableReplaceState;
		$this->clientOptions['timeout'] = $this->timeout;
		$this->clientOptions['scrollTo'] = $this->scrollTo;
		if (!isset($this->clientOptions['container'])) {
			$this->clientOptions['container'] = "#$id";
		}
		$options = Json::htmlEncode($this->clientOptions);
		$js = '';
		if ($this->linkSelector !== false) {
			$linkSelector = Json::htmlEncode($this->linkSelector !== null ? $this->linkSelector : '#' . $id . ' a');
			$js .= "jQuery(document).pjax($linkSelector, $options);";
		}
		if ($this->formSelector !== false) {
			$formSelector = Json::htmlEncode($this->formSelector !== null ? $this->formSelector : '#' . $id . ' form[data-pjax]');
			$submitEvent = Json::htmlEncode($this->submitEvent);
			$js .= "\njQuery(document).on($submitEvent, $formSelector, function (event) {jQuery.pjax.submit(event, $options);});";
		}
		$view = $this->getView();
		
		if ($js !== '') {
			$view->registerJs($js);
		}
	}
}
?>