<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobprodsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobprods',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('store_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('store_name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('cat_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => false ])
        ->addColumn('cat_name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('subcat_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => true ])
        ->addColumn('subcat_name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('slug', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('description', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('prod_ico', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('ico_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('ico_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('prod_imga', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('imga_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('imga_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('prod_imgb', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('imgb_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('imgb_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('prod_imgc', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('imgc_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('imgc_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('prod_imgd', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('imgd_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('imgd_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('prod_imge', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('imge_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('imge_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('prod_imgf', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('imgf_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('imgf_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('prod_imgg', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('imgg_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('imgg_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('prod_imgh', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('imgh_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('imgh_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('weight', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('weiunit', 'string', [ 'default' => 'kgs', 'limit' => 30, 'null' => true, ])
        ->addColumn('size_w', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('size_h', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('size_d', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('sizeunit', 'string', [ 'default' => 'cm', 'limit' => 30, 'null' => true, ])
        ->addColumn('views', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('sort', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('active', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('taxrate_id', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('taxrate', 'float', [ 'null' => true, 'default' => 7.5])
        ->addColumn('pricesell', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('pricebuy', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('prod_sku', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('prod_ref', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('prod_code', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('prod_cotype', 'string', [ 'default' => 'Barcode', 'limit' => 255, 'null' => true, ])
        ->addColumn('stockunits', 'integer', [ 'default' => 999, 'null' => true, ])
        ->addColumn('minstock', 'integer', [ 'default' => 19, 'null' => true, ])
        ->addColumn('suppl_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => true ])
        ->addColumn('loc_lat', 'double', [ 'null' => true, 'default' => 0])
        ->addColumn('loc_lng', 'double', [ 'null' => true, 'default' => 0])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'store_id', ] )
        ->addIndex( [ 'cat_id', ] )
        ->addIndex( [ 'cat_name', ] )
        ->addIndex( [ 'subcat_id', ] )
        ->addIndex( [ 'subcat_name', ] )
        ->addIndex( [ 'name', ] )
        ->addIndex( [ 'pricesell', ] )
        ->addIndex( [ 'pricebuy', ] )
        ->addIndex( [ 'slug', ] )
        ->addIndex( [ 'sort', ] )
        ->addIndex( [ 'active', ] )
        ->addIndex( [ 'prod_sku', ] )
        ->addIndex( [ 'prod_ref', ] )
        ->addIndex( [ 'prod_code', ] )
        ->addIndex( [ 'prod_cotype', ] )
        ->addIndex( [ 'stockunits', ] )
        ->addIndex( [ 'minstock', ] )
        ->addIndex( [ 'suppl_id', ] )
        ->addIndex( [ 'loc_lat', ] )
        ->addIndex( [ 'loc_lng', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobprods')->drop()->save();
    }
}
