<?php

namespace Atcmobapp\Core\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Atcmobapp\Core\Atcmobapp;

/**
 * BulkProcess Component
 *
 * @category Component
 * @package  Atcmobapp.Atcmobapp.Controller.Component
 * @version  1.0
 * @author   ATC Mobile Team
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class BulkProcessComponent extends Component
{

    public $components = [
        'Flash'
    ];

    /**
     * controller
     *
     * @var Controller
     */
    protected $_controller = null;

    /**
     * beforeFilter
     */
    public function beforeFilter(Event $event)
    {
        $this->_controller = $event->getSubject();
        if ($this->_controller->request->getParam('action') == 'process') {
            $this->_controller->Security->setConfig('validatePost', false);
        }
    }

    /**
     * Get variables used for bulk processing
     *
     * @param string $model Model alias
     * @param string $primaryKey Primary key
     * @return array Array with 2 elements. First element is action name, second is
     *               array of model IDs
     */
    public function getRequestVars($model, $primaryKey = 'id')
    {
        $data = $this->_controller->request->getData($model);
        $action = $this->_controller->request->getData('action');
        $ids = [];
        foreach ($data as $id => $value) {
            if (is_array($value) && !empty($value[$primaryKey])) {
                $ids[] = $id;
            }
        }

        return [$action, $ids];
    }

    /**
     * Convenience method to check for selection count and redirect request
     *
     * @param bool $condition True will redirect request to $options['redirect']
     * @param array $options Options array as passed to process()
     * @return bool True if selection is valid
     */
    protected function _validateSelection($condition, $options, $messageName)
    {
        $messageMap = $options['messageMap'];
        $message = $messageMap[$messageName];

        if ($condition === true) {
            $this->Flash->error($message);
            $this->_controller->redirect($options['redirect']);
        }

        return !$condition;
    }

    /**
     * Process Bulk Request
     *
     * Operates on $Model object and assumes that bulk processing will be delegated
     * to BulkProcessBehavior
     *
     * Options:
     * - redirect URL to redirect in array format
     * - messageMap Map of error name and its message
     *
     * @param Table $table Table instance
     * @param string $action Action name to process
     * @param array $ids Array of IDs
     * @param array $options Options
     * @return void
     */
    public function process(Table $table, $action, $ids, $options = [])
    {
        $Controller = $this->_controller;
        $emptyMessage = __d('atcmobile', 'No item selected');
        $noMultipleMessage = __d('atcmobile', 'Please choose only one item for this operation');
        $options = Hash::merge([
            'multiple' => [],
            'redirect' => [
                'action' => 'index',
            ],
            'messageMap' => [
                'empty' => $emptyMessage,
                'noMultiple' => $noMultipleMessage,
            ],
        ], $options);
        $messageMap = $options['messageMap'];
        $itemCount = count($ids);

        $noItems = $itemCount === 0 || $action == null;
        $valid = $this->_validateSelection($noItems, $options, 'empty');
        if (!$valid) {
            return;
        }

        $tooMany = isset($options['multiple'][$action]) && $options['multiple'][$action] === false && $itemCount > 1;
        $valid = $this->_validateSelection($tooMany, $options, 'noMultiple');
        if (!$valid) {
            return false;
        }

        if (!$table->hasBehavior('BulkProcess')) {
            $table->addBehavior('Atcmobapp/Core.BulkProcess');
        }

        try {
            $processed = $table->processAction($action, $ids);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if (isset($processed)) {
            $eventName = 'Controller.' . $Controller->getName() . '.after' . ucfirst($action);
            if (!empty($messageMap[$action])) {
                $message = $messageMap[$action];
            } else {
                $message = __d('atcmobile', '%s processed', Inflector::humanize($table->alias()));
            }
            $flashMethod = 'success';
            Atcmobapp::dispatchEvent($eventName, $Controller, compact($ids));
        } else {
            $message = $message ?: __d('atcmobile', 'An error occured');
            $flashMethod = 'error';
        }
        $this->Flash->{$flashMethod}($message);

        return $Controller->redirect($options['redirect']);
    }
}
