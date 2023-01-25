<footer class="navbar-dark">
    <div class="navbar-inner">

        <div class="footer-content">
            <?php

            use Cake\Core\Configure;

            $link = $this->Html->link(
                __d('atcmobile', 'Atcmobapp %s', (string)Configure::read('Atcmobapp.version')),
                'http://metroeconomics.com'
            );
            ?>
            <?= __d('atcmobile', 'Powered by %s', $link) ?>
        </div>

    </div>
</footer>
