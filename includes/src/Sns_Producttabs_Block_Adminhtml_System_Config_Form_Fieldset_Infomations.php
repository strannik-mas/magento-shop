<?php
class Sns_Producttabs_Block_Adminhtml_System_Config_Form_Fieldset_Infomations extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {
    protected function _getHeaderTitleHtml($element) {
		$version = Mage::getConfig()->getNode()->modules->Sns_Producttabs->version;
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
					<td class="label"><label for="group_form_static_helper">Static Block Usage Slider Layout</label></td>
					<td class="value" style="width: auto;><span id="group_form_static_helper">{{block type="producttabs/slider" {Option key}="{Option value}" effects="bounceInRight"}}</span></td>
				</tr>
				<tr>
					<td class="label"><label for="group_form_static_helper">Static Block Usage Grid Layout</label></td>
					<td class="value" style="width: auto;><span id="group_form_static_helper">{{block type="producttabs/grid" {Option key}="{Option value}" effects="bounceInRight"}}</span></td>
				</tr>
				<tr>
					<td class="label"><label for="group_form_layout_helper">Layout Update Usage Slider Layout</label></td>
					<td class="value" style="width: auto;">
						<span id="group_form_layout_helper">
							&lt;block type="producttabs/slider" name="producttabs.slider"&gt;<br />
							' . $tab . '&lt;action method="setConfig"&gt;<br />
							' . $tab . $tab . '&lt;name&gt;<br />
							' . $tab . $tab . $tab . '&lt;{Option key}&gt;&lt;![CDATA[{Option value}]]&gt;&lt;/{Option key}&gt;<br />
							' . $tab . $tab . $tab . '&lt;effects&gt;&lt;![CDATA[bounceInRight]]&gt;&lt;/effects&gt;<br />
							' . $tab . $tab . '&lt;/name&gt;<br />
							' . $tab . '&lt;/action&gt;<br />
							&lt;/block&gt;
						</span>
					</td>
				</tr>
				<tr>
					<td class="label"><label for="group_form_layout_helper">Layout Update Usage Grid Layout</label></td>
					<td class="value" style="width: auto;">
						<span id="group_form_layout_helper">
							&lt;block type="producttabs/grid" name="producttabs.grid"&gt;<br />
							' . $tab . '&lt;action method="setConfig"&gt;<br />
							' . $tab . $tab . '&lt;name&gt;<br />
							' . $tab . $tab . $tab . '&lt;{Option key}&gt;&lt;![CDATA[{Option value}]]&gt;&lt;/{Option key}&gt;<br />
							' . $tab . $tab . $tab . '&lt;effects&gt;&lt;![CDATA[bounceInRight]]&gt;&lt;/effects&gt;<br />
							' . $tab . $tab . '&lt;/name&gt;<br />
							' . $tab . '&lt;/action&gt;<br />
							&lt;/block&gt;
						</span>
					</td>
				</tr>
			</table>
<table style="width: 100%; border-collapse: unset; border: 1px solid rgb(221, 221, 221); padding: 10px 20px;">
	<tr>
		<th>Option name</th>
		<th>Option key</th>
		<th>Available values</th>
	</tr>
	<tr>
		<td>Enabled</td>
		<td>isenabled</td>
		<td>0, 1</td>
	</tr>
	<tr>
		<td>Title</td>
		<td>title</td>
		<td>string</td>
	</tr>
	<tr>
		<td>Effects</td>
		<td>effects</td>
		<td>slideBottom, slideLeft, slideRight, bounceIn, bounceInRight, zoomIn, zoomOut, pageTop, pageBottom, pageLeft, pageRight, starwars</td>
	</tr>
	<tr>
		<td>List Products By</td>
		<td>list_products_by</td>
		<td>order, category</td>
	</tr>
	<tr>
		<td>Select Order By</td>
		<td>order_type</td>
		<td>position, best_sales, created_at, name, price, top_rating, most_reviewed, most_viewed, is_featured</td>
	</tr>
	<tr>
		<td>Select Category</td>
		<td>product_category</td>
		<td>catgory ids ex: 2,4,5</td>
	</tr>
	<tr>
		<td>Product Order By</td>
		<td>product_order_by</td>
		<td>position, created_at, name, price, top_rating, most_reviewed, most_viewed, best_sales, is_featured</td>
	</tr>
	<tr>
		<td>Product Order Dir</td>
		<td>order_dir</td>
		<td>asc, desc</td>
	</tr>
	<tr>
		<td>Number per tab</td>
		<td>number_per_display</td>
		<td>Number</td>
	</tr>
	<tr>
		<td>Screen width > 480px</td>
		<td>screen_xs</td>
		<td>1, 2, 3, 4, 6</td>
	</tr>
	<tr>
		<td>Screen width > 768px</td>
		<td>screen_sm</td>
		<td>1, 2, 3, 4, 6</td>
	</tr>
	<tr>
		<td>Screen width > 992px</td>
		<td>screen_md</td>
		<td>1, 2, 3, 4, 6</td>
	</tr>
	<tr>
		<td>Screen width > 1200px</td>
		<td>screen_lg</td>
		<td>1, 2, 3, 4, 6</td>
	</tr>
	<tr>
		<td>Show number on button Load More</td>
		<td>Show number on button Load More	show_number_loadmore</td>
		<td>0 ,1</td>
	</tr>
	<tr>
		<td>Number per load more</td>
		<td>number_per_loadmore</td>
		<td>Number</td>
	</tr>
</table>

		';
		
        $html .= $this->_getFooterHtml($element);

        return $html;
    }
}
