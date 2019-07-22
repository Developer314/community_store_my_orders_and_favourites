<?php
namespace Concrete\Package\CommunityStoreMyOrdersAndFavourites;

use Package;
use Page;
use SinglePage;
use Route;
use Events;
use Concrete\Package\CommunityStoreMyOrdersAndFavourites\Src\CustomerIdentifier;

class controller extends package {

	protected $pkgHandle = 'community_store_my_orders_and_favourites';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '0.0.0.3';

	public function getPackageName(){

		return t("My Orders and Favourites");

	 }

	 public function getPackageDescription(){

		 return t("List Order informations in user account.");

    }

	public function install(){
		$pkg = parent::install();
		self::installSinglepages($pkg);
	}

	public function uninstall(){
		parent::uninstall();
	}

	public function installSinglepages($pkg){
		self::installpage('/account/orders',$pkg);
		//self::installpage('/account/my_favourites',$pkg);

	}

	public function installpage($path,$pkg){
		 $page = Page::getByPath($path);
        if (!is_object($page) || $page->isError()) {
            SinglePage::add($path, $pkg);
		 }
		 return true;
    }

	public function on_start(){
		Route::register('/addtofavourate','Concrete\Package\CommunityStoreMyOrdersAndFavourites\Controller\Utility\Favourite::addToFavorate');
		Route::register('/removefromfavourate','Concrete\Package\CommunityStoreMyOrdersAndFavourites\Controller\Utility\Favourite::removeFromFavorate');

		/*Events::addListener('on_community_store_order', function($event) {
			$order = $event->getOrder();
			CustomerIdentifier::addCustomer($order);
		});*/

		Route::register("/favourites/add_remove_favourites",function(){

			$data =$_POST;

			$user = new \Concrete\Core\User\User;

	  	$userInfo  = \Concrete\Core\User\UserInfo::getByID($user->getUserID());

			$favourites = $userInfo->getAttribute("favourites");
			$favoritiesIDs = explode('||',$favourites);
			$message = '';
			if(is_array($favoritiesIDs)){

					$pos = array_search($data['productId'], $favoritiesIDs);

					if(!empty($pos)){

								unset($favoritiesIDs[$pos]);
								$favoritiesIDs = 	array_filter($favoritiesIDs);
								$favoriteText = implode('||',$favoritiesIDs );
								$message = 'Add to Favourites';

					}else{
						array_push($favoritiesIDs, $data['productId'] );
						$favoriteText = implode('||',$favoritiesIDs );
						$message = 'Remove to Favourites';

					}


			}else{
				$favoritiesIDs = array();

				array_push($favoritiesIDs, $data['productId'] );
				$favoriteText = implode('||',$favoritiesIDs );

				$message = 'Remove to Favourites';


			}

			$userInfo->setAttribute('favourites',$favoriteText);
			echo $message;

			exit();


		});


		$al = \Concrete\Core\Asset\AssetList::getInstance();
		$al->register('javascript','favourate','js/favourate.js',array(),'community_store_my_orders_and_favourites');
		$al->register('css','favourate','css/favourate.css',array(),'community_store_my_orders_and_favourites');
	}

}
