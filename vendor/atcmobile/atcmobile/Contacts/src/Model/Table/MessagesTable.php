<?php

namespace Atcmobapp\Contacts\Model\Table;

use Cake\Validation\Validator;
use Atcmobapp\Core\Model\Table\AtcmobappTable;

/**
 * Message
 *
 * @category Model
 * @package  Atcmobapp.Contacts.Model
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class MessagesTable extends AtcmobappTable
{

    public function initialize(array $config)
    {
        $this->setEntityClass('Atcmobapp/Contacts.Message');
        $this->belongsTo('Contacts', [
            'className' => 'Atcmobapp/Contacts.Contacts',
            'foreignKey' => 'contact_id',
        ]);
        $this->addBehavior('CounterCache', [
            'Contacts' => ['message_count']
        ]);

        $this->addBehavior('Atcmobapp/Core.BulkProcess', [
            'actionsMap' => [
                'read' => 'bulkRead',
                'unread' => 'bulkUnread',
            ],
        ]);
        $this->addBehavior('Atcmobapp/Core.Trackable');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Timestamp');

        $this->searchManager()
            ->value('contact_id')
            ->add('created', 'Atcmobapp/Core.Date', [
                'field' => 'Messages.created'
            ])
            ->add('search', 'Search.Like', [
                'field' => [
                    'Messages.name', 'Messages.email', 'Messages.title',
                    'Messages.body',
                ],
                'before' => true,
                'after' => true,
            ])
            ->value('status', [
                'field' => $this->aliasField('status'),
            ]);
    }

    public function validationDefault(Validator $validator)
    {
        $notBlankMessage = __d('atcmobile', 'This field cannot be left blank.');
        $validator->notBlank('name', $notBlankMessage);
        $validator->email('email', __d('atcmobile', 'Please provide a valid email address.'));
        $validator->notBlank('title', $notBlankMessage);
        $validator->notBlank('body', $notBlankMessage);

        return $validator;
    }

    /**
     * Mark messages as read in bulk
     *
     * @param array $ids Array of Message Ids
     * @return bool True if successful, false otherwise
     */
    public function bulkRead($ids)
    {
        return $this->updateAll(
            ['status' => 1],
            [$this->aliasField('id') . ' IN' => $ids]
        );
    }

    /**
     * Mark messages as Unread in bulk
     *
     * @param array $ids Array of Message Ids
     * @return bool True if successful, false otherwise
     */
    public function bulkUnread($ids)
    {
        return $this->updateAll(
            ['status' => 0],
            [$this->aliasField('id') . ' IN' => $ids]
        );
    }
}
