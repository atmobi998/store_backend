<?php $this->assign('title', __d('atcmobile', 'Dashboards')) ?>
<?php
$this->Atcmobapp->adminScript('Atcmobapp/Dashboards.admin');
$this->Html->css('Atcmobapp/Dashboards.admin', ['block' => true]);

$this->Breadcrumbs  ->add(__d('atcmobile', 'Dashboard'), $this->getRequest()->getRequestTarget());

echo $this->Dashboards->dashboards();

$this->Js->buffer('Dashboard.init();');
?>
<div id="dashboard-url" style="display: none"><?= $this->Url->build(['action' => 'save']);?></div>
