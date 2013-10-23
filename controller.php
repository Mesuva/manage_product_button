<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class ManageProductButtonPackage extends Package {

	protected $pkgHandle = 'manage_product_button';
	protected $appVersionRequired = '5.5.1';
	protected $pkgVersion = '0.9.1';
	
	public function getPackageDescription() {
		return t("A toolbar button to quickly manage an eCommerce product.");
	}
	
	public function getPackageName() {
		return t("Manage eCommerce Product Toolbar Button");
	}
	
	public function install() {
		$installed = Package::getInstalledHandles();
		
		if( !(is_array($installed) && in_array('core_commerce',$installed)) ) {
			throw new Exception(t('This package requires that the <a href="http://www.concrete5.org/marketplace/addons/ecommerce/" target="_blank">eCommerce package</a> is installed<br/>'));	
		}
		
		$pkg = parent::install();	 	
	}
	
	public function on_start() {
	  if(version_compare(APP_VERSION,'5.4.1.1', '>')){
		   $ihm = Loader::helper('concrete/interface/menu');
		   $uh = Loader::helper('concrete/urls');
		   $req = Request::get(); 
		   $id = $req->getRequestCollectionID();
		   $db = Loader::db();
		   $currentProduct = $db->getOne('select productID from CoreCommerceProducts where cID = ?', $id);
			
			if ($currentProduct > 0) {	  	
		   		$ihm->addPageHeaderMenuItem(null, t('Manage Product'), 'left', array('style'=>' background-position: -15px -2212px !important;','class'=>'ccm-menu-icon', 'href' => DIR_REL . '/index.php/dashboard/core_commerce/products/search/view_detail/' .  $currentProduct), 'manage_product_button');
			}
	 	}   
	}
}