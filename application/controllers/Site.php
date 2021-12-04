<?php
//use Mollie\Api\MollieApiClient;
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->headerData = array();
        $this->footerData = array();
        $this->load->helper("text");
        $this->load->library('session');

        $this->load->helper('form');
        $this->load->model('Checkdata', '', TRUE);
        // $this->load->model('Get_Lang', '', TRUE);
        $this->load->library('user_agent');
        $this->load->helper('url');
        $seo = $this->db->query("SELECT *  FROM seo ")->result_object();

        $this->headerData['pageTitle'] = $seo[0]->theTitle;
        $this->headerData['pageDescrption'] = $seo[0]->theText;




        $this->headerData['theSharePhoto'] = 'http://' . $_SERVER['SERVER_NAME'] . '/public/img/logo.png';
        // $this->headerData['metaDescription'] ="";


        $this->footerData['theColor'] = $this->db->query("SELECT theValue FROM site_setting")->result_object();
        $this->headerData['theColor'] = $this->db->query("SELECT theValue FROM site_setting")->result_object();
        $this->headerData['theLogo'] = $this->db->query("SELECT theValue FROM site_setting WHERE seId = 3")->result_object();
        $this->headerData["yusuf"] = 0;

        $this->headerData["menu_link"] = $this->db->query("SELECT * FROM menu_link ")->result_object();
        $this->headerData["footer11"] = $this->db->query("SELECT * FROM footer1 ")->result_object();

        $this->headerData["footer2"] = $this->db->query("SELECT * FROM footer2 ")->result_object();
        $this->headerData["footer3"] = $this->db->query("SELECT * FROM footer3 ")->result_object();
        $this->headerData["footer4"] = $this->db->query("SELECT * FROM footer4 ")->result_object();
//        $this->headerData["status"] =0;


        $this->footerData["footer11"] = $this->db->query("SELECT * FROM footer1 ")->result_object();
        $this->footerData["footer22"] = $this->db->query("SELECT * FROM footer2 ")->result_object();
        $this->footerData["footer33"] = $this->db->query("SELECT * FROM footer3 ")->result_object();
        $this->footerData["footer44"] = $this->db->query("SELECT * FROM footer4 ")->result_object();



//
//        $this->headerData['theLang'] = $theLang;
//       $this->headerData['langId'] = $langId;


        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }
    }


    public function index($url = Null, $url3 = NULL,$url4 = NULL) {
        $pageData = array();
        $theLang = $this->session->userdata("lang");

        if ($url) {
            $url2 = str_replace("-", "_", $url);
            if (method_exists($this, $url2)) {
                if ($url3) {
                    if ($url4) {
                        $this->$url2($url3,$url4);
                    }else{
                        $this->$url2($url3);
                    }
                } else {
                    $this->$url2();
                }
            } else {

                $checkURL = $this->db->query("SELECT page, content_id FROM links WHERE url = '$url'")->result_object();

                $thePage = $checkURL[0]->page;
                $theID = $checkURL[0]->content_id;
                if ($thePage == 'menu_link') {
                    $this->menu_link($theID);
                } elseif ($thePage == 'category') {
                    $this->prodact($theID);
                } elseif ($thePage == 'cities') {
                    $this->submenu_link($theID);
                }  elseif ($thePage == 'add_properity') {
                    $this->submit();
                } elseif ($thePage == ' addEditProperity') {
                    $this->add_submit();
                }elseif ($thePage == 'prodact') {
                    $this->subdetails($theID);


                }elseif ($thePage == 'prodactUser') {
                    $this->subdetails_user($theID);


                } else {
//                        $this->prodact();
                    header("Location: /");
                    exit();

                }
//                }
//                }
            }
        } else {






            $pageData["homeheader"] = $this->db->query("SELECT *  FROM home_header ")->result_object();


            $pageData["market"] = $this->db->query("SELECT * FROM market ")->result_object();
            $pageData["prodact"] = $this->db->query("SELECT * FROM prodact  WHERE status = 1 AND user_id = 0 LIMIT 3" )->result_object();

            $pageData["opinion"] = $this->db->query("SELECT * FROM opinion ")->result_object();










            $this->load->view('common/header', $this->headerData);
            $this->load->view('content/home', $pageData);
            $this->load->view('common/footer', $this->footerData);
        }


    }





//    public function login1() {
//        $pageData = array();
//        $pageData["status"] = 0;
//
//        if ($this->input->post()) {
//            $username = $this->Checkdata->checkInputData($this->input->post("theName"));
//            $password = $this->input->post("password");
//            $check = $this->db->query("select count(1) as cnt from kullanci where theName = '" . $username . "' and thePassword = '" . sha1($password) . "'")->result();
//            if ($check[0]->cnt > 0) {
//                $memberData = $this->db->query("select id from users where theName = '" . $username . "' and thePassword = '" . sha1($password) . "'")->result_array();
//                $session = array(
//                    'username' => $username,
//                    'id' => $memberData[0]["id"]
//                );
//                $this->session->set_userdata($session);
//                header("Location: /site/home/");
//            } else {
//                $pageData["status"] = 1;
//                $this->load->view("site/login", $pageData);
//            }
//        } else {
//
//            $this->load->view("site/login", $pageData);
//        }
//    }




    public function menu_link($id = 0){
        $pageData = array();
        $seo = $this->db->query("SELECT *  FROM seo ")->result_object();

        $this->headerData['pageTitle'] = $seo[0]->theTitle;
        $this->headerData['pageDescrption'] = $seo[0]->theText;


        $links = $this->db->query("SELECT * FROM links ")->result();
        $page1 = $links[0]->page;
        $content =$links[0]->id;
        $links = $this->db->query("SELECT * FROM links ")->result();
        $page1 = $links[0]->page;


//            print_r($page1);
        if ($id == 2 && $page1 =='menu_link') {
            $this->about_us();
        }elseif ($id == 4 && $page1 =="menu_link") {
            $this->prodact();
        }elseif ($id == 5 && $page1 =='menu_link') {
            $this->contact_us();

        }else {

//          $pageData['cities'] = $this->db->query("SELECT * FROM cities WHERE id=' $id'")->result_object();
//          $pageData['prodact'] = $this->db->query("SELECT * FROM prodact WHERE  category_id= '$id'")->result_object();
//
//          $this->load->view('common/header', $this->headerData);
//          $this->load->view('content/submenu', $pageData);
//          $this->load->view('common/footer', $this->footerData);
        }
    }

    public function about_us(){
        header("Location:/");
        }
    public function order(){
        $pageData = array();
        $user = $this->session->userdata("id");
        $user_id = $user;
        $prodact_id = $this->input->post("id");
        $thePrice = $this->input->post("thePrice");
        $theTitle = $this->input->post("theTitle");

        $exist =$this->db->query("SELECT id FROM oders WHERE  user_id = '$user' ")->result();

        if ($exist){
            $id= $exist[0]->id;


                $this->wishlist($id);


        }else{
            $processArr["user_id"] = $user;
            $processArr["prodact_id"] = $prodact_id;
            $processArr["thePrice"] = $thePrice;
            $processArr["theTitle"] =  $theTitle;


                $this->db->insert("oders", $processArr);
            $order =$this->db->query("SELECT * FROM oders WHERE  user_id = '$user' AND prodact_id = '$prodact_id' ")->result_object();
            $id= $order[0]->id;

            $this->wishlist($id);

        }





    }

    public function submenu_link($id =0){
        $pageData = array();

        if($this->input->get("page_no") > 1){
            $pageNum = $this->input->get("page_no");
        }else{
            $pageNum = 1;
        }
        $planLength = 15;
        if ($pageNum > 1) { $start = ($pageNum - 1) * $planLength; } else { $start = 0; }
        $pageData['pageNum'] = $pageNum;

//        $pageData["subAll"] = $this->db->query("SELECT * FROM prodact  ")->result_object();




        $pageData["allProductsNUM"] = $this->db->query("SELECT * FROM prodact WHERE 1  ")->result_object();





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
        $pageData["prodact"] = $this->db->query("SELECT * FROM prodact WHERE category_id= '$id'  AND status = 1   LIMIT $start, $planLength ")->result_object();
//        $pageData["pro"] = $this->db->query("SELECT * FROM prodact_user WHERE category_id = '$id'  AND status = 1  LIMIT $start, $planLength ")->result_object();





        $pageData['cities'] = $this->db->query("SELECT * FROM cities WHERE id=' $id'")->result_object();
//            $pageData['prodact'] = $this->db->query("SELECT * FROM prodact WHERE  category_id= '$id'")->result_object();




        $this->load->view('common/header', $this->headerData);
        $this->load->view('content/submenu', $pageData);
        $this->load->view('common/footer', $this->footerData);
    }




//    public function wishlist(){
//$pageData = array();
//$this->load->database();
//$this->load->helper('url');
//$this->load->library('session');
//$this->load->helper('form');
//$this->load->library('API/mollie_api_autoloader');
//$this->load->library('API/mollie_api_client');
//if($this->config->item('Mollie_status')=="test"){
//$this->mollie_api_client->setApiKey("test_RfxMJ42kDBNMkPnTP6aWKzBsvR35gj");
//}else{
//    $this->mollie_api_client->setApiKey("test_RfxMJ42kDBNMkPnTP6aWKzBsvR35gj");
//}
//
//$order_id=rand(10,100);
////        $subscription = $this->input->post('payment_type');
//$subscription = $this->input->post('payment_type');
//if($subscription==1) {
//    $customer = $this->mollie_api_client->customers->create(array(
//        "name" => $this->input->post('consumerName'),
//        "email" => $this->input->post('email'),
//    ));
//}
//
//echo "<p>Customer created with id ". $customer->id."</p>";
//
//$payment = $this->mollie_api_client->payments->create(array(
//    "amount"      =>10 ,
//    "description" =>"gregrthh" ,
//    "redirectUrl" => "http://www.example.org/ci/Mollie/order/".$order_id."/?type=".$order_id."",
//    "webhookUrl"  => "http://www.example.org/ci/Mollie/mollie_webhook/",
////                http://megaclassifieds.in/ci/Mollie/order/90/?type=0
//));
////            $this->database_write($order_id, $payment->id);
////            $query = $this->db->query("insert into payment(payment_id,order_id,mode,amount,description,status,createdDatetime) values ('".$payment->id."','".$order_id."','".$payment->mode."','".$payment->amount."','".$payment->description."','".$payment->status."','".$payment->createdDatetime."')");
//
//$this->session->set_userdata('payment_id', $payment->id);
//
//header("Location: " . $payment->getPaymentUrl());
////        }
//$this->load->view('admin/addEditHomeSlider', $pageData);
//    }



    public function wishlist($id =0){
        $pageData = array();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('API/mollie_api_autoloader');
        $this->load->library('API/mollie_api_client');
        if($this->config->item('Mollie_status')=="test"){
            $this->mollie_api_client->setApiKey("test_RfxMJ42kDBNMkPnTP6aWKzBsvR35gj");
        }else{
            $this->mollie_api_client->setApiKey("test_RfxMJ42kDBNMkPnTP6aWKzBsvR35gj");
        }


        $oders =$this->db->query("SELECT * FROM oders WHERE  id = '$id' ")->result();

        $price_id = $oders[0]->thePrice;
       $theTitle = $oders[0]->theTitle;
        $order_id = $oders[0]->id;
//        $order_id=rand(10,100);
//

        $payment = $this->mollie_api_client->payments->create(array(
            // "amount"      => $this->input->post('thePrice') ,
              "amount"      => $price_id,
//            'customerId'    => $customer->id,
            // "description" =>$this->input->post('theTitle') ,
            "description" => $theTitle ,

            "redirectUrl" => "http://www.example.org/ci/Mollie/order/".$order_id."/?type=".$order_id."",
            "webhookUrl"  => "http://www.example.org/ci/Mollie/mollie_webhook/",
//                http://megaclassifieds.in/ci/Mollie/order/90/?type=0
        ));
//            $this->database_write($order_id, $payment->id);
//            $query = $this->db->query("insert into payment(payment_id,order_id,mode,amount,description,status,createdDatetime) values ('".$payment->id."','".$order_id."','".$payment->mode."','".$payment->amount."','".$payment->description."','".$payment->status."','".$payment->createdDatetime."')");

        $this->session->set_userdata('payment_id', $payment->id);

        header("Location: " . $payment->getPaymentUrl());
//        }


    }

    public function front_login() {

//    $username = $this->input->post("theName");
        $theEmail = $this->input->post("theEmail");

        $password = $this->input->post("thePassword");


        $check = $this->db->query("SELECT count(1) as cnt FROM kullanci WHERE theEmail = '" . $theEmail . "' AND thePassword = '" . sha1($password) . "'")->result();
        $checks = $this->db->query("select * FROM kullanci WHERE theEmail = '" . $theEmail . "' AND thePassword = '" . sha1($password) . "' ")->result();
        if ($check[0]->cnt > 0) {
//        $memberData = $this->db->query("SELECT *  FROM kullanci WHERE theName = '" . $username . "' AND thePassword = '" . sha1($password) . "'")->result_array();
            $session = array(
                'name' =>  $checks[0]->theName,
                'email1' =>$theEmail ,
                'id' => $checks[0]->id
            );

            $this->session->set_userdata($session);
            header("Location:https://hurenkangoedkoper.com");
        }else{
            $this->session->set_flashdata('category_error', 'please check your password and username.');
            header("Location:https://hurenkangoedkoper.com");


        }

    }





        public function prodacttts($id = 0){
            $pageData = array();
    //
            $theSearch = $this->input->get("term");
//            header("Location: /$theSearch");
             $theSearch = str_replace(array('"',"'","#","SELECT","ORDER","EXTRACTVALUE","OR","AND","CONCAT"),"",$theSearch);
            if($theSearch ){
               $theSearchADD = "AND (theLocation LIKE '%$theSearch' OR theLocation LIKE '%$theSearch%' OR theLocation LIKE '$theSearch%') ";
            //
           }else{
                $theSearchADD ="";
          }



            if($this->input->get("page_no") > 1){
                $pageNum = $this->input->get("page_no");
            }else{
                $pageNum = 1;
            }
            $planLength = 15;
            if ($pageNum > 1) { $start = ($pageNum - 1) * $planLength; } else { $start = 0; }
            $pageData['pageNum'] = $pageNum;
            $pageData["allProductsNUM"] = $this->db->query("SELECT * FROM prodact WHERE 1 $theSearchADD ")->result_object();
            $pageData["prodact"] = $this->db->query("SELECT * FROM prodact WHERE 1 $theSearchADD LIMIT $start, $planLength ")->result_object();
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

            $this->load->view('common/header', $this->headerData);
            $this->load->view('content/prodacts', $pageData);
            $this->load->view('common/footer', $this->footerData);

        }


    function logout1() {
        $this->session->sess_destroy();
        header("Location:1");
    }

    public function submit($id = 0){

        $pageData = array();
        $pageData['cities'] = $this->db->query("SELECT * FROM cities ")->result_object();

        if ($id !=0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);
            $pageData['id'] =$id;
            $returner= array();
            $user = $this->session->userdata("id");
//            AND user_id ='$user'
            $prodact =$this->db->query("SELECT * FROM prodact WHERE id ='$id' AND user_id ='$user'")->result_object();
//            $links = $this->db->query("SELECT url FROM links WHERE content_id = '$id' AND page = 'prodactUser' ")->result_object();
            $links = $this->db->query("SELECT url FROM links WHERE content_id = '$id' AND page = 'prodact' ")->result_object();

            if (empty($prodact)) {
                header("Location: /");

                exit();
            }
            $prodact = $prodact[0];

//            $pageData['pageTitle'] = 'Edit prodact';
//            $returner["alt"]= $prodact->alt;

            $returner["category_id"]= $prodact->category_id;
            $returner["theLocation"]= $prodact->theLocation;
            $returner["theTitle"]= $prodact->theTitle;
            $returner["theType"]= $prodact->theType;
            $returner["theRoom"]= $prodact->theRoom;
            $returner["parking"]= $prodact->parking;
            $returner["balcony"]= $prodact->balcony;
            if ($prodact->cable){
                $returner["cable"]= $prodact->cable;
            }
            if ($prodact->pool) {
                $returner["pool"] = $prodact->pool;
            }
            $returner["garden"]= $prodact->garden;
            $returner["theNameHome"]= $prodact->theNameHome;
            $returner["theBath"]= $prodact->theBath;
            $returner["thePrice"]= $prodact->thePrice;
            $returner["theText"]= $prodact->theText;












//            $pageData["thePhoto"] = $prodact_users->thePhoto;

//            if ($links) {
//                $returner["url"] = urldecode($links[0]->url);
//            }

            $pageData["thePhoto"] = $prodact->thePhoto;
            $pageData["thePhoto1"] = $prodact->thePhoto1;
//            $pageData["thePhoto2"] = $prodact->thePhoto2;
            $pageData["thePhoto3"] = $prodact->thePhoto3;
            $pageData["thePhoto4"] = $prodact->thePhoto4;
            $pageData["values"] = json_encode($returner);

        }else {
//            $pageData['pageTitle'] = 'Add submenulink';
            $pageData["thePhoto"] = NULL;
            $pageData["thePhoto1"] = NULL;
//            $pageData["thePhoto2"] = NULL;
            $pageData["thePhoto3"] = NULL;
            $pageData["thePhoto4"] = NULL;
            $pageData['id'] = 0;
        }
//        $this->load->view('common/header', $this->headerData);
        $this->load->view('panel/common/header1', $this->headerData);
        $this->load->view('content/submit-property', $pageData);
        $this->load->view('common/footer', $this->footerData);
//        $this->load->view('panel/common/footer1', $this->footerData);

    }
    public function add_submit(){
        $pageData = array();
        if(!$this->session->userdata("id") > 0){
          header("Location: /");
        }
        $this->load->view('panel/common/header1', $this->headerData);
        $this->load->view('content/addproperty', $pageData);
//        $this->load->view('common/footer', $this->footerData);
        $this->load->view('panel/common/footer1', $this->footerData);

    }


    public function  login(){
        $pageData = array();
        $this->load->view('common/header', $this->headerData);
        $this->load->view('content/login', $pageData);
        $this->load->view('common/footer', $this->footerData);


    }


    public function login1() {
        $pageData = array();
        $pageData["status"] = 0;

        if ($this->input->post()) {
            $username = $this->Checkdata->checkInputData($this->input->post("theName"));
            $password = $this->input->post("password");
            $check = $this->db->query("select count(1) as cnt from kullanci where theName = '" . $username . "' and thePassword = '" . sha1($password) . "'")->result();
            if ($check[0]->cnt > 0) {
                $memberData = $this->db->query("select id from users where theName = '" . $username . "' and thePassword = '" . sha1($password) . "'")->result_array();
                $session = array(
                    'name' => $username,
                    'id' => $memberData[0]["id"]
                );
                $this->session->set_userdata($session);
                header("Location: /site/home/");
            } else {
                $pageData["status"] = 1;
                $this->load->view("site/login", $pageData);
            }
        } else {

            $this->load->view("site/login", $pageData);
        }
    }














    public function ne_yaptik($id = 0){
        $pageData = array();

        $pageData["projectheader"] =
        $pageData["projectphoto"] =
        $pageData["projectslider"] =

        $pageData["youtube"] =



            $this->load->view('common/header', $this->headerData);
        $this->load->view('content/neyaptik', $pageData);
        $this->load->view('common/footer', $this->footerData);
    }
//            if ($founded){
//                $this->load->view('common/header', $this->headerData);
//                $this->load->view('content/prodacts', $pageData);
//                $this->load->view('common/footer', $this->footerData);
//
//            }else{
//                echo "Notfound";
//            }


    public function prodact($id = 0){
        $pageData = array();

//        $theSearch = $this->input->get("seeo");
        $theSearch = $this->input->get("name");
        $theSearch = str_replace(array('"',"'","#","SELECT","ORDER","EXTRACTVALUE","OR","AND","CONCAT"),"",$theSearch);

        if($theSearch){
            $theSearchADD = "AND (theRoom LIKE '%$theSearch%'  )";

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
        $pageData["prodact"] = $this->db->query("SELECT * FROM prodact WHERE status = 1 $theSearchADD  LIMIT $start, $planLength ")->result_object();
//        $pageData["pro"] = $this->db->query("SELECT * FROM prodact_user WHERE status = 1  $theSearchADD  LIMIT $start, $planLength ")->result_object();








//        $pageData["prodact"] = $this->db->query("SELECT * FROM prodact WHERE 1 $theSearchADD  ")->result_object();

        $this->load->view('common/header', $this->headerData);
        $this->load->view('content/prodacts', $pageData);
        $this->load->view('common/footer', $this->footerData);

    }







    public function subdetails($id=0){
        $pageData = array();


        $pageData["prodact"] =$this->db->query("SELECT * FROM prodact WHERE id = '$id'")->result_object();
       $pageData["thePhoto"] =$this->db->query("SELECT * FROM thePhoto WHERE category_id = '$id' ")->result_object();

//      print_r($this->db->query("SELECT * FROM thePhoto WHERE category_id = '$id' ")->result_object());
        $this->load->view('common/header', $this->headerData);
        $this->load->view('content/subdetails', $pageData);
        $this->load->view('common/footer', $this->footerData);


    }


    public function contact_us($id=0){


        $pageData = array();
        $pageData["map"] =$this->db->query("SELECT * FROM map ")->result_object();
        $pageData["footer2"] =$this->db->query("SELECT * FROM footer2 ")->result_object();
        $pageData["footer3"] =$this->db->query("SELECT * FROM footer3 ")->result_object();
        $pageData["footer4"] =$this->db->query("SELECT * FROM footer4 ")->result_object();


        $this->load->view('common/header', $this->headerData);
        $this->load->view('content/contactus', $pageData);
        $this->load->view('common/footer', $this->footerData);

    }





    function ajax($param1, $param2 = NULL, $param3 = NULL) {
        switch ($param1) {

            case "changeLanguage":
                $lang = $this->Checkdata->checkInputData($this->input->post("lang"));
                if ($lang == 'ar') {
                    $session = array( 'lang' => 'ar' );
                    $this->session->set_userdata($session);
                }
                else if ($lang == 'en') {
                    $session = array( 'lang' => 'en' );
                    $this->session->set_userdata($session);
                } else {
                    $session = array( 'lang' => 'tr' );
                    $this->session->set_userdata($session);
                }
                echo 1;
                break;



                case "contactus" :
                $theName = $this->input->post("firstName");
                  $lastName= $this->input->post("lastName");
                $emailAddress = $this->input->post("email");
                // $thePhone = $this->input->post("thePhone");
                // $theWebsite = $this->input->post("theWebsite");
                $theMessage = $this->input->post("message");

                $insert = array();

                $insert['theName'] = $theName;
                $insert['lastName'] = $lastName;
                $insert['email'] = $emailAddress;
                $insert['theMessage'] = $theMessage;

                // $this->db->insert("contactus_form", $insert);

                $subject = " New Contact Us Message ";
                $htmlBody = " New Message has been sucessfully sent to Contact Us Form List
                        <table style='text-align: center;'> <thead class='cf'>";
                foreach ($insert as $key => $value) {
                    $htmlBody .= "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
                }

                $htmlBody .= " </tr></thead>
                        <tbody>";


                    $theEmail = "yosef.abo121@gmail.com";


                $htmlBody .= "</tbody></table>";
                $this->load->library('email');
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'mail.hurenkangoedkoper.com',
                    'smtp_port' => 25,
                    'smtp_timeout' => '5',
                    'smtp_crypto' => 'tls',
                    'smtp_user' => 'info@hurenkangoedkoper.com',
                    'smtp_pass' => 'InfoInfo99',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );
                $this->load->library('email', $config);
                $result = $this->email
                        ->from($emailAddress)
                        ->to("info@hurenkangoedkoper.com")
                        ->bcc("yosef.abo121@gmail.com")
                        ->subject($subject)
                        ->message($htmlBody);
                $this->email->send();

                echo 1;
                break;





            case "signup":

                $this->load->helper('form');
                $this->load->library('form_validation');



                $this->form_validation->set_rules('theEmail', 'Email', 'required|trim|is_unique[kullanci.theEmail]');

                if ($this->form_validation->run() === FALSE) {

                    echo "This email appears to be in use, please enter a different email";
//                    echo json_encode($returnToServer);


                } else {
                    $processArr = array();
                    $processArr["theName"] = $this->input->post("theName");
                $processArr["nickname"] = $this->input->post("nickname");
                    $processArr["theEmail"] = $this->input->post("theEmail");
                    $processArr["nickname"] = $this->input->post("nickname");



                    $processArr["thePassword"] =  sha1($this->input->post("thePassword")) ;
                    $this->db->insert("kullanci", $processArr);
                    $username = $this->Checkdata->checkInputData($this->input->post("theName"));
                    $theEmail = $this->Checkdata->checkInputData($this->input->post("theEmail"));
                    $ids = $this->db->query("SELECT id FROM kullanci WHERE  theName ='$username' AND  theEmail ='$theEmail'")->result();

                    $id = $ids[0]->id;

                    $session = array(
                        'name' => $username,
                        'theEmail' => $theEmail,
                        'id' => $id
                    );
                    $this->session->set_userdata($session);
                    echo 1;
                }
                break;

            case "getProdact":


                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->get("sSearch");
                $result = $this->db->query("SELECT * FROM prodact WHERE (theTitle LIKE '%" . $sSearch . "%' )  ORDER BY id ")->result_array();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM prodact ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                foreach ($result as $dt) {

                    $returnToServer["aaData"][] = array(
                        $dt->theTitletr,
                        $dt->theTitleen,

                    );
                }
                echo json_encode($returnToServer);

                break;





            case "getProdactUser":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");
                $user = $this->session->userdata("id");
//                echo $user;
//

                $result = $this->db->query("SELECT * FROM prodact  WHERE user_id ='$user' ORDER BY id DESC  LIMIT $iDisplayStart, $iDisplayLength ")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM prodact WHERE user_id ='$user'")->row()->cnt;
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


                    $actions = "<div class='d-inline mr-4'><a class='btn btn-light-primary font-weight-bold' href='/site/submit/{$dt->id}'><i class='flaticon2-pen text-info'></i></a></div>";
                   // $actions .= "<button class='oper' onclick=\"document.getElementById('id01').style.display='block'({$dt->id},\"deleteProdactUser\")\">Open Modal</button>";
                // $actions .= "<button type='button' class='btn btn-primary  data-id=\"({$dt->id}\"'data-toggle='modal' data-target='#exampleModal'>demo</button>";
                // $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteSubmenulink\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";
                // $actions .= "<a type='button' onclick='deleteBTN({$dt->id},\"deleteSubmenulink\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></a>";

                   $actions .= "<a href='#openModal' ><i class='glyphicon glyphicon-trash text-danger'></i></a>";
                       $actions.= '<div id="openModal" class="modalDialog"><div class="post_list">	<a href="#close" title="Close" class="close">X</a><h2>Delete Properties</h2>
                               <p>are you sure you want to delete the Post ? </p>
                               <button type="submit"class="deletebtn"  onclick="myFunction('.$dt->id.')" rel="'.$dt->id.' name="button">delete</button>
                                <button > <a href="#close"type="button"id="cancelbtn" name="button">cancel</a></button></div></div>';

                    // $actions .= "<button onclick='document.getElementById('id01').style.display='block'({$dt->id},\"deleteProdactUser\")' class='btn btn-light-primary font-weight-bold' id='kt_sweetalert_demo_9'><i class='glyphicon glyphicon-trash text-danger'></i></button>";
                    // $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/panel/ajax/deleteProdactUser/{$dt->id}' class='deleteButton' type='button'><i class='glyphicon glyphicon-trash'></i></a> </div>";

                    if($dt->status == 0){
                        $condation ="  <span class='btn btn-danger'>Not Active yet</span>";

                    }else{
                        $condation =" <span class='btn btn-success'>active</span>";

                    }
                    $returnToServer["aaData"][] = array(
//                        '<img src="/public/uploads/php/files/prodact_user/' . $dt->thePhoto . '" width="80">',
                        $dt->theTitle,
                        $city,
                        $condation,
                        $actions,

                    );
                }

                echo json_encode($returnToServer);
                break;

            case "addEditProdactUser":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));
                $thePhoto1 = $this->Checkdata->checkInputData($this->input->post("file1"));
                $thePhoto2 = $this->Checkdata->checkInputData($this->input->post("file2"));
                $thePhoto3 = $this->Checkdata->checkInputData($this->input->post("file3"));
                $thePhoto4 = $this->Checkdata->checkInputData($this->input->post("file4"));


                $url = urlencode(str_replace(" ","-",$this->Checkdata->permalink($this->input->post("theTitle"))));
                $page = 'prodact';
                $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url'")->result();
                if($id > 0){
                    $theURL = $this->db->query("SELECT id FROM links WHERE url = '$url' AND content_id != '$id'")->result();

                }
                if($theURL){
//                    $this->form_validation->set_rules('url2', 'URL', 'required');
                }
                $user = $this->session->userdata("id");

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
                    $processArr["user_id"] =$user;
                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($thePhoto1)
                        $processArr["thePhoto1"] = $thePhoto1;
//                    if ($thePhoto2)
//                        $processArr["thePhoto2"] = $thePhoto2;

                    if ($thePhoto)
                        $processArr["thePhoto3"] = $thePhoto3;

                    if ($thePhoto)
                        $processArr["thePhoto4"] = $thePhoto4;






                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);
                        $checkPhoto = $this->db->query("SELECT thePhoto FROM prodact WHERE id = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            unlink('admin/public1/uploads/php/files/prodact_user /' . $checkPhoto[0]->thePhoto);
                            unlink('admin/public1/uploads/php/files/prodact_user /thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('admin/public1/uploads/php/files/prodact_user /medium/' . $checkPhoto[0]->thePhoto);
                        }


                        $checkPhoto1 = $this->db->query("SELECT thePhoto1 FROM prodact WHERE id = $id")->result();
                        if ($thePhoto1 && $checkPhoto1) {
                            unlink('admin/public1/uploads/php/files/prodact_user1 /' . $checkPhoto1[0]->thePhoto1);
                            unlink('admin/public1/uploads/php/files/prodact_user1 /thumbnail/' . $checkPhoto1[0]->thePhoto1);
                            unlink('admin/public1/uploads/php/files/prodact_user1 /medium/' . $checkPhoto1[0]->thePhoto1);
                        }

//                        $checkPhoto2 = $this->db->query("SELECT thePhoto2 FROM prodact WHERE id = $id")->result();
//                        if ($thePhoto2 && $checkPhoto2) {
//                            unlink('admin.hurenkangoedkoper.com/public1/uploads/php/files/prodact_user2 /' . $checkPhoto2[0]->thePhoto2);
//                            unlink('admin.hurenkangoedkoper.com/public1/uploads/php/files/prodact_user2 /thumbnail/' . $checkPhoto2[0]->thePhoto2);
//                            unlink('admin.hurenkangoedkoper.com/public1/uploads/php/files/prodact_user2 /medium/' . $checkPhoto2[0]->thePhoto2);
//                        }
                        $checkPhoto3 = $this->db->query("SELECT thePhoto3 FROM prodact WHERE id = $id")->result();
                        if ($thePhoto3 && $checkPhoto4) {
                            unlink('admin/public1/uploads/php/files/prodact_user3 /' . $checkPhoto3[0]->thePhoto3);
                            unlink('admin/public1/uploads/php/files/prodact_user3 /thumbnail/' . $checkPhoto3[0]->thePhoto3);
                            unlink('admin/public1/uploads/php/files/prodact_user3 /medium/' . $checkPhoto3[0]->thePhoto3);
                        }
                        $checkPhoto4 = $this->db->query("SELECT thePhoto4 FROM prodact WHERE id = $id")->result();
                        if ($thePhoto4 && $checkPhoto4) {
                            unlink('admin/public1/uploads/php/files/prodact_user4 /' . $checkPhoto4[0]->thePhoto4);
                            unlink('admin/public1/uploads/php/files/prodact_user4 /thumbnail/' . $checkPhoto4[0]->thePhoto4);
                            unlink('admin/public1/uploads/php/files/prodact_user4 /medium/' . $checkPhoto4[0]->thePhoto4);
                        }








                        if(!$this->session->userdata("id") > 0){
                          header("Location: /");
                        }else {

                        if ( $this->db->update("prodact", $processArr, array('id' => $id))){
//                     )
                            $processArr2['url'] ="$url";
                            $this->db->where('page',"$page")->where('content_id',$id);
                            $this->db->update("links", $processArr2);

                        }
                        }
                    } else {

                      if(!$this->session->userdata("id") > 0){
                        header("Location: /");
                      }else {
                        if (  $this->db->insert("prodact", $processArr) ){

                            $id = $this->db->insert_id();
                            $processArr2['content_id'] = $id;
                            $processArr2['page'] = "$page";
                            $processArr2['url'] = "$url";
                            $this->db->insert("links", $processArr2);
                        }

                      }

                    }
                    echo 1;
                }
                break;

            case "deleteProdactUser":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);
                $checkPhoto = $this->db->query("SELECT thePhoto FROM prodact WHERE id = '$id'")->result();
                if (isset($checkPhoto[0]->thePhoto)) {
                    unlink('admin/public1/uploads/php/files/prodact_user/' . $checkPhoto[0]->thePhoto);
                    unlink('admin/public1/uploads/php/files/prodact_user/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('admin/public1/uploads/php/files/prodact_user/medium/' . $checkPhoto[0]->thePhoto);
                }
                $checkPhoto1 = $this->db->query("SELECT thePhoto1 FROM prodact WHERE id = $id")->result();
                if (isset($checkPhoto1[0]->thePhoto1)) {
                    unlink('admin/public1/uploads/php/files/prodact_user1/' . $checkPhoto1[0]->thePhoto1);
                    unlink('admin/public1/uploads/php/files/prodact_user1/thumbnail/' . $checkPhoto1[0]->thePhoto1);
                    unlink('admin/public1/uploads/php/files/prodact_user1/medium/' . $checkPhoto1[0]->thePhoto1);
                }

//                $checkPhoto2 = $this->db->query("SELECT thePhoto2 FROM prodact WHERE id = $id")->result();
//                if ($checkPhoto2) {
//                    unlink('admin.hurenkangoedkoper.com/public1/uploads/php/files/prodact_user2/' . $checkPhoto2[0]->thePhoto2);
//                    unlink('admin.hurenkangoedkoper.com/public1/uploads/php/files/prodact_user2/thumbnail/' . $checkPhoto2[0]->thePhoto2);
//                    unlink('admin.hurenkangoedkoper.com/public1/uploads/php/files/prodact_user2/medium/' . $checkPhoto2[0]->thePhoto2);
//                }
//
                $checkPhoto3 = $this->db->query("SELECT thePhoto3 FROM prodact WHERE id = $id")->result();
                if (isset($checkPhoto3[0]->thePhoto3)) {
                    unlink('admin/public1/uploads/php/files/prodact_user3/' . $checkPhoto3[0]->thePhoto3);
                    unlink('admin/public1/uploads/php/files/prodact_user3/thumbnail/' . $checkPhoto3[0]->thePhoto3);
                    unlink('admin/public1/uploads/php/files/prodact_user3/medium/' . $checkPhoto3[0]->thePhoto3);
                }
                $checkPhoto4 = $this->db->query("SELECT thePhoto4 FROM prodact WHERE id = $id")->result();
                if (isset($checkPhoto4[0]->thePhoto4)) {
                    unlink('admin/public1/uploads/php/files/prodact_user4/' . $checkPhoto4[0]->thePhoto4);
                    unlink('admin/public1/uploads/php/files/prodact_user4/thumbnail/' . $checkPhoto4[0]->thePhoto4);
                    unlink('admin/public1/uploads/php/files/prodact_user4/medium/' . $checkPhoto4[0]->thePhoto4);
                }

                $this->db->delete("prodact", array('id' => $id));
                echo 1;
                break;









        }
    }

}
