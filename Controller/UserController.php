<?php
include 'system/db/users.php';
class UserController extends Controller {
    function login() {
        if (is_login()) redirect_to(BASE_URL);
        if (isset($_POST['uname'], $_POST['psw'])) {
            $user = (new users())->login($_POST['uname'], $_POST['psw']);
            if ($user) {
                $_SESSION['username'] = $user->username;
                $_SESSION['login_status'] = 1;
                $_SESSION['avatar'] = $user->avatar;
                $_SESSION['alias'] = $user->alias;
                // save cookie if needed
                if (isset($_POST['remember']) and $_POST['remember']) {
                    $time = time() + 60 * 60 * 24 * 30; // save cookie for 30 days
                    setcookie("remember", true, $time);
                    setcookie("username", $user->username, $time);
                    setcookie("alias", $user->alias, $time);
                    setcookie("avatar", $user->avatar, $time);
                }

                redirect_to(BASE_URL, alert_success_msg('Login successful'));
            } else {
                echo alert_danger_msg('Wrong username or password!');
            }
        }
        $this->show('View/users/login', 'empty');
    }
    function registration() {
        if (is_login()) redirect_to(BASE_URL);
        $msg = '';
        $flag = true;
        if (!empty($_POST)) {
            // Check information validation
            if (empty($_POST['username'])) {
                $msg .= 'Username is required!';
                $flag = false;
            }
            if (empty($_POST['password'])) {
                $msg .= 'Password is required!';
                $flag = false;
            }
            if (empty($_POST['2ndpassword']) or $_POST['2ndpassword'] != $_POST['password']) {
                $msg .= 'Passwords do not match!';
                $flag = false;
            }
            if (empty($_POST['phone'])) {
                $msg .= 'Phone number is required!';
                $flag = false;
            }
            if (empty($_POST['address'])) {
                $msg .= 'Address is required!';
                $flag = false;
            }
            if ($flag) {
                $alias = empty($_POST['alias']) ? $_POST['username'] : $_POST['alias'];
                $about_me = empty($_POST['about_me']) ? 'Hi, nice to meet you!' : $_POST['about_me'];
                $add_user = (new users())->addUser($_POST['username'], $_POST['password'], $alias, $_POST['phone'], $_POST['address'], 'no-avatar.png', $about_me, 0);
                if (!$add_user) {
                    $flag = false;
                    $msg .= 'Username or phone number existed. Please try another username.';
                } else {
                    $msg .= alert_success_msg('Registration successful');
                    // Upload avatar if account successfully created
                    if (isset($_FILES['avatar'])) {
                        $msg .= singleUpload($_FILES['avatar'], 'Images/UploadAvatars/', $_POST['username']);
                        if (isset($_SESSION['uploaded_name'])) {
                            (new users())->setAvatar($_POST['username'], $_SESSION['uploaded_name']);
                            unset($_SESSION['uploaded_name']);
                        }
                    }
                }
            }

            // Redirect to login page if account is successfully created
            if ($flag) {
                $_SESSION['empty_msg'] = $msg;
                redirect_to('http://auctionhouse.com?cont=user&action=login');
            }
        }
        $_SESSION['empty_msg'] = empty($msg) ? '' : alert_danger_msg($msg);
        $this->show('View/users/registration', 'empty');
    }

    function logout() {
        session_destroy();
        setcookie("remember", '', time() - 3600);
        setcookie("username", '', time() - 3600);
        setcookie("alias", '', time() - 3600);
        setcookie("avatar", '', time() - 3600);
        redirect_to(BASE_URL, alert_success_msg('Logout successful'));
    }

    function profile() {
        if (!is_login()) redirect_to(BASE_URL.'?cont=user&action=login');
        if (empty($_GET['username']))
            redirect_to('?cont=user&action=profile&username='.$_SESSION['username']);
        $this->show('View/users/profile');
    }

    function showAll() {
        $this->show('View/users/showAll');
    }

    function activeUser() {
        if (!is_login()) redirect_to(BASE_URL.'?cont=user&action=login');
        $user = $_GET['user'];
        $status = $_GET['status'];
        $status ? (new users())->activeUser($user) : (new users())->deactiveUser($user);
        $this->show('View/users/showAll');
    }

    function unsetAvt() {
        if (!is_login()) redirect_to(BASE_URL.'?cont=user&action=login');
        (new users())->unsetAvatar($_SESSION['username']);
        $_SESSION['avatar'] = 'no-avatar.png';
        redirect_to(BASE_URL.'?cont=user&action=profile', alert_success_msg('Avatar removed'));
    }

    function edit() {
        if (!is_login()) redirect_to(BASE_URL.'?cont=user&action=login');
        $msg = '';
        if (!empty($_POST)) {
            $flag = true;
            if (empty($_POST['phone'])) {
                $flag = false;
                $msg .= 'Phone number is required!';
            }
            if (empty($_POST['address'])) {
                $flag = false;
                $msg .= 'Address is required!';
            }
            $alias = empty($_POST['alias']) ? $_POST['username'] : $_POST['alias'];
            $aboutme = empty($_POST['about_me']) ? 'Hi, nice to meet you!' : $_POST['about_me'];

            if ($flag) {
                if ((new users())->updateInfo($_POST['username'], $alias, $_POST['phone'], $_POST['address'], $aboutme)) {
                    $msg .= alert_success_msg('Update successful');
                    // Upload avatar if info is update successfully
                    if (isset($_FILES['avatar'])) {
                        $msg .= singleUpload($_FILES['avatar'], 'Images/UploadAvatars/', $_POST['username']);
                        if (isset($_SESSION['uploaded_name'])) {
                            (new users())->setAvatar($_SESSION['username'], $_SESSION['uploaded_name']);
                            $_SESSION['avatar'] = $_SESSION['uploaded_name'];
                            unset($_SESSION['uploaded_name']);
                        }
                    }
                    redirect_to('?cont=user&action=profile', $msg);
                }
            }
        }
        $_SESSION['global_msg'] = empty($msg) ? '' : alert_danger_msg($msg);
        $this->show('View/users/edit');
    }

    function changepw() {
        if (!is_login()) redirect_to(BASE_URL.'?cont=user&action=login');
        $flag = true; $msg = '';
        if (!empty($_POST)) {
            if (empty($_POST['old_password']) or empty($_POST['new_password']) or empty($_POST['confirm_password'])) {
                $msg .= 'Password is required!';
                $flag = false;
            }
            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                $msg .= 'Passwords do not match!';
                $flag = false;
            }

            $user = (new users())->getUserByUsername($_SESSION['username']);
            if ($_POST['old_password'] !== $user->password) {
                $flag = false;
                $msg .= 'Current password is wrong!';
            }

            if ($flag) {
                if ((new users())->updatePassword($user->username, $_POST['new_password'])) {
                    redirect_to(BASE_URL . '?cont=user&action=profile', alert_success_msg('Password changed!'));
                    exit();
                } else {
                    echo alert_danger_msg('Something went wrong! Please try again or contact customer service!');
                }
            }
        }
        $_SESSION['global_msg'] = empty($msg) ? '' : alert_danger_msg($msg);
        $this->show('View/users/changepw');
    }

    function delete() {
        if (!is_login()) redirect_to(BASE_URL.'?cont=user&action=login');
        $user = $_GET['user'];
        if ($user == $_SESSION['username']) {
            redirect_to('?cont=user&action=showall', alert_danger_msg('You can\'t delete your own account!'));
        } else {
            if ((new users())->remove($user)) {
                redirect_to('?cont=user&action=showall', alert_success_msg('Successfully delete account with username '.$user));
            } else {
                redirect_to('?cont=user&action=showall', alert_danger_msg('Failed to delete account with username '.$user));
            }
        }
    }

    function resetpw() {
        if (!is_login()) redirect_to(BASE_URL.'?cont=user&action=login');
        $user = $_GET['user'];
        if ((new users())->updatePassword($user, '123')) {
            redirect_to('?cont=user&action=showall', alert_success_msg('Successfully reset password for account with username '.$user));
        } else {
            redirect_to('?cont=user&action=showall', alert_danger_msg('Failed to reset password for account with username '.$user));
        }
    }
}