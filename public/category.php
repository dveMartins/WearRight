<?php include 'includes/header.php'; ?>
<?php
if(isset($_GET['cat_name'])) {
    $cat_name = $database->escape_string($_GET['cat_name']);
?>

<?php $product = new Product(); ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Category</h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->     
                        <?php
                        
                        $category = new Category();
                        
                        $category->display_all_cats();
                        
                        ?> 
                    </div><!--/category-products-->
                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center"><?php echo strtoupper($cat_name); ?></h2>
                    
                    <?php $category->show_item_by_cat($cat_name); ?>
                 
                </div><!--features_items-->

            </div>
        </div>
    </div>
</section>

<?php
} else {
$category->redirect('404.php');
}

include 'includes/footer.php';



