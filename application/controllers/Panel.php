<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->headerData = array();
        $this->footerData = array();
        $this->load->helper("text");
        $this->load->helper('form');
//        $this->load->model('Funcs', '', TRUE);
        $this->load->model('Checkdata', '', TRUE);
        $this->load->model('DateTimeFunc', '', TRUE);
        $this->lang->load('site', "english");
        $seo = $this->db->query("SELECT *  FROM seo ")->result_object();

        $this->headerData['pageTitle'] = $seo[0]->theTitle;
        $this->headerData['pageDescrption'] = $seo[0]->theText;

        $this->headerData["menu_link"] = $this->db->query("SELECT * FROM menu_link ")->result_object();
        $this->headerData["footer11"] = $this->db->query("SELECT * FROM footer1 ")->result_object();

        $this->headerData["footer2"] = $this->db->query("SELECT * FROM footer2 ")->result_object();
        $this->headerData["footer3"] = $this->db->query("SELECT * FROM footer3 ")->result_object();
        $this->headerData["footer4"] = $this->db->query("SELECT * FROM footer4 ")->result_object();


        $this->footerData["footer11"] = $this->db->query("SELECT * FROM footer1 ")->result_object();
        $this->footerData["footer22"] = $this->db->query("SELECT * FROM footer2 ")->result_object();
        $this->footerData["footer33"] = $this->db->query("SELECT * FROM footer3 ")->result_object();
        $this->footerData["footer44"] = $this->db->query("SELECT * FROM footer4 ")->result_object();


       if ($this->session->userdata("username") == "" && $this->uri->segment(2) != "login") {
           header("Location: /panel/login");
           die();
       }


        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }
//        header("Location: /panel/login");

        $this->footerData['theColor'] = $this->db->query("SELECT theValue FROM site_setting")->result_object();
        $this->headerData['theColor'] = $this->db->query("SELECT theValue FROM site_setting")->result_object();
        $this->headerData['theLogo'] = $this->db->query("SELECT theValue FROM site_setting WHERE seId = 3")->result_object();
    }

    public function index() {
        header("Location: /panel/login/");
    }
//    public function panel() {
//        $this->load->view("panel/common/header", $this->headerData);
//        $this->load->view("panel", $pageData);
//        $this->load->view("panel/common/footer", $this->footerData);
//    }

    public function home() {
//        header("Location: /panel/users/");
        header("Location: /panel/dashbord/");
    }
    public function login() {
        $pageData = array();
        $pageData["status"] = 0;

        if ($this->input->post()) {
            $username = $this->Checkdata->checkInputData($this->input->post("username"));
            $password = $this->input->post("password");
            $check = $this->db->query("select count(1) as cnt from users where username = '" . $username . "' and thePassword = '" . sha1($password) . "' AND isDeleted = 0")->result();
            if ($check[0]->cnt > 0) {
                $memberData = $this->db->query("select usId from users where username = '" . $username . "' and thePassword = '" . sha1($password) . "' AND isDeleted = 0")->result_array();
                $session = array(
                    'username' => $username,
                    'lastlogin' => Date("Y-m-d H:i:s"),
                    'usId' => $memberData[0]["usId"]
                );
                $this->session->set_userdata($session);
                header("Location: /panel/home/");
            } else {
                $pageData["status"] = 1;
                $this->load->view("panel/login", $pageData);
            }
        } else {

            $this->load->view("panel/login", $pageData);
        }
    }
    function logout() {
        $this->session->sess_destroy();
        header("Location: /panel/login");
    }

    function logout1() {
        $this->session->sess_destroy();
        header("Location:1");
    }

//     public function front_login() {
//
// //    $username = $this->input->post("theName");
//         $theEmail = $this->input->post("theEmail");
//
//         $password = $this->input->post("thePassword");
//
//         $check = $this->db->query("SELECT count(1) as cnt FROM kullanci WHERE theEmail = '" . $theEmail . "' AND thePassword = '" . sha1($password) . "'")->result();
//         $checks = $this->db->query("select * FROM kullanci WHERE theEmail = '" . $theEmail . "' AND thePassword = '" . sha1($password) . "' ")->result();
//         if ($check[0]->cnt > 0) {
// //        $memberData = $this->db->query("SELECT *  FROM kullanci WHERE theName = '" . $username . "' AND thePassword = '" . sha1($password) . "'")->result_array();
//             $session = array(
//                 'username' =>  $checks[0]->theName,
//                 'email' =>$theEmail ,
//                 'id' => $checks[0]->id
//             );
//
//             $this->session->set_userdata($session);
//             header("Location:https://hurenkangoedkoper.com");
//         }else{
//             $this->session->set_flashdata('category_error', 'please check your password and username.');
//             header("Location:https://hurenkangoedkoper.com");
//
//
//         }
//
//     }

// dashbord
    public function dashbord() {
        $pageData = array();
        $pageData["prodactss"] = $this->db->query("SELECT * FROM prodact WHERE status = 0")->result_object();
        $pageData["activePrd"] = $this->db->query("SELECT COUNT(*) as prd FROM prodact WHERE status = 1")->result_object();
        $pageData["order"] = $this->db->query("SELECT COUNT(*) as odr FROM oders ")->result_object();
          $pageData["users"] =  $this->db->query("SELECT COUNT(*) as usr FROM kullanci ")->result_object();

//        $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM users WHERE isDeleted = 0")->row()->cnt;

//        print_r($user);



        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/dashbord", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);
    }

    // Users
    public function users() {
        $pageData["users"] = $this->db->query("SELECT usId, username, lastlogin from users WHERE isDeleted = 0 ORDER BY usId")->result_array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/users", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);
    }




    public function prodactts($id = 0){
        $pageData = array();

        $theSearch = $this->input->get("term");
//        $theSearch1 = $this->input->get("room");
//        $theSearch2 = $this->input->get("location");
//        $theSearch3 = $this->input->get("price");
        $theSearch = str_replace(array('"',"'","#","SELECT","ORDER","EXTRACTVALUE","OR","AND","CONCAT"),"",$theSearch);
//        $theSearch1 = str_replace(array('"',"'","#","SELECT","ORDER","EXTRACTVALUE","OR","AND","CONCAT"),"",$theSearch1);
//        $theSearch2 = str_replace(array('"',"'","#","SELECT","ORDER","EXTRACTVALUE","OR","AND","CONCAT"),"",$theSearch2);
//        $theSearch3 = str_replace(array('"',"'","#","SELECT","ORDER","EXTRACTVALUE","OR","AND","CONCAT"),"",$theSearch3);

        if($theSearch ){
            $theSearchADD = "AND (theType LIKE '%$theSearch%' OR theRoom LIKE '%$theSearch%' OR category_id LIKE '%$theSearch%' OR thePrice LIKE '%$theSearch%'  ) ";
//            "AND (theTitletr LIKE '%$theSearch%' OR theTitleen LIKE '%$theSearch%' OR theCode LIKE '%$theSearch%' )";

        }else{
            $theSearchADD = "";

        }



        if($this->input->get("page_no") > 1){
            $pageNum = $this->input->get("page_no");
        }else{
            $pageNum = 1;
        }
        $planLength = 15;
        if ($pageNum > 1) { $start = ($pageNum - 1) * $planLength; } else { $start = 0; }
        $pageData['pageNum'] = $pageNum;

        $pageData["category"] = $this->db->query("SELECT * FROM category ")->result_object();
//        $pageData["subAll"] = $this->db->query("SELECT * FROM prodact  ")->result_object();




        $pageData["allProductsNUM"] = $this->db->query("SELECT * FROM prodact WHERE 1 $theSearchADD ")->result_object();





        $pageData['prev'] = $pageNum - 1;
        $pageData['next'] = $pageNum + 1;

        $pageData['cateNum'] = ceil(sizeof($pageData['allProductsNUM']) / $planLength);
        if (($pageData['allProductsNUM']) && ($pageData['cateNum'] < $pageNum)) {
            $pageNum = $pageData['cateNum'];
            $pageData['pageNum'] = $pageNum;
            header("Location:/");
            exit();
        }




        $pageData['id'] = $id;
        $pageData["prodact"] = $this->db->query("SELECT * FROM prodact WHERE 1 $theSearchADD  LIMIT $start, $planLength ")->result_object();
        $pageData["pro"] = $this->db->query("SELECT * FROM prodact WHERE category_id = $id $theSearchADD  LIMIT $start, $planLength ")->result_object();



//        $pageData["prodact"] = $this->db->query("SELECT * FROM prodact WHERE 1 $theSearchADD  ")->result_object();

        $this->load->view('common/header', $this->headerData);
        $this->load->view('content/prodacts', $pageData);
        $this->load->view('common/footer', $this->footerData);

    }


















    public function submit(){
        $pageData = array();
        $this->load->view('common/header', $this->headerData);
        $this->load->view('content/submit-property', $pageData);
        $this->load->view('common/footer', $this->footerData);

    }
    public function add_submit(){
        $pageData = array();
        $this->load->view('common/header', $this->headerData);
        $this->load->view('content/addproperty', $pageData);
        $this->load->view('common/footer', $this->footerData);

    }



    function addEditUsers($id = 0) {
        $pageData = array();
        if ($id) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();
            $userData = $this->db->query("SELECT username,thePassword FROM users WHERE usId = $id AND isDeleted = 0")->result_object();
            if (empty($userData)) {
                header("Location: /panel/users");
                exit();
            }
            $userData = $userData[0];
            $pageData['pageTitle'] = 'Edit User';

            $returner["username"] = $userData->username;
            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add User';
            $pageData['id'] = 0;
        }

        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditUsers', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);
    }




    //SEO
    public function seo(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/seo", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }



    public function add_edit_seo($id = 0){
        $pageData = array();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $seo = $this->db->query("SELECT * FROM seo WHERE id = $id")->result_object();
            if (empty($seo)) {
                header("Location: /panel/seo/");
                exit();
            }
            $seos = $seo[0];
            $pageData['pageTitle'] = 'Edit Seo';

            $returner["theTitle"] = $seos->theTitle;

            $returner["theText"] = $seos->theText;




            $pageData['values'] = json_encode($returner);
        } else {
            echo "error";
        }

        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditSeo', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }






    public function map(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/map", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }



    public function add_edit_map($id = 0){
        $pageData = array();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $maps = $this->db->query("SELECT * FROM map WHERE id = $id")->result_object();
            if (empty($maps)) {
                header("Location: /panel/map/");
                exit();
            }
            $map = $maps[0];
            $pageData['pageTitle'] = 'Edit map';
            $returner["theText"] = $map->theText;




            $pageData['values'] = json_encode($returner);
        } else {
            echo "error";
        }

        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditMap', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }



    //iconss
    public function customicon(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/customicon", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }


    public function flaticon(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/flaticon", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }
    public function fontawesome5(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/fontawesome5", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function lineawesome(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/lineawesome", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function socicons(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/socicons", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }




    public function menuLink(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/menuLink", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }




    public function add_edit_menu_link($id = 0){
        $pageData = array();

        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner= array();
            $menulink =$this->db->query("SELECT * FROM menu_link WHERE id ='$id'")->result_object();
            $links =$this->db->query("SELECT * FROM links WHERE content_id = '$id' AND page ='menu_link'")->result_object();

            if (empty($menulink)) {
                header("Location: /panel/menulink/");

                exit();
            }
            $menulink = $menulink[0];
            $pageData['pageTitle'] = 'Edit service';
            $returner["theName"]= $menulink->theName;


            if ($links) {
                $returner["url"]=urldecode($links[0]->url);
            }

            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add MenuLink';
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditMenuLink', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }




    public function submenulink(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/submenulink", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }
    public function add_edit_submenulink($id = 0){
        $pageData = array();
        $pageData['menu'] = $this->db->query("SELECT * FROM menu_link ")->result_object();

        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner= array();
            $submenulink =$this->db->query("SELECT * FROM sub_menulink WHERE id ='$id'")->result_object();
            $links = $this->db->query("SELECT url FROM links WHERE content_id = '$id' AND page = 'submenulink' ")->result_object();

            if (empty($submenulink)) {
                header("Location: /panel/submenulink/");

                exit();
            }
            $submenulink = $submenulink[0];
            $pageData['pageTitle'] = 'Edit subcategoryloq';
            $returner["category_id"]= $submenulink->category_id;
            $returner["theNameen"]= $submenulink->theNameen;
            $returner["theNamear"]= $submenulink->theNamear;
            $returner["theNametr"]= $submenulink->theNametr;
            $returner["theTitletr"]= $submenulink->theTitletr;
            $returner["theTitleen"]= $submenulink->theTitleen;
            $returner["theTitlear"]= $submenulink->theTitlear;
            $returner["theTexttr"]= $submenulink->theTexttr;
            $returner["theTexten"]= $submenulink->theTexten;
            $returner["theTextar"]= $submenulink->theTextar;
            if ($links) {
                $returner["url"] = urldecode($links[0]->url);
            }

            $pageData["thePhoto"] = $submenulink->thePhoto;
            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add submenulink';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditSubmenulink', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }


    public function kullanci(){

        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/kullanci", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);




    }


    public function home_header(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/homeHeader", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function add_edit_home_header( $id=0 ){

        $pageData = array();


        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner = array();
            $home_header =$this->db->query("SELECT * FROM home_header WHERE id ='$id'")->result_object();

            if (empty($home_header)) {
                header("Location: /panel/home_header/");

                exit();
            }
            $home_header = $home_header[0];
            $pageData['pageTitle'] = 'Edit Home Header';

            $returner["alt"]= $home_header->alt;


            $pageData["thePhoto"] = $home_header->thePhoto;
            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add Home Header';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditHomeHeader', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }


    public function market(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/market", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function add_edit_market( $id=0 ){

        $pageData = array();


        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner = array();
            $market =$this->db->query("SELECT * FROM market WHERE id ='$id'")->result_object();

            if (empty($market)) {
                header("Location: /panel/market/");

                exit();
            }
            $market = $market[0];
            $pageData['pageTitle'] = 'Edit market';

            $returner["alt"]= $market->alt;
            $returner["theTitle"]= $market->theTitle;
            $returner["theText"]= $market->theText;


            $pageData["thePhoto"] = $market->thePhoto;
            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add market';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditMarket', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }




    public function photo(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/thePhoto", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function add_edit_photo( $id=0 ){

        $pageData = array();
        $pageData['prodact'] = $this->db->query("SELECT * FROM prodact ")->result_object();

        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner = array();


            $thePhoto =$this->db->query("SELECT * FROM thePhoto WHERE id ='$id'")->result_object();

            if (empty($thePhoto)) {
                header("Location: /panel/thePhoto/");

                exit();
            }
            $thePhoto = $thePhoto[0];
            $pageData['pageTitle'] = 'Edit photo';
            $returner["category_id"]= $thePhoto->category_id;

            $pageData["thePhoto"] = $thePhoto->thePhoto;
            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add photo';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditthePhoto', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }


    public function work(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/work", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function add_edit_work($id=0){

        $pageData = array();


        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner = array();
            $work =$this->db->query("SELECT * FROM ourwork WHERE id ='$id'")->result_object();

            if (empty($market)) {
                header("Location: /panel/work/");

                exit();
            }
            $work = $work[0];
            $pageData['pageTitle'] = 'Edit work';

            $returner["alt"]= $work->alt;
            $returner["theTitle"]= $work->theTitle;
            $returner["theText"]= $work->theText;


            $pageData["thePhoto"] = $work->thePhoto;
            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add work';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditWork', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }




    public function aboutcard(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/aboutcard", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function add_edit_aboutcard($id=0){

        $pageData = array();


        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner = array();
            $aboutcard =$this->db->query("SELECT * FROM aboutcard WHERE id ='$id'")->result_object();

            if (empty($aboutcard)) {
                header("Location: /panel/aboutcard/");

                exit();
            }
            $aboutcard = $aboutcard[0];
            $pageData['pageTitle'] = 'Edit Service';

            $returner["theTitle"]= $aboutcard->theTitle;
            $returner["theText"]= $aboutcard->theText;
            $returner["icon"]= $aboutcard->icon;

            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add Service';
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditAboutcard', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }
    public function opinion(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/opinion", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function add_edit_opinion( $id=0 ){

        $pageData = array();


        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner = array();
            $opinion =$this->db->query("SELECT * FROM opinion WHERE id ='$id'")->result_object();

            if (empty($opinion)) {
                header("Location: /panel/opinion/");

                exit();
            }
            $opinion = $opinion[0];
            $pageData['pageTitle'] = 'Edit customer comments';

            $returner["theName"]= $opinion->theName;
            $returner["theTitle"]= $opinion->theTitle;
            $returner["theText"]= $opinion->theText;
            $returner["theIcone"]= $opinion->theIcone;
            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add customer comments';
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditOpinion', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function cities(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/cities', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);
    }

    public function add_edit_cities($id=0){

        $pageData = array();
        $pageData['menu'] = $this->db->query("SELECT * FROM menu_link ")->result_object();


        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner = array();
            $cities =$this->db->query("SELECT * FROM cities WHERE id ='$id'")->result_object();
            $links = $this->db->query("SELECT url FROM links WHERE content_id = '$id' AND page = 'cities' ")->result_object();


            if (empty($cities)) {
                header("Location: /panel/cities/");

                exit();
            }
            $cities = $cities[0];
            $pageData['pageTitle'] = 'Edit cities';

            $returner["theName"]= $cities->theName;
            $returner["category_id"]= $cities->category_id;

            if ($links) {
                $returner["url"] = urldecode($links[0]->url);
            }

            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add city';
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditCities', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }
    public function projectheader(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/projectheader", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function add_edit_projectheader( $id=0 ){

        $pageData = array();


        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner = array();
            $projectheader =$this->db->query("SELECT * FROM projectheader WHERE id ='$id'")->result_object();

            if (empty($projectheader)) {
                header("Location: /panel/projectheader/");

                exit();
            }
            $projectheader = $projectheader[0];
            $pageData['pageTitle'] = 'Edit header';

            $returner["alt"]= $projectheader->alt;
            $returner["theTitle"]= $projectheader->theTitle;


            $pageData["thePhoto"] = $projectheader->thePhoto;
            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add Header';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditProjectheader', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }


    public function prodact(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/prodact", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }

    public function add_edit_prodact($id=0){

        $pageData = array();
        $pageData['cities'] = $this->db->query("SELECT * FROM cities ")->result_object();



        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner = array();
            $prodact =$this->db->query("SELECT * FROM prodact WHERE id ='$id'")->result_object();
            $links = $this->db->query("SELECT url FROM links WHERE content_id = '$id' AND page = 'prodact' ")->result_object();


            if (empty($prodact)) {
                header("Location: /panel/prodact/");

                exit();
            }
            $prodact = $prodact[0];
            $pageData['pageTitle'] = 'Edit prodact';

//            $returner["alt"]= $prodact->alt;
            $returner["theType"]= $prodact->theType;
            $returner["theRoom"]= $prodact->theRoom;
            $returner["theLocation"]= $prodact->theLocation;
            $returner["thePrice"]= $prodact->thePrice;
            $returner["theText"]= $prodact->theText;
            $returner["theTitle"]= $prodact->theTitle;

            $returner["theBath"]= $prodact->theBath;
            $returner["theNameHome"]= $prodact->theNameHome;
            $returner["parking"]= $prodact->parking;
            $returner["balcony"]= $prodact->balcony;
            $returner["cable"]= $prodact->cable;
            $returner["pool"]= $prodact->pool;
            $returner["garden"]= $prodact->garden;
            $returner["category_id"]= $prodact->category_id;
            if ($links) {
                $returner["url"] = urldecode($links[0]->url);
            }


            $pageData["thePhoto"] = $prodact->thePhoto;
            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add prodact';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditProdact', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }



    //footer1
    public function footer1(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/footer1", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }


    public function add_edit_footer1($id = 0){
        $pageData = array();
        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner= array();
            $footer1 =$this->db->query("SELECT * FROM footer1 WHERE id ='$id'")->result_object();
            if (empty($footer1)) {
                header("Location: /panel/footer1/");

                exit();
            }
            $footer1 = $footer1[0];
            $pageData['pageTitle'] = 'Edit First Section';

            $returner["theText"]= $footer1->theText;

            $pageData["thePhoto"] = $footer1->thePhoto;
            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add First Section';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditFooter1', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }

    //footer2
    public function footer2(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/footer2", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }


    public function add_edit_footer2($id = 0){
        $pageData = array();
        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner= array();
            $footer2 =$this->db->query("SELECT * FROM footer2 WHERE id ='$id'")->result_object();
            if (empty($footer2)) {
                header("Location: /panel/footer2/");

                exit();
            }
            $footer2 = $footer2[0];
            $pageData['pageTitle'] = 'Edit SecondSection';
            $returner["theEmail1"]= $footer2->theEmail1;
            $returner["theEmail2"]= $footer2->theEmail2;
            $returner["thePhone1"]= $footer2->thePhone1;
            $returner["thePhone2"]= $footer2->thePhone2;
            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add Second Section';
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditFooter2', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }






    //footer3
    public function footer3(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/footer3", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }


    public function add_edit_footer3($id = 0){
        $pageData = array();
        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner= array();
            $footer3 =$this->db->query("SELECT * FROM footer3 WHERE id ='$id'")->result_object();
            if (empty($footer3)) {
                header("Location: /panel/footer3/");

                exit();
            }
            $footer3 = $footer3[0];
            $pageData['pageTitle'] = 'Edit ThirdSection';
            $returner["theTitle"]= $footer3->theTitle;
            $returner["icon"]= $footer3->icon;
            $returner["url"]= $footer3->url;

            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add Third Section';
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditFooter3', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }






    //footer4
    public function footer4(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/footer4", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }


    public function add_edit_footer4($id = 0){
        $pageData = array();
        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner= array();
            $footer4 =$this->db->query("SELECT * FROM footer4 WHERE id ='$id'")->result_object();
            if (empty($footer4)) {
                header("Location: /panel/footer4/");

                exit();
            }
            $footer4 = $footer4[0];
            $pageData['pageTitle'] = 'Edit ThirdSection';
            $returner["theAddress"]= $footer4->theAddress;


            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add forth Section';
            $pageData['id'] = 0;
        }
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditFooter4', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }




    //footer4
    public function prodactUser(){
        $pageData = array();
        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view("panel/prodactUser", $pageData);
        $this->load->view("panel/common/footer", $this->footerData);

    }


    public function add_edit_prodactss($id = 0){

        $pageData = array();
        $pageData['cities'] = $this->db->query("SELECT * FROM cities ")->result_object();



        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner = array();
            $prodact =$this->db->query("SELECT * FROM prodact WHERE id ='$id'")->result_object();
            $links = $this->db->query("SELECT url FROM links WHERE content_id = '$id' AND page = 'prodact' ")->result_object();


            if (empty($prodact)) {
                header("Location: /panel/prodact/");

                exit();
            }
            $prodact = $prodact[0];
            $pageData['pageTitle'] = 'Edit prodact';

            $returner["theType"]= $prodact->theType;
            $returner["theRoom"]= $prodact->theRoom;
            $returner["theLocation"]= $prodact->theLocation;
            $returner["thePrice"]= $prodact->thePrice;
            $returner["theText"]= $prodact->theText;
            $returner["theTitle"]= $prodact->theTitle;

            $returner["theBath"]= $prodact->theBath;
            $returner["theNameHome"]= $prodact->theNameHome;
            $returner["parking"]= $prodact->parking;
            $returner["balcony"]= $prodact->balcony;
            $returner["cable"]= $prodact->cable;
            $returner["pool"]= $prodact->pool;
            $returner["garden"]= $prodact->garden;
            $returner["category_id"]= $prodact->category_id;
            if ($links) {
                $returner["url"]=urldecode($links[0]->url);
            }



            $pageData["values"] = json_encode($returner);

        }else {
            $pageData['pageTitle'] = 'Add prodact';

            $pageData['id'] = 0;
        }

        $this->load->view("panel/common/header", $this->headerData);
        $this->load->view('panel/addEditProdactUsr', $pageData);
        $this->load->view("panel/common/footer", $this->footerData);


    }












    function ajax($param1, $param2 = 0, $param3 = 0)
    {
        switch ($param1) {

            //Users
            case "getUsers":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT usId, username, lastlogin FROM users WHERE (username LIKE '%" . $sSearch . "%')AND isDeleted = 0 ORDER BY usId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM users WHERE isDeleted = 0")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $actions = "<div class='actionsIcon'><a href='/panel/addEditUsers/{$dt->usId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
//                    $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteUser/{$dt->usId}' data-name='{$dt->username}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
                    $date = Date("d/m/Y", strtotime($dt->lastlogin));
                    $returnToServer["aaData"][] = array(
                        $dt->username,
                        $date,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditUsers":

                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('thePassword', 'Password', 'required');

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();

                    $processArr["username"] = $this->Checkdata->checkInputData($this->input->post("username"));
                    $processArr["thePassword"] = $this->Checkdata->checkInputData(sha1($this->input->post("thePassword")));
                    $processArr["lastlogin"] = Date("Y-m-d H:i:s");

                    if ($id != 0) {
                        // check password
                        $checkPassword = $this->db->query('SELECT thePassword FROM users WHERE username = "' . $processArr["username"] . '" AND isDeleted = 0')->result_object();
                        if ($checkPassword) {
                            if ($checkPassword[0]->thePassword == $this->input->post("thePassword")) {
                                unset($processArr["thePassword"]);
                            }
                        }

                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);
                        $this->db->update("users", $processArr, array('usId' => $id));
                    } else {

                        $this->db->insert("users", $processArr);
                    }
                    echo 1;
                }

                break;

            case "deleteUser":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $processArr = array();
                $processArr["isDeleted"] = 1;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);
                $this->db->where('usId', $id);
                $this->db->update("users", $processArr, array('usId' => $id));
                echo 1;
                break;
















            case "getMenuLink":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM menu_link  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM menu_link ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {
                    $links = $this->db->query("SELECT url FROM links WHERE content_id = $dt->id AND page = 'menu_link' ")->result_object();
                    if ($links) {
                        $linkName = $links[0]->url;
                    } else {
                        $linkName = '';
                    }


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_menu_link/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    // $actions .= "<div class='d-inline mr-4'><a href='javascript:;' data-href='/panel/ajax/deleteMenuLink/{$dt->id}' data-name='{$dt->theNametr}' class='deleteButton'><i class='glyphicon glyphicon-trash text-danger'></i></a> </div>";

                    $returnToServer["aaData"][] = array(

                        $dt->theName,

                        $linkName,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditMenuLink":
                $this->load->helper('form');
                $this->load->library('form_validation');
                $id = $this->Checkdata->checkInputData($this->input->post("id"));

                $this->form_validation->set_rules('id', 'Photo', 'required');
                //  $this->form_validation->set_rules('url', 'URL', 'required')
                $url = urlencode(str_replace(" ", "-", $this->Checkdata->permalink($this->input->post("url"))));
                $page = 'menu_link';
                $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url'")->result();
                if ($id > 0) {
                    $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url' AND content_id != '$id'")->result();

                }
                if ($theURL) {
                    $this->form_validation->set_rules('url2', 'URL', 'required');
                }

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theName"] = $this->input->post("theName");

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        if ($this->db->update("menu_link", $processArr, array('id' => $id))) {
                            $processArr2['url'] = "$url";
                            $this->db->where('page', "$page")->where('content_id', $id);
                            $this->db->update("links", $processArr2);
                        }
                    } else {
                        if ($this->db->insert("menu_link", $processArr)) {
                            $id = $this->db->insert_id();
                            $processArr2['content_id'] = $id;
                            $processArr2['page'] = "$page";
                            $processArr2['url'] = "$url";
                            $this->db->insert("links", $processArr2);

                        }
                    }
                    echo 1;
                }
                break;

            case "deleteMenuLink":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);


                if ($this->db->delete("menu_link", array('id' => $id))) {
                    $this->db->where('page', "menu_link")->where('content_id', $id);
                    $this->db->delete("links");
                }
                echo 1;
                break;


            case "getSubmenuLink":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM sub_menulink  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM sub_menulink ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {
                    $menulink = $this->db->query("SELECT * FROM menu_link WHERE id = '$dt->category_id' ")->result_object();

                    if ($menulink) {
                        $menulinkName = $menulink[0]->theNameen;
                    } else {
                        $menulinkName = NULL;
                    }


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_submenulink/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteSubmenulink\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                    $returnToServer["aaData"][] = array(
                        '<img src="' . $dt->thePhoto . '" width="80">',
                        $dt->theTitletr,
                        $dt->theTitleen,
                        $dt->theTitlear,
                        $menulinkName,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditSubmenulink":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');
                $this->form_validation->set_rules('url', 'URL', 'required');
                $id = $this->Checkdata->checkInputData($this->input->post("id"));


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));
                $url = urlencode(str_replace(" ", "-", $this->Checkdata->permalink($this->input->post("url"))));
                $page = 'submenulink';
                $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url'")->result();
                if ($id > 0) {
                    $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url' AND content_id != '$id'")->result();

                }
                if ($theURL) {
                    $this->form_validation->set_rules('url2', 'URL', 'required');
                }

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theNametr"] = $this->input->post("theNametr");
                    $processArr["theNamear"] = $this->input->post("theNamear");
                    $processArr["theNameen"] = $this->input->post("theNameen");
                    $processArr["theTitletr"] = $this->input->post("theTitletr");
                    $processArr["theTitlear"] = $this->input->post("theTitlear");
                    $processArr["theTitleen"] = $this->input->post("theTitleen");
                    $processArr["theTexttr"] = $this->input->post("theTexttr");
                    $processArr["theTextar"] = $this->input->post("theTextar");
                    $processArr["theTexten"] = $this->input->post("theTexten");
                    $processArr["category_id"] = $this->input->post("category_id");

                    if ($thePhoto){
                        $photo = explode("/public", $thePhoto);
                        $photo = "/public".$photo[1];
                        $processArr["thePhoto"] = $photo;
                    }

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        if ($this->db->update("sub_menulink", $processArr, array('id' => $id))) {
                            $processArr2['url'] = "$url";
                            $this->db->where('page', "$page")->where('content_id', $id);
                            $this->db->update("links", $processArr2);

                        }
                    } else {
                        if ($this->db->insert("sub_menulink", $processArr)) {
                            $id = $this->db->insert_id();
                            $processArr2['content_id'] = $id;
                            $processArr2['page'] = "$page";
                            $processArr2['url'] = "$url";
                            $this->db->insert("links", $processArr2);

                        }
                    }
                    echo 1;
                }
                break;

            case "deleteSubmenulink":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM sub_menulink WHERE id = '$id'")->result();
                $photoExist = "public/uploads/php/files/sub_menulink/".$checkPhoto[0]->thePhoto;
                if ($checkPhoto && (file_exists($photoExist))) {
                    unlink('public/uploads/php/files/sub_menulink/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/sub_menulink/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/sub_menulink/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("sub_menulink", array('id' => $id));
                echo 1;
                break;


            case "getKullanci":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM kullanci  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM kullanci ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {


                    $returnToServer["aaData"][] = array(
                        $dt->theName,
                        $dt->theEmail,



                    );
                }
                echo json_encode($returnToServer);
                break;









            case "getSeo":

                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM seo  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM seo ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"]= array();
                foreach ($result as $dt){

                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_seo/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";

                    $returnToServer["aaData"][] = array(
                        $dt->theTitle,
                        $dt->theText,

                        $actions
                    );

                }


                echo json_encode($returnToServer);


                break;



            case "addEditSeo":

                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {

                    $processArr = array();

                    $processArr["theTitle"] = $this->input->post("theTitle");
                    $processArr["theText"] = $this->input->post("theText");





                    if ($id !=0){
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $this->db->update("seo", $processArr, array('id' => $id));
                    }else{
                        echo "error";
                    }

                    echo 1;

                }

                break;



            case "getHomeHeader":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM home_header  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM home_header ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_home_header/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";

                    $returnToServer["aaData"][] = array(
                        '<img src="' . $dt->thePhoto . '" width="80">',
                        $dt->alt,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditHomeHeader":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["alt"] = $this->input->post("alt");


                    if ($thePhoto){
                        $photo = explode("/public", $thePhoto);
                        $photo = "/public".$photo[1];
                        $processArr["thePhoto"] = $photo;
                    }

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        $this->db->update("home_header", $processArr, array('id' => $id));
                    } else {
                        $this->db->insert("home_header", $processArr);
                    }
                    echo 1;
                }
                break;



            case "getMarket":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM market  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM market ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_market/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteMarket\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                    $returnToServer["aaData"][] = array(
                        '<img src="' . $dt->thePhoto . '" width="80">',
                        $dt->theTitle,
                        $dt->alt,

                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditMarket":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["alt"] = $this->input->post("alt");
                    $processArr["theTitle"] = $this->input->post("theTitle");
                    $processArr["theText"] = $this->input->post("theText");


                    if ($thePhoto){
                        $photo = explode("/public", $thePhoto);
                        $photo = "/public".$photo[1];
                        $processArr["thePhoto"] = $photo;
                    }

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        $this->db->update("market", $processArr, array('id' => $id));
                    } else {
                        $this->db->insert("market", $processArr);
                    }
                    echo 1;
                }
                break;
            case "deleteMarket":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM market WHERE id = '$id'")->result();
                $photoExist = "public/uploads/php/files/market/".$checkPhoto[0]->thePhoto;
                if ($checkPhoto && (file_exists($photoExist))) {
                    unlink('public/uploads/php/files/market/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/market/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/market/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("market", array('id' => $id));
                echo 1;
                break;
            case "getWork":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM ourwork  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM ourwork ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_work/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteWork\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                    $returnToServer["aaData"][] = array(
                        '<img src="' . $dt->thePhoto . '" width="80">',
                        $dt->theTitle,
                        $dt->alt,

                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditWork":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["alt"] = $this->input->post("alt");
                    $processArr["theTitle"] = $this->input->post("theTitle");
                    $processArr["theText"] = $this->input->post("theText");


                    if ($thePhoto){
                        $photo = explode("/public", $thePhoto);
                        $photo = "/public".$photo[1];
                        $processArr["thePhoto"] = $photo;
                    }

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        $this->db->update("ourwork", $processArr, array('id' => $id));
                    } else {
                        $this->db->insert("ourwork", $processArr);
                    }
                    echo 1;
                }
                break;
            case "deleteWork":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM ourwork WHERE id = '$id'")->result();
                $photoExist = "public/uploads/php/files/market/".$checkPhoto[0]->thePhoto;
                if ($checkPhoto && (file_exists($photoExist))) {
                    unlink('public/uploads/php/files/work/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/work/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/work/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("ourwork", array('id' => $id));
                echo 1;
                break;




            case "getAboutcard":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM aboutcard  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM aboutcard ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_aboutcard/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteAboutcard\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                    $returnToServer["aaData"][] = array(
                        '<i style="margin-left:0px;" class="' .  $dt->icon . '" width="80"></i>',
                        $dt->theTitle,

                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditAboutcard":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["icon"] = $this->input->post("icon");
                    $processArr["theTitle"] = $this->input->post("theTitle");
                    $processArr["theText"] = $this->input->post("theText");

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        $this->db->update("aboutcard", $processArr, array('id' => $id));
                    } else {
                        $this->db->insert("aboutcard", $processArr);
                    }
                    echo 1;
                }
                break;
            case "deleteAboutcard":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $this->db->delete("aboutcard", array('id' => $id));
                echo 1;
                break;



            case "getOpinion":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM opinion  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM opinion ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_opinion/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteOpinion\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                    $returnToServer["aaData"][] = array(
                        '<i  class="' . $dt->theIcone . '" width="80" ></i> ',
                        $dt->theTitle,
                        $dt->theName,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditOpinion":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();

                    $processArr["theTitle"] = $this->input->post("theTitle");
                    $processArr["theText"] = $this->input->post("theText");
                    $processArr["theIcone"] = $this->input->post("theIcone");
                    $processArr["theName"] = $this->input->post("theName");




                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        $this->db->update("opinion", $processArr, array('id' => $id));
                    } else {
                        $this->db->insert("opinion", $processArr);
                    }
                    echo 1;
                }
                break;
            case "deleteOpinion":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $this->db->delete("opinion", array('id' => $id));
                echo 1;
                break;


            case "getCities":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM cities  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM cities ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {
                    $menulink = $this->db->query("SELECT * FROM menu_link WHERE id = '$dt->category_id' ")->result_object();

                    if ($menulink) {
                        $menulinkName = $menulink[0]->theName;
                    } else {
                        $menulinkName = NULL;
                    }
                    $links = $this->db->query("SELECT url FROM links WHERE content_id = $dt->id AND page = 'cities' ")->result_object();
                    if ($links) {
                        $linkName = $links[0]->url;
                    } else {
                        $linkName = '';
                    }


//                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_cities/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";

                    $returnToServer["aaData"][] = array(

                        $dt->theName,
                        $menulinkName,
                        $linkName,

//                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditCities":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');
                $this->form_validation->set_rules('url', 'URL', 'required');
                $id = $this->Checkdata->checkInputData($this->input->post("id"));


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));
                $url = urlencode(str_replace(" ", "-", $this->Checkdata->permalink($this->input->post("url"))));
                $page = 'cities';
                $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url'")->result();
                if ($id > 0) {
                    $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url' AND content_id != '$id'")->result();

                }
                if ($theURL) {
                    $this->form_validation->set_rules('url2', 'URL', 'required');
                }

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theName"] = $this->input->post("theName");

                    $processArr["category_id"] = $this->input->post("category_id");



                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        if ($this->db->update("cities", $processArr, array('id' => $id))) {
                            $processArr2['url'] = "$url";
                            $this->db->where('page', "$page")->where('content_id', $id);
                            $this->db->update("links", $processArr2);

                        }
                    } else {
                        if ($this->db->insert("cities", $processArr)) {
                            $id = $this->db->insert_id();
                            $processArr2['content_id'] = $id;
                            $processArr2['page'] = "$page";
                            $processArr2['url'] = "$url";
                            $this->db->insert("links", $processArr2);

                        }
                    }
                    echo 1;
                }
                break;


            case "getProjectheader":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM projectheader  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM projectheader ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {



                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_projectheader/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";

                    $returnToServer["aaData"][] = array(
                        '<img src="' . $dt->thePhoto . '" width="80">',
                        $dt->theTitle,
                        $dt->alt,


                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditProjectheader":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["alt"] = $this->input->post("alt");
                    $processArr["theTitle"] = $this->input->post("theTitle");

                    if ($thePhoto){
                        $photo = explode("/public", $thePhoto);
                        $photo = "/public".$photo[1];
                        $processArr["thePhoto"] = $photo;
                    }

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        $this->db->update("projectheader", $processArr, array('id' => $id));
                    } else {
                        $this->db->insert("projectheader", $processArr);
                    }
                    echo 1;
                }
                break;


            case "getProdact":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM prodact  WHERE   user_id = 0  ORDER BY id DESC  LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM prodact ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {
                    $citeies = $this->db->query("SELECT theName FROM cities WHERE id = '$dt->category_id'")->result();

                    if ($citeies) {
                        $city = $citeies[0]->theName;
                    }else {
                        $city = NULL;
                    }


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_prodact/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteProdact\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                    $returnToServer["aaData"][] = array(
                        '<img src="' . $dt->thePhoto . '" width="80">',
                        $dt->theTitle,
                        $city,
                        $actions
                    );
                }

                echo json_encode($returnToServer);
                break;

            case "addEditProdact":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));
                $url = urlencode(str_replace(" ","-",$this->Checkdata->permalink($this->input->post("url"))));
                $page = 'prodact';
                $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url'")->result();
                if($id > 0){
                    $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url' AND content_id != '$id'")->result();

                }
                if($theURL){
                    // $this->form_validation->set_rules('url2', 'URL', 'required');
                }

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
//                    $processArr["alt"] = $this->input->post("alt");
                    $processArr["theType"] = $this->input->post("theType");
                    $processArr["theRoom"] = $this->input->post("theRoom");
                    $processArr["theLocation"] = $this->input->post("theLocation");
                    $processArr["thePrice"] = $this->input->post("thePrice");
                    $processArr["theText"] = $this->input->post("theText");
                    $processArr["theTitle"] = $this->input->post("theTitle");
                    $processArr["theBath"] = $this->input->post("theBath");
                    $processArr["theNameHome"] = $this->input->post("theNameHome");
                    $processArr["category_id"] = $this->input->post("category_id");
                    $processArr["parking"] = $this->input->post("parking");
                    $processArr["balcony"] = $this->input->post("balcony");
                    $processArr["cable"] = $this->input->post("cable");
                    $processArr["pool"] = $this->input->post("pool");
                    $processArr["garden"] = $this->input->post("garden");
                    $processArr["user_id"] = 0;
                    $processArr["status"] = 1;




                    if ($thePhoto){
                        $photo = explode("/public", $thePhoto);
                        $photo = "/public".$photo[1];
                        $processArr["thePhoto"] = $photo;
                    }

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        if ($this->db->update("prodact", $processArr, array('id' => $id))){
                            $processArr2['url'] ="$url";
                            $this->db->where('page',"$page")->where('content_id',$id);
                            $this->db->update("links", $processArr2);

                        }
                    } else {
                        if ($this->db->insert("prodact", $processArr)){
                            $id = $this->db->insert_id();
                            $processArr2['content_id'] = $id;
                            $processArr2['page'] = "$page";
                            $processArr2['url'] = "$url";
                            $this->db->insert("links", $processArr2);
                        }
                    }
                    echo 1;
                }
                break;

            case "deleteProdact":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM prodact WHERE id = '$id'")->result();
                $photoExist = "public/uploads/php/files/prodact/".$checkPhoto[0]->thePhoto;
                if ($checkPhoto && (file_exists($photoExist))) {
                    unlink('public/uploads/php/files/prodact/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/prodact/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/prodact/medium/' . $checkPhoto[0]->thePhoto);
                }

                if ($this->db->delete("prodact", array('id' => $id))){

                    $this->db->where('page',"prodact")->where('content_id',$id);
                    $this->db->delete("links");
                    echo 1;
                }
//                echo 1;
                break;

            // footer1
            case "getFooter1":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM footer1  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM footer1 ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();

                foreach ($result as $dt) {


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_footer1/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";



                    $returnToServer["aaData"][] = array(
                        '<img src="' . $dt->thePhoto . '" width="80">',
                        $dt->theText,

                        $actions,
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditFooter1":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theText"] = $this->input->post("theText");



                    if ($thePhoto){
                        $photo = explode("/public", $thePhoto);
                        $photo = "/public".$photo[1];
                        $processArr["thePhoto"] = $photo;
                    }

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $this->db->update("footer1", $processArr, array('id' => $id));
                    } else {
                        $this->db->insert("footer1", $processArr);
                    }
                    echo 1;
                }
                break;



            case "getFooter2":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM footer2  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM footer2 ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_footer2/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteFooter2\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                    $returnToServer["aaData"][] = array(
                        $dt->theEmail1,
                        $dt->thePhone1,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditFooter2":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theEmail1"] = $this->input->post("theEmail1");
                    $processArr["theEmail2"] = $this->input->post("theEmail2");
                    $processArr["thePhone1"] = $this->input->post("thePhone1");
                    $processArr["thePhone2"] = $this->input->post("thePhone2");


                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        $this->db->update("footer2", $processArr, array('id' => $id));
                    } else {
                        $this->db->insert("footer2", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteFooter2":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);


                $this->db->delete("footer2", array('id' => $id));
                echo 1;
                break;


            case "getFooter3":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT * FROM footer3  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM footer3 ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_footer3/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteFooter3\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                    $returnToServer["aaData"][] = array(
                        '<i class="' . $dt->icon . '"></i>',
                        $dt->theTitle,
                        $dt->url,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditFooter3":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["icon"] = $this->input->post("icon");
                    $processArr["theTitle"] = $this->input->post("theTitle");
                    $processArr["url"] = $this->input->post("url");


                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        $this->db->update("footer3", $processArr, array('id' => $id));
                    } else {
                        $this->db->insert("footer3", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteFooter3":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);


                $this->db->delete("footer3", array('id' => $id));
                echo 1;
                break;


            case "getFooter4":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM footer4  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM footer4 ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_footer4/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";

                    $returnToServer["aaData"][] = array(
                        $dt->theAddress,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditFooter4":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theAddress"] = $this->input->post("theAddress");


                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                        $this->db->update("footer4", $processArr, array('id' => $id));
                    } else {
                        $this->db->insert("footer4", $processArr);
                    }
                    echo 1;
                }
                break;





            case "getMap":

                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM map  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM map ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"]= array();
                foreach ($result as $dt){

                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_map/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";

                    $returnToServer["aaData"][] = array(
                        $dt->theText,

                        $actions
                    );

                }


                echo json_encode($returnToServer);


                break;



            case "addEditMap":

                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {

                    $processArr = array();
                    $processArr["theText"] = $this->input->post("theText");





                    if ($id !=0){
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $this->db->update("map", $processArr, array('id' => $id));
                    }else{
                        $this->db->insert("map", $processArr);
                    }

                    echo 1;

                }

                break;


            case 'getPublish':

                $post_id = $this->Checkdata->checkInputData($this->input->post("post_id"));
                $processArr['status']=$this->input->post("status");
                $this->db->update("prodact", $processArr,array('id' =>  $post_id ));

                echo "1";
                break;



            case'DeletePublish':
                $id = $this->Checkdata->checkInputData($this->input->post("post_id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);


                $this->db->delete("prodact", array('id' => $id));

                echo "1";



                break;



            case "getProdactss":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM prodact WHERE user_id !=0  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM prodact_user ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {
                    $citeies = $this->db->query("SELECT theName FROM cities WHERE id = '$dt->category_id'")->result();

                    if ($citeies) {
                        $city = $citeies[0]->theName;
                    }else {
                        $city = NULL;
                    }


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_prodactss/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteProdactss\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                    $returnToServer["aaData"][] = array(
//                        '<img src="' . $dt->thePhoto . '" width="80">',
                        $dt->theTitle,
                        $city,
                        $actions
                    );
                }

                echo json_encode($returnToServer);
                break;


            case "addEditProdactss":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));


//                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));
                $url = urlencode(str_replace(" ","-",$this->Checkdata->permalink($this->input->post("theTitle"))));
                $page = 'prodact';
                $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url'")->result();
                if($id > 0){
                    $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url' AND content_id != '$id'")->result();

                }
                if($theURL){
                    // $this->form_validation->set_rules('url2', 'URL', 'required');
                }

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theType"] = $this->input->post("theType");
                    $processArr["theRoom"] = $this->input->post("theRoom");
                    $processArr["theLocation"] = $this->input->post("theLocation");
                    $processArr["thePrice"] = $this->input->post("thePrice");
                    $processArr["theText"] = $this->input->post("theText");
                    $processArr["theTitle"] = $this->input->post("theTitle");

                    $processArr["theBath"] = $this->input->post("theBath");
                    $processArr["theNameHome"] = $this->input->post("theNameHome");
                    $processArr["parking"] = $this->input->post("parking");
                    $processArr["balcony"] = $this->input->post("balcony");
                    $processArr["pool"] = $this->input->post("pool");
                    $processArr["cable"] = $this->input->post("cable");
                    $processArr["garden"] = $this->input->post("garden");
                    $processArr["category_id"] = $this->input->post("category_id");
//                    if ($thePhoto)
//                        $processArr["thePhoto"] = $thePhoto;
//
//                    if ($thePhoto1)
//                        $processArr["thePhoto1"] = $thePhoto1;
//                    if ($thePhoto2)
//                        $processArr["thePhoto2"] = $thePhoto2;
//
//                    if ($thePhoto)
//                        $processArr["thePhoto3"] = $thePhoto3;
//
//                    if ($thePhoto)
//                        $processArr["thePhoto4"] = $thePhoto4;



//                    if ($thePhoto){
//                        $photo = explode("/public", $thePhoto);
//                        $photo = "/public".$photo[1];
//                        $processArr["thePhoto"] = $photo;
//                    }

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);
                        $checkPhoto = $this->db->query("SELECT thePhoto FROM prodact WHERE id = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            unlink('public1/uploads/php/files/prodact_user /' . $checkPhoto[0]->thePhoto);
                            unlink('public1/uploads/php/files/prodact_user /thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public1/uploads/php/files/prodact_user /medium/' . $checkPhoto[0]->thePhoto);
                        }


                        $checkPhoto1 = $this->db->query("SELECT thePhoto1 FROM prodact WHERE id = $id")->result();
                        if ($thePhoto1 && $checkPhoto1) {
                            unlink('public1/uploads/php/files/prodact_user1 /' . $checkPhoto1[0]->thePhoto1);
                            unlink('public1/uploads/php/files/prodact_user1 /thumbnail/' . $checkPhoto1[0]->thePhoto1);
                            unlink('public1/uploads/php/files/prodact_user1 /medium/' . $checkPhoto1[0]->thePhoto1);
                        }

                        $checkPhoto2 = $this->db->query("SELECT thePhoto2 FROM prodact WHERE id = $id")->result();
                        if ($thePhoto2 && $checkPhoto2) {
                            unlink('public1/uploads/php/files/prodact_user2 /' . $checkPhoto2[0]->thePhoto2);
                            unlink('public1/uploads/php/files/prodact_user2 /thumbnail/' . $checkPhoto2[0]->thePhoto2);
                            unlink('public1/uploads/php/files/prodact_user2 /medium/' . $checkPhoto2[0]->thePhoto2);
                        }
                        $checkPhoto3 = $this->db->query("SELECT thePhoto3 FROM prodact WHERE id = $id")->result();
                        if ($thePhoto3 && $checkPhoto4) {
                            unlink('public1/uploads/php/files/prodact_user3 /' . $checkPhoto3[0]->thePhoto3);
                            unlink('public1/uploads/php/files/prodact_user3 /thumbnail/' . $checkPhoto3[0]->thePhoto3);
                            unlink('public1/uploads/php/files/prodact_user3 /medium/' . $checkPhoto3[0]->thePhoto3);
                        }
                        $checkPhoto4 = $this->db->query("SELECT thePhoto4 FROM prodact WHERE id = $id")->result();
                        if ($thePhoto4 && $checkPhoto4) {
                            unlink('public1/uploads/php/files/prodact_user4 /' . $checkPhoto4[0]->thePhoto4);
                            unlink('public1/uploads/php/files/prodact_user4 /thumbnail/' . $checkPhoto4[0]->thePhoto4);
                            unlink('public1/uploads/php/files/prodact_user4 /medium/' . $checkPhoto4[0]->thePhoto4);
                        }


                        if ( $this->db->update("prodact", $processArr, array('id' => $id))) {
                            $processArr2['url'] ="$url";
                            $this->db->where('page', "$page")->where('content_id', $id);
                            $this->db->update("links", $processArr2);
                        }


                    } else {
                        if ( $this->db->insert("prodact", $processArr)) {
                            $id = $this->db->insert_id();
                            $processArr2['content_id'] = $id;
                            $processArr2['page'] = "$page";
                            $processArr2['url'] = "$url";
                            $this->db->insert("links", $processArr2);
                        }


                    }
                    echo 1;
                }
                break;

            case "deleteProdactss":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);
                $checkPhoto = $this->db->query("SELECT thePhoto FROM prodact WHERE id = $id")->result();
                if ($checkPhoto) {
                    unlink('public1/uploads/php/files/prodact_user/' . $checkPhoto[0]->thePhoto);
                    unlink('public1/uploads/php/files/prodact_user/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public1/uploads/php/files/prodact_user/medium/' . $checkPhoto[0]->thePhoto);
                }


                $checkPhoto1 = $this->db->query("SELECT thePhoto1 FROM prodact WHERE id = $id")->result();
                if ($checkPhoto1) {
                    unlink('public1/uploads/php/files/prodact_user1/' . $checkPhoto1[0]->thePhoto1);
                    unlink('public1/uploads/php/files/prodact_user1/thumbnail/' . $checkPhoto1[0]->thePhoto1);
                    unlink('public1/uploads/php/files/prodact_user1/medium/' . $checkPhoto1[0]->thePhoto1);
                }

                $checkPhoto2 = $this->db->query("SELECT thePhoto2 FROM prodact WHERE id = $id")->result();
                if ($checkPhoto2) {
                    unlink('public1/uploads/php/files/prodact_user2/' . $checkPhoto2[0]->thePhoto2);
                    unlink('public1/uploads/php/files/prodact_user2/thumbnail/' . $checkPhoto2[0]->thePhoto2);
                    unlink('public1/uploads/php/files/prodact_user2/medium/' . $checkPhoto2[0]->thePhoto2);
                }


                $checkPhoto3 = $this->db->query("SELECT thePhoto3 FROM prodact WHERE id = $id")->result();
                if ($checkPhoto3) {
                    unlink('public1/uploads/php/files/prodact_user3/' . $checkPhoto3[0]->thePhoto3);
                    unlink('public1/uploads/php/files/prodact_user3/thumbnail/' . $checkPhoto3[0]->thePhoto3);
                    unlink('public1/uploads/php/files/prodact_user3/medium/' . $checkPhoto3[0]->thePhoto3);
                }



                $checkPhoto4 = $this->db->query("SELECT thePhoto4 FROM prodact WHERE id = $id")->result();
                if ($checkPhoto3) {
                    unlink('public1/uploads/php/files/prodact_user4/' . $checkPhoto4[0]->thePhoto4);
                    unlink('public1/uploads/php/files/prodact_user4/thumbnail/' . $checkPhoto4[0]->thePhoto4);
                    unlink('public1/uploads/php/files/prodact_user4/medium/' . $checkPhoto4[0]->thePhoto4);
                }

                if ( $this->db->delete("prodact", array('id' => $id))) {
                    $this->db->where('page', "prodact")->where('content_id', $id);
                    $this->db->delete("links");
                    echo 1;
                }


                break;

























            case "getPhoto":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT * FROM thePhoto  ORDER BY id DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM thePhoto ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {
                    $prodact = $this->db->query("SELECT theTitle FROM prodact WHERE id = '$dt->category_id'")->result();

                    if ($prodact) {
                        $prodacts = $prodact[0]->theTitle;
                    }else {
                        $prodacts = NULL;
                    }


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/panel/add_edit_photo/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                    $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deletePhoto\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                    $returnToServer["aaData"][] = array(
                        '<img src="' . $dt->thePhoto . '" width="80">',
                        $prodacts,
                        $actions
                    );
                }

                echo json_encode($returnToServer);
                break;


            case "addEditPhoto":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));


              $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));


                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();

                    $processArr["category_id"] = $this->input->post("category_id");



                    if ($thePhoto){
                        $photo = explode("/public", $thePhoto);
                        $photo = "/public".$photo[1];
                        $processArr["thePhoto"] = $photo;
                    }

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);


                    $this->db->update("thePhoto", $processArr, array('id' => $id));




                    } else {
                        $this->db->insert("thePhoto", $processArr);



                    }
                    echo 1;
                }
                break;

            case "deletePhoto":
                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM thePhoto WHERE id = '$id'")->result();
                $photoExist = "public/uploads/php/files/photo/".$checkPhoto[0]->thePhoto;
                if ($checkPhoto && (file_exists($photoExist))) {
                    unlink('public/uploads/php/files/photo/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/photo/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/photo/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("thePhoto", array('id' => $id));


                echo 1;
                break;

















        }
    }
}
