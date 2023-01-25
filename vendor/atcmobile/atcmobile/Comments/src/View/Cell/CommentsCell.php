<?php

namespace Atcmobapp\Comments\View\Cell;

use Cake\ORM\Query;
use Cake\View\Cell;
use Atcmobapp\Comments\Model\Entity\Comment;
use Atcmobapp\Nodes\Model\Entity\Node;
use Atcmobapp\Taxonomy\Model\Entity\Type;

class CommentsCell extends Cell
{
    public function node($nodeId)
    {
        $this->loadModel('Atcmobapp/Nodes.Nodes');

        $entity = $this->Nodes->get($nodeId, [
            'contain' => [
                'Comments' => function (Query $query) {
                    $query->find('threaded');

                    return $query;
                }
            ]
        ]);

        $this->set('entity', $entity);
    }

    public function commentFormNode(Node $node, Type $type, Comment $comment = null, Comment $parentComment = null)
    {
        $this->loadModel('Atcmobapp/Comments.Comments');

        $formUrl = [
            'plugin' => 'Atcmobapp/Comments',
            'controller' => 'Comments',
            'action' => 'add',
            '?' => [
                'model' => 'Atcmobapp/Nodes.Nodes',
                'foreign_key' => $node->id,
                'parent_id' => $parentComment ? $parentComment->id : null,
            ],
        ];

        $this->set('title', $node->title);
        $this->set('url', $node->url);
        $this->set('formUrl', $formUrl);
        $this->set('comment', $comment ?: $this->Comments->newEntity());
        $this->set('parentComment', $parentComment);
        $this->set('captcha', $type->comment_captcha);
        $this->set('loggedInUser', $this->request->getSession()->read('Auth.User'));
    }
}
