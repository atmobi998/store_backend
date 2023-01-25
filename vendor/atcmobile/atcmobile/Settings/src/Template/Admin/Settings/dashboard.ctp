<h2 class="d-md-none"><?= $title_for_layout ?></h2>
<?php
$this->Breadcrumbs
    ->add(__d('atcmobile', 'Dashboard'), $this->getRequest()->getRequestTarget());
?>
