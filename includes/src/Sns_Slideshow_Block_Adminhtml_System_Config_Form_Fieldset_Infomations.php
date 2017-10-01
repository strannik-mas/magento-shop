<?php
class Sns_Slideshow_Block_Adminhtml_System_Config_Form_Fieldset_Infomations extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {
    protected function _getHeaderTitleHtml($element) {
		$version = Mage::getConfig()->getNode()->modules->Sns_Slideshow->version;
		$html = '
			<div class="entry-edit-head collapseable">
				<a id="' . $element->getHtmlId() . '-head" href="#" onclick="Fieldset.toggleCollapse(\'' . $element->getHtmlId() . '\', \'' . $this->getUrl('*/*/state') . '\'); return false;">' . $element->getLegend() . ' v' . $version . '</a>
			</div>
		';
        return $html;
    }
    public function render(Varien_Data_Form_Element_Abstract $element) {
        $this->setElement($element);
        $html = $this->_getHeaderHtml($element);
        
		$tab = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		$html .= '
			<p style="font-size: 130%">This module is using <strong>Jssor Slider</strong>, you can refer to configure <a href="http://www.jssor.com/" target="_blank">here</a>.</p>
			<table class="form-list">
				<tr>
					<td class="label"><label for="group_form_static_helper">Static Block Usage</label></td>
					<td class="value" style="width: auto;><span id="group_form_static_helper">{{block type="slideshow/slideshow" title="" slide_width="" slide_height="" autoplay="" slide_transitions="" rand_transition="" slides_html=""}}</span></td>
				</tr>
				<tr>
					<td class="label"><label for="group_form_layout_helper">Layout Update Usage</label></td>
					<td class="value" style="width: auto;">
						<span id="group_form_layout_helper">
							&lt;block type="slideshow/slideshow" name="sns.slideshow" as="slideshow"&gt;<br />
							' . $tab . '&lt;action method="setConfig"&gt;<br />
							' . $tab . $tab . '&lt;name&gt;<br />
							' . $tab . $tab . $tab . '&lt;title&gt;&lt;![CDATA[SNS Slideshow]]&gt;&lt;/title&gt;<br />
							' . $tab . $tab . $tab . '&lt;slide_width&gt;&lt;![CDATA[1140]]&gt;&lt;/slide_width&gt;<br />
							' . $tab . $tab . $tab . '&lt;slide_height&gt;&lt;![CDATA[450]]&gt;&lt;/slide_height&gt;<br />
							' . $tab . $tab . $tab . '&lt;autoplay&gt;&lt;![CDATA[3000]]&gt;&lt;/autoplay&gt;<br />
							' . $tab . $tab . $tab . '&lt;slide_transitions&gt;&lt;![CDATA[rotateoverlap,flytwins,rotateinminusoutplus]]&gt;&lt;/slide_transitions&gt;<br />
							' . $tab . $tab . $tab . '&lt;rand_transition&gt;&lt;![CDATA[1]]&gt;&lt;/rand_transition&gt;<br />
							' . $tab . $tab . $tab . '&lt;slides_html&gt;&lt;![CDATA[simp_slide_html, simp_slide_html2, simp_slide_html3]]&gt;&lt;/slides_html&gt;<br />
							' . $tab . $tab . '&lt;/name&gt;<br />
							' . $tab . '&lt;/action&gt;<br />
							&lt;/block&gt;
						</span>
					</td>
				</tr>
			</table>
		';
		
        $html .= $this->_getFooterHtml($element);

        return $html;
    }
}
