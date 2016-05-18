<?php

$products = new Product();

?>
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <?php
                            for($i = 1; $i <= 2; $i++) {                              
                                echo "<li data-target='#slider-carousel' data-slide-to='$i'></li>";
                            }                     
                        ?>
                    </ol>
                    <div class="carousel-inner">                     
                        <?php 
                            $slider_active = $database->query("SELECT * FROM products LIMIT 1");
                            $slider = $products->get_product();                           
                                while($row = $slider_active->fetch_array(MYSQLI_NUM)) {
                                    while($row1 = $slider->fetch_array(MYSQLI_ASSOC)): 
                                    if($row[0] == $row1['product_id']) {
                                        $active = "active";
                                    } else {
                                        $active = "";
                                    }
                        ?>
                        <div class="item <?php echo $active; ?>">
                            <div class="col-sm-6">
                                <h1><span>W</span>ear-<span>R</span>ight</h1>
                                <h2>Where To Shop Right</h2>                               
                                <p><?php echo $row1['product_desc']; ?> </p>
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="<?php echo $row1['product_image']; ?>" class="img-responsive" alt="" />
                            </div>
                        </div>                     
                        <?php endwhile; } ?>                      
                    </div>
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section><!--/slider-->