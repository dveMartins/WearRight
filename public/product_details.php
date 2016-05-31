<?php require_once 'includes/header.php'; ?>	
<?php
$cat     = new Category();
$product = new Product();
$rev     = new Review();

if(!isset($_GET['p_id'])) {
   $product->redirect("404.php"); 
} else {
    $product->product_id = $database->escape_string($_GET['p_id']);
    $product->get_prod_items_by_id();
}

if(isset($_POST['submit'])) {
    if(!empty($_POST['sender_name']) && !empty($_POST['sender_email']) && !empty($_POST['rev_body'])) {
        $rev->send_review();
    } else {
        $rev->set_message("Please fill in the Form correctly!");
    }
}


?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Category</h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        <?php
                        $cat->display_all_cats();
                        ?>
                    </div><!--/category-products-->
                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="product-details"><!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <img src="images/products/<?php echo $product->product_image; ?>" alt="" />
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="product-information"><!--/product-information-->
                            <h2><?php echo $product->product_name; ?></h2>
                            <p>Category: <?php echo $product->product_category; ?></p>
                            <span>
                                <span>EUR &euro;<?php echo $product->product_price; ?></span>
                            </span>
                            <p><b>Availability:</b> In Stock</p>
                            <p><b>Condition:</b> New</p>
                            <p><b>Brand:</b> Wear-Right</p>
                            <br>
                            <a href="cart.php?add=<?php echo $product->product_id; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                        </div><!--/product-information-->
                    </div>
                </div><!--/product-details-->
                
                <!-- Validation message -->
                <?php $rev->display_msg("alert-danger"); ?>
                
                <div class="category-tab shop-details-tab"><!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#details" data-toggle="tab">Description</a></li>
                            <li><a href="#rel_prod" data-toggle="tab">Related Products</a></li>
                            <li><a href="#reviews" data-toggle="tab">Reviews</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="details">
                            <div class="col-md-12">
                                <p><?php echo $product->product_desc; ?></p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="rel_prod" >
                            <?php $product->show_related_prod($product->product_category); ?>
                        </div>

                        <div class="tab-pane fade" id="reviews" >
                            <div class="col-sm-12">
                                <?php $rev->display_reviews(); ?>
                                <div class="row">
                                    <p><b>Write Your Review</b></p>

                                    <form action="#" method="post">
                                        <span>
                                            <input type="text" name="sender_name" placeholder="Your Name"/>
                                            <input type="email" name="sender_email" placeholder="Email Address"/>
                                        </span>
                                        <textarea name="rev_body" ></textarea>
                                        <button type="submit" name="submit" class="btn btn-default pull-right">
                                            Submit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/category-tab-->
            </div>
        </div>
    </div>
</section>
<?php
require_once 'includes/footer.php';
