<?php

$this->loadHelper('Atcmobapp/Core.Atcmobapp');
if ($this->getRequest()->getQuery('urls')) {
    foreach ($permissions as $acoId => &$aco) {
        $aco[key($aco)]['url'] = array(
            'up' => $this->Html->link('',
                array('controller' => 'Actions', 'action' => 'moveup', $acoId, 'up'),
                [
                    'icon' => $this->Theme->getIcon('move-up'),
                    'escapeTitle' => false,
                    'tooltip' => __d('atcmobile', 'Move up')
                ]
            ),
            'down' => $this->Html->link('',
                array('controller' => 'Actions', 'action' => 'movedown', $acoId, 'down'),
                [
                    'icon' => $this->Theme->getIcon('move-down'),
                    'escapeTitle' => false,
                    'tooltip' => __d('atcmobile', 'Move down')
                ]
            ),
            'edit' => $this->Html->link('',
                array('controller' => 'Actions', 'action' => 'edit', $acoId),
                [
                    'icon' => $this->Theme->getIcon('update'),
                    'escapeTitle' => false,
                    'tooltip' => __d('atcmobile', 'Edit this item')
                ]
            ),
            'del' => $this->Atcmobapp->adminRowAction('',
                array('controller' => 'Actions', 'action' => 'delete', $acoId),
                [
                    'icon' => $this->Theme->getIcon('delete'),
                    'escapeTitle' => false,
                    'tooltip' => __d('atcmobile', 'Remove this item')
                ],
                __d('atcmobile', 'Are you sure?')
            ),
        );
    }
}
echo json_encode(compact('aros', 'permissions', 'level'));
