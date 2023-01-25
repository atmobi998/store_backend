<?php

namespace Atcmobapp\Nodes\Event;

use Cake\Cache\Cache;
use Cake\Core\Plugin;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Core\Nav;

/**
 * Nodes Event Handler
 *
 * @category Event
 * @package  Atcmobapp.Nodes.Event
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class NodesEventHandler implements EventListenerInterface
{

    /**
     * implementedEvents
     */
    public function implementedEvents()
    {
        return [
            'Atcmobapp.bootstrapComplete' => [
                'callable' => 'onBootstrapComplete',
            ],
            'Atcmobapp.setupAdminData' => [
                'callable' => 'onSetupAdminData',
            ],
            'Controller.Links.setupLinkChooser' => [
                'callable' => 'onSetupLinkChooser',
            ],
            'Controller.Nodes.afterPublish' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterUnpublish' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterPromote' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterUnpromote' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterDelete' => [
                'callable' => 'onAfterBulkProcess',
            ],
        ];
    }

    /**
     * Setup admin data
     */
    public function onSetupAdminData($event)
    {
        $View = $event->getSubject();

        if (!isset($View->viewVars['typesForAdminLayout'])) {
            return;
        }

        $types = $View->viewVars['typesForAdminLayout'];
        foreach ($types as $type) {
            if (!empty($type->plugin)) {
                continue;
            }
            Nav::add('sidebar', 'content.children.create.children.' . $type->alias, [
                'title' => $type->title,
                'url' => [
                    'prefix' => 'admin',
                    'plugin' => 'Atcmobapp/Nodes',
                    'controller' => 'Nodes',
                    'action' => 'add',
                    $type->alias,
                ],
            ]);
        };
    }

    /**
     * onBootstrapComplete
     */
    public function onBootstrapComplete($event)
    {
        if (Plugin::isLoaded('Atcmobapp/Comments')) {
            Atcmobapp::hookBehavior('Atcmobapp/Nodes.Nodes', 'Atcmobapp/Comments.Commentable');
            Atcmobapp::hookTableProperty('Atcmobapp/Comments.Comments', 'belongsTo', [
                'Nodes' => [
                    'className' => 'Atcmobapp/Nodes.Nodes',
                    'foreignKey' => 'foreign_key',
                    'counterCache' => true,
                    'counterScope' => [
                        'Comments.model' => 'Atcmobapp/Nodes.Nodes',
                        'Comments.status' => true,
                    ],
                ],
            ]);
        }
        if (Plugin::isLoaded('Atcmobapp/Taxonomy')) {
            Atcmobapp::hookBehavior('Atcmobapp/Nodes.Nodes', 'Atcmobapp/Taxonomy.Taxonomizable');
        }
        if (Plugin::isLoaded('Atcmobapp/Meta')) {
            Atcmobapp::hookBehavior('Atcmobapp/Nodes.Nodes', 'Atcmobapp/Meta.Meta');
        }
    }

    /**
     * Setup Link chooser values
     *
     * @return void
     */
    public function onSetupLinkChooser($event)
    {
        $typesTable = TableRegistry::get('Atcmobapp/Taxonomy.Types');
        $types = $typesTable->find('all', [
            'fields' => ['alias', 'title', 'description'],
        ]);
        $linkChoosers = [];
        foreach ($types as $type) {
            $linkChoosers[$type->title] = [
                'title' => h($type->title),
                'description' => $type->description,
                'url' => [
                    'prefix' => 'admin',
                    'plugin' => 'Atcmobapp/Nodes',
                    'controller' => 'Nodes',
                    'action' => 'index',
                    '?' => [
                        'type' => $type->alias,
                        'chooser' => 1,
                    ],
                ],
            ];
        }
        Atcmobapp::mergeConfig('Atcmobapp.linkChoosers', $linkChoosers);
    }

    /**
     * Clear Nodes related cache after bulk operation
     *
     * @param CakeEvent $event
     * @return void
     */
    public function onAfterBulkProcess($event)
    {
        Cache::clearGroup('nodes', 'nodes');
        Cache::clearGroup('nodes', 'nodes_view');
        Cache::clearGroup('nodes', 'nodes_promoted');
        Cache::clearGroup('nodes', 'nodes_term');
        Cache::clearGroup('nodes', 'nodes_index');
    }
}
