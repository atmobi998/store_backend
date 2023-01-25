<?php

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Log\LogTrait;
use Phinx\Seed\AbstractSeed;

class MobposusrsSeed extends AbstractSeed
{

    public $records = array(
        array('id' => '1','store_id' => '1','store_code' => 'Ij2/+hCWgYlCNg','pos_name' => 'Staff 01','pos_code' => 'UJGyYWDU5J2Dni','pos_passcode' => '$2y$10$KzwtjPLIUEdUzbHAVA1SBuTRaB6/kr/p9V8LH0QcNOOHQzzPQWG92','passcode_bk' => '12348765','active' => '1','pos_ip' => '','pos_token' => '\'\'','status' => 'Working','staff_img' => '/img/stores/staffs/resized/1/c58adcf9_cd89_438e_9e46_8c497d3648d8.jpg','img_w' => '259','img_h' => '194','phone' => '0932390737','name' => 'Trang Bui Thi Thuy','addr' => '9 bis 3, 1ST Street','addr2' => 'BHHA, Binh Tan','city' => 'Ho Chi Minh','zip' => '70000','state' => 'Ho Chi Minh','country' => 'Vietnam','devinfo' => '\'\'','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-12 00:00:00','modified' => '2021-01-12 00:00:00'),
        array('id' => '5','store_id' => '1','store_code' => 'Ij2/+hCWgYlCNg','pos_name' => 'Staff 02','pos_code' => 'TQ6llpJIKsUECI','pos_passcode' => '$2y$10$UtAksXt/o.M4JD02ZWneOO5pjV.CZQ5O89w71XAS.bVIWgVsURN3C','passcode_bk' => '12348765','active' => '1','pos_ip' => '','pos_token' => '','status' => '','staff_img' => '/img/stores/staffs/resized/5/4e5283a6_a623_4caa_885b_3737e6e9cb00.jpg','img_w' => '259','img_h' => '194','phone' => '0979547863','name' => 'An Ho','addr' => '9 bis 3, 1ST Street','addr2' => 'BHHA, Binh Tan','city' => 'Ho Chi Minh','zip' => '70000','state' => 'Ho Chi Minh','country' => 'Vietnam','devinfo' => '','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-13 14:05:39','modified' => NULL),
        array('id' => '6','store_id' => '2','store_code' => 'gHX/jgSJMny8bw','pos_name' => 'POS 01','pos_code' => 'VLMnNw5aLNrhu5','pos_passcode' => '$2y$10$0GGW3R.iSbJXO.nt.6Bdf.Q9sxW0nSw90rw/g6u.IoM.XYBPXcwDa','passcode_bk' => '12348765','active' => '1','pos_ip' => '','pos_token' => '','status' => '','staff_img' => '/img/stores/staffs/resized/6/29fef0da_4314_4e5f_8a56_58428861af64.png','img_w' => '569','img_h' => '512','phone' => '0932390737','name' => 'Trang Bui Thi Thuy','addr' => '9 bis 3, 1ST Street','addr2' => 'BHHA, Binh Tan','city' => 'Ho Chi Minh','zip' => '70000','state' => 'Ho Chi Minh','country' => 'Vietnam','devinfo' => '','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-13 14:21:06','modified' => NULL),
        array('id' => '7','store_id' => '1','store_code' => 'Ij2/+hCWgYlCNg','pos_name' => 'Staff 03','pos_code' => '6gvaKnQ9Edl2P3','pos_passcode' => '$2y$10$6jD8p2sQhFAlJD/iFAicIempQXix1i09Xb.4cqrC5K0H6CkxfVMCG','passcode_bk' => '12348765','active' => '1','pos_ip' => '','pos_token' => '','status' => '','staff_img' => '/img/stores/staffs/resized/7/4ed7d9bb_caf7_46ab_b56f_0c6d04d5991e.jpg','img_w' => '259','img_h' => '194','phone' => '0932390737','name' => 'Trang BTT','addr' => '9 bis 3, 1ST street','addr2' => 'BHHA, Binh Tan','city' => 'Ho Chi Minh','zip' => '','state' => '','country' => 'Vietnam','devinfo' => '','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-28 14:28:44','modified' => NULL),
        array('id' => '8','store_id' => '1','store_code' => 'Ij2/+hCWgYlCNg','pos_name' => 'Staff 04','pos_code' => 'W6yFEeI0B/Ngc9','pos_passcode' => '$2y$10$UIfCJMoF3JKPaj7QVz.URe.iK7bcE/E8hzw/F/eKqpiSl1me3i2lu','passcode_bk' => '12348765','active' => '1','pos_ip' => '','pos_token' => '','status' => '','staff_img' => '/img/stores/staffs/resized/8/5738c22a_5609_4e7d_a897_6febcfd622b9.png','img_w' => '569','img_h' => '512','phone' => '0979547863','name' => 'An Ho','addr' => '9 bis 3, 1ST street','addr2' => 'BHHA, Binh Tan','city' => 'Ho Chi Minh','zip' => '700000','state' => 'Ho Chi Minh','country' => 'Vietnam','devinfo' => '','lft' => NULL,'rght' => NULL,'created_by' => '1','modified_by' => '1','created' => '2021-01-28 14:33:18','modified' => NULL)
      );
      
    public function run()
    {
        foreach ($this->records as $uk => $uv) {
            $this->records[$uk]['pos_passcode'] = (new DefaultPasswordHasher)->hash($uv['passcode_bk']);
        }
        $Table = $this->table('mobposusrs');
        $Table->insert($this->records)->save();
    }
}
