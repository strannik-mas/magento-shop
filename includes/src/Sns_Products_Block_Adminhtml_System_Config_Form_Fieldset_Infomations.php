<?php
class Sns_Products_Block_Adminhtml_System_Config_Form_Fieldset_Infomations extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {
    protected function _getHeaderTitleHtml($element) {
		$version = Mage::getConfig()->getNode()->modules->Sns_Products->version;
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
			<h4>1. Slider layout</h4>
			<table class="form-list">
				<tr>
					<td class="label"><label>Static Block Usage</label></td>
					<td class="value" style="width: auto;"><span>{{block type="products/slider" title="SNS Products Slider" {Option key}="{Option value}"}}</span></td>
				</tr>
				<tr>
					<td class="label"><label>Layout Update Usage</label></td>
					<td class="value" style="width: auto;">
						<span id="group_form_layout_helper">
							&lt;block type="products/slider" name="sns.products.slider"&gt;<br />
							' . $tab . '&lt;action method="setConfig"&gt;<br />
							' . $tab . $tab . '&lt;name&gt;<br />
							' . $tab . $tab . $tab . '&lt;title&gt;&lt;![CDATA[SNS Products Slider]]&gt;&lt;/title&gt;<br />
							' . $tab . $tab . $tab . '&lt;{Option key}&gt;&lt;![CDATA[{Option value}]]&gt;&lt;/{Option key}&gt;<br />
							' . $tab . $tab . '&lt;/name&gt;<br />
							' . $tab . '&lt;/action&gt;<br />
							&lt;/block&gt;
						</span>
					</td>
				</tr>
			</table>
			<hr style="border: 1px solid #ccc; border-width: 1px 0 0; margin: 20px 0;" />
			<h4>2. List layout</h4>
			<table class="form-list">
				<tr>
					<td class="label"><label>Static Block Usage</label></td>
					<td class="value" style="width: auto;"><span>{{block type="products/list" title="SNS Products List" {Option key}="{Option value}"}}</span></td>
				</tr>
				<tr>
					<td class="label"><label>Layout Update Usage</label></td>
					<td class="value" style="width: auto;">
						<span id="group_form_layout_helper">
							&lt;block type="products/list" name="sns.products.list"&gt;<br />
							' . $tab . '&lt;action method="setConfig"&gt;<br />
							' . $tab . $tab . '&lt;name&gt;<br />
							' . $tab . $tab . $tab . '&lt;title&gt;&lt;![CDATA[SNS Products List]]&gt;&lt;/title&gt;<br />
							' . $tab . $tab . $tab . '&lt;{Option key}&gt;&lt;![CDATA[{Option value}]]&gt;&lt;/{Option key}&gt;<br />
							' . $tab . $tab . '&lt;/name&gt;<br />
							' . $tab . '&lt;/action&gt;<br />
							&lt;/block&gt;
						</span>
					</td>
				</tr>
			</table>
			<hr style="border: 1px solid #ccc; border-width: 1px 0 0; margin: 20px 0;" />
			<h4>3. Grid layout</h4>
			<table class="form-list">
				<tr>
					<td class="label"><label>Static Block Usage</label></td>
					<td class="value" style="width: auto;"><span>{{block type="products/grid" title="SNS Products Grid" {Option key}="{Option value}"}}</span></td>
				</tr>
				<tr>
					<td class="label"><label>Layout Update Usage</label></td>
					<td class="value" style="width: auto;">
						<span id="group_form_layout_helper">
							&lt;block type="products/grid" name="sns.products.grid"&gt;<br />
							' . $tab . '&lt;action method="setConfig"&gt;<br />
							' . $tab . $tab . '&lt;name&gt;<br />
							' . $tab . $tab . $tab . '&lt;title&gt;&lt;![CDATA[SNS Products Grid]]&gt;&lt;/title&gt;<br />
							' . $tab . $tab . $tab . '&lt;{Option key}&gt;&lt;![CDATA[{Option value}]]&gt;&lt;/{Option key}&gt;<br />
							' . $tab . $tab . '&lt;/name&gt;<br />
							' . $tab . '&lt;/action&gt;<br />
							&lt;/block&gt;
						</span>
					</td>
				</tr>
			</table>
			<hr style="border: 1px solid #ccc; border-width: 1px 0 0; margin: 20px 0;" />
			<h4>4. Deals layout</h4>
			<table class="form-list">
				<tr>
					<td class="label"><label>Static Block Usage</label></td>
					<td class="value" style="width: auto;"><span>{{block type="products/deals" title="SNS Products Deals" {Option key}="{Option value}"}}</span></td>
				</tr>
				<tr>
					<td class="label"><label>Layout Update Usage</label></td>
					<td class="value" style="width: auto;">
						<span id="group_form_layout_helper">
							&lt;block type="products/deals" name="sns.products.deals"&gt;<br />
							' . $tab . '&lt;action method="setConfig"&gt;<br />
							' . $tab . $tab . '&lt;name&gt;<br />
							' . $tab . $tab . $tab . '&lt;title&gt;&lt;![CDATA[SNS Products Deals]]&gt;&lt;/title&gt;<br />
							' . $tab . $tab . $tab . '&lt;{Option key}&gt;&lt;![CDATA[{Option value}]]&gt;&lt;/{Option key}&gt;<br />
							' . $tab . $tab . '&lt;/name&gt;<br />
							' . $tab . '&lt;/action&gt;<br />
							&lt;/block&gt;
						</span>
					</td>
				</tr>
			</table>
			<hr style="border: 1px solid #ccc; border-width: 1px 0 0; margin: 20px 0;" />



							
<table style="width: 100%; border-collapse: unset; border: 1px solid rgb(221, 221, 221); padding: 10px 20px;">
	<tr>
		<th>Option name</th>
		<th>Option key</th>
		<th>Available values</th>
	</tr>
	<tr>
		<td>Block Title</td>
		<td>title</td>
		<td>String</td>
	</tr>
	<tr>
		<td>Product Source</td>
		<td>product_source</td>
		<td>catalog, product</td>
	</tr>
	<tr>
		<td>Select Category</td>
		<td>product_category</td>
		<td>Category ids. Separator by comma (,). Ex: 2,3,4,5...</td>
	</tr>
	<tr>
		<td>IDs of Products</td>
		<td>product_ids</td>
		<td>Product ids. Separator by comma (,). Eg: 1,2,3,4...</td>
	</tr>
	<tr>
		<td>Product Order by</td>
		<td>product_order_by</td>
		<td>position, best_sales, created_at, name, price, top_rating, most_reviewed, most_viewed, is_featured</td>
	</tr>
	<tr>
		<td>Product Order Dir</td>
		<td>order_dir</td>
		<td>asc, desc</td>
	</tr>
	<tr>
		<td>Product Filter</td>
		<td>product_filter_by</td>
		<td>all, sale, deals, featured</td>
	</tr>
	<tr>
		<td>Product Limitation</td>
		<td>product_limitation</td>
		<td>number</td>
	</tr>
	
	<tr>
		<td>Screen width > 0</td>
		<td>screen_phone</td>
		<td>1, 2, 3, 4, 6</td>
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
</table>

		';
		
        $html .= $this->_getFooterHtml($element);

        return $html;
    }
}
