<?php
$this->assign('title', __d('atcmobile', 'Successful'));

use Atcmobapp\Core\Router; ?>
<p class="success">
    <?= __d(
    'atcmobile',
    'The user %s has been created with administrative rights.',
    sprintf('<strong>%s</strong>', $user['username'])
);
?>
</p>

<p>
    <?= __d(
    'atcmobile',
    'Admin panel: %s',
    $this->Html->link(Router::url('/admin', true), Router::url('/admin', true))
) ?>
</p>

<p>
    <?php
    echo __d(
        'atcmobile',
        'You can start with %s or jump in and %s.',
        $this->Html->link(__d('atcmobile', 'configuring your site'), [
            'plugin' => 'Atcmobapp/Settings',
            'prefix' => 'admin',
            'controller' => 'Settings',
            'action' => 'prefix',
            'Site',
        ]),
        $this->Html->link(__d('atcmobile', 'create a blog post'), [
            'plugin' => 'Atcmobapp/Nodes',
            'prefix' => 'admin',
            'controller' => 'Nodes',
            'action' => 'add',
            'blog',
        ])
    );
    ?>
</p>

<blockquote>
    <h3><?= __d('atcmobile', 'Resources') ?></h3>
    <ul class="bullet">
        <li><?= $this->Html->link('http://metroeconomics.com') ?></li>
        <li><?= $this->Html->link('http://wiki.metroeconomics.com/') ?></li>
        <li><?= $this->Html->link('http://github.com/atcmobile/atcmobile') ?></li>
        <li><?= $this->Html->link(
            'Atcmobapp Google Group',
            'https://groups.google.com/forum/#!forum/atcmobile'
        ) ?></li>
    </ul>
</blockquote>
