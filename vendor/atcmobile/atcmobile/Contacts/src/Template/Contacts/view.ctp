<div id="contact-<?= $contact->id ?>" class="">
    <h2><?= $contact->title ?></h2>
    <div class="contact-body">
        <?= $contact->body ?>
    </div>

    <?php if ($contact->message_status) : ?>
        <div class="contact-form">
            <?php
            echo $this->Form->create($message);
            echo $this->Form->input('name', ['label' => __d('atcmobile', 'Your name')]);
            echo $this->Form->input('email', ['label' => __d('atcmobile', 'Your email')]);
            echo $this->Form->input('title', ['label' => __d('atcmobile', 'Subject')]);
            echo $this->Form->input('body', ['label' => __d('atcmobile', 'Message')]);
            if ($contact->message_captcha) :
                echo $this->Recaptcha->display();
            endif;
            echo $this->Form->submit();
            echo $this->Form->end();
            ?>
        </div>
    <?php endif ?>
</div>
