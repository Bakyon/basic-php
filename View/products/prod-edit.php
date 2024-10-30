<?php
defined('BASE_URL') OR exit('Access denied !!!');
$prod = (new prods())->checkOwner($_GET['pid'], $_SESSION['username']);
if (!$prod) {
    redirect_to(BASE_URL . '?cont=user&action=profile', alert_danger_msg('You do not have this product!'));
}
$categories = (new prods())->getCategories();
$ref_img_src = (strpos($prod->images, 'img_'.$prod->pid) !== false) ? 'Images/UploadProducts/'.$prod->pid.'/'.$prod->images : "Images/no-image.png";
?>
<div class="container-fluid" style="padding: 50px;">
    <div class="image_4" style="min-height: 225px;">
        <img style="max-height: 225px;" src="<?= $ref_img_src ?>">
    </div>
    <h1 class="about_taital">Edit product</h1>
    <!-- Add new product form -->
    <form method="post" enctype="multipart/form-data">
        <!-- Left side -->
        <div class="container col-xl-4 col-lg-6" style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin">
                <div class="input-group-text">
                    <label for="pname" style="margin: 0; width: 30%;"><b>Name</b></label>
                    <input type="text" class="email-bt" required value="<?= $prod->name ?>" name="pname" size="28" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                </div><br>
                <div class="input-group-text">
                    <label for="category" style="margin: 0; width: 30%;"><b>Category</b></label>
                    <select id="category" name="category">
                        <?php
                        foreach ($categories as $category) {
                            echo '<option value="'.$category->cid.'" '.($category->cid == $prod->cid ? 'selected' : '').'>'.$category->name.'</option>';
                        }
                        ?>
                    </select>
                </div><br>
                <div class="input-group-text">
                    <label for="desc" style="margin: 0; width: 30%;"><b>Description</b></label>
                    <textarea type="text" class="email-bt" required name="description" aria-required="true" style="margin: 0; padding: 0 0 0 20px; height: 400px; resize: none"><?= $prod->description ?></textarea>
                </div><br>
            </div>
        </div>
        <!-- End of left side -->
        <!-- Start of right side-->
        <div class="container col-xl-4 col-lg-6"  style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin">
                <div class="input-group-text">
                    <label for="brand"  style="margin: 0; width: 30%;"><b>Brand</b></label>
                    <input type="text" class="email-bt" value="<?= $prod->brand ?>" name="brand" size="50" style="margin: 0; padding: 0 0 0 20px;">
                </div><br>
                <div class="input-group-text">
                    <label for="avatar"  style="margin: 0; width: 30%;"><b>Add more images</b></label>
                    <input type="file" multiple class="form-control-file" placeholder="Choose your files..." onchange="preview(event)" name="prodimg[]" aria-describedby="fileHelpId" style="margin: 0; padding: 0 0 0 20px;">
                </div><br>
                <!-- Preview zone to show uploaded images -->
                <div id="preview-zone" style="padding: 0; margin: 0;">
                </div>
                <!-- End of preview zone -->
            </div>
        </div>
        <!-- End of right side -->
        <div class="container col-xl-4 col-lg-6"  style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin card-group">
                <button type="submit" class="btn btn-success" style="margin-bottom: 10px; width: 100%">Edit</button>
                <a href='?cont=user&action=profile' type="button" class="btn btn-secondary" style="margin-bottom: 10px; width: 100%">Go back to profile</a>
                <button type="reset" class="btn btn-dark" style="margin-bottom: 10px; width: 100%" onclick="reset_prv()">Reset</button>
            </div>
        </div>
    </form>
    <!-- End of add new product form -->
</div>
<script>
    let reset_prv = function () {
        let previewZone = document.getElementById('preview-zone');
        while (previewZone.firstChild) {
            previewZone.removeChild(previewZone.firstChild);
        }
    };
    let preview = function(event) {
        // Clear preview zone before processing
        let previewZone = document.getElementById('preview-zone');
        while (previewZone.firstChild) {
            previewZone.removeChild(previewZone.firstChild);
        }

        // Get amount of upload files
        let amount = event.target.files.length;

        // Creating img preview and append to preview zone
        for (let i = 0; i < amount; i++) {
            // Create new element to contain the image
            let newElement = document.createElement('img');

            // Setting attributes for new element
            newElement.style.width = '23%';
            newElement.style.height = '100px';
            newElement.style.float = "left";
            newElement.style.margin = "1%";
            newElement.src = URL.createObjectURL(event.target.files[i]);
            newElement.onload = function() {
                URL.revokeObjectURL(newElement.src) // free memory
            }

            // Append new element to preview zone
            previewZone.appendChild(newElement);
        }
    };
</script>
