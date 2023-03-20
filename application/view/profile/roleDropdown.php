<?php if (Session::get("user_account_type") == 7) { ?>
    <form action="<?= Config::get("URL");?>/admin/actionAccountSettings" method="post">
        <td>
            <select name="roles" id="roles">
                <?php foreach (UserRoleModel::getAllroles() as $r) { ?>
                    <option value=<?= $r->id ?> <?php if ($user->role_name == $r->role_name) {
                                                    echo "selected";
                                                } else {
                                                    echo "";
                                                } ?>>
                        <?= ucwords($r->role_name); ?>
                    </option>
                <?php } ?>
            </select>
        </td>
        <td style="display: none;"><input readonly type="number" name="user_id" 
            value="<?=$user->user_id?>"></td>
        <td><input type="submit" name="submit" value="Submit"></td>
    </form>
<?php } else { ?>
    <?= ucwords($user->user_account_type) ?>
<?php } ?>