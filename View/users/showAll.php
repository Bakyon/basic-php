<?php
defined('BASE_URL') OR exit('Access denied !!!');
$users = (new users())->getAllUsers();
?>

<div>
    <table class="user-table table fixed-table">
        <thead>
        <tr>
            <th class="user-table">ID</th>
            <th class="user-table">Username</th>
            <th class="user-table">Alias</th>
            <th class="user-table">Phone number</th>
            <th class="user-table">Address</th>
            <th class="user-table">Avatar</th>
            <th class="user-table">Status</th>
            <th class="user-table">Operation</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td class="user-table"><?= $user->uid ?></td>
                <td class="user-table"><?= $user->username ?></td>
                <td class="user-table"><?= $user->alias ?></td>
                <td class="user-table"><?= $user->phone ?></td>
                <td class="user-table"><?= $user->address ?></td>
                <td class="user-table"><img src="images/uploadavatars/<?= $user->avatar ?>" style="border-radius: 50%; margin: 5px; object-fit: cover; width: 45px; height: 45px;"></td>
                <td class="user-table">
                    <?= $user->status ?
                        '<div class="btn" style="align-items: center; background: green; border-radius: 50%; height: 20px; width: 20px; padding: 0; margin: 10px" ></div><a class="btn btn-danger" href="?cont=user&action=activeUser&user='.$user->username.'&status=0">Deactive</a>' :
                        '<div class="btn" style="align-items: center; background: red; border-radius: 50%; height: 20px; width: 20px; padding: 0; margin: 10px" ></div><a class="btn btn-success" href="?cont=user&action=activeUser&user='.$user->username.'&status=1">Active</a>'
                    ?>
                </td>
                <td>
                    <a class="btn btn-success" href="?cont=user&action=edit&username=<?= $user->username ?>">Edit</a>
                    <button class="btn btn-danger" onclick="confirmDelete('<?= $user->username ?>')">Delete</button>
                    <button class="btn btn-secondary" onclick="confirmResetPsw('<?= $user->username ?>')">Reset password</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

        <script>
            function confirmDelete(user) {
                if (confirm("Are you sure you want to delete?")) {
                    // Redirect to the delete action
                    window.location.href = "?cont=user&action=delete&user=" + user;
                }
            }
            function confirmResetPsw(user) {
                if (confirm("Are you sure you want to reset password?")) {
                    // Redirect to the reset password action
                    window.location.href = "?cont=user&action=resetpw&user=" + user;
                }
            }
        </script>
    </table>
</div>
