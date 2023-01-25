<?php

use Phinx\Seed\AbstractSeed;

class MobclisSeed extends AbstractSeed
{

    public $records = array(
  array('id' => '1','user_id' => '8','cli_code' => 'Mw5fX7UczP3onB','cli_name' => 'Ho Tran An','cli_email' => 'anhovn@hotmail.com','cli_phone' => '0979547863','cli_fax' => '0979547863','cli_addr' => '9 bis 3, 1ST street, BHHA, B. Tan','cli_addr2' => '','cli_city' => '','cli_zip' => '','cli_state' => '','cli_country' => '','home_lat' => '10.7695883','home_lng' => '106.6317567','cli_lat' => '10.7934233','cli_lng' => '106.6545067','cli_status' => 'Cab call','cli_img' => '/img/clis/selfimgs/resized/1/f537f331_bbce_4cd1_8e03_e081df519f73.jpg','img_w' => '776','img_h' => '512','up_img' => 'img/clis/selfimgs/upload/1/f537f331_bbce_4cd1_8e03_e081df519f73.jpg','up_img_w' => '1600','up_img_h' => '1056','nid_info' => '','nid_name' => '','nid_nbr' => '','nid_bplace' => '','nid_bdate' => '2021-02-19 16:04:25','nid_date' => '2021-02-19 16:04:25','nid_img' => '','nid_img_w' => '0','nid_img_h' => '0','cli_verify' => '0','verify_date' => '2021-02-19 16:04:25','verify_note' => '','bcntry_code' => 'VN','scntry_code' => 'VN','currency' => 'VND','billing_phone' => '979547863','billing_name' => '','billing_addr' => '','billing_addr2' => '','billing_city' => '','billing_zip' => '','billing_state' => '','billing_country' => '','shipping_phone' => '','shipping_name' => '','shipping_addr' => '','shipping_addr2' => '','shipping_city' => '','shipping_zip' => '','shipping_state' => '','shipping_country' => '','payment_method' => 'VISA','card_owner' => 'abc cde','card_number' => '1234345656786789','card_code' => '111','card_year' => '2025','card_month' => '12','authorization' => 'testing authorization','transaction' => 'testing trans','balance' => '1000000','last_acc_ip' => '','last_acc_token' => '','devinfo' => '','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-02-19 16:04:25','modified' => NULL),
  array('id' => '2','user_id' => '9','cli_code' => '/Iu5N05tv+FesA','cli_name' => 'Ho Tran An','cli_email' => 'anhovn@hotmail.com','cli_phone' => '0907628544','cli_fax' => '0907628544','cli_addr' => '9 bis 3, 1ST street, BHHA, B. Tan','cli_addr2' => 'Ho Chi Minh City, Vietnam','cli_city' => '','cli_zip' => '','cli_state' => '','cli_country' => '','home_lat' => '0','home_lng' => '0','cli_lat' => '0','cli_lng' => '0','cli_status' => 'Cab call','cli_img' => '/img/clis/selfimgs/resized/2/cede193f_7d76_4879_8064_6905e99e50ac.png','img_w' => '266','img_h' => '330','up_img' => 'img/clis/selfimgs/upload/2/cede193f_7d76_4879_8064_6905e99e50ac.png','up_img_w' => '266','up_img_h' => '330','nid_info' => '','nid_name' => '','nid_nbr' => '','nid_bplace' => '','nid_bdate' => '2021-02-24 11:22:28','nid_date' => '2021-02-24 11:22:28','nid_img' => '','nid_img_w' => '0','nid_img_h' => '0','cli_verify' => '0','verify_date' => '2021-02-24 11:22:28','verify_note' => '','bcntry_code' => 'VN','scntry_code' => 'VN','currency' => 'VND','billing_phone' => '','billing_name' => '','billing_addr' => '','billing_addr2' => '','billing_city' => '','billing_zip' => '','billing_state' => '','billing_country' => '','shipping_phone' => '','shipping_name' => '','shipping_addr' => '','shipping_addr2' => '','shipping_city' => '','shipping_zip' => '','shipping_state' => '','shipping_country' => '','payment_method' => 'VISA','card_owner' => '','card_number' => '','card_code' => '','card_year' => '','card_month' => '','authorization' => '','transaction' => '','balance' => '0','last_acc_ip' => '','last_acc_token' => '','devinfo' => '','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-02-24 11:22:28','modified' => NULL)
);


    public function run()
    {
        $Table = $this->table('mobclis');
        $Table->insert($this->records)->save();
    }
}
