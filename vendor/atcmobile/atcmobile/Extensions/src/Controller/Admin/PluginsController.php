<?php

namespace Atcmobapp\Extensions\Controller\Admin;

use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Atcmobapp\Core\PluginManager;
use Atcmobapp\Extensions\ExtensionsInstaller;

/**
 * Extensions Plugins Controller
 *
 * @category Controller
 * @package  Atcmobapp.Extensions.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class PluginsController extends AppController
{

    /**
     * BC compatibility
     */
    public function __get($name)
    {
        if ($name == 'corePlugins') {
            return Plugin::$corePlugins;
        }
    }

    /**
     * beforeFilter
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->_AtcmobappPlugin = new PluginManager();
        $this->_AtcmobappPlugin->setController($this);
    }

    /**
     * Admin index
     *
     * @return void
     */
    public function index()
    {
        $this->set('title_for_layout', __d('atcmobile', 'Plugins'));

        $plugins = $this->_AtcmobappPlugin->plugins(false);
        $this->set('corePlugins', PluginManager::$corePlugins);
        $this->set('bundledPlugins', PluginManager::$bundledPlugins);
        $this->set(compact('plugins'));
    }

    /**
     * Admin add
     *
     * @return \Cake\Http\Response|void
     */
    public function add()
    {
        $this->set('title_for_layout', __d('atcmobile', 'Upload a new plugin'));

        if ($this->getRequest()->is('post')) {
            $data = $this->getRequest()->getData();
            $file = $data['Plugin']['file'];
            unset($data['Plugin']['file']);
            $this->request = $this->getRequest()->withParsedBody($data);

            $Installer = new ExtensionsInstaller;
            try {
                $Installer->extractPlugin($file['tmp_name']);
            } catch (Exception $e) {
                $this->Flash->error($e->getMessage());

                return $this->redirect(['action' => 'add']);
            }

            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Admin delete
     *
     * @return \Cake\Http\Response|void
     */
    public function delete($id)
    {
        $plugin = $this->getRequest()->query('name');
        if (!$plugin) {
            $this->Flash->error(__d('atcmobile', 'Invalid plugin'));

            return $this->redirect(['action' => 'index']);
        }
        if ($this->_AtcmobappPlugin->isActive($plugin)) {
            $this->Flash->error(__d('atcmobile', 'You cannot delete a plugin that is currently active.'));

            return $this->redirect(['action' => 'index']);
        }

        $result = $this->_AtcmobappPlugin->delete($plugin);
        if ($result === true) {
            $this->Flash->success(__d('atcmobile', 'Plugin "%s" deleted successfully.', $plugin));
        } elseif (!empty($result[0])) {
            $this->Flash->error($result[0]);
        } else {
            $this->Flash->error(__d('atcmobile', 'Plugin could not be deleted.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Admin toggle
     *
     * @return \Cake\Http\Response|void
     */
    public function toggle()
    {
        $plugin = $this->getRequest()->getQuery('name');
        if (!$plugin) {
            $this->Flash->error(__d('atcmobile', 'Invalid plugin'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->_AtcmobappPlugin->isActive($plugin)) {
            $usedBy = $this->_AtcmobappPlugin->usedBy($plugin);
            if ($usedBy !== false) {
                $this->Flash->error(__d('atcmobile', 'Plugin "%s" could not be deactivated since "%s" depends on it.', $plugin, implode(', ', $usedBy)));

                return $this->redirect(['action' => 'index']);
            }
            $result = $this->_AtcmobappPlugin->deactivate($plugin);
            if ($result === true) {
                $this->Flash->success(__d('atcmobile', 'Plugin "%s" deactivated successfully.', $plugin));
            } elseif (is_string($result)) {
                $this->Flash->error($result);
            } else {
                $this->Flash->error(__d('atcmobile', 'Plugin could not be deactivated. Please, try again.'));
            }
        } else {
            $result = $this->_AtcmobappPlugin->activate($plugin);
            if ($result === true) {
                $this->Flash->success(__d('atcmobile', 'Plugin "%s" activated successfully.', $plugin));
            } elseif (is_string($result)) {
                $this->Flash->error($result);
            } else {
                $this->Flash->error(__d('atcmobile', 'Plugin could not be activated. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Migrate a plugin (database)
     *
     * @return \Cake\Http\Response|void
     */
    public function migrate()
    {
        $plugin = $this->getRequest()->query('name');
        if (!$plugin) {
            $this->Flash->error(__d('atcmobile', 'Invalid plugin'));
        } elseif ($this->_AtcmobappPlugin->migrate($plugin)) {
            $this->Flash->success(__d('atcmobile', 'Plugin "%s" migrated successfully.', $plugin));
        } else {
            $this->Flash->error(
                __d('atcmobile', 'Plugin "%s" could not be migrated. Error: %s', $plugin, implode('<br />', $this->_AtcmobappPlugin->migrationErrors))
            );
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Move up a plugin in bootstrap order
     *
     * @throws Exception
     */
    public function moveup()
    {
        $plugin = $this->getRequest()->query('name');
        $this->getRequest()->allowMethod('post');

        if ($plugin === null) {
            throw new Exception(__d('atcmobile', 'Invalid plugin'));
        }

        $class = 'success';
        $result = $this->_AtcmobappPlugin->move('up', $plugin);
        if ($result === true) {
            $message = __d('atcmobile', 'Plugin %s has been moved up', $plugin);
            $this->Flash->success($message);
        } else {
            $message = $result;
            $this->Flash->error($message);
        }

        return $this->redirect($this->referer());
    }

    /**
     * Move down a plugin in bootstrap order
     *
     * @throws Exception
     */
    public function movedown()
    {
        $plugin = $this->getRequest()->query('name');
        $this->getRequest()->allowMethod('post');

        if ($plugin === null) {
            throw new Exception(__d('atcmobile', 'Invalid plugin'));
        }

        $element = 'success';
        $result = $this->_AtcmobappPlugin->move('down', $plugin);
        if ($result === true) {
            $message = __d('atcmobile', 'Plugin %s has been moved down', $plugin);
        } else {
            $message = $result;
            $element = 'error';
        }
        $this->Flash->set($message, compact('element'));

        return $this->redirect($this->referer());
    }
}
