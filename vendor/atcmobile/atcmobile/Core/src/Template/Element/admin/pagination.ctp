<div class="pagination-wrapper">
    <p>
        <?php
        echo $this->Paginator->counter([
            'format' => __d('atcmobile',
                'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total'),
        ]);
        ?>
    </p>
    <ul class="pagination justify-content-center pagination-sm">
        <?= $this->Paginator->first('< ' . __d('atcmobile', 'first')) ?>
        <?= $this->Paginator->prev('< ' . __d('atcmobile', 'prev')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__d('atcmobile', 'next') . ' >') ?>
        <?= $this->Paginator->last(__d('atcmobile', 'last') . ' >') ?>
    </ul>
</div>
