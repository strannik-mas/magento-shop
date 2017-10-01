<?php
class Sns_Lamino_Block_Adminhtml_System_Config_Form_Field_Pattern extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
		$html = '';
		
		$options = $element->getValues();

		$html .= '<div class="radio_img_group" id="' . $element->getHtmlId() . '">';
		foreach($options as $option) {
			
			$patternUrl = Mage::getBaseUrl('skin') . 'frontend/sns_lamino/default/images/pattern/' . $option['value'] . '.png';
			
			$checked = ($element->getEscapedValue() == $option['value']) ? ' checked' : '';

			$html .= '<label style="display: inline-block;" title="' . $option['label'] . '">';
			
			$html .= '<input type="radio" name="' . $element->getName() . '" value="' . $option['value'] . '" ' . $checked . ' />';
			
			$html .= '<span style="background-image: url(\''.$patternUrl.'\')"></span>';
			
			$html .= '</label>';
		}
		
		$html .= '</div>';
		
		$html .= '<style>
					.radio_img_group {
					}
					.radio_img_group label {
						display: inline-block;
						margin-right: 3px;
					}
					.radio_img_group input {
						display: none;
					}
					.radio_img_group span {
						display: block;
						border: 1px solid gray;
						width: 50px;
						height: 30px;
						cursor: pointer;
					}
					input:checked + span {
						border: 1px solid red;
					}
				</style>';
		
		$html .= $element->getAfterElementHtml();
		
        return $html;
    }
}