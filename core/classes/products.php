<?php

class Product extends General{
    
    public $product_id;
    public $product_name;
    public $product_desc;
    public $product_category;
    public $product_price;
    public $product_quantity;
    public $product_image;
    
    public function get_product() {
        global $database;    
        $query = $database->query("SELECT * FROM products");
        return $query;
    }
    
    public function display_all_product() {
        $products = $this->get_product();
        while ($prod = $products->fetch_array(MYSQLI_ASSOC)) {
            $show_p =
<<<DELIMETER
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="images/products/{$prod['product_image']}" alt="{$prod['product_name']}" />
                        <h2>&euro; {$prod['product_price']}</h2>
                        <p>{$prod['product_name']}</p>
                    </div>
                    <div class="product-overlay">
                        <div class="overlay-content">
                            <h2>&euro; {$prod['product_price']}</h2>
                            <p>{$prod['product_name']}</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>            
DELIMETER;
            echo $show_p;
        }
    }
    
}
