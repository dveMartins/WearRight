<?php

class Product extends General{
    
    public $product_id;
    public $product_name;
    public $product_desc;
    public $product_category;
    public $product_price;
    public $product_quantity;
    public $product_image;
    
    private function get_product() {
        global $database;    
        $query = $database->query("SELECT * FROM products");
        return $query;
    }
    
    public function get_prod_by_id($prod_id) {
        global $database;
        $query = $database->query("SELECT * FROM products WHERE product_id = $prod_id");
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
                            <a href="product_details.php?p_id={$prod['product_id']}" class="btn btn-default add-to-cart"><i class="fa fa-eye"></i>View</a><br>
                            <a href="cart.php?add={$prod['product_id']}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
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
            $this->product_id    = $row['product_id'];
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
                <a href="single_product.php?p_id={$this->product_id}" class="product-title">$this->product_name
                    <span class="label label-warning pull-right">&euro;$this->product_price</span></a>
                <span class="product-description">
                    $this->product_desc
                </span>
            </div>
        </li>   
DELIMETER;
        endwhile;

    }
    
    /*************** Get all Products according to product IDs **************/
    
    public function get_all_prod_by_id() {
        global $database;
        $query = $database->query("SELECT * FROM products WHERE product_id = '{$this->product_id}'");
        return $query;
    }
    
    public function get_prod_items_by_id() {
        global $database;
        $query = $this->get_all_prod_by_id();
        while($row = $query->fetch_array(MYSQLI_ASSOC)) {
            $this->product_id = $row['product_id'];
            $this->product_name = $row['product_name'];
            $this->product_desc = $row['product_desc'];
            $this->product_category = $row['product_category'];
            $this->product_price = $row['product_price'];
            $this->product_quantity = $row['product_quantity'];
            $this->product_image = $row['product_image'];
        }
    }
    
    /************** Get all categories for Edit Product page ***************/
    
    public function show_all_category($prod_cat) {
        global $database;
        $cat = $database->query("SELECT * FROM categories");
        while($row = $cat->fetch_array(MYSQLI_ASSOC)):
            $selected = $row['category_name'] == $prod_cat ? 'selected' : '';
            echo "<option $selected> {$row['category_name']} </option>";
        endwhile;
    }
    
    /************** Create Product ***************/
    
    public function create_product() {
        global $database;
        $this->product_name     = $database->escape_string($_POST['product_name']);
        $this->product_category = $database->escape_string($_POST['product_category']);
        $this->product_desc     = $database->escape_string($_POST['product_desc']);
        $this->product_price    = $database->escape_string($_POST['product_price']);
        $this->product_quantity = $database->escape_string($_POST['product_quantity']);
        
        if($_FILES['product_image']['error'] == 0) {        
            $this->product_image = htmlspecialchars($_FILES['product_image']['name']);
        } else {
            $this->product_image = "default-product.png";
        }
        
        $query = $database->query("INSERT INTO products (product_name, product_desc, product_category, product_price, product_quantity, product_image) "
                . "VALUES ('{$this->product_name}', '{$this->product_desc}', '{$this->product_category}', '{$this->product_price}', "
                . "'{$this->product_quantity}', '{$this->product_image}')");
                
        return $query;
    }
    
    
    /*********** Update Products *********************/
    
    public function update_product($row) {
        global $database;
        $this->product_name     = $database->escape_string($_POST['product_name']);
        $this->product_category = $database->escape_string($_POST['product_category']);
        $this->product_desc     = $database->escape_string($_POST['product_desc']);
        $this->product_price    = $database->escape_string($_POST['product_price']);
        $this->product_quantity = $database->escape_string($_POST['product_quantity']);
        
        
        
        //Check if image was uploaded
        
        if($_FILES['product_image']['error'] == 0) {        
            $this->product_image = htmlspecialchars($_FILES['product_image']['name']);
        } else {
            $this->product_image = $row['product_image'];
        }
        
         //check empty for textarea
        
        if(isset($_POST['product_desc']) && empty($_POST['product_desc'])) {
            $this->product_desc = $row['product_desc'];
        }
        
        //Check for empty inputs
        
        switch (empty($_POST)):
            case $_POST['product_name']:
                    $this->product_name     = $row['product_name'];
            case $_POST['product_category']:
                    $this->product_category = $row['product_category'];          
            case $_POST['product_price']:
                    $this->product_price    = $row['product_price'];
            case $_POST['product_quantity']:
                    $this->product_quantity = $row['product_quantity'];
                    break;
        endswitch;
        
        $query = $database->query("UPDATE products SET "
                . "product_name     = '{$this->product_name}', "
                . "product_desc     = '{$this->product_desc}', "
                . "product_category = '{$this->product_category}', "
                . "product_price    = '{$this->product_price}', "
                . "product_quantity = '{$this->product_quantity}', "
                . "product_image    = '{$this->product_image}' "
                . "WHERE product_id = '{$this->product_id}'");
                
        return $query;
    }
    
    /************** Delete Products *******************/
    
    public function delete_product() {
        global $database;
        $query = $database->query("DELETE FROM products WHERE product_id = {$this->product_id}");
        return $query;
    }
   
    
    /************* Display all Products in Admin ************/
    
    public function display_all_prod_in_admin() {
        $products   = $this->get_product();
        while($row = $products->fetch_array(MYSQLI_ASSOC)) { 
            $prod_desc = substr($row['product_desc'], 0, 50);
echo <<<PRODUCTS
            
    <tr class='clickable-row' data-href='single_product.php?p_id={$row['product_id']}'>
       <td>{$row['product_id']}</td>
       <td>{$row['product_name']}</td>
       <td><span class="label label-info">{$row['product_quantity']}</span></td>
       <td><img class="img-bordered img-responsive img-circle" width="65" height="80" src="../images/products/{$row['product_image']}"></td>
       <td><span class="label label-danger">{$row['product_category']}</span></td>
       <td>{$row['product_price']}</td>
       <td>{$prod_desc}...</td> 
    </tr>   
           
PRODUCTS;
            
        }
    }
    
    /************* Show related products in product description page ******************/
    
    public function show_related_prod($category) {
        global $database;
        $query = $database->query("SELECT * FROM products WHERE product_category = '{$category}'");
        while($row = $query->fetch_array(MYSQLI_ASSOC)) {
    echo <<<DELIMETER
        <div class="col-sm-3">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="images/products/{$row['product_image']}" alt="{$row['product_name']}" />
                        <h2>&euro;{$row['product_price']}</h2>
                        <p>{$row['product_name']}</p>
                        <a href="product_details.php?p_id={$row['product_id']}" class="btn btn-default add-to-cart"><i class="fa fa-eye"></i>View</a>
                    </div>
                </div>
            </div>
        </div>  
DELIMETER;
        }
    }
}