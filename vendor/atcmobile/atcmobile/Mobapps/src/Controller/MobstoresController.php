<?php

namespace Atcmobapp\Mobapps\Controller;

use Cake\Core\Configure;
use Cake\Database\Expression\IdentifierExpression;
use Cake\I18n\I18n;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\Core\Plugin;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Text;
use Cake\Network\Email\Email;
use Cake\Network\Session;
use Cake\Utility\Security;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Controller;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Users\Model\Table\UsersTable;
use Atcmobapp\Users\Model\Table\RolesTable;
use Atcmobapp\Mobapps\Controller\Component\MathCaptchaComponent;
use Atcmobapp\Mobapps\Controller\Api\AppController;
use \Firebase\JWT\JWT;
use ZipArchive;

/**
 * Mobapps Controller
 *
 * @property MobappsTable Mobapps
 * @category Mobapps.Controller
 * @package  Atcmobapp.Mobapps
 * @version  1.0
 * @author   SP.NET Team <admin@streetplan.net>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://streetplan.net
 */
class MobstoresController extends AppController
{
    
    public $presetVars = true;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Cntryregions');
        $this->loadModel('Countries');
        $this->loadModel('Groups');
        $this->loadModel('Profiles');
        $this->loadModel('States');
        $this->loadModel('Uroles');
        $this->loadModel('Useractions');
        $this->loadModel('Useractips');
        $this->loadModel('Userlogs');
        $this->loadModel('Atcmobapp/Users.Users');
        $this->loadModel('Atcmobapp/Users.Roles');
        $this->loadModel('Zipcodes');
        $this->loadModel('Mobapps');
        $this->loadModel('Mobstores');
        $this->loadModel('Mobstoretrans');
        $this->loadModel('Mobstrusrs');
        $this->loadModel('Mobposusrs');
        $this->loadModel('Mobpossecs');
        $this->loadModel('Mobpostkts');
        $this->loadModel('Mobtktdets');
        $this->loadModel('Mobsuppls');
        $this->loadModel('Mobcats');
        $this->loadModel('Mobsubcats');
        $this->loadModel('Mobtaxrates');
        $this->loadModel('Mobprods');
        $this->loadModel('Mobprodinvs');
        $this->loadModel('Mobprdopts');
        $this->loadModel('Mobprdimgs');
        $this->loadModel('Mobords');
        $this->loadModel('Mobordprds');
        $this->loadModel('Rescafcnts');
        $this->loadModel('Mobcarts');
        $this->loadModel('Mobcartitms');
        $this->loadModel('Mobdrvs');
        $this->loadModel('Mobdrvtrans');
        $this->loadModel('Mobclis');
        $this->loadModel('Mobclitrans');
        $this->loadModel('Mobcabs');

        $this->FldsCountries = ['Countries.id', 'Countries.country_name', 'Countries.country_printable_name', 'Countries.country_iso3', 'Countries.country_numcode', 'Countries.region_id', 'Countries.display_order', 'Countries.created', 'Countries.modified'];
        $this->FldsStates = ['States.id', 'States.state_name', 'States.country_iso3', 'States.region_id', 'States.display_order', 'States.created', 'States.modified'];
        $this->FldsZipcodes = ['Zipcodes.id', 'Zipcodes.city', 'Zipcodes.state', 'Zipcodes.state_name', 'Zipcodes.country_iso2', 'Zipcodes.country_iso3', 'Zipcodes.country_name', 'Zipcodes.lat', 'Zipcodes.lng', 'Zipcodes.created', 'Zipcodes.modified'];
        $this->FldsProfiles = ['Profiles.id', 'Profiles.role_id', 'Profiles.username', 'Profiles.password', 'Profiles.verify_password', 'Profiles.name', 'Profiles.firstname', 'Profiles.lastname', 'Profiles.email', 'Profiles.website', 'Profiles.address', 'Profiles.address2', 'Profiles.phone', 'Profiles.phone_code', 'Profiles.pn_verify', 'Profiles.code_sent', 'Profiles.sent_value', 'Profiles.fax', 'Profiles.has_logo', 'Profiles.logo_text', 'Profiles.logo_img', 'Profiles.logo_w', 'Profiles.logo_h', 'Profiles.self_img', 'Profiles.self_w', 'Profiles.self_h', 'Profiles.img_host', 'Profiles.currency', 'Profiles.zipcode', 'Profiles.country_id', 'Profiles.country_name', 'Profiles.state_id', 'Profiles.state_name', 'Profiles.city_name', 'Profiles.local_name', 'Profiles.group_id', 'Profiles.profile_path', 'Profiles.activation_key', 'Profiles.status', 'Profiles.banned', 'Profiles.note', 'Profiles.timezone', 'Profiles.fbase_id', 'Profiles.fbase_creds', 'Profiles.twit_id', 'Profiles.twit_creds', 'Profiles.fb_id', 'Profiles.fb_creds', 'Profiles.aws_id', 'Profiles.aws_creds', 'Profiles.google_id', 'Profiles.google_creds', 'Profiles.notifications', 'Profiles.balance', 'Profiles.data', 'Profiles.created', 'Profiles.modified'];
        $this->FldsMobapps = ['Mobapps.id', 'Mobapps.app_name', 'Mobapps.app_desc', 'Mobapps.gleapp_id', 'Mobapps.gleapp_url', 'Mobapps.aplapp_id', 'Mobapps.aplapp_url', 'Mobapps.created', 'Mobapps.modified'];
        $this->FldsMobcabs = ['Mobcabs.id', 'Mobcabs.drv_id', 'Mobcabs.drv_name', 'Mobcabs.drv_phone', 'Mobcabs.drv_email', 'Mobcabs.drv_img', 'Mobcabs.drv_img_w', 'Mobcabs.drv_img_h', 'Mobcabs.drv_lat', 'Mobcabs.drv_lng', 'Mobcabs.vmodel', 'Mobcabs.vmanyr', 'Mobcabs.vseats', 'Mobcabs.vlicplat', 'Mobcabs.cli_id', 'Mobcabs.cli_name', 'Mobcabs.cli_phone', 'Mobcabs.cli_email', 'Mobcabs.cli_img', 'Mobcabs.cli_img_w', 'Mobcabs.cli_img_h', 'Mobcabs.cli_lat', 'Mobcabs.cli_lng', 'Mobcabs.start_addr', 'Mobcabs.start_addr2', 'Mobcabs.start_place', 'Mobcabs.start_lat', 'Mobcabs.start_lng', 'Mobcabs.dest_addr', 'Mobcabs.dest_addr2', 'Mobcabs.dest_place', 'Mobcabs.dest_lat', 'Mobcabs.dest_lng', 'Mobcabs.cabpickedup', 'Mobcabs.cabfinish', 'Mobcabs.pcabfr', 'Mobcabs.pcabto', 'Mobcabs.distance', 'Mobcabs.units', 'Mobcabs.is_taxi', 'Mobcabs.is_bike', 'Mobcabs.is_car', 'Mobcabs.car_seats', 'Mobcabs.taxi_status', 'Mobcabs.is_deli', 'Mobcabs.order_id', 'Mobcabs.ord_subtotal', 'Mobcabs.ord_ship', 'Mobcabs.ord_total', 'Mobcabs.deli_status', 'Mobcabs.keep_hot', 'Mobcabs.keep_cool', 'Mobcabs.cabprice', 'Mobcabs.cabtax', 'Mobcabs.cabtotal', 'Mobcabs.currency', 'Mobcabs.by_cash', 'Mobcabs.payment_method', 'Mobcabs.card_owner', 'Mobcabs.card_number', 'Mobcabs.card_code', 'Mobcabs.card_year', 'Mobcabs.card_month', 'Mobcabs.authorization', 'Mobcabs.transaction', 'Mobcabs.clidevinfo', 'Mobcabs.drvdevinfo', 'Mobcabs.status', 'Mobcabs.cancelled', 'Mobcabs.created', 'Mobcabs.modified'];
        $this->FldsMobcarts = ['Mobcarts.id', 'Mobcarts.session_id', 'Mobcarts.user_id', 'Mobcarts.email', 'Mobcarts.phone', 'Mobcarts.devinfo', 'Mobcarts.created', 'Mobcarts.modified'];
        $this->FldsMobcartitms = ['Mobcartitms.id', 'Mobcartitms.cart_id', 'Mobcartitms.prod_id', 'Mobcartitms.prdopt_id', 'Mobcartitms.note', 'Mobcartitms.qty', 'Mobcartitms.created', 'Mobcartitms.modified'];
        $this->FldsMobclis = ['Mobclis.id', 'Mobclis.user_id', 'Mobclis.cli_code', 'Mobclis.cli_name', 'Mobclis.cli_email', 'Mobclis.cli_phone', 'Mobclis.cli_fax', 'Mobclis.cli_addr', 'Mobclis.cli_addr2', 'Mobclis.cli_city', 'Mobclis.cli_zip', 'Mobclis.cli_state', 'Mobclis.cli_country', 'Mobclis.home_lat', 'Mobclis.home_lng', 'Mobclis.cli_lat', 'Mobclis.cli_lng', 'Mobclis.cli_status', 'Mobclis.cli_img', 'Mobclis.img_w', 'Mobclis.img_h', 'Mobclis.up_img', 'Mobclis.up_img_w', 'Mobclis.up_img_h', 'Mobclis.nid_info', 'Mobclis.nid_name', 'Mobclis.nid_nbr', 'Mobclis.nid_bplace', 'Mobclis.nid_bdate', 'Mobclis.nid_date', 'Mobclis.nid_img', 'Mobclis.nid_img_w', 'Mobclis.nid_img_h', 'Mobclis.cli_verify', 'Mobclis.verify_date', 'Mobclis.verify_note', 'Mobclis.bcntry_code', 'Mobclis.scntry_code', 'Mobclis.currency', 'Mobclis.billing_phone', 'Mobclis.billing_name', 'Mobclis.billing_addr', 'Mobclis.billing_addr2', 'Mobclis.billing_city', 'Mobclis.billing_zip', 'Mobclis.billing_state', 'Mobclis.billing_country', 'Mobclis.shipping_phone', 'Mobclis.shipping_name', 'Mobclis.shipping_addr', 'Mobclis.shipping_addr2', 'Mobclis.shipping_city', 'Mobclis.shipping_zip', 'Mobclis.shipping_state', 'Mobclis.shipping_country', 'Mobclis.payment_method', 'Mobclis.card_owner', 'Mobclis.card_number', 'Mobclis.card_code', 'Mobclis.card_year', 'Mobclis.card_month', 'Mobclis.authorization', 'Mobclis.transaction', 'Mobclis.balance', 'Mobclis.last_acc_ip', 'Mobclis.last_acc_token', 'Mobclis.devinfo', 'Mobclis.created', 'Mobclis.modified'];
        $this->FldsMobclitrans = ['Mobclitrans.id', 'Mobclitrans.user_id', 'Mobclitrans.cli_id', 'Mobclitrans.amount', 'Mobclitrans.upfee', 'Mobclitrans.total', 'Mobclitrans.balanced', 'Mobclitrans.currency', 'Mobclitrans.comment', 'Mobclitrans.card_owner', 'Mobclitrans.card_number', 'Mobclitrans.card_code', 'Mobclitrans.card_year', 'Mobclitrans.card_month', 'Mobclitrans.authorization', 'Mobclitrans.transaction', 'Mobclitrans.status', 'Mobclitrans.created', 'Mobclitrans.modified'];
        $this->FldsMobdrvs = ['Mobdrvs.id', 'Mobdrvs.user_id', 'Mobdrvs.drv_code', 'Mobdrvs.drv_name', 'Mobdrvs.drv_email', 'Mobdrvs.drv_phone', 'Mobdrvs.drv_fax', 'Mobdrvs.drv_addr', 'Mobdrvs.drv_addr2', 'Mobdrvs.drv_city', 'Mobdrvs.drv_zip', 'Mobdrvs.drv_state', 'Mobdrvs.drv_country', 'Mobdrvs.home_lat', 'Mobdrvs.home_lng', 'Mobdrvs.drv_lat', 'Mobdrvs.drv_lng', 'Mobdrvs.drv_status', 'Mobdrvs.drv_img', 'Mobdrvs.img_w', 'Mobdrvs.img_h', 'Mobdrvs.up_img', 'Mobdrvs.up_img_w', 'Mobdrvs.up_img_h', 'Mobdrvs.bike', 'Mobdrvs.car', 'Mobdrvs.ca_vmodel', 'Mobdrvs.ca_vmanyr', 'Mobdrvs.ca_vlicplat', 'Mobdrvs.ca_vregdat', 'Mobdrvs.ca_seats', 'Mobdrvs.ca_vown_name', 'Mobdrvs.ca_vown_nid', 'Mobdrvs.ca_vimg', 'Mobdrvs.ca_vimg_w', 'Mobdrvs.ca_vimg_h', 'Mobdrvs.bi_vmodel', 'Mobdrvs.bi_vmanyr', 'Mobdrvs.bi_vlicplat', 'Mobdrvs.bi_vregdat', 'Mobdrvs.bi_vown_name', 'Mobdrvs.bi_vown_nid', 'Mobdrvs.bi_vimg', 'Mobdrvs.bi_vimg_w', 'Mobdrvs.bi_vimg_h', 'Mobdrvs.ca_drvlic_info', 'Mobdrvs.ca_drvlic_name', 'Mobdrvs.ca_drvlic_nbr', 'Mobdrvs.ca_drvlic_date', 'Mobdrvs.ca_drvlic_img', 'Mobdrvs.ca_drvlic_img_w', 'Mobdrvs.ca_drvlic_img_h', 'Mobdrvs.bi_drvlic_info', 'Mobdrvs.bi_drvlic_name', 'Mobdrvs.bi_drvlic_nbr', 'Mobdrvs.bi_drvlic_date', 'Mobdrvs.bi_drvlic_img', 'Mobdrvs.bi_drvlic_img_w', 'Mobdrvs.bi_drvlic_img_h', 'Mobdrvs.nid_info', 'Mobdrvs.nid_name', 'Mobdrvs.nid_nbr', 'Mobdrvs.nid_bplace', 'Mobdrvs.nid_bdate', 'Mobdrvs.nid_date', 'Mobdrvs.nid_img', 'Mobdrvs.nid_img_w', 'Mobdrvs.nid_img_h', 'Mobdrvs.drv_verify', 'Mobdrvs.verify_date', 'Mobdrvs.verify_note', 'Mobdrvs.bcntry_code', 'Mobdrvs.scntry_code', 'Mobdrvs.currency', 'Mobdrvs.billing_phone', 'Mobdrvs.billing_name', 'Mobdrvs.billing_addr', 'Mobdrvs.billing_addr2', 'Mobdrvs.billing_city', 'Mobdrvs.billing_zip', 'Mobdrvs.billing_state', 'Mobdrvs.billing_country', 'Mobdrvs.shipping_phone', 'Mobdrvs.shipping_name', 'Mobdrvs.shipping_addr', 'Mobdrvs.shipping_addr2', 'Mobdrvs.shipping_city', 'Mobdrvs.shipping_zip', 'Mobdrvs.shipping_state', 'Mobdrvs.shipping_country', 'Mobdrvs.payment_method', 'Mobdrvs.card_owner', 'Mobdrvs.card_number', 'Mobdrvs.card_code', 'Mobdrvs.card_year', 'Mobdrvs.card_month', 'Mobdrvs.authorization', 'Mobdrvs.transaction', 'Mobdrvs.balance', 'Mobdrvs.last_acc_ip', 'Mobdrvs.last_acc_token', 'Mobdrvs.devinfo', 'Mobdrvs.created', 'Mobdrvs.modified'];
        $this->FldsMobdrvtrans = ['Mobdrvtrans.id', 'Mobdrvtrans.user_id', 'Mobdrvtrans.drv_id', 'Mobdrvtrans.amount', 'Mobdrvtrans.upfee', 'Mobdrvtrans.total', 'Mobdrvtrans.balanced', 'Mobdrvtrans.currency', 'Mobdrvtrans.comment', 'Mobdrvtrans.card_owner', 'Mobdrvtrans.card_number', 'Mobdrvtrans.card_code', 'Mobdrvtrans.card_year', 'Mobdrvtrans.card_month', 'Mobdrvtrans.authorization', 'Mobdrvtrans.transaction', 'Mobdrvtrans.status', 'Mobdrvtrans.created', 'Mobdrvtrans.modified'];
        $this->FldsMobstores = ['Mobstores.id', 'Mobstores.user_id', 'Mobstores.store_code', 'Mobstores.store_name', 'Mobstores.store_email', 'Mobstores.store_phone', 'Mobstores.store_fax', 'Mobstores.store_addr', 'Mobstores.store_addr2', 'Mobstores.store_city', 'Mobstores.store_zip', 'Mobstores.store_state', 'Mobstores.store_country', 'Mobstores.currency', 'Mobstores.store_lat', 'Mobstores.store_lng', 'Mobstores.rescaf', 'Mobstores.rescaf_tabs', 'Mobstores.rescaf_take', 'Mobstores.cvsmart', 'Mobstores.pharmacy', 'Mobstores.logo_img', 'Mobstores.logo_w', 'Mobstores.logo_h', 'Mobstores.up_logo_img', 'Mobstores.up_logo_w', 'Mobstores.up_logo_h', 'Mobstores.bcntry_code', 'Mobstores.scntry_code', 'Mobstores.billing_phone', 'Mobstores.billing_name', 'Mobstores.billing_addr', 'Mobstores.billing_addr2', 'Mobstores.billing_city', 'Mobstores.billing_zip', 'Mobstores.billing_state', 'Mobstores.billing_country', 'Mobstores.shipping_phone', 'Mobstores.shipping_name', 'Mobstores.shipping_addr', 'Mobstores.shipping_addr2', 'Mobstores.shipping_city', 'Mobstores.shipping_zip', 'Mobstores.shipping_state', 'Mobstores.shipping_country', 'Mobstores.payment_method', 'Mobstores.card_owner', 'Mobstores.card_number', 'Mobstores.card_code', 'Mobstores.card_year', 'Mobstores.card_month', 'Mobstores.authorization', 'Mobstores.transaction', 'Mobstores.balance', 'Mobstores.acc_ip', 'Mobstores.acc_token', 'Mobstores.devinfo', 'Mobstores.created', 'Mobstores.modified'];
        $this->FldsMobstoretrans = ['Mobstoretrans.id', 'Mobstoretrans.user_id', 'Mobstoretrans.store_id', 'Mobstoretrans.amount', 'Mobstoretrans.upfee', 'Mobstoretrans.total', 'Mobstoretrans.balanced', 'Mobstoretrans.comment', 'Mobstoretrans.card_owner', 'Mobstoretrans.card_number', 'Mobstoretrans.card_code', 'Mobstoretrans.card_year', 'Mobstoretrans.card_month', 'Mobstoretrans.authorization', 'Mobstoretrans.transaction', 'Mobstoretrans.status', 'Mobstoretrans.created', 'Mobstoretrans.modified'];
        $this->FldsMobstrusrs = ['Mobstrusrs.id', 'Mobstrusrs.store_id', 'Mobstrusrs.store_code', 'Mobstrusrs.usr_name', 'Mobstrusrs.usr_code', 'Mobstrusrs.usr_passcode', 'Mobstrusrs.passcode_bk', 'Mobstrusrs.is_pos', 'Mobstrusrs.is_inv', 'Mobstrusrs.is_kitchen', 'Mobstrusrs.is_frontst', 'Mobstrusrs.active', 'Mobstrusrs.dev_ip', 'Mobstrusrs.dev_token', 'Mobstrusrs.status', 'Mobstrusrs.staff_img', 'Mobstrusrs.img_w', 'Mobstrusrs.img_h', 'Mobstrusrs.phone', 'Mobstrusrs.name', 'Mobstrusrs.addr', 'Mobstrusrs.addr2', 'Mobstrusrs.city', 'Mobstrusrs.zip', 'Mobstrusrs.state', 'Mobstrusrs.country', 'Mobstrusrs.devinfo', 'Mobstrusrs.created', 'Mobstrusrs.modified'];
        $this->FldsMobcats = ['Mobcats.id', 'Mobcats.store_id', 'Mobcats.name', 'Mobcats.slug', 'Mobcats.description', 'Mobcats.sort', 'Mobcats.active', 'Mobcats.created', 'Mobcats.modified'];
        $this->FldsMobsubcats = ['Mobsubcats.id', 'Mobsubcats.store_id', 'Mobsubcats.cat_id', 'Mobsubcats.cat_name', 'Mobsubcats.name', 'Mobsubcats.slug', 'Mobsubcats.description', 'Mobsubcats.sort', 'Mobsubcats.active', 'Mobsubcats.created', 'Mobsubcats.modified'];
        $this->FldsMobprods = ['Mobprods.id', 'Mobprods.store_id', 'Mobprods.store_name', 'Mobprods.cat_id', 'Mobprods.cat_name', 'Mobprods.subcat_id', 'Mobprods.subcat_name', 'Mobprods.name', 'Mobprods.slug', 'Mobprods.description', 'Mobprods.prod_ico', 'Mobprods.ico_w', 'Mobprods.ico_h', 'Mobprods.prod_imga', 'Mobprods.imga_w', 'Mobprods.imga_h', 'Mobprods.prod_imgb', 'Mobprods.imgb_w', 'Mobprods.imgb_h', 'Mobprods.prod_imgc', 'Mobprods.imgc_w', 'Mobprods.imgc_h', 'Mobprods.prod_imgd', 'Mobprods.imgd_w', 'Mobprods.imgd_h', 'Mobprods.prod_imge', 'Mobprods.imge_w', 'Mobprods.imge_h', 'Mobprods.prod_imgf', 'Mobprods.imgf_w', 'Mobprods.imgf_h', 'Mobprods.prod_imgg', 'Mobprods.imgg_w', 'Mobprods.imgg_h', 'Mobprods.prod_imgh', 'Mobprods.imgh_w', 'Mobprods.imgh_h', 'Mobprods.weight', 'Mobprods.weiunit', 'Mobprods.size_w', 'Mobprods.size_h', 'Mobprods.size_d', 'Mobprods.sizeunit', 'Mobprods.views', 'Mobprods.sort', 'Mobprods.active', 'Mobprods.taxrate_id', 'Mobprods.taxrate', 'Mobprods.pricesell', 'Mobprods.pricebuy', 'Mobprods.prod_sku', 'Mobprods.prod_ref', 'Mobprods.prod_code', 'Mobprods.prod_cotype', 'Mobprods.stockunits', 'Mobprods.minstock', 'Mobprods.suppl_id', 'Mobprods.loc_lat', 'Mobprods.loc_lng', 'Mobprods.created', 'Mobprods.modified'];
        $this->FldsMobprodinvs = ['Mobprodinvs.id', 'Mobprodinvs.store_id', 'Mobprodinvs.prod_id', 'Mobprodinvs.prod_code', 'Mobprodinvs.quantity', 'Mobprodinvs.inv', 'Mobprodinvs.kitchen', 'Mobprodinvs.front', 'Mobprodinvs.pos', 'Mobprodinvs.inv_id', 'Mobprodinvs.kitchen_id', 'Mobprodinvs.front_id', 'Mobprodinvs.pos_id', 'Mobprodinvs.note', 'Mobprodinvs.created', 'Mobprodinvs.modified'];
        $this->FldsMobprdopts = ['Mobprdopts.id', 'Mobprdopts.prod_id', 'Mobprdopts.optname', 'Mobprdopts.optvalue', 'Mobprdopts.description', 'Mobprdopts.image', 'Mobprdopts.color', 'Mobprdopts.price', 'Mobprdopts.weight', 'Mobprdopts.size_w', 'Mobprdopts.size_h', 'Mobprdopts.size_d', 'Mobprdopts.views', 'Mobprdopts.sort', 'Mobprdopts.active', 'Mobprdopts.created', 'Mobprdopts.modified'];
        $this->FldsMobprdimgs = ['Mobprdimgs.id', 'Mobprdimgs.prod_id', 'Mobprdimgs.img_title', 'Mobprdimgs.img_host', 'Mobprdimgs.img_path', 'Mobprdimgs.img_w', 'Mobprdimgs.img_h', 'Mobprdimgs.sort', 'Mobprdimgs.created', 'Mobprdimgs.modified'];
        $this->FldsMobords = ['Mobords.id', 'Mobords.store_id', 'Mobords.store_name', 'Mobords.sess_id', 'Mobords.pos_id', 'Mobords.front_id', 'Mobords.kitchen_id', 'Mobords.inv_id', 'Mobords.secpos_id', 'Mobords.secfront_id', 'Mobords.seckit_id', 'Mobords.secinv_id', 'Mobords.rescaf', 'Mobords.rescaf_tab', 'Mobords.rescaf_take', 'Mobords.cvsmart', 'Mobords.pharmacy', 'Mobords.first_name', 'Mobords.last_name', 'Mobords.email', 'Mobords.phone', 'Mobords.billing_address', 'Mobords.billing_address2', 'Mobords.billing_city', 'Mobords.billing_zip', 'Mobords.billing_state', 'Mobords.billing_country', 'Mobords.shipping_address', 'Mobords.shipping_address2', 'Mobords.shipping_city', 'Mobords.shipping_zip', 'Mobords.shipping_state', 'Mobords.shipping_country', 'Mobords.weight', 'Mobords.item_count', 'Mobords.subtotal', 'Mobords.tax', 'Mobords.total', 'Mobords.cash', 'Mobords.cashchg', 'Mobords.shipfee', 'Mobords.status', 'Mobords.rescaf_checkout', 'Mobords.rescafcheckout_log', 'Mobords.rescaf_paid', 'Mobords.rescafpaid_log', 'Mobords.rescaf_counted', 'Mobords.paid', 'Mobords.shipped', 'Mobords.shipping_method', 'Mobords.payment_method', 'Mobords.card_owner', 'Mobords.card_number', 'Mobords.card_code', 'Mobords.card_year', 'Mobords.card_month', 'Mobords.authorization', 'Mobords.transaction', 'Mobords.ip_address', 'Mobords.remote_host', 'Mobords.referer_cookie', 'Mobords.referer_session', 'Mobords.request_uri', 'Mobords.comment', 'Mobords.note', 'Mobords.lft', 'Mobords.rght', 'Mobords.created_by', 'Mobords.modified_by', 'Mobords.created', 'Mobords.modified'];
        $this->FldsMobordprds = ['Mobordprds.id', 'Mobordprds.order_id', 'Mobordprds.prod_id', 'Mobordprds.prod_code', 'Mobordprds.prdopt_id', 'Mobordprds.prd_name', 'Mobordprds.prdopt_name', 'Mobordprds.color', 'Mobordprds.quantity', 'Mobordprds.weight', 'Mobordprds.price', 'Mobordprds.tax', 'Mobordprds.subtotal', 'Mobordprds.kitchen_need', 'Mobordprds.kitchen_accept', 'Mobordprds.kitchen_done', 'Mobordprds.kitchen_status', 'Mobordprds.kitchen_id', 'Mobordprds.inv_need', 'Mobordprds.inv_accept', 'Mobordprds.inv_done', 'Mobordprds.inv_status', 'Mobordprds.inv_id', 'Mobordprds.front_id', 'Mobordprds.front_status', 'Mobordprds.delivered', 'Mobordprds.secfront_id', 'Mobordprds.secfront_status', 'Mobordprds.seckit_id', 'Mobordprds.seckit_status', 'Mobordprds.secinv_id', 'Mobordprds.secinv_status', 'Mobordprds.secpos_id', 'Mobordprds.secpos_status', 'Mobordprds.rescaf', 'Mobordprds.rescaf_tab', 'Mobordprds.rescaf_take', 'Mobordprds.note', 'Mobordprds.lft', 'Mobordprds.rght', 'Mobordprds.created_by', 'Mobordprds.modified_by', 'Mobordprds.created', 'Mobordprds.modified'];
        $this->FldsRescafcnts = ['Rescafcnts.id', 'Rescafcnts.store_id', 'Rescafcnts.store_name', 'Rescafcnts.sess_id', 'Rescafcnts.pos_id', 'Rescafcnts.pos_name', 'Rescafcnts.pos_username', 'Rescafcnts.order_count', 'Rescafcnts.orders', 'Rescafcnts.subtotal', 'Rescafcnts.tax', 'Rescafcnts.total', 'Rescafcnts.ip_address', 'Rescafcnts.remote_host', 'Rescafcnts.comment', 'Rescafcnts.note', 'Rescafcnts.lft', 'Rescafcnts.rght', 'Rescafcnts.created_by', 'Rescafcnts.modified_by', 'Rescafcnts.created', 'Rescafcnts.modified'];
        $this->FldsMobposusrs = ['Mobposusrs.id', 'Mobposusrs.store_id', 'Mobposusrs.store_code', 'Mobposusrs.pos_name', 'Mobposusrs.pos_code', 'Mobposusrs.pos_passcode', 'Mobposusrs.passcode_bk', 'Mobposusrs.active', 'Mobposusrs.pos_ip', 'Mobposusrs.pos_token', 'Mobposusrs.status', 'Mobposusrs.staff_img', 'Mobposusrs.img_w', 'Mobposusrs.img_h', 'Mobposusrs.phone', 'Mobposusrs.name', 'Mobposusrs.addr', 'Mobposusrs.addr2', 'Mobposusrs.city', 'Mobposusrs.zip', 'Mobposusrs.state', 'Mobposusrs.country', 'Mobposusrs.devinfo', 'Mobposusrs.created', 'Mobposusrs.modified'];
        $this->FldsMobpossecs = ['Mobpossecs.id', 'Mobpossecs.pos_id', 'Mobpossecs.startcash', 'Mobpossecs.timestart', 'Mobpossecs.endcash', 'Mobpossecs.endtime', 'Mobpossecs.curcash', 'Mobpossecs.curtime', 'Mobpossecs.mgr_note', 'Mobpossecs.cashier_note', 'Mobpossecs.totcurtkt', 'Mobpossecs.totendtkt', 'Mobpossecs.is_working', 'Mobpossecs.is_break', 'Mobpossecs.is_close', 'Mobpossecs.stkupd', 'Mobpossecs.created', 'Mobpossecs.modified'];
        $this->FldsMobpostkts = ['Mobpostkts.id', 'Mobpostkts.pos_id', 'Mobpostkts.sess_id', 'Mobpostkts.first_name', 'Mobpostkts.last_name', 'Mobpostkts.email', 'Mobpostkts.phone', 'Mobpostkts.billing_address', 'Mobpostkts.billing_address2', 'Mobpostkts.billing_city', 'Mobpostkts.billing_zip', 'Mobpostkts.billing_state', 'Mobpostkts.billing_country', 'Mobpostkts.shipping_address', 'Mobpostkts.shipping_address2', 'Mobpostkts.shipping_city', 'Mobpostkts.shipping_zip', 'Mobpostkts.shipping_state', 'Mobpostkts.shipping_country', 'Mobpostkts.weight', 'Mobpostkts.item_count', 'Mobpostkts.subtotal', 'Mobpostkts.tax', 'Mobpostkts.shipping', 'Mobpostkts.total', 'Mobpostkts.cash', 'Mobpostkts.cashchg', 'Mobpostkts.shipping_method', 'Mobpostkts.payment_method', 'Mobpostkts.card_owner', 'Mobpostkts.card_number', 'Mobpostkts.card_code', 'Mobpostkts.card_year', 'Mobpostkts.card_month', 'Mobpostkts.authorization', 'Mobpostkts.transaction', 'Mobpostkts.status', 'Mobpostkts.ip_address', 'Mobpostkts.remote_host', 'Mobpostkts.note', 'Mobpostkts.tktpdf', 'Mobpostkts.created', 'Mobpostkts.modified'];
        $this->FldsMobtktdets = ['Mobtktdets.id', 'Mobtktdets.sess_id', 'Mobtktdets.tkt_id', 'Mobtktdets.prod_id', 'Mobtktdets.prd_name', 'Mobtktdets.prdopt_id', 'Mobtktdets.prdopt_name', 'Mobtktdets.color', 'Mobtktdets.quantity', 'Mobtktdets.weight', 'Mobtktdets.price', 'Mobtktdets.tax', 'Mobtktdets.subtotal', 'Mobtktdets.note', 'Mobtktdets.stkupd', 'Mobtktdets.created', 'Mobtktdets.modified'];
        $this->FldsMobsuppls = ['Mobsuppls.id', 'Mobsuppls.store_id', 'Mobsuppls.searchkey', 'Mobsuppls.taxid', 'Mobsuppls.name', 'Mobsuppls.maxdebt', 'Mobsuppls.address', 'Mobsuppls.address2', 'Mobsuppls.zip', 'Mobsuppls.city', 'Mobsuppls.state', 'Mobsuppls.region', 'Mobsuppls.country', 'Mobsuppls.firstname', 'Mobsuppls.lastname', 'Mobsuppls.email', 'Mobsuppls.phone', 'Mobsuppls.phone2', 'Mobsuppls.fax', 'Mobsuppls.notes', 'Mobsuppls.curdate', 'Mobsuppls.curdebt', 'Mobsuppls.vatid', 'Mobsuppls.created', 'Mobsuppls.modified'];
        $this->FldsMobtaxrates = ['Mobtaxrates.id', 'Mobtaxrates.store_id', 'Mobtaxrates.name', 'Mobtaxrates.taxrate', 'Mobtaxrates.sort', 'Mobtaxrates.created', 'Mobtaxrates.modified'];
        
        $MathCapDef = array( 'operand' => '+', 'minNumber' => 1, 'maxNumber' => 5, 'numberOfVariables' => 3 );
        $this->MathCaptcha = new MathCaptchaComponent($MathCapDef, $this);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['postoken', 'addpos', 'editpos', 'posqry', 'addstore', 'delstore', 'editstore', 'getstore', 'storeqry']);
    }

    private function verifyPOStoken($token)
    {
        $user=false;
        if ($token) {
            $payload = JWT::decode($token, Security::getSalt(),array('HS256'));
            if (isset($payload->user->id)) {
                $struser = ($this->Mobstrusrs->exists(['id' => $payload->user->id]))? $this->Mobstrusrs->get($payload->user->id)->toArray() : array();
                if ($struser) {
                    $loginsessid=md5($token);
                    $loginactions=$this->Useractions->find('all',array('recursive'=>0, 'conditions'=>array('AND'=>array('Useractions.session_id' => $loginsessid, 
                                    'Useractions.action_name' => 'MobilePosLogin', 'Useractions.mobapp' => $payload->user->mobapp))));
                    if ($loginactions->count()) {
                        $user=$struser;
                        $user['acts']=$loginactions->first()->toArray();
                        $user['mobapp']=$payload->user->mobapp;
                    }
                }
            }
        }
        return $user;
    }

    protected function generatePOSToken($struser, $mobapp)
    {
        $payload = ['id' => $struser['id'], 'store' => $struser['store_id'], 'name' => $struser['name'], 'posname' => $struser['usr_name'], 'timezone' => $struser['user']['timezone'], 'mobapp' => $mobapp];
        $expiry = 39 * 24 * 3600;
        $buffer = 5 * 60; 
        $exp = time() + rand($expiry, $expiry + $buffer);
        return JWT::encode([ 'iss' => Configure::read('Site.title'), 'sub' => $struser['id'], 'user' => $payload, 'iat' => time(), 'exp' => $exp, ], Security::getSalt()); 
    }

    public function postoken()
    {
        $this->viewBuilder()->setLayout('ajax');
        $thisdata = $this->getRequest()->getData();
        $mobapp = $thisdata['mobapp'];
        $token = '';
        $struser = [];
        $usrstore = [];
        $usrsess = [];
        $thestore = [];
        $theuser = [];
        if (!empty($thisdata['store_code']) || !empty($thisdata['usr_code'])) {
            if (empty($thisdata['store_code'])) {
                $allresusr=$this->Mobstrusrs->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Mobstrusrs.usr_code' => $thisdata['usr_code']))));
                if ($allresusr->count() == 1) {
                    $struser = $allresusr->first()->toArray();
                    $allstore=$this->Mobstores->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Mobstores.store_code' => $struser['store_code']))));
                    if ($allstore->count() == 1) {
                        $thestore = $allstore->first()->toArray();
                        $theuser = ($this->Profiles->exists(['id' => $thestore['user_id']]))? $this->Profiles->get($thestore['user_id'])->toArray() : array();
                    }
                }
            } else {
                $allstore=$this->Mobstores->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Mobstores.store_code' => $thisdata['store_code']))));
                if ($allstore->count() == 1) {
                    $thestore = $allstore->first()->toArray();
                    $theuser = ($this->Profiles->exists(['id' => $thestore['user_id']]))? $this->Profiles->get($thestore['user_id'])->toArray() : array();
                }
            }
            if (!empty($thestore) && !empty($theuser)) {
                if (!empty($thisdata['usr_code']) && !empty($thisdata['usr_passcode'])) {
                    $struser = false;
                    $allresusr=$this->Mobstrusrs->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Mobstrusrs.usr_code' => $thisdata['usr_code']))));
                    $passcodeverify = false;
                    if ($allresusr->count() == 1) {
                        $struser = $allresusr->first()->toArray();
                        $passcodeverify = (new DefaultPasswordHasher)->check($thisdata['usr_passcode'],$struser['usr_passcode']);
                        if ($struser && $struser['store_id'] == $thestore['id'] && $passcodeverify) {
                            $respos = $struser;
                            $respos['store']=$thestore;
                            $respos['user']=$theuser;
                            $token = $this->generatePOSToken($respos, $mobapp);
                            if ($token) {
                                $initpos = $this->Mobstrusrs->get($struser['id']);$this->Mobstrusrs->patchEntity($initpos, ['token' => $token]);
                                $this->Mobstrusrs->save($initpos);
                                $inituseract = $this->Useractions->newEntity();
                                $actionary=array();
                                $actionary['user_id']=$struser['id'];
                                $actionary['action_name']='MobilePosLogin';
                                $actionary['session_id']=md5($token);
                                $actionary['action_ip']=$this->getRequest()->clientIp();
                                $actionary['token']=$token;
                                $actionary['mobapp']=$mobapp;
                                $actionary['modified']=date("Y-m-d H:i:s");
                                $actionary['created']=date("Y-m-d H:i:s");
                                $this->Useractions->patchEntity($inituseract, $actionary);$this->Useractions->save($inituseract);
                                $initsess = $this->Mobpossecs->newEntity();
                                $this->Mobpossecs->patchEntity($initsess, ['pos_id' => $struser['id'],
                                                                            'curtime' => date("Y-m-d H:i:s"),
                                                                            'timestart' => date("Y-m-d H:i:s"),
                                                                            ]);$this->Mobpossecs->save($initsess);
                                $sessid=$initsess->id;
                                if ($sessid) {
                                    $usrsess = $this->Mobpossecs->get($sessid);
                                }
                            }
                        } else {
                            $token = '';
                        }
                    }
                }
            }
        }
        $this->set([
            'data' => [
            'token' => $token,
            'struser' => $struser,
            'thestore' => $thestore,
            'possess' => $usrsess,
            ],
            '_serialize' => ['data'],
        ]);
        $this->set('token', $token);
    }

    public function addpos()
    {
        $this->viewBuilder()->setLayout('ajax');
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {$token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));}
        $return_code=['status' => 0, 'data' => [], 'error' => ''];
        $ajdata = $this->getRequest()->getData();
        $limit_upload_w=1024;
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                if (!empty($ajdata['store_id'])) {
                    $usrstore = ($this->Mobstores->exists(['id' => $ajdata['store_id']]))? $this->Mobstores->get($ajdata['store_id'])->toArray() : array();
                    if ($usrstore && $usrstore['user_id'] == $user['id']) {
                        $ajdata['store_code'] = $usrstore['store_code'];
                        $initpos = $this->Mobstrusrs->newEntity();
                        if (!empty($ajdata['newusrcode'])) {
                            $newposcode = substr(base64_encode(random_bytes(15)), 0, 14);
                            $ajdata['usr_code'] = $newposcode;
                        } else {
                            unset($ajdata['usr_code']);
                        }
                        if (!empty($ajdata['usr_passcode'])) {
                            $ajdata['passcode_bk'] = $newposcode;
                            $ajdata['usr_passcode'] = (new DefaultPasswordHasher)->hash($newposcode);
                        } else {
                            unset($ajdata['usr_passcode']);
                        }
                        $this->Mobstrusrs->patchEntity($initpos, $ajdata);$this->Mobstrusrs->save($initpos);
                        $id=$initpos->id;
                        $savepos = ($this->Mobstrusrs->exists(['id' => $id]))? $this->Mobstrusrs->get($id)->toArray() : array();
                        $oldpos = $savepos;
                        if (!empty($ajdata['staff_img64']) && !empty($ajdata['imgfile'])) {
                            if (!empty($oldpos['staff_img']) && file_exists('.'.$oldpos['staff_img'])) {
                                unlink('.'.$oldpos['staff_img']);
                                unlink(str_replace(['resized'],['upload'],'.'.$oldpos['staff_img']));
                            }
                            $ajdata['imgfile'] = strtolower($ajdata['imgfile']);
                            $filetype = end(explode('.', $ajdata['imgfile']));
                            if (in_array(strtolower($filetype), array('jpeg', 'jpg', 'gif', 'png'))) {
                                $textuuid = new Text();$filename = $textuuid->uuid();
                                $search  = array('-', ' ');$replace = array('_', '_');
                                $filename = str_replace($search,$replace,$filename);
                                $filename .= '.' . $filetype;
                                $fixed_height = 512;
                                $upload_dir = 'img/stores/staffs/upload/'.$savepos['id'];
                                $img_dir = 'img/stores/staffs/resized/'.$savepos['id'];
                                if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
                                if (!is_dir($img_dir)) mkdir($img_dir, 0755, true);
                                $webimg_file = '/'.$upload_dir.'/'.$filename;
                                $img_file = $upload_dir.'/'.$filename;
                                $imgfile = '/'.$img_dir.'/'.$filename;
                                $webimgfile = $img_dir.'/'.$filename;
                                $filehandle = fopen($img_file,"w");
                                fwrite($filehandle,base64_decode($ajdata['staff_img64']));
                                fclose($filehandle);
                                list($uw, $uh, $utype) = getimagesize($img_file);
                                $ratioY = $fixed_height/$uh;
                                $maxh = $fixed_height;
                                $maxw = round($ratioY * $uw);
                                $this->resize_image('resizeCrop', $img_file, $img_dir, $filename, $maxw, $maxh, 85);
                                if ($uw > $limit_upload_w) {
                                    $fixed_height=$limit_upload_w;
                                    $ratioY = $fixed_height/$uh;
                                    $maxh = $fixed_height;
                                    $maxw = round($ratioY * $uw);
                                    $this->resize_image('resizeCrop', $img_file, $upload_dir, $filename, $maxw, $maxh, 85);
                                }
                                list($stimgw, $stimgh, $imgtype) = getimagesize($webimgfile);
                                $initpos = $this->Mobstrusrs->get($savepos['id']);
                                $this->Mobstrusrs->patchEntity($initpos, ['staff_img' => $imgfile, 'img_w' => $stimgw, 'img_h' => $stimgh]);
                                if ($this->Mobstrusrs->save($initpos)) {
                                    $savepos = ($this->Mobstrusrs->exists(['id' => $id]))? $this->Mobstrusrs->get($id)->toArray() : array();
                                    $return_code=['status' => 1, 'data' => $savepos, 'error' => ''];
                                }
                            }
                        }
                        $return_code=['status' => 1, 'data' => $savepos, 'error' => ''];
                        $inituserlog = $this->Userlogs->newEntity();
                        $usrlogary=array();
                        $usrlogary['user_id']=$user['id'];
                        $usrlogary['obj_name']='PosUser_edit';
                        $usrlogary['obj_id']=$savepos['id'];
                        $usrlogary['session_id']=md5($token);
                        $usrlogary['log_ip']=$this->getRequest()->clientIp();
                        $usrlogary['token']=$token;
                        $usrlogary['mobapp']=$user['mobapp'];
                        $usrlogary['old_data']=json_encode($oldpos);
                        $usrlogary['new_data']=json_encode($savepos);
                        $usrlogary['modified']=date("Y-m-d H:i:s");
                        $usrlogary['created']=date("Y-m-d H:i:s");
                        $this->Userlogs->patchEntity($inituserlog, $usrlogary);$this->Userlogs->save($inituserlog);
                    }
                }
            }
        }
        $this->set('return_code', $return_code);
    }

    public function editpos()
    {
        $this->viewBuilder()->setLayout('ajax');
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {$token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));}
        $return_code=['status' => 0, 'data' => [], 'error' => ''];
        $ajdata = $this->getRequest()->getData();
        $limit_upload_w=1024;
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                if (!empty($ajdata['store_id']) &&  !empty($ajdata['id'])) {
                    $id=$ajdata['id'];
                    $struser = ($this->Mobstrusrs->exists(['id' => $id]))? $this->Mobstrusrs->get($id)->toArray() : array();
                    $usrstore = ($this->Mobstores->exists(['id' => $ajdata['store_id']]))? $this->Mobstores->get($ajdata['store_id'])->toArray() : array();
                    if ($usrstore && $struser && $usrstore['id'] == $struser['store_id'] && $usrstore['user_id'] == $user['id']) {
                        $ajdata['store_code'] = $usrstore['store_code'];
                        $initpos = $this->Mobstrusrs->get($id);
                        if (!empty($ajdata['newusrcode'])) {
                            $newposcode = substr(base64_encode(random_bytes(15)), 0, 14);
                            $ajdata['usr_code'] = $newposcode;
                        } else {
                            unset($ajdata['usr_code']);
                        }
                        if (!empty($ajdata['usr_passcode'])) {
                            $ajdata['passcode_bk'] = $ajdata['usr_passcode'];
                            $ajdata['usr_passcode'] = (new DefaultPasswordHasher)->hash($ajdata['usr_passcode']);
                        } else {
                            unset($ajdata['usr_passcode']);
                        }
                        $this->Mobstrusrs->patchEntity($initpos, $ajdata);$this->Mobstrusrs->save($initpos);
                        $savepos = $initpos->toArray();
                        $oldpos = $savepos;
                        if (!empty($ajdata['staff_img64']) && !empty($ajdata['imgfile'])) {
                            if (!empty($oldpos['staff_img']) && file_exists('.'.$oldpos['staff_img'])) {
                                unlink('.'.$oldpos['staff_img']);
                                unlink(str_replace(['resized'],['upload'],'.'.$oldpos['staff_img']));
                            }
                            $ajdata['imgfile'] = strtolower($ajdata['imgfile']);
                            $filetype = end(explode('.', $ajdata['imgfile']));
                            if (in_array(strtolower($filetype), array('jpeg', 'jpg', 'gif', 'png'))) {
                                $textuuid = new Text();$filename = $textuuid->uuid();
                                $search  = array('-', ' ');$replace = array('_', '_');
                                $filename = str_replace($search,$replace,$filename);
                                $filename .= '.' . $filetype;
                                $fixed_height = 512;
                                $upload_dir = 'img/stores/staffs/upload/'.$savepos['id'];
                                $img_dir = 'img/stores/staffs/resized/'.$savepos['id'];
                                if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
                                if (!is_dir($img_dir)) mkdir($img_dir, 0755, true);
                                $webimg_file = '/'.$upload_dir.'/'.$filename;
                                $img_file = $upload_dir.'/'.$filename;
                                $imgfile = '/'.$img_dir.'/'.$filename;
                                $webimgfile = $img_dir.'/'.$filename;
                                $filehandle = fopen($img_file,"w");
                                fwrite($filehandle,base64_decode($ajdata['staff_img64']));
                                fclose($filehandle);
                                list($uw, $uh, $utype) = getimagesize($img_file);
                                $ratioY = $fixed_height/$uh;
                                $maxh = $fixed_height;
                                $maxw = round($ratioY * $uw);
                                $this->resize_image('resizeCrop', $img_file, $img_dir, $filename, $maxw, $maxh, 85);
                                if ($uw > $limit_upload_w) {
                                    $fixed_height=$limit_upload_w;
                                    $ratioY = $fixed_height/$uh;
                                    $maxh = $fixed_height;
                                    $maxw = round($ratioY * $uw);
                                    $this->resize_image('resizeCrop', $img_file, $upload_dir, $filename, $maxw, $maxh, 85);
                                }
                                list($stimgw, $stimgh, $imgtype) = getimagesize($webimgfile);
                                $initpos = $this->Mobstrusrs->get($savepos['id']);
                                $this->Mobstrusrs->patchEntity($initpos, ['staff_img' => $imgfile, 'img_w' => $stimgw, 'img_h' => $stimgh]);
                                if ($this->Mobstrusrs->save($initpos)) {
                                    $savepos = ($this->Mobstrusrs->exists(['id' => $id]))? $this->Mobstrusrs->get($id)->toArray() : array();
                                    $return_code=['status' => 1, 'data' => $savepos, 'error' => ''];
                                }
                            }
                        }
                        $return_code=['status' => 1, 'data' => $savepos, 'error' => ''];
                        $inituserlog = $this->Userlogs->newEntity();
                        $usrlogary=array();
                        $usrlogary['user_id']=$user['id'];
                        $usrlogary['obj_name']='PosUser_edit';
                        $usrlogary['obj_id']=$savepos['id'];
                        $usrlogary['session_id']=md5($token);
                        $usrlogary['log_ip']=$this->getRequest()->clientIp();
                        $usrlogary['token']=$token;
                        $usrlogary['mobapp']=$user['mobapp'];
                        $usrlogary['old_data']=json_encode($oldpos);
                        $usrlogary['new_data']=json_encode($savepos);
                        $usrlogary['modified']=date("Y-m-d H:i:s");
                        $usrlogary['created']=date("Y-m-d H:i:s");
                        $this->Userlogs->patchEntity($inituserlog, $usrlogary);$this->Userlogs->save($inituserlog);
                    }
                }
            }
        }
        $this->set('return_code', $return_code);
    }

    public function posqry()
    {
        $this->viewBuilder()->setLayout('ajax');
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {$token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));}
        $return_code=['status' => 0, 'data' => [], 'error' => ''];
        $ajdata = $this->getRequest()->getData();
        $limit_upload_w=1024;
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                $usrstore = ($this->Mobstores->exists(['id' => $ajdata['store_id']]))? $this->Mobstores->get($ajdata['store_id'])->toArray() : array();
                if ($usrstore && $ajdata['qrymode'] == 'all' && !empty($ajdata['store_id']) && $usrstore['user_id'] == $user['id']) {
                    $allposusr = $this->Mobstrusrs->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Mobstrusrs.store_id' => $ajdata['store_id'], 
                                                            'OR' => array('Mobstrusrs.usr_name LIKE ' => '%'.$ajdata['filter'].'%', 'Mobstrusrs.name LIKE ' => '%'.$ajdata['filter'].'%',
                                                            'Mobstrusrs.phone LIKE ' => '%'.$ajdata['filter'].'%', 'Mobstrusrs.addr LIKE ' => '%'.$ajdata['filter'].'%',
                                                            'Mobstrusrs.addr2 LIKE ' => '%'.$ajdata['filter'].'%', 'Mobstrusrs.zip LIKE ' => '%'.$ajdata['filter'].'%',
                                                            'Mobstrusrs.city LIKE ' => '%'.$ajdata['filter'].'%', 'Mobstrusrs.country LIKE ' => '%'.$ajdata['filter'].'%')))))->toArray();
                    $return_code=['status' => 1, 'data' => $allposusr, 'error' => ''];
                }
                if ($ajdata['qrymode'] == 'by_id' && !empty($ajdata['id'])) {
                    $resposusr = ($this->Mobstrusrs->exists(['id' => $ajdata['id']]))? $this->Mobstrusrs->get($ajdata['id'])->toArray() : array();
                    $usrstore = ($this->Mobstores->exists(['id' => $resposusr['store_id']]))? $this->Mobstores->get($resposusr['store_id'])->toArray() : array();
                    if ($usrstore['user_id'] == $user['id']) {
                        $return_code=['status' => 1, 'data' => $resposusr, 'error' => ''];
                    }
                }
                if ($ajdata['qrymode'] == 'sessbypos' && !empty($ajdata['pos_id'])) {
                    $allsess=$this->Mobpossecs->find('all',array('recursive'=>0,'limit' => 31,'order'=>array('Mobpossecs.created DESC'), 'conditions'=>array('AND'=>array('Mobpossecs.pos_id' => $ajdata['pos_id']))))->toArray();
                    $return_code=['status' => 1, 'data' => $allsess, 'error' => ''];
                }

            }
        }
        $this->set('return_code', $return_code);
    }

    public function addstore()
    {
        $this->viewBuilder()->setLayout('ajax');
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {$token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));}
        $return_code=['status' => 0, 'data' => [], 'error' => ''];
        $ajdata = $this->getRequest()->getData();
        $limit_upload_w=1024;
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                if (!empty($ajdata)) {
                    $initstore = $this->Mobstores->newEntity();
                    $ajdata['user_id'] = $user['id'];
                    $ajdata['store_code'] = substr(base64_encode(random_bytes(15)), 0, 14);
                    $this->Mobstores->patchEntity($initstore, $ajdata);
                    if ($this->Mobstores->save($initstore)) {
                        $id=$initstore->id;
                        $savestore = ($this->Mobstores->exists(['id' => $id]))? $this->Mobstores->get($id)->toArray() : array();
                        $allstrusr=$this->Mobstrusrs->find('all',array('recursive'=>0,
                        'conditions'=>array('AND'=>array('Mobstrusrs.store_id' => $savestore['id']))));
                        if ($allstrusr->count() > 0) {
                            $savestore['storeusers'] = $allstrusr->toArray();
                            // $savestore['storeusers'] = [];
                        } else {
                            $savestore['storeusers'] = [];
                        }
                        $return_code=['status' => 1, 'data' => $savestore, 'error' => ''];
                        if ($savestore) {
                            if (!empty($ajdata['logo_img64']) && !empty($ajdata['logofile'])) {
                                $ajdata['logofile'] = strtolower($ajdata['logofile']);
                                $filetype = end(explode('.', $ajdata['logofile']));
                                if (in_array(strtolower($filetype), array('jpeg', 'jpg', 'gif', 'png'))) {
                                    $textuuid = new Text();$filename = $textuuid->uuid();
                                    $search  = array('-', ' ');$replace = array('_', '_');
                                    $filename = str_replace($search,$replace,$filename);
                                    $filename .= '.' . $filetype;
                                    $fixed_height = 512;
                                    $upload_dir = 'img/stores/logos/upload/'.$savestore['id'];
                                    $img_dir = 'img/stores/logos/resized/'.$savestore['id'];
                                    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
                                    if (!is_dir($img_dir)) mkdir($img_dir, 0755, true);
                                    $webimg_file = '/'.$upload_dir.'/'.$filename;
                                    $img_file = $upload_dir.'/'.$filename;
                                    $logofile = '/'.$img_dir.'/'.$filename;
                                    $weblogofile = $img_dir.'/'.$filename;
                                    $filehandle = fopen($img_file,"w");
                                    fwrite($filehandle,base64_decode($ajdata['logo_img64']));
                                    fclose($filehandle);
                                    list($uw, $uh, $utype) = getimagesize($img_file);
                                    $ratioY = $fixed_height/$uh;
                                    $maxh = $fixed_height;
                                    $maxw = round($ratioY * $uw);
                                    $this->resize_image('resizeCrop', $img_file, $img_dir, $filename, $maxw, $maxh, 85);
                                    if ($uw > $limit_upload_w) {
                                        $fixed_height=$limit_upload_w;
                                        $ratioY = $fixed_height/$uh;
                                        $maxh = $fixed_height;
                                        $maxw = round($ratioY * $uw);
                                        $this->resize_image('resizeCrop', $img_file, $upload_dir, $filename, $maxw, $maxh, 85);
                                    }
                                    list($logow, $logoh, $logotype) = getimagesize($weblogofile);
                                    $initstore = $this->Mobstores->get($savestore['id']);
                                    $this->Mobstores->patchEntity($initstore, ['logo_img' => $logofile, 'logo_w' => $logow, 'logo_h' => $logoh, 'up_logo_img' => $img_file, 'up_logo_w' => $uw, 'up_logo_h' => $uh]);
                                    if ($this->Mobstores->save($initstore)) {
                                        $savestore = ($this->Mobstores->exists(['id' => $id]))? $this->Mobstores->get($id)->toArray() : array();
                                        $allstrusr=$this->Mobstrusrs->find('all',array('recursive'=>0,
                                        'conditions'=>array('AND'=>array('Mobstrusrs.store_id' => $savestore['id']))));
                                        if ($allstrusr->count() > 0) {
                                            $savestore['storeusers'] = $allstrusr->toArray();
                                            // $savestore['storeusers'] = [];
                                        } else {
                                            $savestore['storeusers'] = [];
                                        }
                                        $return_code=['status' => 1, 'data' => $savestore, 'error' => ''];
                                    }
                                }
                            }
                            $alltaxrates = $this->Mobtaxrates->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Mobtaxrates.store_id' => $savestore['id']))));
                            if ($alltaxrates->count() < 1) {
                                $taxs = array(2.0,2.5,5.0,7.5,10.0,12.5,15.0,17.5,20.0,25.0);
                                foreach ($taxs as $tk => $tv) {
                                    $inittax = $this->Mobtaxrates->newEntity();
                                    $this->Mobtaxrates->patchEntity($inittax, ['store_id' => $savestore['id'], 'name' => 'VAT '.$tv.'%', 'taxrate' => $tv, 'sort' => ($tk+1)*10]);
                                    $savedtaxrate = $this->Mobtaxrates->save($inittax);
                                }
                            }
                            $inituserlog = $this->Userlogs->newEntity();
                            $usrlogary=array();
                            $usrlogary['user_id']=$user['id'];
                            $usrlogary['obj_name']='Store_new';
                            $usrlogary['obj_id']=$savestore['id'];
                            $usrlogary['session_id']=md5($token);
                            $usrlogary['log_ip']=$this->getRequest()->clientIp();
                            $usrlogary['token']=$token;
                            $usrlogary['mobapp']=$user['mobapp'];
                            $usrlogary['old_data']=json_encode([]);
                            $usrlogary['new_data']=json_encode($savestore);
                            $usrlogary['modified']=date("Y-m-d H:i:s");
                            $usrlogary['created']=date("Y-m-d H:i:s");
                            $this->Userlogs->patchEntity($inituserlog, $usrlogary);$this->Userlogs->save($inituserlog);
                        }
                    }
                }
            }
        }
        $this->set('return_code', $return_code);
    }

    public function delstore()
    {
        $this->viewBuilder()->setLayout('ajax');
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {$token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));}
        $return_code=['status' => 0, 'data' => [], 'error' => ''];
        $ajdata = $this->getRequest()->getData();
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                
            }
        }
        $this->set('return_code', $return_code);
    }

    public function editstore()
    {
        $this->viewBuilder()->setLayout('ajax');
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {$token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));}
        $return_code=['status' => 0, 'data' => [], 'error' => ''];
        $ajdata = $this->getRequest()->getData();
        $limit_upload_w=1024;
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                if ($ajdata['id']) {
                    $savestore = ($this->Mobstores->exists(['id' => $ajdata['id']]))? $this->Mobstores->get($ajdata['id'])->toArray() : array();
                    if ($savestore['user_id'] == $user['id']) {
                        $olddata = $savestore;
                        if ($ajdata['newcode'] == '1') {
                            $ajdata['store_code'] = substr(base64_encode(random_bytes(15)), 0, 14);
                        }
                        $cardmask = strpos($ajdata['card_number'], '*');
                        if ($cardmask === false) {} else {
                            unset($ajdata['card_owner']);
                            unset($ajdata['card_number']);
                            unset($ajdata['card_code']);
                            unset($ajdata['card_year']);
                            unset($ajdata['card_month']);
                            unset($ajdata['authorization']);
                            unset($ajdata['transaction']);
                        }
                        if ($ajdata['newlogo'] && !empty($ajdata['logo_img64']) && !empty($ajdata['logofile'])) {
                            if (!empty($savestore['logo_img']) && file_exists('.'.$savestore['logo_img'])) {
                                unlink('.'.$savestore['logo_img']);
                            }
                            if (!empty($savestore['up_logo_img']) && file_exists('./'.$savestore['up_logo_img'])) {
                                unlink('./'.$savestore['up_logo_img']);
                            }
                            unset($ajdata['newlogo']);
                            $ajdata['logofile'] = strtolower($ajdata['logofile']);
                            $filetype = end(explode('.', $ajdata['logofile']));
                            if (in_array(strtolower($filetype), array('jpeg', 'jpg', 'gif', 'png'))) {
                                $textuuid = new Text();$filename = $textuuid->uuid();
                                $search  = array('-', ' ');$replace = array('_', '_');
                                $filename = str_replace($search,$replace,$filename);
                                $filename .= '.' . $filetype;
                                $fixed_height = 512;
                                $upload_dir = 'img/stores/logos/upload/'.$savestore['id'];
                                $img_dir = 'img/stores/logos/resized/'.$savestore['id'];
                                if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
                                if (!is_dir($img_dir)) mkdir($img_dir, 0755, true);
                                $webimg_file = '/'.$upload_dir.'/'.$filename;
                                $img_file = $upload_dir.'/'.$filename;
                                $logofile = '/'.$img_dir.'/'.$filename;
                                $weblogofile = $img_dir.'/'.$filename;
                                $filehandle = fopen($img_file,"w");
                                fwrite($filehandle,base64_decode($ajdata['logo_img64']));
                                fclose($filehandle);
                                list($uw, $uh, $utype) = getimagesize($img_file);
                                $ratioY = $fixed_height/$uh;
                                $maxh = $fixed_height;
                                $maxw = round($ratioY * $uw);
                                $this->resize_image('resizeCrop', $img_file, $img_dir, $filename, $maxw, $maxh, 85);
                                if ($uw > $limit_upload_w) {
                                    $fixed_height=$limit_upload_w;
                                    $ratioY = $fixed_height/$uh;
                                    $maxh = $fixed_height;
                                    $maxw = round($ratioY * $uw);
                                    $this->resize_image('resizeCrop', $img_file, $upload_dir, $filename, $maxw, $maxh, 85);
                                }
                                list($logow, $logoh, $logotype) = getimagesize($weblogofile);
                                $initstore = $this->Mobstores->get($savestore['id']);
                                $this->Mobstores->patchEntity($initstore, ['logo_img' => $logofile, 'logo_w' => $logow, 'logo_h' => $logoh, 'up_logo_img' => $img_file, 'up_logo_w' => $uw, 'up_logo_h' => $uh]);
                                if ($this->Mobstores->save($initstore)) {
                                    $savestore = ($this->Mobstores->exists(['id' => $savestore['id']]))? $this->Mobstores->get($savestore['id'])->toArray() : array();
                                    $allstrusr=$this->Mobstrusrs->find('all',array('recursive'=>0,
                                    'conditions'=>array('AND'=>array('Mobstrusrs.store_id' => $savestore['id']))));
                                    if ($allstrusr->count() > 0) {
                                        $savestore['storeusers'] = $allstrusr->toArray();
                                        // $savestore['storeusers'] = [];
                                    } else {
                                        $savestore['storeusers'] = [];
                                    }
                                    $return_code=['status' => 1, 'data' => $savestore, 'error' => ''];
                                }
                            }
                        }
                        unset($ajdata['logo_img64']);unset($ajdata['logofile']);
                        $initstore = $this->Mobstores->get($savestore['id']);
                        if (empty($savestore['store_code'])) {
                            $ajdata['store_code'] = substr(base64_encode(random_bytes(15)), 0, 14);
                        }
                        $this->Mobstores->patchEntity($initstore, $ajdata);
                        if ($this->Mobstores->save($initstore)) {
                            $savestore = ($this->Mobstores->exists(['id' => $savestore['id']]))? $this->Mobstores->get($savestore['id'])->toArray() : array();
                            $allstrusr=$this->Mobstrusrs->find('all',array('recursive'=>0,
                            'conditions'=>array('AND'=>array('Mobstrusrs.store_id' => $savestore['id']))));
                            if ($allstrusr->count() > 0) {
                                $savestore['storeusers'] = $allstrusr->toArray();
                                // $savestore['storeusers'] = [];
                            } else {
                                $savestore['storeusers'] = [];
                            }
                            $return_code=['status' => 1, 'data' => $savestore, 'error' => ''];
                            if ($ajdata['newcode'] == '1') {
                                $allposusr = $this->Mobstrusrs->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Mobstrusrs.store_id' => $savestore['id']))))->toArray();
                                foreach ($allposusr as $poskey => $posvalue) {
                                    $posusr = $this->Mobstrusrs->get($posvalue['id']);
                                    $this->Mobstrusrs->patchEntity($posusr, ['store_code' => $savestore['store_code']]);
                                    $this->Mobstrusrs->save($posusr);
                                }
                            }
                            if ($savestore) {
                                $alltaxrates = $this->Mobtaxrates->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Mobtaxrates.store_id' => $savestore['id']))));
                                if ($alltaxrates->count() < 1) {
                                    $taxs = array(2.0,2.5,5.0,7.5,10.0,12.5,15.0,17.5,20.0,25.0);
                                    foreach ($taxs as $tk => $tv) {
                                        $inittax = $this->Mobtaxrates->newEntity();
                                        $this->Mobtaxrates->patchEntity($inittax, ['store_id' => $savestore['id'], 'name' => 'VAT '.$tv.'%', 'taxrate' => $tv, 'sort' => ($tk+1)*10]);
                                        $savedtaxrate = $this->Mobtaxrates->save($inittax);
                                    }
                                }
                            }
                        }
                        $inituserlog = $this->Userlogs->newEntity();
                        $usrlogary=array();
                        $usrlogary['user_id']=$user['id'];
                        $usrlogary['obj_name']='Store_change_info';
                        $usrlogary['obj_id']=$olddata['id'];
                        $usrlogary['session_id']=md5($token);
                        $usrlogary['log_ip']=$this->getRequest()->clientIp();
                        $usrlogary['token']=$token;
                        $usrlogary['mobapp']=$user['mobapp'];
                        $usrlogary['old_data']=json_encode($olddata);
                        $usrlogary['new_data']=json_encode($savestore);
                        $usrlogary['modified']=date("Y-m-d H:i:s");
                        $usrlogary['created']=date("Y-m-d H:i:s");
                        $this->Userlogs->patchEntity($inituserlog, $usrlogary);$this->Userlogs->save($inituserlog);
                    }
                }
            }
        }
        if (strlen($return_code['data']['card_number'])) {
            $return_code['data']['card_number'] = str_pad(substr($return_code['data']['card_number'], -4), strlen($return_code['data']['card_number']), '*', STR_PAD_LEFT);
            $return_code['data']['card_code'] = str_pad(substr($return_code['data']['card_code'], -1), strlen($return_code['data']['card_code']), '*', STR_PAD_LEFT);
        }
        $this->set('return_code', $return_code);
    }

    public function getstore()
    {
        $this->viewBuilder()->setLayout('ajax');
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {$token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));}
        $return_code=['status' => 0, 'data' => [], 'error' => ''];
        $ajdata = $this->getRequest()->getData();
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                
            }
        }
        $this->set('return_code', $return_code);
    }

    public function storeqry()
    {
        $this->viewBuilder()->setLayout('ajax');
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {$token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));}
        $return_code=['status' => 0, 'data' => [], 'error' => ''];
        $ajdata = $this->getRequest()->getData();
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                if ($ajdata['qrymode'] == 'all') {
                    $allstore=$this->Mobstores->find('all',array('recursive'=>0,
                        'fields'=>$this->FldsMobstores,
                        'conditions'=>array('AND'=>array('Mobstores.user_id' => $user['id']))))->toArray();
                    foreach ($allstore as $sk => $sv) {
                        $allstore[$sk]['card_number'] = str_pad(substr($allstore[$sk]['card_number'], -4), strlen($allstore[$sk]['card_number']), '*', STR_PAD_LEFT);
                        $allstore[$sk]['card_code'] = str_pad(substr($allstore[$sk]['card_code'], -1), strlen($allstore[$sk]['card_code']), '*', STR_PAD_LEFT);
                        $allstrusr=$this->Mobstrusrs->find('all',array('recursive'=>0,
                            'conditions'=>array('AND'=>array('Mobstrusrs.store_id' => $sv['id']))));
                        if ($allstrusr->count() > 0) {
                            $allstore[$sk]['storeusers'] = $allstrusr->toArray();
                        } else {
                            $allstore[$sk]['storeusers'] = [];
                        }
                    }
                    $return_code=['status' => 1, 'data' => $allstore, 'error' => ''];
                }
                if ($ajdata['qrymode'] == 'by_id') {
                    $resstore = ($this->Mobstores->exists(['id' => $ajdata['id']]))? $this->Mobstores->get($ajdata['id'])->toArray() : array();
                    $resstore['card_number'] = str_pad(substr($resstore['card_number'], -4), strlen($resstore['card_number']), '*', STR_PAD_LEFT);
                    $resstore['card_code'] = str_pad(substr($resstore['card_code'], -1), strlen($resstore['card_code']), '*', STR_PAD_LEFT);
                    if ($resstore['user_id'] == $user['id']) {
                        $allstrusr=$this->Mobstrusrs->find('all',array('recursive'=>0,
                            'conditions'=>array('AND'=>array('Mobstrusrs.store_id' => $resstore['id']))));
                        if ($allstrusr->count() > 0) {
                            $allstore[$sk]['storeusers'] = $allstrusr->toArray();
                        } else {
                            $allstore[$sk]['storeusers'] = [];
                        }
                        $return_code=['status' => 1, 'data' => $resstore, 'error' => ''];
                    }
                }
            }
        }
        $this->set('return_code', $return_code);
    }
 
    public function login()
    {
        $this->viewBuilder()->setLayout('ajax');
        $tmpusername = str_replace(array('+','-','.',','), array('','','',''), $this->request->data['username']);
        $this->request->data['username'] = $tmpusername;
        $this->request->data['username'] = $this->request->data['username'].'_'.$this->request->data['mobapp'];
        $thisdata = $this->getRequest()->getData();
        $mobapp = $thisdata['mobapp'];
        $verifycode = $thisdata['pn_verify'];
        $vprofile=$this->Profiles->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Profiles.username' => $thisdata['username']))))->first()->toArray();
        if ((new DefaultPasswordHasher)->check($thisdata['password'],$vprofile['password'])) {
            $user = $vprofile;
        } else {
            $user = false;
        }
        if ($user) {
            $curtoken=$this->getRequest()->getData('token');
            if ($curtoken) {
                $veriuser=$this->verifytoken($curtoken);
                $veriuserobj = $this->Profiles->get($veriuser['id']);
                if ($veriuser['sent_value'] == $verifycode) {
                    $veriuser['pn_verify'] = 1;
                    $this->Profiles->patchEntity($veriuserobj, array('pn_verify' => 1,'sent_value' => '888888',date("Y-m-d H:i:s"),'fbase_id' => $thisdata['fbaseuserid'],'fbase_creds' => $thisdata['fbaseusercreds']));
                    $this->Profiles->save($veriuserobj);
                    $user = $this->Profiles->get($veriuser['id']);
                    $token = $curtoken;
                    $initprofileact = $this->Useractions->newEntity();
                    $actionary=array();
                    $actionary['user_id']=$user['id'];
                    $actionary['action_name']='MobileVerifyNumber';
                    $actionary['session_id']=md5($token.'MobileVerifyNumber');
                    $actionary['action_ip']=$this->getRequest()->clientIp();
                    $actionary['token']=$token;
                    $actionary['mobapp']=$mobapp;
                    $actionary['modified']=date("Y-m-d H:i:s");
                    $actionary['created']=date("Y-m-d H:i:s");
                    $this->Useractions->patchEntity($initprofileact, $actionary);$this->Useractions->save($initprofileact);
                }
                $token = $curtoken;
            } else {
                $token = $this->generateToken($user, $mobapp);
                $initprofileact = $this->Useractions->newEntity();
                $actionary=array();
                $actionary['user_id']=$user['id'];
                $actionary['action_name']='MobileLogin';
                $actionary['session_id']=md5($token);
                $actionary['action_ip']=$this->getRequest()->clientIp();
                $actionary['token']=$token;
                $actionary['mobapp']=$mobapp;
                $actionary['modified']=date("Y-m-d H:i:s");
                $actionary['created']=date("Y-m-d H:i:s");
                $this->Useractions->patchEntity($initprofileact, $actionary);$this->Useractions->save($initprofileact);					
            }
        } else {
            $token = '';
        }
        $this->set([
            'data' => [
            'token' => $token,
            'reguser' => $user,
            ],
            '_serialize' => ['data'],
        ]);
        $this->set('token', $token);
    }
    
    public function token()
    {
        $this->viewBuilder()->setLayout('ajax');
        $tmpusername = str_replace(array('+','-','.',','), array('','','',''), $this->request->data['username']);
        $this->request->data['username'] = $tmpusername;
        $this->request->data['username'] = $this->request->data['username'].'_'.$this->request->data['mobapp'];
        $thisdata = $this->getRequest()->getData();
        $mobapp = $thisdata['mobapp'];
        $verifycode = $thisdata['pn_verify'];
        $vprofile=$this->Profiles->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Profiles.username' => $thisdata['username']))))->first()->toArray();
        if ((new DefaultPasswordHasher)->check($thisdata['password'],$vprofile['password'])) {
            $user = $vprofile;
        } else {
            $user = false;
        }
        if ($user) {
            $curtoken=$this->getRequest()->getData('token');
            if ($curtoken) {
                $veriuser=$this->verifytoken($curtoken);
                $veriuserobj = $this->Profiles->get($veriuser['id']);
                if ($veriuser['sent_value'] == $verifycode) {
                    $veriuser['pn_verify'] = 1;
                    $this->Profiles->patchEntity($veriuserobj, array('pn_verify' => 1,'sent_value' => '888888',date("Y-m-d H:i:s"),'fbase_id' => $thisdata['fbaseuserid'],'fbase_creds' => $thisdata['fbaseusercreds']));
                    $this->Profiles->save($veriuserobj);
                    $user = $this->Profiles->get($veriuser['id']);
                    $token = $curtoken;
                    $initprofileact = $this->Useractions->newEntity();
                    $actionary=array();
                    $actionary['user_id']=$user['id'];
                    $actionary['action_name']='MobileVerifyNumber';
                    $actionary['session_id']=md5($token.'MobileVerifyNumber');
                    $actionary['action_ip']=$this->getRequest()->clientIp();
                    $actionary['token']=$token;
                    $actionary['mobapp']=$mobapp;
                    $actionary['modified']=date("Y-m-d H:i:s");
                    $actionary['created']=date("Y-m-d H:i:s");
                    $this->Useractions->patchEntity($initprofileact, $actionary);$this->Useractions->save($initprofileact);
                }
                $token = $curtoken;
            } else {
                $token = $this->generateToken($user, $mobapp);
                $initprofileact = $this->Useractions->newEntity();
                $actionary=array();
                $actionary['user_id']=$user['id'];
                $actionary['action_name']='MobileLogin';
                $actionary['session_id']=md5($token);
                $actionary['action_ip']=$this->getRequest()->clientIp();
                $actionary['token']=$token;
                $actionary['mobapp']=$mobapp;
                $actionary['modified']=date("Y-m-d H:i:s");
                $actionary['created']=date("Y-m-d H:i:s");
                $this->Useractions->patchEntity($initprofileact, $actionary);$this->Useractions->save($initprofileact);					
            }
        } else {
            $token = '';
        }
        $this->set([
            'data' => [
            'token' => $token,
            'reguser' => $user,
            ],
            '_serialize' => ['data'],
        ]);
        $this->set('token', $token);
    }

    private function verifytoken($token)
    {
        $user=false;
        if ($token) {
            $payload = JWT::decode($token, Security::getSalt(),array('HS256'));
            if (isset($payload->user->username)) {
                $mbuser=$this->Profiles->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Profiles.username' => $payload->user->username))));
                if ($mbuser) {
                    $loginsessid=md5($token);
                    $loginactions=$this->Useractions->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Useractions.session_id' => $loginsessid, 'Useractions.action_name' => 'MobileLogin', 'Useractions.mobapp' => $payload->user->mobapp))));
                    if ($loginactions->count()) {
                        $user=$mbuser->first()->toArray();
                        $user['acts']=$loginactions->first()->toArray();
                        $user['mobapp']=$payload->user->mobapp;
                    }
                }
            }
        }
        return $user;
    }

    protected function generateToken($user, $mobapp)
    {
        $payload = ['username' => $user['username'], 'name' => $user['name'], 'email' => $user['email'], 'timezone' => $user['timezone'], 'mobapp' => $mobapp];
        $expiry = 39 * 24 * 3600;
        $buffer = 5 * 60; 
        $exp = time() + rand($expiry, $expiry + $buffer);
        return JWT::encode([ 'iss' => Configure::read('Site.title'), 'sub' => $user['id'], 'user' => $payload, 'iat' => time(), 'exp' => $exp, ], Security::getSalt()); 
    }

    public function generateActivationKey($length = null)
    {
        if (!$length) {
            $length = Configure::read('Atcmobapp.activationKeyLength', 20);
        }
        return bin2hex(Security::randomBytes($length));
    }

    public function image_type_to_extension($imagetype) {
        $Session = $this->getRequest()->getSession();
        $thisdata = $this->getRequest()->getData();
        if (empty($imagetype)) return false;
        switch($imagetype) {
            case IMAGETYPE_TIFF_II : return 'tiff';
            case IMAGETYPE_TIFF_MM : return 'tiff';
            case IMAGETYPE_GIF  : return 'gif';
            case IMAGETYPE_JPEG : return 'jpg';
            case IMAGETYPE_PNG  : return 'png';
            case IMAGETYPE_SWF  : return 'swf';
            case IMAGETYPE_PSD  : return 'psd';
            case IMAGETYPE_BMP  : return 'bmp';
            case IMAGETYPE_JPC  : return 'jpc';
            case IMAGETYPE_JP2  : return 'jp2';
            case IMAGETYPE_JPX  : return 'jpf';
            case IMAGETYPE_JB2  : return 'jb2';
            case IMAGETYPE_SWC  : return 'swc';
            case IMAGETYPE_IFF  : return 'aiff';
            case IMAGETYPE_WBMP : return 'wbmp';
            case IMAGETYPE_XBM  : return 'xbm';
            default             : return false;
        }
    }
    
    public function is_image($file_type) {
        $Session = $this->getRequest()->getSession();
        $thisdata = $this->getRequest()->getData();
        $image_types = array('jpeg', 'jpg', 'gif', 'png');
        return in_array(strtolower($file_type), $image_types);
    }

    public function resize_image($cType = 'resize', $tmpfile, $dst_folder, $dstname = false, $newWidth=false, $newHeight=false, $quality = 75) {
        $Session = $this->getRequest()->getSession();
        $thisdata = $this->getRequest()->getData();
        $srcimg = $tmpfile;
        list($oldWidth, $oldHeight, $type) = getimagesize($srcimg);
        $ext = $this->image_type_to_extension($type);

        if (is_writeable($dst_folder)) {
            $dstimg = $dst_folder.DS.$dstname;
        } else {
            
        }

        if ($newWidth or $newHeight) {
        if (file_exists($dstimg)) {
            // unlink($dstimg);
        } else {
            switch ($cType) {
            default:
                case 'resize':
                    $widthScale  = 2;
                    $heightScale = 2;
                    if ($newWidth) {
                        if ($newWidth > $oldWidth) $newWidth = $oldWidth;
                        $widthScale = $newWidth / $oldWidth;
                    }
                    if ($newHeight) {
                        if ($newHeight > $oldHeight) $newHeight = $oldHeight;
                        $heightScale = $newHeight / $oldHeight;
                    }
                    if ($widthScale < $heightScale) {
                        $maxWidth  = $newWidth;
                        $maxHeight = false;
                    } elseif ($widthScale > $heightScale ) {
                        $maxHeight = $newHeight;
                        $maxWidth  = false;
                    } else {
                        $maxHeight = $newHeight;
                        $maxWidth  = $newWidth;
                    }

                    if ($maxWidth > $maxHeight){
                        $applyWidth  = $maxWidth;
                        $applyHeight = ($oldHeight*$applyWidth)/$oldWidth;
                    } elseif ($maxHeight > $maxWidth) {
                        $applyHeight = $maxHeight;
                        $applyWidth  = ($applyHeight*$oldWidth)/$oldHeight;
                    } else {
                        $applyWidth  = $maxWidth;
                        $applyHeight = $maxHeight;
                    }
                        $startX = 0;
                        $startY = 0;
                    break;

                case 'resizeCrop':
                    if ($newWidth > $oldWidth) $newWidth = $oldWidth;
                    $ratioX = $newWidth / $oldWidth;

                    if ($newHeight > $oldHeight) $newHeight = $oldHeight;
                    $ratioY = $newHeight / $oldHeight;

                    if ($ratioX < $ratioY) {
                        $startX = round(($oldWidth - ($newWidth / $ratioY))/2);
                        $startY = 0;
                        $oldWidth  = round($newWidth / $ratioY);
                        $oldHeight = $oldHeight;
                    } else {
                        $startX = 0;
                        $startY = round(($oldHeight - ($newHeight / $ratioX))/2);
                        $oldWidth  = $oldWidth;
                        $oldHeight = round($newHeight / $ratioX);
                    }
                    $applyWidth  = $newWidth;
                    $applyHeight = $newHeight;
                    break;
            
                case 'crop':
                    $startY = ($oldHeight - $newHeight)/2;
                    $startX = ($oldWidth - $newWidth)/2;
                    $oldHeight   = $newHeight;
                    $applyHeight = $newHeight;
                    $oldWidth    = $newWidth;
                    $applyWidth  = $newWidth;
                    break;
            }

            switch($ext) {
                case 'gif' :
                    $oldImage = imagecreatefromgif($srcimg);
                    break;
                case 'png' :
                    $oldImage = imagecreatefrompng($srcimg);
                    break;
                case 'jpg' :
                case 'jpeg' :
                    $oldImage = imagecreatefromjpeg($srcimg);
                    break;
                default :
                    return false;
                    break;
            }

            $newImage = imagecreatetruecolor($applyWidth, $applyHeight);
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            imagecopyresampled($newImage, $oldImage, 0, 0, $startX, $startY, $applyWidth, $applyHeight, $oldWidth, $oldHeight);

            switch($ext) {
                case 'gif' :
                    imagegif($newImage, $dstimg, $quality);
                    break;
                case 'png' :
                    imagepng($newImage, $dstimg, round($quality/10));
                    break;
                case 'jpg' :
                case 'jpeg' :
                    imagejpeg($newImage, $dstimg, $quality);
                    break;
                default :
                    return false;
                    break;
            }
            imagedestroy($newImage);
            imagedestroy($oldImage);
            return true;
            }
        } else { 
        return false;
        }
    }

    protected function _setCommonVariables($id)
    {

    }
    
}
