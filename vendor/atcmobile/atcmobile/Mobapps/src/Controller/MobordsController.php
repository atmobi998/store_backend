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
class MobordsController extends AppController
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
        $this->Auth->allow(['addord', 'delord', 'editord', 'getord', 'ordqry']);
    }

    public function addord()
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

    public function delord()
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

    public function editord()
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

    public function getord()
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

    public function ordqry()
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

    protected function _setCommonVariables($id)
    {

    }
    
}
