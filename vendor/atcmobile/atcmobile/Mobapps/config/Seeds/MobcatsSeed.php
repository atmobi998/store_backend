<?php

use Phinx\Seed\AbstractSeed;

class MobcatsSeed extends AbstractSeed
{

    public $records = array(
  array('id' => '1','store_id' => '1','name' => 'Delivery Foods','slug' => 'delivery-foods','description' => 'Delivery Foods','sort' => '1','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-04 00:00:00','modified' => '2021-01-04 00:00:00'),
  array('id' => '2','store_id' => '1','name' => 'Fruit Juice','slug' => 'fruit-juices','description' => 'Fruit Juices take away and delivery','sort' => '2','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-04 00:00:00','modified' => '2021-01-04 00:00:00'),
  array('id' => '3','store_id' => '1','name' => 'Lunch','slug' => 'lunch-delivery','description' => 'Lunch delivery','sort' => '3','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-04 00:00:00','modified' => '2021-01-04 00:00:00'),
  array('id' => '4','store_id' => '1','name' => 'Dinner','slug' => 'food-for-dinner','description' => 'Food for dinner','sort' => '4','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-04 20:22:52','modified' => NULL),
  array('id' => '5','store_id' => '1','name' => 'Cakes','slug' => 'delivery-cakes','description' => 'Delivery cakes','sort' => '5','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-04 20:31:53','modified' => NULL),
  array('id' => '6','store_id' => '1','name' => 'Breads','slug' => 'delivery-breads','description' => 'Delivery Breads','sort' => '6','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-04 20:37:32','modified' => NULL),
  array('id' => '7','store_id' => '3','name' => 'Handmade bags','slug' => 'Handmade bags','description' => 'Handmade bags','sort' => '1','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-06 20:52:40','modified' => NULL),
  array('id' => '8','store_id' => '1','name' => 'Breakfasts','slug' => 'breakfasts','description' => 'Breakfasts food','sort' => '2','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-09 21:16:56','modified' => NULL),
  array('id' => '9','store_id' => '1','name' => 'Street foods','slug' => 'Street foods','description' => 'Street foods','sort' => '1','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-09 23:44:14','modified' => NULL),
  array('id' => '10','store_id' => '1','name' => 'Misc','slug' => 'misc','description' => 'miscellaneous','sort' => '6','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-11 11:11:13','modified' => NULL),
  array('id' => '11','store_id' => '2','name' => 'Bags','slug' => 'bags','description' => 'Handmade bags','sort' => '1','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-25 20:27:24','modified' => NULL),
  array('id' => '12','store_id' => '6','name' => 'Bag 01','slug' => 'bag-01','description' => 'Bag for girls','sort' => '1','active' => '1','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-27 17:04:46','modified' => NULL)
);





    public function run()
    {
        $Table = $this->table('mobcats');
        $Table->insert($this->records)->save();
    }
}
