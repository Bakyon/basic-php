<?php
defined('BASE_URL') OR exit('Access denied !!!');
$pid = $_GET['pid'];
$product = (new prods())->checkOwner($pid, $_SESSION['username']);
if (!$product) {
    redirect_to('?cont=user&action=profile', alert_danger_msg('Product does not exist'));
}
$ref_img_src = (strpos($product->images, 'img_'.$product->pid) !== false) ? 'Images/UploadProducts/'.$product->pid.'/'.$product->images : "Images/no-image.png";
include_once 'system/db/categories.php';
$category = (new categories())->getCategory($product->cid)->name;
if (!empty($_POST['delete-img'])) var_dump($_POST['delete-img']);
?>
<div class="container-fluid profile-container">
    <div class="row">
        <div class="col-xl-2">
            <div class="card-img" style="align-content: center;">
                <div class="image_4" style="min-height: 225px;">
                    <img style="max-height: 225px;" src="<?= $ref_img_src ?>">
                </div>
                <a href="?cont=prod&action=edit&pid=<?= $pid ?>" class="btn btn-success" style="width: 100%;margin-top: 10px;">Edit product</a>
                <a href="?cont=user&action=profile" class="btn btn-success" style="width: 100%;margin-top: 10px">Back to profile</a>
                <button class="btn btn-danger" style="width: 100%;margin-top: 10px;" onclick="removeProduct(<?= $pid ?>)">Remove product</button>
            </div>
            <div>

            </div>
        </div>
        <div class="col-xl-10">
            <!-- Start of basic information -->
            <div class="container-fluid" style="padding: 20px;">
                <h1 class="about_taital"><?= $product->name ?></h1>

                <div class="container col-xl-12 col-lg-12" style="float: left; padding: 15px;">
                    <div class="container col-xs-12 mail_sectin">
                        <div class="input-group-text">
                            <label for="pname" style="margin: 0; width: 30%;"><b>Name</b></label>
                            <input type="text" disabled class="email-bt" value="<?= $product->name ?>" name="pname" size="28" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                        </div><br>
                        <div class="input-group-text">
                            <label for="category" style="margin: 0; width: 30%;"><b>Category</b></label>
                            <input type="text" disabled class="email-bt" value="<?= $category ?>" name="category" size="28" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                        </div><br>
                        <div class="input-group-text">
                            <label for="desc" style="margin: 0; width: 30%;"><b>Description</b></label>
                            <textarea type="text" class="email-bt" name="description" aria-required="true" style="margin: 0; padding: 0 0 0 20px; height: 400px; resize: none"><?= $product->description ?></textarea>
                        </div><br>
                        <div class="input-group-text">
                            <label for="brand"  style="margin: 0; width: 30%;"><b>Brand</b></label>
                            <input type="text" class="email-bt" value="<?= $product->brand ?>" name="brand" size="50" style="margin: 0; padding: 0 0 0 20px;">
                        </div><br>
                        <div class="input-group-text">
                            <label for=""  style="margin: 0; width: 30%;"><b>List of images</b></label>
                        </div><br>
                        <!-- Images preview zone -->
                        <div id="preview-zone" style="padding: 0; margin: 0;">
                            <form method="post" enctype="multipart/form-data">
                                <input type="text" hidden id="image-path" readonly name="delete-img">
                            <?php
                            $images = getImages('Images/UploadProducts/'.$product->pid);
                            foreach ($images as $image) { ?>
                                <div class="box_section col-lg-3 col-md-4 col-sm-6" style="height: 310px;">
                                    <div class="image_4" style="min-height: 225px;">
                                            <img alt="img-error" style="max-height: 225px;" src="<?= $image ?>">
                                    </div>
                                    <div class="buy_bt_1 active">
                                        <button type="submit" class="btn btn-danger" style="margin: 10px 0 0 -10px;" onclick="removeImage('<?= $image ?>')">Remove image</button>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function removeProduct(pid) {
                    if (confirm('Are you sure you want to remove this Product? This action cannot be undone!')) {
                        // Redirect to the remove product action
                        window.location.href = "?cont=prod&action=removing&pid=" + pid;
                    }
                }
                function removeImage(path) {
                    if (confirm('Are you sure you want to remove this image? This action cannot be undone!')) {
                        // Redirect to remove image action
                        document.getElementById('image-path').value = path;
                    }
                }
            </script>
        </div>
    </div>
</div>


