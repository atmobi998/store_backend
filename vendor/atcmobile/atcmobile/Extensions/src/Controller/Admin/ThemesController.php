<?php

namespace Atcmobapp\Extensions\Controller\Admin;

use UnexpectedValueException;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Network\Exception\BadRequestException;
use Atcmobapp\Extensions\AtcmobappTheme;
use Atcmobapp\Extensions\Exception\MissingThemeException;
use Atcmobapp\Extensions\ExtensionsInstaller;

/**
 * Extensions Themes Controller
 *
 * @category Controller
 * @package  Atcmobapp.Extensions.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class ThemesController extends AppController
{

    /**
     * AtcmobappTheme instance
     * @var \Atcmobapp\Extensions\AtcmobappTheme
     */
    protected $_AtcmobappTheme = false;

    /**
     * Constructor
     */
    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->_AtcmobappTheme = new AtcmobappTheme();
    }

    /**
     * Admin index
     *
     * @return void
     */
    public function index()
    {
        $this->set('title_for_layout', __d('atcmobile', 'Themes'));

        $themes = $this->_AtcmobappTheme->getThemes();
        $themesData = [];
        foreach ($themes as $theme => $path) {
            $themesData[$theme] = $this->_AtcmobappTheme->getData($theme, $path);
        }

        $activeTheme = Configure::read('Site.theme');
        if (empty($activeTheme)) {
            $activeTheme = 'Atcmobapp/Core';
        }
        $currentTheme = $this->_AtcmobappTheme->getData($activeTheme);

        $activeBackendTheme = Configure::read('Site.admin_theme');
        if (empty($activeBackendTheme)) {
            $activeBackendTheme = 'Atcmobapp/Core';
        }
        $currentBackendTheme = $this->_AtcmobappTheme->getData($activeBackendTheme);

        $this->set(compact('themes', 'themesData', 'currentTheme', 'currentBackendTheme'));
    }

    /**
     * Admin activate
     *
     * @param string $theme
     */
    public function activate()
    {
        $theme = $this->getRequest()->getQuery('theme');
        $type = $this->getRequest()->getQuery('type') ?: 'theme';

        if (!$theme) {
            throw new UnexpectedValueException();
        }
        try {
            $this->_AtcmobappTheme->activate($theme, $type);

            $this->Flash->success(__d('atcmobile', 'Theme activated.'));
        } catch (MissingThemeException $exception) {
            $this->Flash->error(__d('atcmobile', 'Theme activation failed: %s', $exception->getMessage()));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Admin add
     *
     * @return \Cake\Http\Response|void
     */
    public function add()
    {
        $this->set('title_for_layout', __d('atcmobile', 'Upload a new theme'));

        if ($this->getRequest()->is('post')) {
            $data = $this->getRequest()->getData();
            $file = $data['Theme']['file'];
            unset($data['Theme']['file']);
            $this->request = $this->getRequest()->withParsedBody($data);

            $Installer = new ExtensionsInstaller;
            try {
                $Installer->extractTheme($file['tmp_name']);
                $this->Flash->success(__d('atcmobile', 'Theme uploaded successfully.'));
            } catch (Exception $e) {
                $this->Flash->error($e->getMessage());
            }

            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Admin editor
     *
     * @return void
     */
    public function editor()
    {
        $this->set('title_for_layout', __d('atcmobile', 'Theme Editor'));
    }

    /**
     * Admin save
     *
     * @return void
     */
    public function save()
    {
    }

    /**
     * Admin delete
     *
     * @param string $alias
     * @return \Cake\Http\Response|void
     */
    public function delete($alias = null)
    {
        if (!$alias) {
            $alias = $this->getRequest()->getQuery('theme');
        }
        if ($alias == null) {
            $this->Flash->error(__d('atcmobile', 'Invalid Theme.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($alias == 'Atcmobapp/Core') {
            $this->Flash->error(__d('atcmobile', 'Default theme cannot be deleted.'));

            return $this->redirect(['action' => 'index']);
        } elseif ($alias == Configure::read('Site.theme')) {
            $this->Flash->error(__d('atcmobile', 'You cannot delete a theme that is currently active.'));

            return $this->redirect(['action' => 'index']);
        }

        $result = $this->_AtcmobappTheme->delete($alias);

        if ($result === true) {
            $this->Flash->success(__d('atcmobile', 'Theme deleted successfully.'));
        } elseif (!empty($result[0])) {
            $this->Flash->error($result[0]);
        } else {
            $this->Flash->error(__d('atcmobile', 'An error occurred.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
