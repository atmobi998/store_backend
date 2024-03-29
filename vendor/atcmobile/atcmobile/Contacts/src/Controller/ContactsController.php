<?php

namespace Atcmobapp\Contacts\Controller;

use Cake\Core\Configure;
use Cake\Mailer\Email;
use Atcmobapp\Contacts\Model\Entity\Message;
use Atcmobapp\Core\Atcmobapp;

/**
 * Class ContactsController
 */
class ContactsController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->_loadAtcmobappComponents([
            'Akismet',
            'Recaptcha' => [
                'actions' => ['view']
            ]
        ]);
    }

    /**
     * View
     *
     * @param string $alias
     * @return \Cake\Http\Response|void
     * @throws NotFoundException
     */
    public function view($alias = null)
    {
        if (!$alias) {
            $alias = 'contact';
        }
        $contact = $this->Contacts->find()
            ->where([
                'alias' => $alias,
                'status' => 1,
            ])
            ->firstOrFail();

        $continue = true;
        if (!$contact->message_status) {
            $continue = false;
        }
        $message = $this->Contacts->Messages->newEntity();
        if ($this->getRequest()->is('post') && $continue === true) {
            $message = $this->Contacts->Messages->patchEntity($message, $this->getRequest()->data);
            $message->contact_id = $contact->id;
            Atcmobapp::dispatchEvent('Controller.Contacts.beforeMessage', $this);

            $continue = $this->_spamProtection($continue, $contact, $message);
            $continue = $this->_captcha($continue, $contact, $message);
            $continue = $this->_validation($continue, $contact, $message);
            $continue = $this->_sendEmail($continue, $contact, $message);
            $this->set(compact('continue'));

            if ($continue === true) {
                $this->Contacts->Messages->save($message);
                Atcmobapp::dispatchEvent('Controller.Contacts.afterMessage', $this);
                $this->Flash->success(__d('atcmobile', 'Your message has been received...'));

                return $this->redirect($this->referer());
            }
        }

        $this->Atcmobapp->viewFallback([
            'view_' . $contact->id,
            'view_' . $contact->alias,
        ]);
        $this->set('contact', $contact);
        $this->set('message', $message);
    }

    /**
     * Validation
     *
     * @param bool $continue
     * @param array $contact
     * @return bool
     * @access protected
     */
    protected function _validation($continue, $contact, Message $message)
    {
        if ($message->errors() || $continue === false) {
            return false;
        }

        if ($contact->message_archive && !$this->Contacts->Messages->save($message)) {
            return false;
        }

        return $continue;
    }

    /**
     * Spam protection
     *
     * @param bool $continue
     * @param array $contact
     * @return bool
     * @access protected
     */
    protected function _spamProtection($continue, $contact, Message $message)
    {
        if (!$contact->message_spam_protection || $continue === false) {
            return $continue;
        }
        $this->Akismet->setCommentAuthor($message->name);
        $this->Akismet->setCommentAuthorEmail($message->email);
        $this->Akismet->setCommentContent($message->body);
        if ($this->Akismet->isCommentSpam()) {
            $this->Flash->error(__d('atcmobile', 'Sorry, the message appears to be spam.'));

            return false;
        }

        return true;
    }

    /**
     * Captcha
     *
     * @param bool $continue
     * @param array $contact
     * @return bool
     * @access protected
     */
    protected function _captcha($continue, $contact, Message $message)
    {
        if (!$contact->message_captcha || $continue === false) {
            return $continue;
        }

        if (!$this->Recaptcha->verify()) {
            $this->Flash->error(__d('atcmobile', 'Invalid captcha entry'));

            return false;
        }

        return true;
    }

    /**
     * Send Email
     *
     * @param bool $continue
     * @param array $contact
     * @return bool
     * @access protected
     */
    protected function _sendEmail($continue, $contact, Message $message)
    {
        if (!$contact->message_notify || $continue === false) {
            return $continue;
        }

        $email = new Email();
        $siteTitle = Configure::read('Site.title');
        try {
            $email->from($message->email)
                ->to($contact->email)
                ->subject(__d('atcmobile', '[%s] %s', $siteTitle, $contact->title))
                ->template('Atcmobapp/Contacts.contact')
                ->viewVars([
                    'contact' => $contact,
                    'message' => $message,
                ]);
            if ($this->viewBuilder()->getTheme()) {
                $email->theme($this->viewBuilder()->getTheme());
            }
            if (!$email->send()) {
                $continue = false;
            }
        } catch (SocketException $e) {
            $this->log(sprintf('Error sending contact notification: %s', $e->getMessage()));
            $continue = false;
        }

        return $continue;
    }
}
