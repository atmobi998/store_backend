<?php

use Phinx\Seed\AbstractSeed;

class UrolesSeed extends AbstractSeed
{

    public $records = array(
  array('id' => '1','role' => 'Anonymous','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59'),
  array('id' => '2','role' => 'No Role 1','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59'),
  array('id' => '3','role' => 'No Role 2','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59'),
  array('id' => '10','role' => 'Planning Manager','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59'),
  array('id' => '20','role' => 'Design Manager','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59'),
  array('id' => '30','role' => 'Construction Manager','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59'),
  array('id' => '40','role' => 'Planning and Concept Development','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59'),
  array('id' => '50','role' => 'Traffic Engineering Microsimulation','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59'),
  array('id' => '60','role' => 'Preliminary Design, Architecture, Surrounding uses','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59'),
  array('id' => '70','role' => 'Represented the Government Sponsor','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59'),
  array('id' => '80','role' => 'Generated public support and funding','modified' => '2020-07-12 19:40:59','created' => '2020-07-12 19:40:59')
);

    public function run()
    {
        $Table = $this->table('uroles');
        $Table->insert($this->records)->save();
    }
}
