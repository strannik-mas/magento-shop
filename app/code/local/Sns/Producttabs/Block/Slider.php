<?php
class Sns_Producttabs_Block_Slider extends Sns_Producttabs_Block_List{
	protected function _toHtml(){
		if(!$this->getConfig('isenabled')) return;
		$type      = Mage::app()->getRequest()->getParam('pdt_type');
		if( $type!='' ){
			$template_file = 'sns/producttabs/items-slider.phtml';
		}else{
			if($this->getTemplate()) $template_file = $this->getTemplate();
			else $template_file = 'sns/producttabs/default-slider.phtml';
		}
		$this->setTemplate($template_file);
		return parent::_toHtml();
	}
}
