<?php

namespace Atcmobapp\Comments\Mailer;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Mailer\Mailer;
use Atcmobapp\Comments\Model\Entity\Comment;

class CommentMailer extends Mailer
{
    public function implementedEvents()
    {
        return [
            'Model.afterSave' => 'onCommentPosted'
        ];
    }

    public function onCommentPosted(Event $event, Comment $comment)
    {
        if (!$comment->isNew()) {
            return;
        }
        if (!Configure::read('Comment.email_notification')) {
            return;
        }

        $this->send('notifyAboutComment', [$comment]);
    }

    public function notifyAboutComment(Comment $comment)
    {
        $this->to(Configure::read('Site.email'))
            ->subject('[' . Configure::read('Site.title') . '] ' .
                __d('atcmobile', 'New comment posted'))
            ->viewVars([
                'comment' => $comment
            ])
            ->template('Atcmobapp/Comments.comment');
    }
}
