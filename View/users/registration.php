<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<div class="container-fluid" style="padding: 50px;">
    <div class="image_2"><img src="Images/logo.png" style="height: 70px; width: auto;"></div>
    <h1 class="about_taital">Registration</h1>
    <!-- Registration form -->
    <form method="post" enctype="multipart/form-data">
        <!-- Start of basic information -->
        <div class="container col-xl-4 col-lg-6 col-xs-12" style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin">
                <div class="input-group-text">
                    <label for="username" style="margin: 0; width: 30%;"><b>Username *</b></label>
                    <input type="text" class="email-bt" required placeholder="Enter Username" name="username" size="28" aria-required="true">
                </div><br>
                <div class="input-group-text">
                    <label for="password" style="margin: 0; width: 30%;"><b>Password *</b></label>
                    <input type="password" class="email-bt" required placeholder="Enter Password" name="password" size="50" aria-required="true">
                </div><br>
                <div class="input-group-text">
                    <label for="2ndpassword" style="margin: 0; width: 30%;"><b>Retype<br>password *</b></label>
                    <input type="password" class="email-bt" required placeholder="Retype password" name="2ndpassword" size="50" aria-required="true">
                </div><br>
                <div class="input-group-text">
                    <label for="phone"  style="margin: 0; width: 30%;"><b>Phone *</b></label>
                    <input type="text" class="email-bt" required placeholder="Enter phone number" name="phone" size="20" aria-required="true">
                </div><br>
                <div class="input-group-text">
                    <label for="address"  style="margin: 0; width: 30%;"><b>Address *</b></label>
                    <input type="text" class="email-bt" required placeholder="Enter address" name="address" aria-required="true">
                </div><br>
            </div>
        </div>
        <!-- End of basic information -->
        <!-- Start of additional information-->
        <div class="container col-xl-4 col-lg-6 col-xs-12"  style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin">
                <div class="input-group-text">
                    <label for="alias"  style="margin: 0; width: 30%;"><b>Alias</b></label>
                    <input type="text" class="email-bt" placeholder="Enter Alias" name="alias" size="50">
                </div><br>
                <div class="input-group-text">
                    <textarea class="massage-bt" placeholder="Tell us about yourself" rows="5" id="comment" name="aboutme"></textarea>
                </div><br>
                <div class="input-group-text">
                    <label for="avatar"  style="margin: 0; width: 30%;"><b>Avatar</b></label>
                    <input type="file" class="form-control-file" placeholder="Choose your file..." onchange="preview(event)" name="avatar" aria-describedby="fileHelpId" style="margin: 0; padding: 0 0 0 20px;">
                </div><br>
                <div>
                    <img id="preview-img-1">
                    <img id="preview-img-2">
                </div>
            </div>
        </div>
        <!-- End of additional information -->
        <div class="container col-xl-4 col-lg-6 col-xs-12"  style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin card-group">
                <button type="submit" class="btn btn-success" style="margin-bottom: 10px; width: 100%;">Register</button>
                <a href="http://auctionhouse.com" type="button" class="btn btn-secondary" style="margin-bottom: 10px; width: 100%;">Go back to home page</a>
                <a href="?cont=user&action=login" type="button" class="btn btn-dark" style="margin-bottom: 10px; width: 100%;">Already have an account?<br>Login now !</a>
            </div>
        </div>
    </form>
    <!-- End of registration form -->
</div>
<script>
    let preview = function(event) {
        let size = [130, 60];
        for (let i = 1; i < 3; i++) {
            let $img = 'preview-img-' + i;
            let output = document.getElementById($img);
            output.style.height = size[i-1] + 'px';
            output.style.width = size[i-1] + 'px';
            output.style.float = "left";
            output.style.marginRight = "20px";
            output.style.borderRadius = "50%";
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }

    };
</script>