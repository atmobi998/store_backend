<?php

namespace Atcmobapp\Taxonomy\Event;

use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Core\Nav;

/**
 * Taxonomy Event Handler
 *
 * @category Event
 * @package  Atcmobapp.Taxonomy.Event
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class TaxonomiesEventHandler implements EventListenerInterface
{

    /**
     * implementedEvents
     */
    public function implementedEvents()
    {
        return [
            'Atcmobapp.setupAdminData' => [
                'callable' => 'onSetupAdminData',
            ],
            'Controller.Links.setupLinkChooser' => [
                'callable' => 'onSetupLinkChooser',
            ],
        ];
    }

    /**
     * Setup admin data
     */
    public function onSetupAdminData($event)
    {
        $View = $event->getSubject();

        if (empty($View->viewVars['vocabulariesForAdminLayout'])) {
            $vocabularies = [];
        } else {
            $vocabularies = $View->viewVars['vocabulariesForAdminLayout'];
        }
        foreach ($vocabularies as $v) {
            $weight = 9999 + $v->weight;
            Nav::add('sidebar', 'content.children.taxonomy.children.' . $v->alias, [
                'title' => $v->title,
                'url' => [
                    'prefix' => 'admin',
                    'plugin' => 'Atcmobapp/Taxonomy',
                    'controller' => 'Taxonomies',
                    'action' => 'index',
                    '?' => [
                        'vocabulary_id' => $v->id,
                    ],
                ],
                'weight' => $weight,
            ]);
        };
    }

    /**
     * Setup Link chooser values
     *
     * @return void
     */
    public function onSetupLinkChooser($event)
    {
        $vocabulariesTable = TableRegistry::get('Atcmobapp/Taxonomy.Vocabularies');
        $vocabularies = $vocabulariesTable->find('all')->contain([
            'Types'
        ]);

        $linkChoosers = [];
        foreach ($vocabularies as $vocabulary) {
            foreach ($vocabulary->types as $type) {
                $title = h($type->title . ' ' . $vocabulary->title);
                $linkChoosers[$title] = [
                    'description' => h($vocabulary->description),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Atcmobapp/Taxonomy',
                        'controller' => 'Taxonomies',
                        'action' => 'index',
                        $vocabulary->id,
                        '?' => [
                            'type' => $type->alias,
                            'chooser' => 1,
                        ],
                    ],
                ];
            }
        }
        Atcmobapp::mergeConfig('Atcmobapp.linkChoosers', $linkChoosers);
    }
}