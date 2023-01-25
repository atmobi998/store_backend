<?php

namespace Atcmobapp\Core\View\Cell\Admin;

use Cake\Core\Configure;
use Cake\View\Cell;
use Atcmobapp\Core\Atcmobapp;

/**
 * Class LinkChooserCell
 */
class LinkChooserCell extends Cell
{
    public function display($target)
    {
        Atcmobapp::dispatchEvent('Controller.Links.setupLinkChooser', $this);
        $linkChoosers = Configure::read('Atcmobapp.linkChoosers');
        $this->set(compact('target', 'linkChoosers'));
    }
}
