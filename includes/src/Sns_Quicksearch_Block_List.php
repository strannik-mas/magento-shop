<?php
class Sns_Quicksearch_Block_List extends Mage_Catalog_Block_Product_Abstract
{
	protected $_config = null;

	public function __construct($attributes = array()){
		parent::__construct();
		$this->_config = Mage::helper('quicksearch/data')->get($attributes);
	}

	public function getConfig($name=null, $value=null){
		if (is_null($this->_config)){
			$this->_config = Mage::helper('quicksearch/data')->get(null);
		}
		if (!is_null($name) && !empty($name)){
			$valueRet = isset($this->_config[$name]) ? $this->_config[$name] : $value;
			return $valueRet;
		}
		return $this->_config;
	}

	public function setConfig($name, $value=null){
		if (is_null($this->_config)) $this->getConfig();
		if (is_array($name)){
			Mage::log($name);
			$this->_config = array_merge($this->_config, $name);
			return;
		}
		if (!empty($name)){
			$this->_config[$name] = $value;
		}
		return true;
	}

	public function getConfigObject(){
        return (object)$this->getConfig();
	}

	protected function _toHtml(){
		if(!$this->getConfig('isenabled')) return;
		if($this->getTemmplate()) $template_file = $this->getTemmplate();
		else $template_file = 'sns/quicksearch/default.phtml';
		
		$this->setTemplate($template_file);
		return parent::_toHtml();
	}

	
	
	public function getCategories(){
        $category = Mage::getModel('quicksearch/system_config_source_listCategory');
		$root_id =  (int) $this->getConfig('root_catalog');
		$level = $this->getConfig('level');	
		$level = $level + 1;
		$cat_list = $category->toOptionArray($root_id, $level);
        return $cat_list;	
	}
	
	
	/*
    public function getSearchableCategories()
    {
        $rootCategory = Mage::getModel('catalog/category')->load(Mage::app()->getStore()->getRootCategoryId());
		$list_cat = $this->getSearchableSubCategories($rootCategory);
        return $list_cat;
    }

    public function getSearchableSubCategories($category)
    {
        return Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('all_children')
            ->addAttributeToFilter('is_active', 1)
            ->addAttributeToFilter('include_in_menu', 1)
            ->addIdFilter($category->getChildren())
            ->setOrder('position', 'ASC')
            ->load();
    }
	*/

    protected $_terms;
    protected $_minPopularity;
    protected $_maxPopularity;


    /**
     * Load terms and try to sort it by names
     *
     * @return Mage_CatalogSearch_Block_Term
     */
    protected function _loadTerms()
    {
        if (empty($this->_terms)) {
            $this->_terms = array();
			
			
			$is_ajax = Mage::app()->getRequest()->getParam('is_ajax');
			
			//Zend_debug::dump($is_ajax);
			if($is_ajax){
				//$count_term = $this->getConfig('limit_popular');
				 $count_term = Mage::app()->getRequest()->getParam('count_term');
				 $terms = Mage::getResourceModel('catalogsearch/query_collection')
                ->setPopularQueryFilter(Mage::app()->getStore()->getId())
                ->setPageSize( $count_term )
                ->load()
                ->getItems();
			}else{
			$count_term = $this->getConfig('limit_popular');
            $terms = Mage::getResourceModel('catalogsearch/query_collection')
                ->setPopularQueryFilter(Mage::app()->getStore()->getId())
                ->setPageSize( $count_term )
                ->load()
                ->getItems();
			}
            if( count($terms) == 0 ) {
                return $this;
            }


            $this->_maxPopularity = reset($terms)->getPopularity();
            $this->_minPopularity = end($terms)->getPopularity();
            $range = $this->_maxPopularity - $this->_minPopularity;
            $range = ( $range == 0 ) ? 1 : $range;
            foreach ($terms as $term) {
                if( !$term->getPopularity() ) {
                    continue;
                }
                $term->setRatio(($term->getPopularity()-$this->_minPopularity)/$range);
                $temp[$term->getName()] = $term;
                $termKeys[] = $term->getName();
            }
            natcasesort($termKeys);

            foreach ($termKeys as $termKey) {
                $this->_terms[$termKey] = $temp[$termKey];
            }
        }
        return $this;
    }

    public function getTerms()
    {
        $this->_loadTerms();
        return $this->_terms;
    }

    public function getSearchUrl($obj)
    {
        $url = Mage::getModel('core/url');
        /*
        * url encoding will be done in Url.php http_build_query
        * so no need to explicitly called urlencode for the text
        */
        $url->setQueryParam('q', $obj->getName());
        return $url->getUrl('catalogsearch/result');
    }

    public function getMaxPopularity()
    {
        return $this->_maxPopularity;
    }

    public function getMinPopularity()
    {
        return $this->_minPopularity;
    }
}



