<?php
require_once '../core/config.php';
$cart_class = new Cart();

if(isset($_GET['add'])) {
    if($cart_class->add_prod_to_cart()) {
       $cart_class->redirect("shopping_cart.php");
    } else {
        $cart_class->redirect("shopping_cart.php");
        $cart_class->set_message("Sorry your request exceed the Item quantity in Stock. More on the way.");
    }
}
if(isset($_GET['remove'])) {
    if($cart_class->remove_from_cart()) {
        $cart_class->redirect("shopping_cart.php");
    }
}
if(isset($_GET['delete'])) {
    if($cart_class->delete_cart()) {
        $cart_class->redirect("shopping_cart.php");
    }
}
        
                    
                    
                    
                    

