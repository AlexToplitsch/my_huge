<div class="container">
    <h1>Chat with <?= $this->user->user_name ?></h1>
    <div class="box">
        <section class="discussion">
            <?php for ($i = 0; $i < count($this->messages); $i++) { ?>
                <div class=<?php if ($this->messages[$i]->from == Session::get('user_id')) {
                                if ($i == 0 || $this->messages[$i]->from != $this->messages[$i - 1]->from) {
                                    echo "'bubble sender first'";
                                } else if (($i == count($this->messages) - 1) || $this->messages[$i]->from != $this->messages[$i + 1]->from) {
                                    echo "'bubble sender last'";
                                } else {
                                    echo "'bubble sender middle";
                                }
                            } else {
                                if ($i == 0 || $this->messages[$i]->from != $this->messages[$i - 1]->from) {
                                    echo "'bubble recipient first'";
                                } else if (($i == count($this->messages) - 1) || $this->messages[$i]->from != $this->messages[$i + 1]->from) {
                                    echo "'bubble recipient last'";
                                } else {
                                    echo "'bubble recipient middle";
                                }
                            } ?>>
                    <?= $this->messages[$i]->content ?>
                </div>
            <?php } ?>
        </section>
        <br><br>
        <hr>
        <form action="<?= Config::get("URL"); ?>/messenger/sendMessage" method="post">
            <input autofocus style="width:70%;" type="text" placeholder="Type your message..." name="content" />
            <input style="display:none;" type="text" value=<?= $this->user->user_id ?> name="destination_id" />
            <input type="submit" value="Send" />
        </form>
    </div>
</div>