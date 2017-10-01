<?php 
    class Sns_Lamino_Adminhtml_ImportController extends Mage_Adminhtml_Controller_Action{ 
        public function indexAction() {
            $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/sns_lamino_cfg/"));
        }
        public function blocksAction() {
            $isoverwrite = Mage::helper('lamino')->getCfg('install/overwrite_blocks');
            Mage::getSingleton('lamino/import_cms')->importCms('cms/block', 'blocks', $isoverwrite);
            $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/sns_lamino_cfg/"));
        }
        public function pagesAction() {
            $isoverwrite = Mage::helper('lamino')->getCfg('install/overwrite_pages');
            Mage::getSingleton('lamino/import_cms')->importCms('cms/page', 'pages', $isoverwrite);
            $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/sns_lamino_cfg/")); 
        }
    }
    //$config = Mage::getStoreConfig('section_name/group/field'); //value
?>