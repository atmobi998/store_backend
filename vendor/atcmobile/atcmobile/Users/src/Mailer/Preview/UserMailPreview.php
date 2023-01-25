<?php

namespace Atcmobapp\Users\Mailer\Preview;

use DebugKit\Mailer\MailPreview;

class UserMailPreview extends MailPreview
{

    public function resetPassword()
    {
        $this->loadModel('Atcmobapp/Users.Users');
        $user = $this->Users->get(1);
        if (empty($user->email)) {
            $user->email = 'test@example.org';
            $user->clean();
        }

        return $this->getMailer('Atcmobapp/Users.User')
            ->resetPassword($user);
    }

    public function registrationActivation()
    {
        $this->loadModel('Atcmobapp/Users.Users');
        $user = $this->Users->get(1);
        if (empty($user->email)) {
            $user->email = 'test@example.org';
            $user->clean();
        }

        return $this->getMailer('Atcmobapp/Users.User')
            ->registrationActivation($user);
    }
}
