<?php

namespace Atcmobapp\Core\Shell;

use Cake\Utility\Security;
use Atcmobapp\Acl\AclGenerator;

/**
 * Atcmobapp Shell
 *
 * @category Shell
 * @package  Atcmobapp.Atcmobapp.Console.Command
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class AtcmobappShell extends AppShell
{
    /**
     * Display help/options
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        $parser->description(__d('atcmobile', 'Atcmobapp Utilities'))
            ->addSubcommand('password', [
                'help' => 'Get hashed password',
                'parser' => [
                    'description' => 'Get hashed password',
                    'arguments' => [
                        'password' => [
                            'required' => true,
                            'help' => 'Password to hash',
                        ],
                    ],
                ],
            ])->addSubcommand('sync_content_acos', [
                'help' => 'Sync content acos',
                'parser' => [
                    'description' => 'Populate acos of existing contents',
                ],
            ]);

        return $parser;
    }

    /**
     * Get hashed password
     *
     * Usage: ./Console/cake atcmobile password myPasswordHere
     */
    public function password()
    {
        $value = trim($this->args['0']);
        $this->out(Security::hash($value, null, true));
    }

    public function syncContentAcos()
    {
        $aclGenerator = new AclGenerator();

        return $aclGenerator->syncContentAcos();
    }
}
