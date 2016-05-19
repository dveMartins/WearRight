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
    
    public function show_recent_product() {
        global $database;
        $query = $database->query("SELECT * FROM products ORDER BY product_id DESC LIMIT 4");
        while($row = $query->fetch_array(MYSQLI_ASSOC)):
            $this->product_name  = $row['product_name'];
            $this->product_desc  = $row['product_desc'];
            $this->product_price = $row['product_price'];
            if(empty($row['product_image'])) {
                $this->product_image = "http://placehold.it/50x50";
            } else {
                $this->product_image = "../images/products/".$row['product_image'];
            }
echo <<<DELIMETER
        <li class="item">
            <div class="product-img">
                <img src="$this->product_image" alt="Product Image">
            </div>
            <div class="product-info">
                <a href="javascript:void(0)" class="product-title">$this->product_name
                    <span class="label label-warning pull-right">&euro;$this->product_price</span></a>
                <span class="product-description">
                    $this->product_desc
                </span>
            </div>
        </li>   
DELIMETER;
        endwhile;

    }
    
}
