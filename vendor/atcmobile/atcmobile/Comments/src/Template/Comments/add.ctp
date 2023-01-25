<div class="form">
    <?=
        $this->cell('Atcmobapp/Comments.Comments::commentFormNode', [
            'entity' => $entity,
            'type' => $typesForLayout[$entity->type],
            'comment' => $comment,
            'parentComment' => isset($parentComment) ? $parentComment : null,
        ]);
    ?>
</div>
