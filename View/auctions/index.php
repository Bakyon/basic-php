<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<!--list of owners products on bidding section start -->
<div class="vegetables_section layout_padding">
    <div class="container">
        <h1 class="about_taital">Bakyon auction house</h1>
        <div class="vegetables_section_2 layout_padding">
            <?php
            $index = 0;

            $products = (new auctions())->getAll();
            foreach ($products as $product) {
                if ($index == 0) {
                    echo "<div class='row'>";
                }
                $img_src = (strpos($product->images, 'img_'.$product->pid) !== false) ? 'Images/UploadProducts/'.$product->pid.'/'.$product->images : "Images/no-image.png";
                ?>
                <div class="col-sm-3">
                    <div class="box_section" style="height: 450px;">
                        <div class="image_4" style="min-height: 225px;">
                            <a href="?cont=auction&action=detail&pid=<?= $product->pid ?>">
                                <img style="max-height: 225px;" src="<?= $img_src ?>">
                            </a>
                        </div>

                        <h2 class="dolor_text">Current: <span style="color: green;">$<?= $product['current_price'] ?></span></h2>
                        <h2 class="dolor_text">Max. bid: <span style="color: darkred;">$<?= $product['max_price'] ?></span></h2>
                        <h2 class="dolor_text">Step: $<?= $product['step'] ?></h2>
                        <h2 class="dolor_text prod-name" style="height: 80px;"><?= $product['name'] ?></h2>
                        <p class="tempor_text">Highest bid by <a href="#"><?= $product['current_bid'] ?></a></p>
                        <div class="buy_bt_1 active"><a href="?cont=Prod&action=detail&pid=<?= $product['id'] ?>">Bid Now</a></div>

                        <h2 class="dolor_text" style="margin: 20px 0 20px 0;"><?= $product->name ?></h2>
                        <div class="buy_bt_1 active">
                            <a href="?cont=auction&action=detail&pid=<?= $product->pid ?>">To auction house</a>
                        </div>
                    </div>
                </div>
                <?php
                if ($index == 3) {
                    echo "</div>";
                }
                $index = ($index + 1) % 4;
            }
            ?>
        </div>
        <div class="read_bt_1"><a href="#">Read More</a></div>
    </div>
</div>
<!--list of owners products on bidding section end -->
