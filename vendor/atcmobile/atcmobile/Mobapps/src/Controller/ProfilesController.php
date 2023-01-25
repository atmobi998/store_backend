<?php

namespace Atcmobapp\Mobapps\Controller;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Database\Expression\IdentifierExpression;
use Cake\I18n\I18n;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\Core\Plugin;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Text;
use Cake\Mailer\Email;
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
use Twilio\Rest\Client;

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
class ProfilesController extends AppController
{
    
    public $presetVars = true;
    private $twiliosid = 'ACb8d23ffab3fc64c0750491d89d8dd1ac';
    private $twiliotoken = '04d00339a20fd6ad8e5a71e8ed74f6b2';
    private $twiliofrom = '+84869402737';

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
        $this->Auth->allow(['register', 'forgot', 'login', 'token', 'userinfo', 'listbyemail', 'profileedit']);
    }

    public function forgot() {
        $this->viewBuilder()->setLayout('ajax');
        $thisdata = $this->getRequest()->getData();
        $mobapp = $thisdata['mobapp'];
        $return_code=['status' => 0, 'data' => [], 'error' => ''];
        if (!empty($thisdata['phonenbr'])) {
            $tmpphone = str_replace(array('+'), array(''), $this->request->data['phonenbr']);
            $pieces = explode("-", $tmpphone);
            $phonecode = $pieces[0];
            $phonenbr = str_replace(array('+'.$phonecode.'-'), array(''), $this->request->data['phonenbr']);
            $phonenbr = str_replace(array('-','.',','), array('','',''), $phonenbr);
            $username = $phonecode.$phonenbr.'_'.$mobapp;
            $existprofiles=$this->Profiles->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Profiles.username' => $username))));
            if ($existprofiles->count() && $thisdata['step'] == 1) {
                $user=$existprofiles->first()->toArray();
                $forgotsessid=md5(date("Y-m-d H:i:s").'ForgotPassword'.$user['id'].$username);
                $client = new Client($this->twiliosid, $this->twiliotoken);
                $tokennbr = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                if ($phonecode == '84') {
                    $this->twiliofrom = '+84-907628544';
                } else if ($phonecode == '1') {
                    $this->twiliofrom = '+1-5866661973';
                }
                
                // $message = $client->messages->create($this->request->data['phonenbr'],['from' => $this->twiliofrom,'body' => 'Your reset code is: '.$tokennbr]);
                // $message = $client->messages->create($this->request->data['phonenbr'], ["messagingServiceSid" => "MGdafcf69f43da133e0562cb08eb28739d","body" => 'Your reset code is: '.$tokennbr]);
                
                $subject = 'Password reset: '.$user['firstname']. ' ' . $user['lastname'] . ' ('.$user['email'].')';

                $email = new Email();
                $email->setTransport('default');
                $contents = '
<p>Hi,</p>
<p>You just requested to reset password,<br />
Your reset code is: '.$tokennbr.'</p>
If you did not request for password reset, please ignore this email.
<p>Regards,</p>
<p>ATC Mobile Team</p>';
                try {
                    $res = $email->setFrom('admin@store.metroeconomics.com')
                    ->setTo(array($user['email']))
                    ->setCc(array('admin@store.metroeconomics.com'))
                    ->setBcc(array('atcanht@gmail.com'))
                    ->setSubject($subject)
                    ->setEmailFormat('html')
                    ->viewBuilder()->setTemplate('default');
                    $email->send($contents);
                } catch (Exception $e) {
                    echo 'Exception : ',  $e->getMessage(), "\n";
                }
                
                $initprofilelog = $this->Userlogs->newEntity();
                $usrlogary=array();
                $usrlogary['user_id']=$user['id'];
                $usrlogary['obj_name']='ForgotPassword';
                $usrlogary['obj_id']=$user['id'];
                $usrlogary['session_id']=$forgotsessid;
                $usrlogary['log_ip']=$this->getRequest()->clientIp();
                $usrlogary['token']=$tokennbr;
                $usrlogary['mobapp']=$mobapp;
                $usrlogary['old_data']=$username;
                $usrlogary['new_data']=$thisdata['phonenbr'].' '.$tokennbr;
                $usrlogary['modified']=date("Y-m-d H:i:s");
                $usrlogary['created']=date("Y-m-d H:i:s");
                $this->Userlogs->patchEntity($initprofilelog, $usrlogary);$this->Userlogs->save($initprofilelog);
                $return_code=['status' => 1, 'data' => $forgotsessid, 'error' => ''];
            } else if ($existprofiles->count() && $thisdata['step'] == 2) {
                if ($thisdata['token']) {
                    $forgotsessid = $thisdata['token'];
                    $userlog=$this->Userlogs->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Userlogs.session_id' => $forgotsessid))))->first()->toArray();
                    if ($thisdata['resetcode'] == $userlog['token']) {
                        $return_code=['status' => 1, 'data' => 'Verified', 'error' => ''];
                    }
                }
            } else if ($existprofiles->count() && $thisdata['step'] == 3) {
                if ($thisdata['token']) {
                    $forgotsessid = $thisdata['token'];
                    $userlog=$this->Userlogs->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Userlogs.session_id' => $forgotsessid))))->first()->toArray();
                    if ($thisdata['resetcode'] == $userlog['token']) {
                        $user=$existprofiles->first()->toArray();
                        $requser = $this->Profiles->get($user['id']);
                        $this->Profiles->patchEntity($requser, ['password' => $thisdata['password'],'verify_password' => $thisdata['password'], 'pn_verify' => 1]);
                        $this->Profiles->save($requser);
                        $return_code=['status' => 1, 'data' => 'Changed', 'error' => ''];
                    }
                }
            }
        }
        $this->set('return_code', $return_code);
    }

    public function register() {
        $Session = $this->getRequest()->getSession();
        $this->request->data['username'] = $this->request->data['username'].'_'.$this->request->data['mobapp'];
        $thisdata = $this->getRequest()->getData();
        $this->viewBuilder()->setLayout('ajax');
        $return_code=['reg' => 0, 'reguser' => $thisdata, 'regerr' => '', 'token' => ''];
        $regvalidate=true;
        $limit_upload_w=1024;
        if (!empty($thisdata)) {
            $existprofiles=$this->Profiles->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Profiles.username' => $thisdata['username']))))->toArray();
            if ($existprofiles) {
                $regvalidate=false;
                $return_code['reg']=-1;
                $return_code['regerr']='This phone number already registered.';
            } else if (empty($thisdata['username'])) {
                $regvalidate=false;
                $return_code['reg']=-1;
                $return_code['regerr']='Please enter country / phone-number.';
            } else if (empty($thisdata['firstname']) && empty($thisdata['lastname'])) {
                $regvalidate=false;
                $return_code['reg']=-1;
                $return_code['regerr']='Please enter your name.';
            } else if (empty($thisdata['email'])) {
                $regvalidate=false;
                $return_code['reg']=-1;
                $return_code['regerr']='Please enter your email address.';
            } else if (empty($thisdata['password'])) {
                $regvalidate=false;
                $return_code['reg']=-1;
                $return_code['regerr']='Please enter your password.';
            } else if (empty($thisdata['phone'])) {
                $regvalidate=false;
                $return_code['reg']=-1;
                $return_code['regerr']='Please enter your phone number.';
            }
        } 
        if ($regvalidate && !empty($thisdata)) {
            $initprofile = $this->Profiles->newEntity();
            $thisdata['role_id'] = 3;
            $thisdata['group_id'] = 2;
            $thisdata['activation_key'] = md5(uniqid());
            $thisdata['status'] = 1;
            $thisdata['name'] = $thisdata['firstname']. ' ' . $thisdata['lastname'];
            $thisdata['password'] = (new DefaultPasswordHasher)->hash($thisdata['password']);
            $this->Profiles->patchEntity($initprofile, $thisdata);
            $initprofile->set([ 'role_id' => 3]);
            if ($this->Profiles->save($initprofile)) {
                $username = $thisdata['firstname']. ' ' . $thisdata['lastname'] . ' ['.$thisdata['username'].'] ('.$thisdata['email'].')';
                $subject = 'New User: '.$thisdata['firstname']. ' ' . $thisdata['lastname'] . ' ('.$thisdata['email'].')';
                $email = new Email();
                $email->setTransport('default');
                $contents = '
<p>Hi Mobapps,</p>
<p>We just have <b>'.$username.'</b> registered successfully.<br />
Please go to User admin panel for more details.</p>
<p>Thanks & Best Regards,</p>
<p>Mobapps Web Register form</p>';
                try {
                    $res = $email->setFrom('admin@store.metroeconomics.com')
                    ->setTo(array('admin@store.metroeconomics.com'))
                    ->setCc(array('admin@store.metroeconomics.com'))
                    ->setBcc(array('atcanht@gmail.com'))
                    ->setSubject($subject)
                    ->setEmailFormat('html')
                    ->viewBuilder()->setTemplate('default');
                    $email->send($contents);
                } catch (Exception $e) {
                    echo 'Exception : ',  $e->getMessage(), "\n";
                }
                $vprofile=$this->Profiles->get($initprofile->id);
                $user = $vprofile;
                $token = $this->generateToken($user, $thisdata['mobapp']);
                $profile=$user;
                if (!empty($thisdata['logo_img64']) && !empty($thisdata['logofile'])) {
                    $thisdata['logofile'] = strtolower($thisdata['logofile']);
                    $filetype = end(explode('.', $thisdata['logofile']));
                    if (in_array(strtolower($filetype), array('jpeg', 'jpg', 'gif', 'png'))) {
                        $textuuid = new Text();$filename = $textuuid->uuid();
                        $search  = array('-', ' ');$replace = array('_', '_');
                        $filename = str_replace($search,$replace,$filename);
                        $filename .= '.' . $filetype;
                        $fixed_height = 512;
                        $upload_dir = 'img/profiles/logos/upload/'.$profile['id'];
                        $img_dir = 'img/profiles/logos/resized/'.$profile['id'];
                        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                        if (!is_dir($img_dir)) mkdir($img_dir, 0777, true);
                        $webimg_file = '/'.$upload_dir.'/'.$filename;
                        $img_file = $upload_dir.'/'.$filename;
                        $logofile = '/'.$img_dir.'/'.$filename;
                        $weblogofile = $img_dir.'/'.$filename;
                        $filehandle = fopen($img_file,"w");
                        fwrite($filehandle,base64_decode($thisdata['logo_img64']));
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
                        $initprofile = $this->Profiles->get($profile['id']);
                        $this->Profiles->patchEntity($initprofile, ['has_logo'=>1,'logo_img' => $logofile, 'logo_w' => $logow, 'logo_h' => $logoh]);
                        if ($this->Profiles->save($initprofile)) {
                        }
                    }
                }
                if (!empty($thisdata['self_img64']) && !empty($thisdata['selffile'])) {
                    $thisdata['selffile'] = strtolower($thisdata['selffile']);
                    $filetype = end(explode('.', $thisdata['selffile']));
                    if (in_array(strtolower($filetype), array('jpeg', 'jpg', 'gif', 'png'))) {
                        $textuuid = new Text();$filename = $textuuid->uuid();
                        $search  = array('-', ' ');$replace = array('_', '_');
                        $filename = str_replace($search,$replace,$filename);
                        $filename .= '.' . $filetype;
                        $fixed_height = 512;
                        $upload_dir = 'img/profiles/selfie/upload/'.$profile['id'];
                        $img_dir = 'img/profiles/selfie/resized/'.$profile['id'];
                        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                        if (!is_dir($img_dir)) mkdir($img_dir, 0777, true);
                        $webimg_file = '/'.$upload_dir.'/'.$filename;
                        $img_file = $upload_dir.'/'.$filename;
                        $selffile = '/'.$img_dir.'/'.$filename;
                        $webselffile = $img_dir.'/'.$filename;
                        $filehandle = fopen($img_file,"w");
                        fwrite($filehandle,base64_decode($thisdata['self_img64']));
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
                        list($selfw, $selfh, $imgtype) = getimagesize($webselffile);
                        $initprofile = $this->Profiles->get($profile['id']);
                        $this->Profiles->patchEntity($initprofile, ['self_img' => $selffile, 'self_w' => $selfw, 'self_h' => $selfh]);
                        if ($this->Profiles->save($initprofile)) {
                        }
                    }
                }
                $initprofileact = $this->Useractions->newEntity();
                $actionary=array();
                $actionary['user_id']=$profile['id'];
                $actionary['action_name']='MobileLogin';
                $actionary['session_id']=md5($token);
                $actionary['action_ip']=$this->getRequest()->clientIp();
                $actionary['token']=$token;
                $actionary['mobapp']=$thisdata['mobapp'];
                $actionary['modified']=date("Y-m-d H:i:s");
                $actionary['created']=date("Y-m-d H:i:s");
                $this->Useractions->patchEntity($initprofileact, $actionary);$this->Useractions->save($initprofileact);
                $return_code['reg']=1;
                $return_code['reguser']=['username' => $profile['username'], 'email' => $profile['email']];
                $return_code['token']=$token;
                $this->set('return_code', $return_code);
                
            } else {
                $return_code['reg']=-1;
                $return_code['regerr']='Mobapps could not register your account.';
            }
        }
        $this->set('return_code', $return_code);
    }

    public function profileedit()
    {
        $this->viewBuilder()->setLayout('ajax');
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {
            $token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));
        }		
        $return_code=['reg' => 0, 'reguser' => [], 'regerr' => '', 'token' => ''];
        $limit_upload_w=1024;
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                $initprofile = $this->Profiles->get($user['id']);
                // do not update username
                unset($this->request->data['username']);
                $Session = $this->getRequest()->getSession();
                $thisdata = $this->getRequest()->getData();
                $this->viewBuilder()->setLayout('ajax');
                $return_code=['reg' => 0, 'reguser' => $thisdata, 'regerr' => '', 'token' => ''];
                $regvalidate=true;
                if (!empty($thisdata)) {
                    if (empty($thisdata['firstname']) && empty($thisdata['lastname'])) {
                        $regvalidate=false;
                        $return_code['reg']=-1;
                        $return_code['regerr']='Please enter your name.';
                    } else if (empty($thisdata['email'])) {
                        $regvalidate=false;
                        $return_code['reg']=-1;
                        $return_code['regerr']='Please enter your email address.';
                    } else if (empty($thisdata['password'])) {
                        unset($thisdata['password']);
                        unset($thisdata['verify_password']);
                    }
                }
                if ($regvalidate && !empty($thisdata)) {
                    $thisdata['role_id'] = 3;
                    $thisdata['group_id'] = 2;
                    $thisdata['activation_key'] = md5(uniqid());
                    $thisdata['status'] = 1;
                    $thisdata['name'] = $thisdata['firstname']. ' ' . $thisdata['lastname'];
                    if (!empty($thisdata['password'])) {
                        $thisdata['verify_password'] = $thisdata['password'];
                        $thisdata['password'] = (new DefaultPasswordHasher)->hash($thisdata['verify_password']);
                    }
                    $this->Profiles->patchEntity($initprofile, $thisdata);
                    $initprofile->set([ 'role_id' => 3]);
                    if ($this->Profiles->save($initprofile)) {
                        $initprofile = $this->Profiles->get($user['id']);						
                        $profile=$initprofile;
                        if (!empty($thisdata['logo_img64']) && !empty($thisdata['logofile'])) {
                            $thisdata['logofile'] = strtolower($thisdata['logofile']);
                            $filetype = end(explode('.', $thisdata['logofile']));
                            if (in_array(strtolower($filetype), array('jpeg', 'jpg', 'gif', 'png'))) {
                                if (file_exists('.'.$profile['logo_img'])) {
                                    unlink('.'.$profile['logo_img']);
                                    unlink(str_replace(['resized'],['upload'],'.'.$profile['logo_img']));
                                }
                                $textuuid = new Text();$filename = $textuuid->uuid();
                                $search  = array('-', ' ');$replace = array('_', '_');
                                $filename = str_replace($search,$replace,$filename);
                                $filename .= '.' . $filetype;
                                $fixed_height = 512;
                                $upload_dir = 'img/profiles/logos/upload/'.$profile['id'];
                                $img_dir = 'img/profiles/logos/resized/'.$profile['id'];
                                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                                if (!is_dir($img_dir)) mkdir($img_dir, 0777, true);
                                $webimg_file = '/'.$upload_dir.'/'.$filename;
                                $img_file = $upload_dir.'/'.$filename;
                                $logofile = '/'.$img_dir.'/'.$filename;
                                $weblogofile = $img_dir.'/'.$filename;
                                $filehandle = fopen($img_file,"w");
                                fwrite($filehandle,base64_decode($thisdata['logo_img64']));
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
                                $initprofile = $this->Profiles->get($profile['id']);
                                $this->Profiles->patchEntity($initprofile, ['has_logo'=>1,'logo_img' => $logofile, 'logo_w' => $logow, 'logo_h' => $logoh]);
                                if ($this->Profiles->save($initprofile)) {
                                    $initprofile = $this->Profiles->get($profile['id']);
                                }
                            }
                        }
                        
                        if (!empty($thisdata['self_img64']) && !empty($thisdata['selffile'])) {
                            $thisdata['selffile'] = strtolower($thisdata['selffile']);
                            $filetype = end(explode('.', $thisdata['selffile']));
                            if (in_array(strtolower($filetype), array('jpeg', 'jpg', 'gif', 'png'))) {
                                if (file_exists('.'.$profile['self_img'])) {
                                    unlink('.'.$profile['self_img']);
                                    unlink(str_replace(['resized'],['upload'],'.'.$profile['self_img']));
                                }								
                                $textuuid = new Text();$filename = $textuuid->uuid();
                                $search  = array('-', ' ');$replace = array('_', '_');
                                $filename = str_replace($search,$replace,$filename);
                                $filename .= '.' . $filetype;
                                $fixed_height = 512;
                                $upload_dir = 'img/profiles/selfie/upload/'.$profile['id'];
                                $img_dir = 'img/profiles/selfie/resized/'.$profile['id'];
                                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                                if (!is_dir($img_dir)) mkdir($img_dir, 0777, true);
                                $webimg_file = '/'.$upload_dir.'/'.$filename;
                                $img_file = $upload_dir.'/'.$filename;
                                $selffile = '/'.$img_dir.'/'.$filename;
                                $webselffile = $img_dir.'/'.$filename;
                                $filehandle = fopen($img_file,"w");
                                fwrite($filehandle,base64_decode($thisdata['self_img64']));
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
                                list($selfw, $selfh, $imgtype) = getimagesize($webselffile);
                                $initprofile = $this->Profiles->get($profile['id']);
                                $this->Profiles->patchEntity($initprofile, ['self_img' => $selffile, 'self_w' => $selfw, 'self_h' => $selfh]);
                                if ($this->Profiles->save($initprofile)) {
                                    $initprofile = $this->Profiles->get($profile['id']);
                                }
                            }
                        }
                        $initprofileact = $this->Useractions->newEntity();
                        $actionary=array();
                        $actionary['user_id']=$profile['id'];
                        $actionary['action_name']='MobileProfileChanges';
                        $actionary['session_id']=md5($token);
                        $actionary['action_ip']=$this->getRequest()->clientIp();
                        $actionary['token']=$token;
                        $actionary['mobapp']=$thisdata['mobapp'];
                        $actionary['modified']=date("Y-m-d H:i:s");
                        $actionary['created']=date("Y-m-d H:i:s");
                        $this->Useractions->patchEntity($initprofileact, $actionary);$this->Useractions->save($initprofileact);
                        $return_code['reg']=1;
                        $return_code['reguser']=$initprofile;
                        $return_code['token']=$token;
                        $this->set('return_code', $return_code);
                    } else {
                        $return_code['reg']=-1;
                        $return_code['regerr']='Mobapps could not save your changes.';
                    }
                }
                $this->set('return_code', $return_code);
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

    public function userinfo()
    {
        $this->viewBuilder()->setLayout('ajax');
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {
            $token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));
        }		
        $showuser=['name' => '', 'username' => '', 'email' => ''];
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                $showuser=[ 'firstname' => $user['firstname'], 'lastname' => $user['lastname'], 'username' => $user['username'], 
                            'email' => $user['email'], 'has_logo' => $user['has_logo'], 'img_host' => $user['img_host'], 
                            'logo' => $user['lfile'], 'logo_text' => $user['logo_text'], 'zipcode' => $user['zipcode'], 
                            'country_id' => $user['country_id'], 'state_id' => $user['state_id'], 'mobapp' => $user['acts']['mobapp']
                        ];
            }
        }
        $this->set('user', $showuser);
    }

    public function listbyemail($email = '')
    {
        $this->viewBuilder()->setLayout('ajax');
        if (empty($email)) {
            $email = $this->getRequest()->getData('email');
        }
        $token=$this->getRequest()->getData('token');
        if (empty($token) && strtolower(explode(' ',$this->request->getHeaderLine('Authorization'))[0]) == 'bearer') {
            $token = str_ireplace('bearer ', '', $this->request->getHeaderLine('Authorization'));
        }		
        $userslist=false;
        if ($token) {
            $user=$this->verifytoken($token);
            if ($user) {
                if ($user['email'] == $email) {
                    $mbusers=$this->Profiles->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Profiles.email' => $email))));
                    if ($mbusers->count()) {
                        $mbusers=$this->Profiles->find('all',array('recursive'=>0,'conditions'=>array('AND'=>array('Profiles.email' => $email))))->toArray();
                        foreach ($mbusers as $uk => $uv) {
                            $userslist[$uv['username']] = ['firstname' => $uv['firstname'], 'lastname' => $uv['lastname'], 'username' => $uv['username'], 'email' => $uv['email'], 'has_logo' => $uv['has_logo'], 'img_host' => 'https://metroeconomics.com', 
                            'logo' => $uv['lfile'], 'logo_text' => $uv['logo_text'], 'zipcode' => $uv['zipcode'], 'country_id' => $uv['country_id'], 'state_id' => $uv['state_id']];
                        }
                    }
                }
            }
        }
        $this->set('userslist', $userslist);
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
