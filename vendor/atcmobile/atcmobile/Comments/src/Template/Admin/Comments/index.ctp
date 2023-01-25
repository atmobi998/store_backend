<?php

$this->Atcmobapp->adminScript('Atcmobapp/Comments.admin');

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('atcmobile', 'Content'), ['plugin' => 'Atcmobapp/Nodes', 'controller' => 'Nodes', 'action' => 'index']);

if (isset($criteria['Comment.status'])) {
    $this->Breadcrumbs->add(__d('atcmobile', 'Comments'), ['action' => 'index']);
    if ($criteria['Comment.status'] == '1') {
        $this->Breadcrumbs->add(__d('atcmobile', 'Published'), $this->getRequest()->getRequestTarget());
        $this->assign('title', __d('atcmobile', 'Comments: Published'));
    } else {
        $this->Breadcrumbs->add(__d('atcmobile', 'Awaiting approval'), $this->getRequest()->getRequestTarget());
        $this->assign('title', __d('atcmobile', 'Comments: Published'));
    }
} else {
    $this->Breadcrumbs->add(__d('atcmobile', 'Comments'), $this->getRequest()->getRequestTarget());
}

$this->append('table-footer', $this->element('Atcmobapp/Core.admin/modal', [
    'id' => 'comment-modal',
    'class' => 'hide',
    ]));

$this->append('action-buttons');
echo $this->Atcmobapp->adminAction(
    __d('atcmobile', 'Published'),
    ['action' => 'index', '?' => ['status' => '1']],
    ['class' => 'btn btn-outline-secondary btn-sm']
);
echo $this->Atcmobapp->adminAction(
    __d('atcmobile', 'Awaiting approval'),
    ['action' => 'index', '?' => ['status' => '0']],
    ['class' => 'btn btn-outline-secondary btn-sm']
);
$this->end();
