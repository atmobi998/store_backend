<?php

namespace Atcmobapp\Core\Controller\Admin;

use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;

class LinkChooserController extends AppController
{

    public function linkChooser()
    {
        Atcmobapp::dispatchEvent('Controller.Links.setupLinkChooser', $this);
        $linkChoosers = Configure::read('Atcmobapp.linkChoosers');
        $this->set(compact('linkChoosers'));
    }
}
