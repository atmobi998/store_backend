<?php

namespace Atcmobapp\Extensions\Controller\Admin;

use Cake\Cache\Cache;
use Cake\Core\App;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\I18n\I18n;
use Locale;

/**
 * Extensions Locales Controller
 *
 * @category Controller
 * @package  Atcmobapp.Extensions.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class LocalesController extends AppController
{

    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = [
        'Atcmobapp/Settings.Settings',
        'Atcmobapp/Users.Users',
    ];

    /**
     * Admin index
     *
     * @return void
     */
    public function index()
    {
        $this->set('title_for_layout', __d('atcmobile', 'Locales'));

        $locales = [];
        $folder = new Folder;
        $paths = App::path('Locale');
        $currentLocale = I18n::getLocale();
        foreach ($paths as $path) {
            $folder->path = $path;
            $content = $folder->read();
            foreach ($content['0'] as $locale) {
                if (strstr($locale, '.') !== false) {
                    continue;
                }
                $fullpath = $path . $locale . DS . 'atcmobile.po';
                if (!file_exists($fullpath)) {
                    continue;
                }

                I18n::setLocale($locale);
                $name = Locale::getDisplayLanguage($locale);
                I18n::setLocale($currentLocale);
                $locales[$locale] = [
                    'path' => $fullpath,
                    'name' => $name,
                ];
            }
        }

        $this->set(compact('content', 'locales'));
    }

    /**
     * Admin activate
     *
     * @param string $locale
     * @return \Cake\Http\Response|void
     */
    public function activate($locale = null)
    {
        $poFile = $this->__getPoFile($locale);
        if ($locale == null || !$poFile) {
            $this->Flash->error(__d('atcmobile', 'Locale does not exist.'));

            return $this->redirect(['action' => 'index']);
        }

        $result = $this->Settings->write('Site.locale', $locale);
        if ($result) {
            Cache::clear(false, '_cake_core_');
            Cache::clear(false, 'atcmobile_menus');
            $this->Flash->success(__d('atcmobile', "Locale '%s' set as default", $locale));
        } else {
            $this->Flash->error(__d('atcmobile', 'Could not save Locale setting.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Deactivate locale
     *
     * @param string $locale
     * @return \Cake\Http\Response|void
     */
    public function deactivate($locale = null)
    {
        if ($locale == null) {
            $this->Flash->error(__d('atcmobile', 'Invalid locale.'));

            return $this->redirect(['action' => 'index']);
        }
        $result = $this->Settings->write('Site.locale', '');
        if ($result) {
            Cache::clear(false, '_cake_core_');
            Cache::clear(false, 'atcmobile_menus');
            $this->Flash->success(__d('atcmobile', "Locale '%s' deactivated", $locale));
        } else {
            $this->Flash->error(__d('atcmobile', 'Could not save Locale setting.'));
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
        $this->set('title_for_layout', __d('atcmobile', 'Upload a new locale'));

        if ($this->getRequest()->is('post') && !empty($this->getRequest()->data)) {
            $file = $this->getRequest()->data['Locale']['file'];
            unset($this->getRequest()->data['Locale']['file']);

            // get locale name
            $zip = zip_open($file['tmp_name']);
            $locale = null;
            if ($zip) {
                while ($zipEntry = zip_read($zip)) {
                    $zipEntryName = zip_entry_name($zipEntry);
                    if (strstr($zipEntryName, 'LC_MESSAGES')) {
                        $zipEntryNameE = explode('/LC_MESSAGES', $zipEntryName);
                        if (isset($zipEntryNameE['0'])) {
                            $pathE = explode('/', $zipEntryNameE['0']);
                            if (isset($pathE[count($pathE) - 1])) {
                                $locale = $pathE[count($pathE) - 1];
                            }
                        }
                    }
                }
            }
            zip_close($zip);

            if (!$locale) {
                $this->Flash->error(__d('atcmobile', 'Invalid locale.'));

                return $this->redirect(['action' => 'add']);
            }

            if (is_dir(APP . 'Locale' . DS . $locale)) {
                $this->Flash->error(__d('atcmobile', 'Locale already exists.'));

                return $this->redirect(['action' => 'add']);
            }

            // extract
            $zip = zip_open($file['tmp_name']);
            if ($zip) {
                while ($zipEntry = zip_read($zip)) {
                    $zipEntryName = zip_entry_name($zipEntry);
                    if (strstr($zipEntryName, $locale . '/')) {
                        $zipEntryNameE = explode($locale . '/', $zipEntryName);
                        if (isset($zipEntryNameE['1'])) {
                            $path = APP . 'Locale' . DS . $locale . DS . str_replace('/', DS, $zipEntryNameE['1']);
                        } else {
                            $path = APP . 'Locale' . DS . $locale . DS;
                        }

                        if (substr($path, strlen($path) - 1) == DS) {
                            // create directory
                            mkdir($path);
                        } else {
                            // create file
                            if (zip_entry_open($zip, $zipEntry, 'r')) {
                                $fileContent = zip_entry_read($zipEntry, zip_entry_filesize($zipEntry));
                                touch($path);
                                $fh = fopen($path, 'w');
                                fwrite($fh, $fileContent);
                                fclose($fh);
                                zip_entry_close($zipEntry);
                            }
                        }
                    }
                }
            }
            zip_close($zip);

            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Admin edit
     *
     * @param string $locale
     * @return \Cake\Http\Response|void
     */
    public function edit($locale = null)
    {
        $this->set('title_for_layout', sprintf(__d('atcmobile', 'Edit locale: %s'), $locale));

        if (!$locale) {
            $this->Flash->error(__d('atcmobile', 'Invalid locale.'));

            return $this->redirect(['action' => 'index']);
        }

        $poFile = $this->__getPoFile($locale);

        if (!$poFile) {
            $this->Flash->error(__d('atcmobile', 'The file %s does not exist.', 'atcmobile.po'));

            return $this->redirect(['action' => 'index']);
        }

        $file = new File($poFile, true);
        $content = $file->read();

        $locale = [
            'locale' => $locale,
            'content' => $content,
            'schema' => true,
        ];

        if (!empty($this->getRequest()->data)) {
            // save
            if ($file->write($this->getRequest()->data('content'))) {
                $this->Flash->success(__d('atcmobile', 'Locale updated successfully'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('locale', 'content'));
    }

    /**
     * Admin delete
     *
     * @param string $locale
     * @return \Cake\Http\Response|void
     */
    public function delete($locale = null)
    {
        $poFile = $this->__getPoFile($locale);

        if (!$poFile) {
            $this->Flash->error(__d('atcmobile', 'The file %s does not exist.', 'atcmobile.po'));

            return $this->redirect(['action' => 'index']);
        }

        $file = new File($poFile, true);
        if ($file->delete()) {
            $this->Flash->success(__d('atcmobile', 'Locale deleted successfully.'));
        } else {
            $this->Flash->error(__d('atcmobile', 'Local could not be deleted.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Returns the path to the atcmobile.po file
     *
     * @param $locale
     */
    private function __getPoFile($locale)
    {
        $paths = App::path('Locale');
        foreach ($paths as $path) {
            $poFile = $path . $locale . DS . 'atcmobile.po';

            if (file_exists($poFile)) {
                return $poFile;
            }
        }

        return false;
    }
}
