<div class="row">
	<div class="col-md-8">
<section class="content">
                    <div class="container">
 <div class="row my-orders">
 <div class="col-xs-12 col-sm-4 col-md-3">
                          <?php 
                        //  Loader::element('account_nav');
                          ?>

                         </div>
 <div class="col-xs-12 col-sm-8 col-md-9">
 <h3 class="page-header"><?php echo t('My Orders')?></h3>
<?php if($controller->getTask() == "view"){?>

	<?php if(sizeof($orderList)>0){ 
	
				Loader::packageElement('orders_list','community_store_my_orders_and_favourites',array("orderList"=>$orderList));
				
	} ?>


<?php }else if($controller->getTask() == "detail"){ ?>
	<?php
	 if(is_object($order)){
		 
		 		Loader::packageElement('order_detail','community_store_my_orders_and_favourites',array("order"=>$order));	
				 
		}	
	?>
	
<?php } ?>
</div>
</div>
</div>
</section>

</div>
	<div class="col-md-4">
		<?php
			$stack = Stack::getByName('My Account Links');
			$stack->display();
			?>
		
	</div>

 