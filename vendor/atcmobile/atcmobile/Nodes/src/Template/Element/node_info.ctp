<div class="node-info text-muted">
<?php
    $type = $typesForLayout[$this->Nodes->field('type')];

if ($type->format_show_author || $type->format_show_date) {
    echo __d('atcmobile', 'Posted');
}
if ($type->format_show_author) {
    echo ' ' . __d('atcmobile', 'by') . ' ';
    if ($this->Nodes->field('user.website') != null) {
        $author = $this->Html->link($this->Nodes->field('user.name'), $this->Nodes->field('user.website'));
    } else {
        $author = $this->Nodes->field('user.name');
    }

    echo $this->Html->tag('span', $author, [
        'class' => 'author',
    ]);
}
if ($type->format_show_date) {
    $nodeDate = $this->Nodes->field('publish_start') ?: $this->Nodes->field('created');
    echo ' ' . __d('atcmobile', 'on') . ' ';
    echo $this->Html->tag('span', $this->Nodes->date($nodeDate), ['class' => 'date']);
}
?>
</div>
