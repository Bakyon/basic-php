<?php
defined('BASE_URL') OR exit('Access denied !!!');
include 'system/db/prods.php';
include 'system/db/categories.php';
$product = (new prods())->checkOwner($_GET['pid'], $_SESSION['username']);
$category = (new categories())->getCategory($product->cid)->name;
$img_src = (strpos($product->images, 'img_'.$product->pid) !== false) ? 'Images/UploadProducts/'.$product->pid.'/'.$product->images : "Images/no-image.png";
?>
<div class="container-fluid profile-container">
    <div class="row">
        <div class="col-xl-2">
            <div class="col-sm-12">
                <div class="box_section" style="height: 350px;">
                    <div class="image_4" style="min-height: 225px;">
                        <img style="max-height: 225px;" src="<?= $img_src ?>">
                    </div>
                    <h2 class="dolor_text prod-name"><?= $product->name ?></h2>
                </div>
            </div>
        </div>
        <div class="col-xl-10">

            <!-- Start of basic information -->
            <div class="container col-xl-6 col-xs-12" style="float: left; padding: 25px;">
                <div class="container col-xs-12 mail_sectin">
                    <div class="input-group-text">
                        <label for="pname" style="margin: 0; width: 30%;"><b>Product name</b></label>
                        <input type="text" class="email-bt" disabled placeholder="<?= $product->name ?>" name="pname" size="28" aria-required="true">
                    </div><br>
                    <div class="input-group-text">
                        <label for="category" style="margin: 0; width: 30%;"><b>Category</b></label>
                        <input type="text" disabled class="email-bt" value="<?= $category ?>" name="category" size="28" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                    </div><br>
                    <div class="input-group-text">
                        <label for="brand"  style="margin: 0; width: 30%;"><b>Brand</b></label>
                        <input type="text" class="email-bt" disabled placeholder="<?= $product->brand ?>" name="brand" size="20" aria-required="true">
                    </div><br>
                    <div class="input-group-text">
                        <label for="desc" style="margin: 0; width: 30%;"><b>Description</b></label>
                        <textarea type="text" class="email-bt" name="description" aria-required="true" style="margin: 0; padding: 0 0 0 20px; height: 400px; resize: none"><?= $product->description ?></textarea>
                    </div><br>
                </div>
            </div>
            <!-- End of basic information -->
            <!-- Start of additional information-->
            <div class="container col-xl-6 col-xs-12"  style="float: left; padding: 25px;">
                <div class="container col-xs-12 mail_sectin">
                    <form method="post" enctype="multipart/form-data">
                        <div class="container col-xs-12 mail_sectin">
                            <div class="input-group-text">
                                <label for="start_price" style="margin: 0; width: 30%;"><b>Starting price</b></label>
                                <input type="text" class="email-bt" required placeholder="Enter starting price" name="start_price" size="28" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                            </div><br>
                            <div class="input-group-text">
                                <label for="end_price" style="margin: 0; width: 30%;"><b>End price</b></label>
                                <input type="text" class="email-bt" required placeholder="Enter reserve price if wished" name="end_price" size="28" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                            </div><br>
                            <div class="input-group-text">
                                <label for="step" style="margin: 0; width: 30%;"><b>Step</b></label>
                                <input type="text" class="email-bt" required placeholder="Enter step, must be multiple of 1.000" name="step" size="28" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                            </div><br>
                            <div class="container col-xs-12 mail_sectin card-group">
                                <button type="submit" class="btn btn-success" style="margin-bottom: 10px; width: 100%">Post to auction</button>
                                <a href="?cont=user&action=profile" type="button" class="btn btn-secondary" style="margin-bottom: 10px; width: 100%">Go back to profile page</a>
                                <button type="reset" class="btn btn-dark" style="margin-bottom: 10px; width: 100%" onclick="reset_prv()">Reset</button>
                            </div><br>
                        </div>
                    </form>
            </div>
            <!-- End of additional information -->
        </div>
    </div>
</div>