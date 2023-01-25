<?php

use Phinx\Seed\AbstractSeed;

class CntryregionsSeed extends AbstractSeed
{

    public $records = array(
  array('id' => '1','region_name' => 'USA - Mountain West','region_description' => '','bbox' => NULL,'extent' => '45.223330,-118.463390,33.855050,-102.360875','swlat' => '45.2233','swlon' => '-118.463','nelat' => '33.855','nelon' => '-102.361','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '2','region_name' => 'USA - North-Central','region_description' => '','bbox' => NULL,'extent' => '38.551175,-97.653235,48.627212,-86.066222','swlat' => '38.5512','swlon' => '-97.6532','nelat' => '48.6272','nelon' => '-86.0662','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '3','region_name' => 'USA - Northeast','region_description' => '','bbox' => NULL,'extent' => '39.467,-84.406,48.222,-62.345','swlat' => '39.467','swlon' => '-84.406','nelat' => '48.222','nelon' => '-62.345','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '4','region_name' => 'USA - Pacific','region_description' => '','bbox' => NULL,'extent' => '45.789760,-127.948038,35.876907,-113.682475','swlat' => '45.7898','swlon' => '-127.948','nelat' => '35.8769','nelon' => '-113.682','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '5','region_name' => 'USA - South-Central','region_description' => '','bbox' => NULL,'extent' => '37.733220,-103.883925,29.004546,-90.037061','swlat' => '37.7332','swlon' => '-103.884','nelat' => '29.0045','nelon' => '-90.0371','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '6','region_name' => 'USA - Southeast','region_description' => '','bbox' => NULL,'extent' => '25,-91.445647,36.537333,-78.678341','swlat' => '25','swlon' => '-91.4456','nelat' => '36.5373','nelon' => '-78.6783','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '8','region_name' => 'Canada','region_description' => '','bbox' => NULL,'extent' => '44.47,-113.23,59.38,-69.113','swlat' => '44.47','swlon' => '-113.23','nelat' => '59.38','nelon' => '-69.113','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '9','region_name' => 'Mexico / Central Am.','region_description' => '','bbox' => NULL,'extent' => '9.7,-116,25,-82','swlat' => '9.7','swlon' => '-116','nelat' => '25','nelon' => '-82','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '10','region_name' => 'South America','region_description' => '','bbox' => NULL,'extent' => '-54,-94,11,-29','swlat' => '-54','swlon' => '-94','nelat' => '11','nelon' => '-29','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '11','region_name' => 'Europe','region_description' => '','bbox' => NULL,'extent' => '35.1105,-12.9465,70.9344,60.53','swlat' => '35.1105','swlon' => '-12.9465','nelat' => '70.9344','nelon' => '60.53','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '12','region_name' => 'Asia','region_description' => '','bbox' => NULL,'extent' => '-8.1359,59.8269,51.1308,147.0144','swlat' => '-8.1359','swlon' => '59.8269','nelat' => '51.1308','nelon' => '147.014','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '13','region_name' => 'Oceania','region_description' => '','bbox' => NULL,'extent' => '-46.4307,107.6394,-9.6987,174','swlat' => '-46.4307','swlon' => '107.639','nelat' => '-9.6987','nelon' => '174','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '14','region_name' => 'Africa','region_description' => '','bbox' => NULL,'extent' => '-39,-23,34,62','swlat' => '-39','swlon' => '-23','nelat' => '34','nelon' => '62','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18'),
  array('id' => '15','region_name' => 'USA','region_description' => '','bbox' => NULL,'extent' => '30.05,-118.060,49.68,-74.93','swlat' => '30.05','swlon' => '-118.06','nelat' => '49.68','nelon' => '-74.93','modified' => '2017-04-10 19:41:18','created' => '2017-04-10 19:41:18')
);

    public function run()
    {
        $Table = $this->table('cntryregions');
        $Table->insert($this->records)->save();
    }
}
