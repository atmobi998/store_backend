<?php

use Cake\Core\Configure;
use Atcmobapp\Install\InstallManager;

$this->assign('title', __d('atcmobile', 'Welcome'));
$check = true;

// tmp is writable
if (is_writable(TMP)) {
    echo '<p><span class="badge badge-success">' . __d('atcmobile', 'Your tmp directory is writable.') . '</span></p>';
} else {
    $check = false;
    echo '<p><span class="badge badge-danger">' . __d('atcmobile', 'Your tmp directory is NOT writable.') . '</span></p>';
}

// config is writable
if (is_writable(ROOT . DS . 'config')) {
    echo '<p><span class="badge badge-success">' . __d('atcmobile', 'Your config directory is writable.') . '</span></p>';
} else {
    $check = false;
    echo '<p><span class="badge badge-danger">' . __d('atcmobile', 'Your config directory is NOT writable.') . '</danger></p>';
}

$versions = InstallManager::versionCheck();
if ($versions['php']) {
    echo '<p><span class="badge badge-success">' .
        sprintf(__d('atcmobile', 'PHP version %s >= %s'), phpversion(), InstallManager::PHP_VERSION) .
        '</span></p>';
} else {
    $check = false;
    echo '<p><span class="badge badge-danger">' .
        sprintf(__d('atcmobile', 'PHP version %s < %s'), phpversion(), InstallManager::PHP_VERSION) .
        '</span></p>';
}

// cakephp version
if ($versions['cake']) {
    echo '<p><span class="badge badge-success">' .
        __d(
        'atcmobile',
        'CakePhp version %s >= %s',
        Configure::version(),
        InstallManager::CAKE_VERSION
    ) .
        '</span></p>';
} else {
    $check = false;
    echo '<p><span class="badge badge-danger">' .
        __d(
        'atcmobile',
        'CakePHP version %s < %s',
        Configure::version(),
        InstallManager::CAKE_VERSION
    ) .
        '</span></p>';
}

if (count($drivers) === 0) {
    $check = false;
    echo '<p><span class="badge badge-danger">' .
        __d('atcmobile', 'No database driver found') .
        '</span></p>';
} else {
    echo '<p><span class="badge badge-success">' .
        __d(
        'atcmobile',
        'Available Database drivers: %s',
        join(', ', array_values($drivers))
        ) .
        '</span></p>';
}

if ($check) {
    $out = $this->Html->link(__d('atcmobile', 'Start installation'), [
        'action' => 'database',
    ], [
        'button' => 'success',
        'tooltip' => [
            'data-title' => __d('atcmobile', 'Click here to begin installation'),
            'data-placement' => 'left',
        ],
    ]);
} else {
    $out = '<p>' . __d('atcmobile', 'Installation cannot continue as minimum requirements are not met.') . '</p>';
}
$this->assign('buttons', $this->Html->div('form-actions', $out));
