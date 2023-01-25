<?php

namespace Atcmobapp\Nodes\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Nodes Component
 *
 * @category Component
 * @package  Atcmobapp.Nodes.Controller.Component
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class NodesComponent extends Component
{

    /**
     * Nodes for layout
     *
     * @var string
     * @access public
     */
    public $nodesForLayout = [];

    /**
     * beforeFilter
     *
     * @param Event $event instance of controller
     */
    public function beforeFilter(Event $event)
    {
        $this->controller = $event->getSubject();
        if (isset($this->controller->Nodes)) {
            $this->Nodes = $this->controller->Nodes;
        } else {
            $this->Nodes = TableRegistry::get('Atcmobapp/Nodes.Nodes');
        }
    }

    /**
     * Startup
     *
     * @param Controller $event instance of controller
     * @return void
     */
    public function startup(Event $event)
    {
        $controller = $event->getSubject();
        if (($controller->request->getParam('prefix') !== 'admin') && !$controller->request->getParam('requested')) {
            $this->nodes();
        }
    }

    /**
     * Nodes
     *
     * Nodes will be available in this variable in views: $nodesForLayout
     *
     * @return void
     */
    public function nodes()
    {
        $roleId = $this->controller->Atcmobapp->roleId();

        $nodes = $this->controller->BlocksHook->blocksData['nodes'];
        $_nodeOptions = [
            'find' => 'all',
            'findOptions' => [],
            'conditions' => [],
            'order' => 'Nodes.publish_start DESC',
            'limit' => 5,
        ];

        foreach ($nodes as $alias => $options) {
            $options = Hash::merge($_nodeOptions, $options);
            $options['limit'] = str_replace('"', '', $options['limit']);
            $node = $this->Nodes->find($options['find'], $options['findOptions'])
                ->where($options['conditions'])
                ->order($options['order'])
                ->limit($options['limit'])
                ->applyOptions([
                    'prefix' => 'nodes_' . $alias,
                    'config' => 'atcmobile_nodes',
                ])->find('byAccess', [
                    'roleId' => $roleId
                ])->find('published');

            $this->nodesForLayout[$alias] = $node;
        }
    }

    /**
     * beforeRender
     *
     * @param object $event instance of controller
     * @return void
     */
    public function beforeRender(Event $event)
    {
        $event->getSubject()->set('nodesForLayout', $this->nodesForLayout);
    }
}
