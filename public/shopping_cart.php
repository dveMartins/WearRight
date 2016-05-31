<?php require_once 'includes/header.php'; ?>
<?php 
$cart_class = new Cart();
?>
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        
        <!-- Alert -->
        <?php $cart_class->display_msg("alert-warning"); ?>
        
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php $cart_class->cart_show(); ?>         
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Item 
                            <span>
                                <?php
    
                                if(isset($_SESSION['item_quantity'])) {
                                    echo $_SESSION['item_quantity'];
                                } else {
                                    $_SESSION['item_quantity'] = "0";
                                }

                                ?>
                            </span>
                        </li>
                        <li>Shipping Cost <span>Free</span></li>
                        <li>Total 
                            <span>&euro;
                                <?php
    
                                if(isset($_SESSION['item_total'])) {
                                    echo $_SESSION['item_total'];
                                } else {
                                    $_SESSION['item_total'] = "0";
                                }

                                ?>
                            </span>
                        </li>
                    </ul>
                    <a class="btn btn-default update" href="index.php">Continue Shopping</a>
                    <a class="btn btn-default check_out" href="checkout.php">Check Out</a>
                </div>  
            </div>
        </div>
    </div>
</section><!--/#do_action-->
<?php
require_once 'includes/footer.php';
