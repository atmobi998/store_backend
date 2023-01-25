<?php

use Cake\Routing\Router;

?>
<p>
<?= __d('atcmobile', 'Hello %s', $user->name); ?>,
</p>

<p>
<?= __d('atcmobile', 'Please visit this link to activate your account: %s', Router::url(['prefix' => false, 'plugin' => 'Atcmobapp/Users', 'controller' => 'Users', 'action' => 'activate', $user->username, $user->activation_key], true));
?>
</p>
