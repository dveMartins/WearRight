<?php require_once 'includes/header.php'; ?>
<?php $cart_class = new Cart(); ?>
<br>
<br>
<section id="cart_items">
    <div class="container">
        <div class="review-payment">
            <h2>Review & Payment</h2>
        </div>
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="business" value="cruzmill.cm@gmail.com">
            <input type="hidden" name="currency_code" value="EUR">
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
                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td colspan="2">
                                <table class="table table-condensed total-result">
                                    <tr>
                                        <td>Cart Sub Total</td>
                                        <td>
                                            <?php
                                            if (isset($_SESSION['item_quantity'])) {
                                                echo $_SESSION['item_quantity'];
                                            } else {
                                                $_SESSION['item_quantity'] = "0";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr class="shipping-cost">
                                        <td>Shipping Cost</td>
                                        <td>Free</td>										
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>
                                            <span>&euro;
                                            <?php
                                            if (isset($_SESSION['item_total'])) {
                                                echo $_SESSION['item_total'];
                                            } else {
                                                $_SESSION['item_total'] = "0";
                                            }
                                            ?>
                                            </span>
                                        </td>
                                        <td><?php echo $cart_class->show_paypal(); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</section> <!--/#cart_items-->

<?php
include('includes/footer.php');
