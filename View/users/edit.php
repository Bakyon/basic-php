<?php
defined('BASE_URL') OR exit('Access denied !!!');
$user = (new users())->getUserByUsername($_GET['username']);
?>
<div class="container-fluid profile-container">
    <div class="row">
        <div class="col-xl-12">
            <!-- Start of change info form -->
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="col-xl-12">
                    <!-- Start of basic information -->
                    <div class="container col-xl-4 col-xs-12" style="float: left; padding: 25px;">
                        <div class="container col-xs-12 mail_sectin">
                            <div class="input-group-text">
                                <label for="username" style="margin: 0; width: 30%;"><b>Username</b></label>
                                <input type="text" class="email-bt" readonly value="<?= $user->username ?>" name="username" size="28" aria-required="true">
                            </div><br>
                            <div class="input-group-text">
                                <label for="phone"  style="margin: 0; width: 30%;"><b>Phone</b></label>
                                <input type="text" class="email-bt" required value="<?= $user->phone ?>" name="phone" size="20" aria-required="true">
                            </div><br>
                            <div class="input-group-text">
                                <label for="address"  style="margin: 0; width: 30%;"><b>Address</b></label>
                                <input type="text" class="email-bt" required value="<?= $user->address ?>" name="address" aria-required="true">
                            </div><br>
                        </div>
                    </div>
                    <!-- End of basic information -->
                    <!-- Start of additional information-->
                    <div class="container col-xl-4 col-xs-12"  style="float: left; padding: 25px;">
                        <div class="container col-xs-12 mail_sectin">
                            <div class="input-group-text">
                                <label for="alias"  style="margin: 0; width: 30%;"><b>Alias</b></label>
                                <input type="text" class="email-bt" value="<?= $user->alias ?>" name="alias" size="50">
                            </div><br>
                            <div class="input-group-text">
                                <label for="aboutme"  style="margin: 0; width: 30%;"><b>About me</b></label>
                                <textarea class="massage-bt" rows="5" id="comment" name="aboutme"><?= $user->about_me ?></textarea>
                            </div><br>
                        </div>
                    </div>
                    <!-- End of additional information -->
                    <!-- Start of avatar preview -->
                    <div class="container col-xl-4 col-xs-12"  style="float: left; padding: 25px;">
                        <div class="input-group-text">
                            <label for="avatar"  style="margin: 0; width: 30%;"><b>Avatar</b></label>
                            <input type="file" class="form-control-file" placeholder="Choose your file..." onchange="preview(event)" id="avatar" name="avatar" aria-describedby="fileHelpId" style="margin: 0; padding: 0 0 0 20px;">
                        </div><br>
                        <div>
                            <img id="preview-img-1" src="Images/UploadAvatars/<?= $user->avatar ?>" width="130px" height="130px" style="border-radius: 50%; margin: 5px; padding: 0;">
                            <img id="preview-img-2" src="Images/UploadAvatars/<?= $user->avatar ?>" width="60px" height="60px" style="border-radius: 50%; margin: 5px; padding: 0;">
                            <button class="btn btn-primary" type="button" onclick="reset_prv('<?= $_SESSION['avatar'] ?>')" style="width: 200px; margin: 0 0 10px 30px;">Reset image</button>
                        </div>
                    </div>
                    <!-- End of avatar preview -->
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-success" style="width: 200px; margin: 0 0 10px 30px;">Update my profile</button>
                    <button type="reset" class="btn btn-danger" style="width: 200px; margin: 0 0 10px 30px;" onclick="reset_prv('<?= $_SESSION['avatar'] ?>')">Reset</button>
                    <a href="?cont=user&action=profile" class="btn btn-secondary" style="width: 200px;margin: 0 0 10px 30px;">Go back</a>

                    <script>
                        let preview = function(event) {
                            for (let i = 1; i < 3; i++) {
                                let $img = 'preview-img-' + i;
                                let output = document.getElementById($img);
                                output.src = URL.createObjectURL(event.target.files[0]);
                                output.onload = function() {
                                    URL.revokeObjectURL(output.src) // free memory
                                }
                            }
                        };
                        let reset_prv = function(avt) {
                            let $img1 = document.getElementById('preview-img-1');
                            let $img2 = document.getElementById('preview-img-2');
                            $img1.src = $img2.src = 'Images/UploadAvatars/' + avt;
                            let $fileInput = document.getElementById('avatar');
                            $fileInput.files = null;
                            $fileInput.value = '';
                        };
                    </script>
                </div>
            </form>
            <!-- End of change info form -->

        </div>
    </div>
</div>

