<?php
class Sns_Lamino_Block_Adminhtml_System_Config_Form_Fieldset_Test
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {
    /**
     * Return header comment part of html for fieldset
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $html = $this->_getHeaderHtml($element);

//        foreach ($element->getSortedElements() as $field) {
//            $html.= $field->toHtml();
//        }
		$html .= 'xxxxxxxxx';
		
        $html .= $this->_getFooterHtml($element);

        return $html;
    }
}
