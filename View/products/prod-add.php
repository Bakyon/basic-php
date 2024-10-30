<?php
defined('BASE_URL') OR exit('Access denied !!!');
$categories = (new prods())->getCategories();
?>
<div class="container-fluid" style="padding: 50px;">
    <div class="image_2"><img src="Images/logo.png" style="height: 70px; width: auto;"></div>
    <h1 class="about_taital">Add new product to your stock</h1>
    <!-- Add new product form -->
    <form method="post" enctype="multipart/form-data">
        <!-- Left side -->
        <div class="container col-xl-4 col-lg-6" style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin">
                <div class="input-group-text">
                    <label for="pname" style="margin: 0; width: 30%;"><b>Name</b></label>
                    <input type="text" class="email-bt" required placeholder="Enter item name" name="pname" size="28" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                </div><br>
                <div class="input-group-text">
                    <label for="category" style="margin: 0; width: 30%;"><b>Category</b></label>
                    <select id="category" name="category">
                        <?php
                        foreach ($categories as $category) {
                            echo '<option value="'.$category->cid.'" '.($category->cid == 1 ? 'selected' : '').'>'.$category->name.'</option>';
                        }
                        ?>
                    </select>
                </div><br>
                <div class="input-group-text">
                    <label for="desc" style="margin: 0; width: 30%;"><b>Description</b></label>
                    <textarea type="text" class="email-bt" required placeholder="Write a description about the item, including item status, the more detail the better. Unspoken rule: always describe item's problem/issue." name="description" aria-required="true" style="margin: 0; padding: 0 0 0 20px; height: 400px; resize: none"></textarea>
                </div><br>
            </div>
        </div>
        <!-- End of left side -->
        <!-- Start of right side-->
        <div class="container col-xl-4 col-lg-6"  style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin">
                <div class="input-group-text">
                    <label for="brand"  style="margin: 0; width: 30%;"><b>Brand</b></label>
                    <input type="text" class="email-bt" placeholder="Enter item brand" name="brand" size="50" style="margin: 0; padding: 0 0 0 20px;">
                </div><br>
                <div class="input-group-text">
                    <label for="avatar"  style="margin: 0; width: 30%;"><b>Images</b></label>
                    <input type="file" multiple class="form-control-file" placeholder="Choose your files..." onchange="preview(event)" name="prodimg[]" aria-describedby="fileHelpId" style="margin: 0; padding: 0 0 0 20px;">
                </div><br>
                <!-- Choosing reference img selector -->
                <div id="reference-id" style="padding: 0; margin: 0;">
                </div>
                <!-- Preview zone to show uploaded images -->
                <div id="preview-zone" style="padding: 0; margin: 0;">
                </div>
                <!-- End of preview zone -->
            </div>
        </div>
        <!-- End of right side -->
        <div class="container col-xl-4 col-lg-6"  style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin card-group">
                <button type="submit" class="btn btn-success" style="margin-bottom: 10px; width: 100%">Add new item</button>
                <a href=BASE_URL type="button" class="btn btn-secondary" style="margin-bottom: 10px; width: 100%">Go back to home page</a>
                <button type="reset" class="btn btn-dark" style="margin-bottom: 10px; width: 100%" onclick="reset_prv()">Reset</button>
            </div>
            <div style="margin-top: 200px;">
                You can add images and choose product reference later!<br>
                You can not remove chosen images but you can re-select them, the new uploaded will replace the old ones.
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

        // Clear selector zone before processing
        let selector_zone = document.getElementById('reference-id');
        while (selector_zone.firstChild) {
            selector_zone.removeChild(selector_zone.firstChild);
        }

        // Create selector
        let selector = document.createElement('select');
        selector.name = 'reference';

        // Create options and append it to selector
        for (let i = 0; i < amount; i++) {
            let option = document.createElement('option');
            option.value = i;
            option.text = 'Image ' + (i + 1);
            option.selected = i == 0 ? true : false;
            selector.appendChild(option);
        }

        // Append selector to selector zone
        selector_zone.appendChild(selector);
    };
</script>
