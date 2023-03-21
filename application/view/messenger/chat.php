<div class="container">
    <h1>Chat with <?= $this->user->user_name ?></h1>
    <div class="box">
        <section class="discussion">
            <?php foreach ($this->messages as $msg) { ?>
                <div class=<?php if ($msg->from == Session::get('user_id')) {
                                echo "'bubble sender first'";
                            } else {
                                echo "'bubble recipient first'";
                            } ?>>
                    <?= $msg->content ?>
                </div>
            <?php } ?>
        </section>
        <br><br>
        <hr>
        <form action="<?= Config::get("URL"); ?>/messenger/sendMessage" method="post">
            <input autofocus style="width:70%;" type="text" placeholder="Type your message..." name="content" />
            <input style="display:none;"type="text" value=<?=$this->user->user_id?> name="destination_id" />
            <input type="submit" value="Send" />
        </form>
    </div>
</div>