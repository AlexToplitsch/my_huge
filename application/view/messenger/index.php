<div class="container">
    <h1>Messenger</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
        <div>
            <table id="userTable">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Username</th>
                        <th>Unread messages</th>
                        <th>User's email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->users as $user) { ?>
                        <?php if ($user->user_id == Session::get('user_id')) {
                            continue;
                        } ?>
                        <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                            <td class="avatar">
                                <?php if (isset($user->user_avatar_link)) { ?>
                                    <img src="<?= $user->user_avatar_link; ?>" />
                                <?php } ?>
                            </td>
                            <td>
                                <a href="<?= Config::get('URL') . 'messenger/showChat/' . $user->user_id; ?>">
                                    <?= $user->user_name; ?>
                                </a>
                            </td>
                            <td>
                                <div class="unread_messages" style="color: red;">
                                    <?php if (array_key_exists($user->user_id, $this->unread_messages)) {
                                        echo $this->unread_messages[$user->user_id];
                                    } else {
                                        echo 0;
                                    }
                                    ?>
                                </div>
                            </td>
                            <td><?= $user->user_email; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>