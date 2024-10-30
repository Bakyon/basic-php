<?php
include 'system/db/prods.php';
class ProdController extends Controller {
    function detail() {
        if (empty($_GET['pid'])) {
            redirect_to(BASE_URL.'?cont=user&action=profile');
        }
        if (!empty($_POST['delete-img'])) {
            if (unlink($_POST['delete-img'])) {
                $msg = alert_success_msg('Successfully deleted image');
            } else {
                $msg = alert_danger_msg('Failed to delete image');
            }
            redirect_to(BASE_URL.'?cont=prod&action=detail&pid='.$_GET['pid'], $msg);
        }
        $this->show('View/products/prod-detail');
    }
    function add() {
        $msg = '';
        // Get owner ID
        include 'system/db/users.php';
        $owner = (new users())->getUserByUsername($_SESSION['username'])->uid;
        // Upload product info
        if (!empty($_POST)) {
            $flag = true;
            // Upload product info and get pid back
            if (empty($_POST['pname'])) {
                $flag = false;
                $msg = 'Product name is required.';
            }
            if (empty($_POST['description'])) {
                $flag = false;
                $msg = 'Product description is required.';
            }
            if ($flag) {
                $brand = empty($_POST['brand']) ? $_POST['brand'] : 'Unknown';
//                 ($name, $cid, $description, $owner, $status, $brand) - status = [0 - deactive, 1 - on hold, 2 - bidding]
                 $pid = (new prods())->addProduct($_POST['pname'], $_POST['category'], $_POST['description'], $owner, 1, $brand);
                if ($pid > 0) {
                    $msg .= alert_success_msg('Product upload successful!');
                    // Upload images of the product if its successfully added
                    if (isset($_FILES['prodimg'])) {
                        // Use the pid to create folder for its images
                        $folder = 'Images/UploadProducts/'.$pid;
                        if (!file_exists($folder)) {
                            // Create a new file or directory
                            mkdir($folder, 0777, true);
                        }
                        $msg .= multipleUpload($_FILES['prodimg'], $folder, 'img_'.$pid);
                        // set reference img for product
                        $ref_name = $_SESSION['uploaded_names'][$_POST['reference']];
                        unset($_SESSION['uploaded_names']);
                        if (!(new prods())->setImages($pid, $ref_name) or !strpos($ref_name, 'img_'.$pid)) {
                            $msg .= alert_success_msg('Failed to upload reference images.');
                        }
                    }
                    redirect_to(BASE_URL.'?cont=prod&action=detail&pid='.$pid, $msg);
                } else {
                    $msg .= 'Failed to create product.';
                }
            }
        }
        echo empty($msg) ? '' : alert_danger_msg($msg);
        $this->show('View/products/prod-add');
    }

    function removing() {
        if (empty($_GET['pid'])) {
            redirect_to(BASE_URL.'?cont=user&action=profile');
        } else {
            $prod = (new prods())->checkOwner($_GET['pid'], $_SESSION['username']);
            if (!$prod) {
                redirect_to(BASE_URL.'?cont=user&action=profile', alert_danger_msg('You do not have this product!'));
            } else {
                (new prods())->setStatus($_GET['pid'], 0);
                redirect_to(BASE_URL.'?cont=user&action=profile', alert_success_msg('Product removed successfully.'));
            }
        }
    }

    function edit() {
        $msg = '';
        // check ownership
        if (empty($_GET['pid'])) {
            redirect_to(BASE_URL.'?cont=user&action=profile');
        }

        // Upload product info
        if (!empty($_POST)) {
            $flag = true;
            // Upload product info and get pid back
            if (empty($_POST['pname'])) {
                $flag = false;
                $msg = 'Product name is required.';
            }
            if (empty($_POST['description'])) {
                $flag = false;
                $msg = 'Product description is required.';
            }
            if ($flag) {
                $brand = empty($_POST['brand']) ? $_POST['brand'] : 'Unknown';
//              updateProduct($id, $name, $cid, $description, $brand) - status = [0 - deactive, 1 - on hold, 2 - bidding]
                $update = (new prods())->updateProduct($_GET['pid'], $_POST['pname'], $_POST['category'], $_POST['description'], $brand);
                if ($update !== 0) {
                    $msg .= alert_success_msg('Product upload successful!');
                    // Upload images of the product if its successfully added
                    if (isset($_FILES['prodimg'])) {
                        // Use the pid to create folder for its images
                        $folder = 'Images/UploadProducts/'.$_GET['pid'];
                        if (!file_exists($folder)) {
                            // Create a new file or directory
                            mkdir($folder, 0777, true);
                        }
                        $msg .= multipleUpload($_FILES['prodimg'], $folder, 'img_'.$_GET['pid']);
                    }
                    redirect_to(BASE_URL.'?cont=prod&action=detail&pid='.$_GET['pid'], $msg);
                } else {
                    $msg .= 'Failed to update product.';
                }
            }
        }
        echo empty($msg) ? '' : alert_danger_msg($msg);
        $this->show('View/products/prod-edit');
    }
}