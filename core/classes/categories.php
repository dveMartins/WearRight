<?php

class Category extends General{
    
    public $category_id;
    public $category_name;
    
    public function get_all_cats() {
        global $database;
        return $database->query("SELECT * FROM categories");
    }
    public function display_all_cats() {
        
        $query = $this->get_all_cats();
        while($cat = $query->fetch_array(MYSQLI_ASSOC)) {
        echo "
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <h4 class='panel-title'><a href='index.php?cat_name={$cat['category_name']}'>{$cat['category_name']}</a></h4>
                </div>
            </div>  
            ";

        }
    }
    
    public function show_cat_nav() {
        $query = $this->get_all_cats();
        while($cat = $query->fetch_array(MYSQLI_ASSOC)) {

         echo "<li><a href='category.php?cat_name={$cat['category_name']}'>" .ucfirst($cat['category_name']). "</a></li>";
                     
        }
    }
    
    public function show_item_by_cat($cat_name) {
        global $database;
        $query = $database->query("SELECT * FROM products WHERE product_category = '{$cat_name}'");
           while ($prod = $query->fetch_array(MYSQLI_ASSOC)) {
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