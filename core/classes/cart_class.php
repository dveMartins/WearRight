<?php

class Cart extends General {

    private $prod_id;
    private $total;
    private $item_quantity;
    private $item_name;
    private $item_number;
    private $amount;
    private $quantity;
    private $sub;

    public function add_prod_to_cart() {
        global $database;
        $product = new Product();
        $this->prod_id = $database->escape_string($_GET['add']);
        $query = $product->get_prod_by_id($this->prod_id);
        foreach ($_SESSION as $key => $value) {
            while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
                if ($row['product_quantity'] > $value) {
                    $_SESSION['product_' . $this->prod_id] += 1;
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    public function remove_from_cart() {
        $_SESSION['product_' . $_GET['remove']] --;

        if ($_SESSION['product_' . $_GET['remove']] < 1) {

            unset($_SESSION['item_total']);
            unset($_SESSION['item_quantity']);
            $this->redirect("index.php");
        }
        return TRUE;
    }

    public function delete_cart() {
        $_SESSION['product_' . $_GET['delete']] = '0';
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        return TRUE;
    }

    public function cart_show() {
        $this->total = 0;
        $this->item_quantity = 0;
        $this->item_name = 1;
        $this->item_number = 1;
        $this->amount = 1;
        $this->quantity = 1;

        foreach ($_SESSION as $name => $value) {
            global $database;
            $product = new Product();
            if ($value > 0) {

                if (substr($name, 0, 8) == "product_") {

                    $length = strlen($name - 8);

                    $this->prod_id = $database->escape_string(substr($name, 8, $length));

                    $query = $product->get_prod_by_id($this->prod_id);

                    while ($row = $query->fetch_array(MYSQLI_ASSOC)) {

                        $this->sub = $row['product_price'] * $value;
                        $this->item_quantity += $value;
                        $product_desc = substr($row['product_desc'], 0, 10);
                        $product = <<<DELIMETER
                    <tr>
                        <td class="cart_product">
                            <a href=""><img class="img-circle img-bordered"height="100" src="images/products/{$row['product_image']}" alt="{$row['product_name']}"></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{$row['product_name']}</a></h4>
                        </td>
                        <td class="cart_price">
                            <p> &euro;{$row['product_price']}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href="cart.php?add={$row['product_id']}"> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="{$value}" autocomplete="off" size="2">
                                <a class="cart_quantity_down" href="cart.php?remove={$row['product_id']}"> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price"> &euro;{$this->sub}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="cart.php?delete={$row['product_id']}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                        
                        <input type="hidden" name="item_name_{$this->item_name}" value="{$row['product_name']}">
                        <input type="hidden" name="item_number_{$this->item_number}" value="{$row['product_id']}">
                        <input type="hidden" name="amount_{$this->amount}" value="{$row['product_price']}">
                        <input type="hidden" name="quantity_{$this->quantity}" value="{$this->quantity}">
                        
DELIMETER;


                        echo $product;

                        $this->item_name ++;
                        $this->item_number ++;
                        $this->amount ++;
                        $this->quantity ++;
                    }

                    //Calculating total

                    $_SESSION['item_total'] = $this->total += $this->sub;
                    $_SESSION['item_quantity'] = $this->item_quantity;
                }
            }
        }
    }
    
    public function show_paypal() {
         if(isset($_SESSION['item_quantity']) && $_SESSION['item_quantity'] >= 1) {

        $paypal_button = 
<<<DELIMETER
            <input type="image" name="upload"
            src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
            alt="PayPal - The safer, easier way to pay online">
DELIMETER;
        return $paypal_button;

    }
    }
}
