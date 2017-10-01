<?php
class Sns_Facebook_Block_Adminhtml_System_Config_Form_Fieldset_Infomations extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {
    protected function _getHeaderTitleHtml($element) {
		$version = Mage::getConfig()->getNode()->modules->Sns_Facebook->version;
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
			<table class="form-list">
				<tr>
					<td class="label">
						<label>Static Block Usage</label>
					</td>
					<td class="value" style="width: auto;">
						<span>{{block type="facebook/list" isenabled="1" title="SNS Facebook" fanpageName="snstheme" numberDisplay="12"}}</span></td>
				</tr>
				<tr>
					<td class="label">
						<label>Layout Update Usage</label>
					</td>
					<td class="value" style="width: auto;">
						<span id="group_form_layout_helper">
							&lt;block type="facebook/list" name="sns.facebook.list"&gt;<br />
							' . $tab . '&lt;action method="setConfig"&gt;<br />
							' . $tab . $tab . '&lt;name&gt;<br />
							' . $tab . $tab . $tab . '&lt;isenabled&gt;&lt;![CDATA[1]]&gt;&lt;/isenabled&gt;<br />
							' . $tab . $tab . $tab . '&lt;title&gt;&lt;![CDATA[SNS Facebook]]&gt;&lt;/title&gt;<br />
							' . $tab . $tab . $tab . '&lt;fanpageName&gt;&lt;![CDATA[snstheme]]&gt;&lt;/fanpageName&gt;<br />
							' . $tab . $tab . $tab . '&lt;numberDisplay&gt;&lt;![CDATA[12]]&gt;&lt;/numberDisplay&gt;<br />
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
