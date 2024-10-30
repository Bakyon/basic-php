<?php
defined('BASE_URL') OR exit('Access denied !!!');
$user = (new users())->getUserByUsername($_GET['username']);
include 'system/db/prods.php';
?>
<div class="container-fluid profile-container">
    <div class="row">
        <div class="col-xl-3">
            <div class="card-img" style="padding: 30px;">
                <img src="Images/UploadAvatars/<?= $user->avatar ?>" style="border-radius: 50%; margin: 0 5px; object-fit: cover; width: 200px; height: 200px;">
            </div>
            <?php
            if (strcasecmp($_GET['username'], $_SESSION['username']) == 0) {
                ?>
                <div>
                    <a href="?cont=user&action=edit&username=<?= $user->username ?>" class="btn btn-success" style="width: 200px;margin: 0 0 10px 30px;">Edit profile</a>
                    <a href="?cont=user&action=changepw" class="btn btn-secondary" style="width: 200px; margin: 0 0 10px 30px;">Change password</a>
                    <button class="btn btn-danger" style="width: 200px; margin: 0 0 10px 30px;" onclick="removeAvatar()">Remove avatar</button>
                    <a href="?cont=prod&action=add" class="btn btn-primary" style="width: 200px; margin: 0 0 10px 30px;">Add new product</a>
                    <script>
                        function removeAvatar() {
                            if (confirm('Are you sure you want to remove your avatar?')) {
                                // Redirect to the remove avatar action
                                window.location.href = "?cont=user&action=unsetavt";
                            }
                        }
                    </script>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="col-xl-9">

            <!-- Start of basic information -->
            <div class="container col-xl-6 col-xs-12" style="float: left; padding: 25px;">
                <div class="container col-xs-12 mail_sectin">
                    <div class="input-group-text">
                        <label for="username" style="margin: 0; width: 30%;"><b>Username</b></label>
                        <input type="text" class="email-bt" disabled placeholder="<?= $user->username ?>" name="username" size="28" aria-required="true">
                    </div><br>
                    <div class="input-group-text">
                        <label for="phone"  style="margin: 0; width: 30%;"><b>Phone *</b></label>
                        <input type="text" class="email-bt" disabled placeholder="<?= $user->phone ?>" name="phone" size="20" aria-required="true">
                    </div><br>
                    <div class="input-group-text">
                        <label for="address"  style="margin: 0; width: 30%;"><b>Address *</b></label>
                        <input type="text" class="email-bt" disabled placeholder="<?= $user->address ?>" name="address" aria-required="true">
                    </div><br>
                </div>
            </div>
            <!-- End of basic information -->
            <!-- Start of additional information-->
            <div class="container col-xl-6 col-xs-12"  style="float: left; padding: 25px;">
                <div class="container col-xs-12 mail_sectin">
                    <div class="input-group-text">
                        <label for="alias"  style="margin: 0; width: 30%;"><b>Alias</b></label>
                        <input type="text" class="email-bt" disabled placeholder="<?= $user->alias ?>" name="alias" size="50">
                    </div><br>
                    <div class="input-group-text">
                        <label for="aboutme"  style="margin: 0; width: 30%;"><b>About me</b></label>
                        <textarea class="massage-bt" style="resize: none;" disabled placeholder="<?= $user->about_me ?>" rows="5" id="comment" name="aboutme"></textarea>
                    </div><br>
                    <div>
                        <img id="preview-img-1">
                        <img id="preview-img-2">
                    </div>
                </div>
            </div>
            <!-- End of additional information -->
        </div>
    </div>
</div>

<?php
if (strcasecmp($_GET['username'], $_SESSION['username']) == 0) {
?>

<!--list of owners products on warehouse section start -->
<div class="vegetables_section layout_padding">
    <div class="container">
        <h1 class="about_taital">My warehouse</h1>
        <div class="vegetables_section_2 layout_padding">
            <?php
            $index = 0;
            $products = (new prods())->getProductByUserID($user->uid, 1);
            foreach ($products as $product) {
                if ($index == 0) {
                    echo "<div class='row'>";
                }
                $img_src = (strpos($product->images, 'img_'.$product->pid) !== false) ? 'Images/UploadProducts/'.$product->pid.'/'.$product->images : "Images/no-image.png";
                ?>
                <div class="col-sm-3">
                    <div class="box_section" style="height: 450px;">
                        <div class="image_4" style="min-height: 225px;">
                            <a href="?cont=prod&action=detail&pid=<?= $product->pid ?>">
                                <img style="max-height: 225px;" src="<?= $img_src ?>">
                            </a>
                        </div>
                        <h2 class="dolor_text prod-name"><?= $product->name ?></h2>
                        <div class="buy_bt_1 active">
                            <a href="?cont=auction&action=posting&pid=<?= $product->pid ?>">Post this</a>
                            <button class="btn btn-danger" style="margin-top: 10px;" onclick="removeProduct(<?= $product->pid ?>)">Remove this</button>
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
            <script>
                function removeProduct(pid) {
                    if (confirm('Are you sure you want to remove this Product? This action cannot be undone!')) {
                        // Redirect to the remove avatar action
                        window.location.href = "?cont=prod&action=removing&pid=" + pid;
                    }
                }
            </script>
        </div>
        <div class="read_bt_1"><a href="#">Read More</a></div>
    </div>
</div>
<!--list of owners products on warehouse section end -->

<!--list of owners products on bidding section start -->
<div class="vegetables_section layout_padding">
    <div class="container">
        <h1 class="about_taital">My products on bidding</h1>
        <div class="vegetables_section_2 layout_padding">
            <?php
            $index = 0;
            $biddings = (new prods())->getProductByUserId($user->uid, 2);
            foreach ($biddings as $product) {
                if ($index == 0) {
                    echo "<div class='row'>";
                }
                $img_src = (strpos($product->images, 'img_'.$product->pid) !== false) ? 'Images/UploadProducts/'.$product->pid.'/'.$product->images : "Images/no-image.png";
                ?>
                <div class="col-sm-3">
                    <div class="box_section" style="height: 450px;">
                        <div class="image_4" style="min-height: 225px;">
                            <a href="?cont=prod&action=detail&pid=<?= $product->pid ?>">
                                <img style="max-height: 225px;" src="<?= $img_src ?>">
                            </a>
                        </div>
                        <h2 class="dolor_text prod-name"><?= $product->name ?></h2>
                        <div class="buy_bt_1 active">
                            <a style="margin-top: 10px;" href="?cont=auction&=detail&pid=<?= $product->pid ?>">To auction house</a>
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

<!--list of owners products on transaction section start -->
<div class="vegetables_section layout_padding">
    <div class="container">
        <h1 class="about_taital">Products on waiting for arrival</h1>
        <div class="vegetables_section_2 layout_padding">
            <?php
            $index = 0;
            $ontransactions = (new prods())->getProductByUserId($user->uid, 3);
            foreach ($ontransactions as $product) {
                if ($index == 0) {
                    echo "<div class='row'>";
                }
                $img_src = (strpos($product->images, 'img_'.$product->pid) !== false) ? 'Images/UploadProducts/'.$product->pid.'/'.$product->images : "Images/no-image.png";
                ?>
                <div class="col-sm-3">
                    <div class="box_section" style="height: 450px;">
                        <div class="image_4" style="min-height: 225px;">
                            <a href="?cont=prod&action=detail&pid=<?= $product->pid ?>">
                                <img style="max-height: 225px;" src="<?= $img_src ?>">
                            </a>
                        </div>
                        <h2 class="dolor_text prod-name"><?= $product->name ?></h2>
                        <div class="buy_bt_1 active">
                            <a href="?cont=Prod&action=receiving&pid=<?= $product->pid ?>">I got this</a>
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
<!--list of owners products on transaction section end -->
<?php } ?>