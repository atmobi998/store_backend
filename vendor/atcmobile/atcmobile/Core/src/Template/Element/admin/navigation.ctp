<nav class="navbar-dark bg-black">
    <?php

    use Cake\Cache\Cache;
    use Atcmobapp\Core\Nav;

    $cacheKey = 'adminnav_' . $this->Layout->getRoleId() . '_' . $this->getRequest()->getPath() . '_' . md5(serialize($this->getRequest()->getQuery()));
    echo Cache::remember($cacheKey, function () {
        return $this->Atcmobapp->adminMenus(Nav::items(), [
            'htmlAttributes' => [
                'id' => 'sidebar-menu',
            ],
        ]);
    }, 'atcmobile_menus');
    ?>
</nav>
