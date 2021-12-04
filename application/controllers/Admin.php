<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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

        if ($this->session->userdata("username") == "" && $this->uri->segment(2) != "login") {
            header("Location: /admin/login");
            die();
        }

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }


        $this->footerData['theColor'] = $this->db->query("SELECT theValue FROM site_setting")->result_object();
        $this->headerData['theColor'] = $this->db->query("SELECT theValue FROM site_setting")->result_object();
        $this->headerData['theLogo'] = $this->db->query("SELECT theValue FROM site_setting WHERE seId = 3")->result_object();
    }

    public function index() {
        header("Location: /admin/login/");
    }

    public function home() {
        header("Location: /admin/users/");
    }

    // Login
    public function login() {
        $pageData = array();
        $pageData["status"] = 0;
        $pageData['theColor'] = $this->db->query("SELECT theValue FROM site_setting")->result_object();
        $pageData['theLogo'] = $this->db->query("SELECT theValue FROM site_setting WHERE seId = 3")->result_object();

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
                header("Location: /admin/home/");
            } else {
                $pageData["status"] = 1;
                $this->load->view("admin/login", $pageData);
            }
        } else {

            $this->load->view("admin/login", $pageData);
        }
    }

    // Users
    public function users() {
        $pageData["users"] = $this->db->query("SELECT usId, username, lastlogin from users WHERE isDeleted = 0 ORDER BY usId")->result_array();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/users", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    function logout() {
        $this->session->sess_destroy();
        header("Location: /admin/login");
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
                header("Location: /admin/users");
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

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditUsers', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    // About Us
    public function aboutUs() {
        $pageData = array();

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/aboutUs", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function edit_aboutUs($id =0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        $pageData['id'] = $id;
        $returner = array();

        $aboutUs = $this->db->query("SELECT abId, thePhoto, theText, langId, PageTitle, pageDesc, traceCode FROM about_us WHERE abId = $id")->result_object();
        if (empty($aboutUs)) {
            header("Location: /admin/aboutUs/");
            exit();
        }
        $aboutUs = $aboutUs[0];
        if($id == 1){
            $pageData['pageTitle'] = 'Edit About Us';
        }else{
            $pageData['pageTitle'] = 'Edit '.$aboutUs->thePhoto;
        }

        $returner["langId"] = $aboutUs->langId;
        $returner["theText"] = $aboutUs->theText;
        $returner["PageTitle"] = $aboutUs->PageTitle;
        $returner["pageDesc"] = $aboutUs->pageDesc;
        $returner["traceCode"] = $aboutUs->traceCode;

        $pageData["thePhoto"] = $aboutUs->thePhoto;


        $pageData['values'] = json_encode($returner);

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/editAboutUs', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }


        // homeSlider
    public function homeSlider() {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/homeSlider", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_home_slider($id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $homeSlider = $this->db->query("SELECT hoId, thePhoto, theText1, theText2, langId FROM home_slider WHERE hoId = $id")->result_object();
            if (empty($homeSlider)) {
                header("Location: /admin/homeSlider/");
                exit();
            }
            $homeSlider = $homeSlider[0];
            $pageData['pageTitle'] = 'Edit Home Slider';

            $returner["langId"] = $homeSlider->langId;
            $returner["theText1"] = $homeSlider->theText1;
            $returner["theText2"] = $homeSlider->theText2;


            $pageData["thePhoto"] = $homeSlider->thePhoto;

            $pageData['values'] = json_encode($returner);
        } else {
          //why we didnT empty text one and 2
            $pageData['pageTitle'] = 'Add Home Slider';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditHomeSlider', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

   // Towns
    public function towns() {
        $pageData = array();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/towns", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_towns($id = 0) {
        $pageData = array();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $towns = $this->db->query("SELECT toId, enName, arName, enDesc, arDesc FROM towns WHERE toId = $id AND isDeleted = 0 ")->result_object();
            if (empty($towns)) {
                header("Location: /admin/towns/");
                exit();
            }
            $towns = $towns[0];
            $pageData['pageTitle'] = 'Edit Town';

            $returner["enName"] = $towns->enName;
            $returner["arName"] = $towns->arName;
            $returner["enDesc"] = $towns->enDesc;
            $returner["arDesc"] = $towns->arDesc;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Town';
            $pageData['id'] = 0;
        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditTowns', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

 // Photos
    public function photos() {
        $pageData = array();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/photos", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function edit_photos($id = 0) {
        $pageData = array();
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;

            $photos = $this->db->query("SELECT phId, theTitle, thePhoto FROM photos WHERE phId = $id")->result_object();
            if (empty($photos)) {
                header("Location: /admin/photos/");
                exit();
            }
            $photos = $photos[0];
            $pageData['pageTitle'] = 'Edit '.$photos->theTitle.' Photo';

            $pageData['thePhoto'] = $photos->thePhoto;

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/editPhotos', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }



    // homePage
    public function homePage() {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/homePage", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_homePage($id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $homePage = $this->db->query("SELECT * FROM home_page WHERE hoId = $id ")->result_object();
            if (empty($homePage)) {
                header("Location: /admin/homePage/");
                exit();
            }
            $homePage = $homePage[0];
            $pageData['pageTitle'] = 'Edit Number On HomePage';

            $returner["theName"] = $homePage->theName;
            $returner["theNumber"] = $homePage->theNumber;
            $returner["langId"] = $homePage->langId;


            $pageData['thePhoto'] = $homePage->thePhoto;

            $pageData['values'] = json_encode($returner);


        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditHomePage', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }


    // Categories
    public function categories() {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/categories", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_categories($id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $categories = $this->db->query("SELECT caId, theTitle, langId, thePhoto, PageTitle, pageDesc, traceCode FROM categories WHERE caId = $id AND isDeleted = 0 ")->result_object();
            if (empty($categories)) {
                header("Location: /admin/categories/");
                exit();
            }
            $categories = $categories[0];
            $pageData['pageTitle'] = 'Edit Categories';

            $returner["theTitle"] = $categories->theTitle;
            $returner["langId"] = $categories->langId;
            $returner["PageTitle"] = $categories->PageTitle;
            $returner["pageDesc"] = $categories->pageDesc;
            $returner["traceCode"] = $categories->traceCode;

            $pageData['thePhoto'] = $categories->thePhoto;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Categories';
            $pageData['thePhoto'] = Null;
            $pageData['id'] = 0;
        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditCategories', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }



    // Plans
    public function plans($categoryId = 0) {
        $pageData = array();
        $pageData['categoryId'] = $categoryId;

        $plans = $this->db->query("SELECT theTitle FROM categories WHERE caId = $categoryId")->result_object();
        if (empty($plans)) {
                header("Location: /admin/categories/");
                exit();
            }
        $pageData['theName'] = $plans[0]->theTitle;

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/plans", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_plans($categoryId = 0, $id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();

        $category = $this->db->query("SELECT langId, theTitle FROM categories WHERE isDeleted = 0 AND caId = $categoryId")->result_object();
        if (empty($category)) {
                header("Location: /admin/plans/".$categoryId);
                exit();
            }else{
                $pageData['categoryId'] = $categoryId;
                $pageData['langId'] = $category[0]->langId;

            }

        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $plans = $this->db->query("SELECT plId, theTitle, theText, code, langId, categoryId, thePhoto, PageTitle, pageDesc, traceCode FROM plans WHERE plId = $id AND categoryId = $categoryId ")->result_object();
            if (empty($plans)) {
                header("Location: /admin/plans/".$categoryId);
                exit();
            }
            $plans = $plans[0];
            $pageData['pageTitle'] = 'Edit '.$plans->theTitle;

            $lang = $plans->langId;
            $getLang = $this->db->query("SELECT laId, theName FROM lang WHERE laId = $lang")->result_object();
                $pageData['theLang'] = $getLang[0]->theName;

            $returner["theTitle"] = $plans->theTitle;
            $pageData["langId"] = $plans->langId;
            $returner["theText"] = $plans->theText;
//            $returner["code"] = 'EP-'.$plans->code;
//            $pageData["code"] = 'EP-'.$plans->code;
            $returner["PageTitle"] = $plans->PageTitle;
            $returner["pageDesc"] = $plans->pageDesc;
            $returner["traceCode"] = $plans->traceCode;

            $pageData['thePhoto'] = $plans->thePhoto;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Sub To '.$category[0]->theTitle;;
            $pageData['thePhoto'] = Null;
            $pageData['id'] = 0;

            $planss = $this->db->query("SELECT plId FROM plans ORDER BY plId DESC ")->result_object();
            $lang = $pageData['langId'];
            $getLang = $this->db->query("SELECT laId, theName FROM lang WHERE laId = $lang")->result_object();
                $pageData['theLang'] = $getLang[0]->theName;
                $pageData['langId'] = $getLang[0]->laId;
//                if($planss){
//                $cods= $planss[0]->plId+3004+1;
//                }else{
//                $cods= 3004+1;
//                }
//                $pageData['code'] = 'EP-'.$cods;

        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditPlans', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }



    // Categories
    public function categories2() {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/categories4", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_categories4($id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $categories = $this->db->query("SELECT caId, theTitle, langId, thePhoto, PageTitle, pageDesc, traceCode FROM categories4 WHERE caId = $id AND isDeleted = 0 ")->result_object();
            if (empty($categories)) {
                header("Location: /admin/categories2/");
                exit();
            }
            $categories = $categories[0];
            $pageData['pageTitle'] = 'Edit Categories';

            $returner["theTitle"] = $categories->theTitle;
            $returner["langId"] = $categories->langId;
            $returner["PageTitle"] = $categories->PageTitle;
            $returner["pageDesc"] = $categories->pageDesc;
            $returner["traceCode"] = $categories->traceCode;

            $pageData['thePhoto'] = $categories->thePhoto;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Categories';
            $pageData['thePhoto'] = Null;
            $pageData['id'] = 0;
        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditCategories4', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }


       // Plans
    public function plans4() {
        $pageData = array();

        $pageData['theName'] = $this->lang->line("touristServices2");

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/plans4", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_plans4($id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();


        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $plans = $this->db->query("SELECT plId, theTitle, theText, code, langId, categoryId, thePhoto, PageTitle, pageDesc, traceCode FROM plans4 WHERE plId = $id ")->result_object();
            if (empty($plans)) {
                header("Location: /admin/plans4/");
                exit();
            }
            $plans = $plans[0];
            $pageData['pageTitle'] = 'Edit '.$plans->theTitle;

            $lang = $plans->langId;
            $getLang = $this->db->query("SELECT laId, theName FROM lang WHERE laId = $lang")->result_object();
                $pageData['theLang'] = $getLang[0]->theName;

            $returner["theTitle"] = $plans->theTitle;
            $returner["langId"] = $plans->langId;
            $returner["theText"] = $plans->theText;
//            $returner["code"] = 'EP-'.$plans->code;
//            $pageData["code"] = 'EP-'.$plans->code;
            $returner["PageTitle"] = $plans->PageTitle;
            $returner["pageDesc"] = $plans->pageDesc;
            $returner["traceCode"] = $plans->traceCode;

            $pageData['thePhoto'] = $plans->thePhoto;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Sub To Services';
            $pageData['thePhoto'] = Null;
            $pageData['id'] = 0;

        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditPlans4', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }



    // Plans
    public function events($planId = 0) {
        $pageData = array();
        $pageData['planId'] = $planId;

        $plans = $this->db->query("SELECT theTitle FROM plans WHERE plId = $planId")->result_object();
        if (empty($plans)) {
                header("Location: /admin/categories/");
                exit();
            }
        $pageData['theName'] = $plans[0]->theTitle;

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/events", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_events($planId = 0, $id = 0) {
        $pageData = array();
        $pageData['planId'] = $planId;
        $planLanguage = $this->db->query("SELECT langId, theTitle FROM plans WHERE plId = $planId")->result_object();
        if($planLanguage[0]->langId == 1){
            $pageData['towns'] = $this->db->query("SELECT toId, arName as theName FROM towns")->result_object();
        }else{
            $pageData['towns'] = $this->db->query("SELECT toId, enName as theName FROM towns")->result_object();
        }


        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $events = $this->db->query("SELECT evId, planId, eventCode, openDate, closeDate, daysNumber, townId, thePrice FROM events WHERE evId = $id AND planId = $planId ")->result_object();
            if (empty($events)) {
                header("Location: /admin/events/".$planId);
                exit();
            }
            $events = $events[0];
            $pageData['pageTitle'] = 'Edit Event';

//            $returner["eventCode"] = $events->eventCode;
            $returner["openDate"] = $events->openDate;
            $returner["closeDate"] = $events->closeDate;
            $returner["daysNumber"] = $events->daysNumber;
            $returner["eventCode"] = 'SQ-'.$events->eventCode;
            $pageData["eventCode"] = 'SQ-'.$events->eventCode;
            $returner["townId"] = $events->townId;
            $returner["thePrice"] = $events->thePrice;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Event To '.$planLanguage[0]->theTitle;
            $pageData['id'] = 0;

            $event = $this->db->query("SELECT evId FROM events ORDER BY evId DESC ")->result_object();
            if($event){
            $cods= $event[0]->evId+81400+1;
            }else{
            $cods= 81400+1;
            }
            $pageData['eventCode'] = 'SQ-'.$cods;
        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditEvents', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }


    // Categories
    public function real_categories() {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/categories2", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_categories2($id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $categories = $this->db->query("SELECT caId, theTitle, langId, thePhoto, PageTitle, pageDesc, traceCode FROM categories2 WHERE caId = $id AND isDeleted = 0 ")->result_object();
            if (empty($categories)) {
                header("Location: /admin/real_categories/");
                exit();
            }
            $categories = $categories[0];
            $pageData['pageTitle'] = 'Edit Categories';

            $returner["theTitle"] = $categories->theTitle;
            $returner["langId"] = $categories->langId;
            $returner["PageTitle"] = $categories->PageTitle;
            $returner["pageDesc"] = $categories->pageDesc;
            $returner["traceCode"] = $categories->traceCode;

            $pageData['thePhoto'] = $categories->thePhoto;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Categories';
            $pageData['thePhoto'] = Null;
            $pageData['id'] = 0;
        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditCategories2', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }



    // Plans
    public function plans2($categoryId = 0) {
        $pageData = array();
        $pageData['categoryId'] = $categoryId;

        $plans = $this->db->query("SELECT theTitle FROM categories2 WHERE caId = $categoryId")->result_object();
        if (empty($plans)) {
                header("Location: /admin/real_categories/");
                exit();
            }
        $pageData['theName'] = $plans[0]->theTitle;

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/plans2", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_plans2($categoryId = 0, $id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();

        $category = $this->db->query("SELECT langId, theTitle FROM categories2 WHERE isDeleted = 0 AND caId = $categoryId")->result_object();
        if (empty($category)) {
                header("Location: /admin/plans2/".$categoryId);
                exit();
            }else{
                $pageData['categoryId'] = $categoryId;
                $pageData['langId'] = $category[0]->langId;

            }

        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $plans = $this->db->query("SELECT plId, theTitle, theText, code, langId, categoryId, thePhoto, PageTitle, pageDesc, traceCode FROM plans2 WHERE plId = $id AND categoryId = $categoryId ")->result_object();
            if (empty($plans)) {
                header("Location: /admin/plans2/".$categoryId);
                exit();
            }
            $plans = $plans[0];
            $pageData['pageTitle'] = 'Edit '.$plans->theTitle;

            $lang = $plans->langId;
            $getLang = $this->db->query("SELECT laId, theName FROM lang WHERE laId = $lang")->result_object();
                $pageData['theLang'] = $getLang[0]->theName;

            $returner["theTitle"] = $plans->theTitle;
            $pageData["langId"] = $plans->langId;
            $returner["theText"] = $plans->theText;
//            $returner["code"] = 'EP-'.$plans->code;
//            $pageData["code"] = 'EP-'.$plans->code;
            $returner["PageTitle"] = $plans->PageTitle;
            $returner["pageDesc"] = $plans->pageDesc;
            $returner["traceCode"] = $plans->traceCode;

            $pageData['thePhoto'] = $plans->thePhoto;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Sub To '.$category[0]->theTitle;;
            $pageData['thePhoto'] = Null;
            $pageData['id'] = 0;

            $planss = $this->db->query("SELECT plId FROM plans2 ORDER BY plId DESC ")->result_object();
            $lang = $pageData['langId'];
            $getLang = $this->db->query("SELECT laId, theName FROM lang WHERE laId = $lang")->result_object();
                $pageData['theLang'] = $getLang[0]->theName;
                $pageData['langId'] = $getLang[0]->laId;
//                if($planss){
//                $cods= $planss[0]->plId+3004+1;
//                }else{
//                $cods= 3004+1;
//                }
//                $pageData['code'] = 'EP-'.$cods;

        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditPlans2', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    // Categories
    public function medical_categories() {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/categories3", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_categories3($id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $categories = $this->db->query("SELECT caId, theTitle, langId, thePhoto, PageTitle, pageDesc, traceCode FROM categories3 WHERE caId = $id AND isDeleted = 0 ")->result_object();
            if (empty($categories)) {
                header("Location: /admin/medical_categories/");
                exit();
            }
            $categories = $categories[0];
            $pageData['pageTitle'] = 'Edit Categories';

            $returner["theTitle"] = $categories->theTitle;
            $returner["langId"] = $categories->langId;
            $returner["PageTitle"] = $categories->PageTitle;
            $returner["pageDesc"] = $categories->pageDesc;
            $returner["traceCode"] = $categories->traceCode;

            $pageData['thePhoto'] = $categories->thePhoto;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Categories';
            $pageData['thePhoto'] = Null;
            $pageData['id'] = 0;
        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditCategories3', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }



    // Plans
    public function plans3() {
        $pageData = array();


        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/plans3", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_plans3($id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();

//        $category = $this->db->query("SELECT langId, theTitle FROM categories3 WHERE isDeleted = 0 AND caId = $categoryId")->result_object();
//        if (empty($category)) {
//                header("Location: /admin/plans3/".$categoryId);
//                exit();
//            }else{
//                $pageData['categoryId'] = $categoryId;
//                $pageData['langId'] = $category[0]->langId;
//
//            }
        $pageData['languages'] = $this->db->query("SELECT laId, theName FROM lang ")->result_object();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $plans = $this->db->query("SELECT plId, theTitle, theText, code, langId, categoryId, thePhoto, PageTitle, pageDesc, traceCode FROM plans3 WHERE plId = $id ")->result_object();
            if (empty($plans)) {
                header("Location: /admin/plans3/");
                exit();
            }
            $plans = $plans[0];
            $pageData['pageTitle'] = 'Edit '.$plans->theTitle;

//            $lang = $plans->langId;
//            $getLang = $this->db->query("SELECT laId, theName FROM lang WHERE laId = $lang")->result_object();
//                $pageData['theLang'] = $getLang[0]->theName;

            $returner["theTitle"] = $plans->theTitle;
            $pageData["langId"] = $plans->langId;
            $returner["theText"] = $plans->theText;
            $returner["langId"] = $plans->langId;
//            $returner["code"] = 'EP-'.$plans->code;
//            $pageData["code"] = 'EP-'.$plans->code;
            $returner["PageTitle"] = $plans->PageTitle;
            $returner["pageDesc"] = $plans->pageDesc;
            $returner["traceCode"] = $plans->traceCode;

            $pageData['thePhoto'] = $plans->thePhoto;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Sub Category';
            $pageData['thePhoto'] = Null;
            $pageData['id'] = 0;

//            $planss = $this->db->query("SELECT plId FROM plans3 ORDER BY plId DESC ")->result_object();
//            $lang = $pageData['langId'];
//            $getLang = $this->db->query("SELECT laId, theName FROM lang WHERE laId = $lang")->result_object();
//                $pageData['theLang'] = $getLang[0]->theName;
//                $pageData['langId'] = $getLang[0]->laId;
//                if($planss){
//                $cods= $planss[0]->plId+3004+1;
//                }else{
//                $cods= 3004+1;
//                }
//                $pageData['code'] = 'EP-'.$cods;

        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditPlans3', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }


        // Tags
    public function tags() {
        $pageData = array();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/tags", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_tags($id = 0) {
        $pageData = array();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $categories = $this->db->query("SELECT taId,enTitle, arTitle FROM tags WHERE taId = $id AND isDeleted = 0 ")->result_object();
            if (empty($categories)) {
                header("Location: /admin/tags/");
                exit();
            }
            $categories = $categories[0];
            $pageData['pageTitle'] = 'Edit Tag';

            $returner["enTitle"] = $categories->enTitle;
            $returner["arTitle"] = $categories->arTitle;


            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add New Tag';
            $pageData['id'] = 0;
        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditTags', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }


     // Blog
    public function blog() {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/blog", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_blog($id = 0) {
        $pageData = array();
        $pageData['lang'] = $this->db->query("SELECT * FROM lang WHERE isDeleted = 0")->result_object();
        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $blog = $this->db->query("SELECT theName, langId, theText, thePhoto, PageTitle, pageDesc, traceCode FROM blog WHERE blId = $id")->result_object();
            if (empty($blog)) {
                header("Location: /admin/blog/");
                exit();
            }
            $blog = $blog[0];
            $pageData['pageTitle'] = 'Edit This Blog';

            $returner["theName"] = $blog->theName;
            $returner["langId"] = $blog->langId;
            $returner["theText"] = $blog->theText;
            $returner["PageTitle"] = $blog->PageTitle;
            $returner["pageDesc"] = $blog->pageDesc;
            $returner["traceCode"] = $blog->traceCode;

            $pageData["thePhoto"] = $blog->thePhoto;

            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add New Blog';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditBlog', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    // Gallery
    public function gallery($productId = 0) {
        $pageData = array();
            $tags = $this->db->query("SELECT taId,enTitle, arTitle FROM tags WHERE taId = $productId AND isDeleted = 0 ")->result_object();
            if($tags){
                $pageData['tagName'] = $tags[0]->enTitle;
            }else{
                $pageData['tagName'] = " ";
            }
            if (empty($tags)) {
            header("Location: /admin/tags/");
            }
        $pageData['menuId'] = $productId;
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/gallery", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);

    }

    public function add_gallery($productId = 0) {
        $pageData = array();
        $pageData['pageTitle'] = 'Add Photo';
        $pageData["thePhoto"] = NULL;
        $pageData['menuId'] = $productId;
        $tags = $this->db->query("SELECT taId,enTitle, arTitle FROM tags WHERE taId = $productId AND isDeleted = 0 ")->result_object();
        if (empty($tags)) {
            header("Location: /admin/tags/");
            }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addGallery', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    // contact US
    public function ContactUs() {
        $pageData = array();

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/ContactUs", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_contact_us($id = 0) {
        $pageData = array();
        $pageData ['id'] = 1;
        $returner = array();

        $contactUs = $this->db->query("SELECT coId, emailAddress, emailAddress2, phoneNumber, phoneNumber2, enAddress, arAddress, companyName, latitude, longitude, enPageTitle, arPageTitle, pageDesc, traceCode  FROM contact_us WHERE coId = 1")->result_object();
        if (empty($contactUs)) {
            header("Location: /admin/contactUs/");
            exit();
        }
        $contactUs = $contactUs[0];
        $pageData['pageTitle'] = 'Edit Contact Us';

        $returner["companyName"] = $contactUs->companyName;
        $returner["emailAddress"] = $contactUs->emailAddress;
        $returner["emailAddress2"] = $contactUs->emailAddress2;
        $returner["phoneNumber"] = $contactUs->phoneNumber;
        $returner["phoneNumber2"] = $contactUs->phoneNumber2;
        $returner["enDetails"] = $contactUs->enAddress;
        $returner["arDetails"] = $contactUs->arAddress;
        $returner["latitude"] = $contactUs->latitude;
        $returner["longitude"] = $contactUs->longitude;
        $returner["enPageTitle"] = $contactUs->enPageTitle;
        $returner["arPageTitle"] = $contactUs->arPageTitle;
        $returner["pageDesc"] = $contactUs->pageDesc;
        $returner["traceCode"] = $contactUs->traceCode;

        $pageData["latitude"] = $contactUs->latitude;
        $pageData["longitude"] = $contactUs->longitude;

        $pageData['values'] = json_encode($returner);


        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditContactUs', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

        // socialMedia
    public function socialMedia() {
        $pageData = array();

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/socialMedia", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_social_media($id = 0) {
        $pageData = array();
        $pageData ['id'] = 1;
        $returner = array();

        $socialMedia = $this->db->query("SELECT coId,facebook, instagram, twitter, snapchat, whatsapp, whatsapp2, messanger FROM contact_us WHERE coId = 1")->result_object();
        if (empty($socialMedia)) {
            header("Location: /admin/socialMedia/");
            exit();
        }
        $socialMedia = $socialMedia[0];
        $pageData['pageTitle'] = 'Edit Social Media';

        $returner["facebook"] = $socialMedia->facebook;
        $returner["instagram"] = $socialMedia->instagram;
        $returner["twitter"] = $socialMedia->twitter;
        $returner["snapchat"] = $socialMedia->snapchat;
        $returner["whatsapp"] = $socialMedia->whatsapp;
        $returner["whatsapp2"] = $socialMedia->whatsapp2;
        $returner["messanger"] = $socialMedia->messanger;


        $pageData['values'] = json_encode($returner);


        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditSocialMedia', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }


    // subscribers
    public function subscribers() {
        $pageData = array();

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/subscribers", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    // contact Us Form
    public function contactUsForm() {
        $pageData = array();

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/contactUsForm", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

        // course Form
    public function courseForm() {
        $pageData = array();

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/courseForm", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

         // common_questions
    public function commonQuestions() {
        $pageData = array();

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/commonQuestions", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_common_questions($id = 0) {
        $pageData = array();

        if ($id != 0) {
            $this->Checkdata->isNotNumeric($id);
            $this->Checkdata->ifEmptyOrZero($id);

            $pageData['id'] = $id;
            $returner = array();

            $commonQuestions = $this->db->query("SELECT * FROM common_questions WHERE coId = $id")->result_object();
            if (empty($commonQuestions)) {
                header("Location: /admin/commonQuestions/");
                exit();
            }
            $commonQuestions = $commonQuestions[0];
            $pageData['pageTitle'] = 'Edit Common Questions';

            $returner["enName"] = $commonQuestions->questionEn;
            $returner["arName"] = $commonQuestions->questionAr;
            $returner["enText"] = $commonQuestions->answerEn;
            $returner["arText"] = $commonQuestions->answerAr;


            $pageData['values'] = json_encode($returner);
        } else {
            $pageData['pageTitle'] = 'Add Common Questions';
            $pageData["thePhoto"] = NULL;
            $pageData['id'] = 0;
        }

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditCommonQuestions', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }


    // setting
    public function setting() {
        $pageData = array();

        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/setting", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    public function add_edit_setting($id = 0) {
        $pageData = array();

        $this->Checkdata->isNotNumeric($id);
        $this->Checkdata->ifEmptyOrZero($id);

        $pageData['id'] = $id;
        $returner = array();

        $setting = $this->db->query("SELECT * FROM site_setting WHERE seId = $id")->result_object();
        if (empty($setting)) {
            header("Location: /admin/setting/");
            exit();
        }
        $setting = $setting[0];
        $pageData['pageTitle'] = $setting->theName;

        $returner["theName"] = $setting->theName;
        if ($id == 4 || $id == 5) {
            $returner["theData"] = $setting->theValue;
        } elseif ($id == 6) {
            $returner["theData2"] = $setting->theValue;
        } elseif ($id == 3 || $id ==9) {
            $pageData["thePhoto"] = $setting->theValue;
        } else {
            $returner["theColor"] = $setting->theValue;
        }


        $pageData['values'] = json_encode($returner);


        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view('admin/addEditSetting', $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }

    function productsExcelExport($categoryId = 0){

      $this->load->model("excel_export_model");
      $this->load->library("excel/excel");
      $object = new PHPExcel();

      $object->setActiveSheetIndex(0);
      // $object->getActiveSheet()->setTitle('Countries');


       $object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
       $object->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
       $object->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
      // $object->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

      $object->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $object->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $object->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      // $object->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      // $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       //$object->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setARGB('#333');
      // $object->getActiveSheet()->getStyle('C1')->getFill()->getStartColor()->setARGB('#333');
      // $object->getActiveSheet()->getStyle('D1')->getFill()->getStartColor()->setARGB('#333');

      $table_columns = array("plan Id", "Plan Code", "Plan Name");

      $column = 0;

      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }



      // $employee_data = $this->excel_export_model->fetch_data();

      $getPlans = $this->db->query("SELECT plId, code, theTitle FROM plans WHERE categoryId = $categoryId")->result_object();

      $excel_row = 2;

      foreach($getPlans as $row){

        // $object->getActiveSheet()->getStyle('A'.$excel_row)->getFont()->setBold(true);
        // $object->getActiveSheet()->getStyle('B'.$excel_row)->getFont()->setBold(true);
        // $object->getActiveSheet()->mergeCells("A1.$excel_row:D1.$excel_row");

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->plId)->getStyle('A'.$excel_row)->getFont()->setBold(true);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->code)->getStyle('B'.$excel_row)->getFont()->setBold(true);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->theTitle)->getStyle('c'.$excel_row)->getFont()->setBold(true);
        $excel_row++;

      }
                $results = $this->db->query("SELECT theTitle FROM categories WHERE caId = $categoryId")->result();
                if($results){
                    $name = $results[0]->theTitle;
                }else{
                    $name = "Category's Plans";
                }
      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header("Content-Disposition: attachment;filename='$name.xls'");
      $object_writer->save('php://output');
    }

            // Orders
    public function orders() {
        $pageData = array();
        $this->load->view("admin/common/header", $this->headerData);
        $this->load->view("admin/orders", $pageData);
        $this->load->view("admin/common/footer", $this->footerData);
    }


    function ajax($param1, $param2 = 0, $param3 = 0) {
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

                    $actions = "<div class='actionsIcon'><a href='/admin/addEditUsers/{$dt->usId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
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
                $id = $param2;
                $processArr = array();
                $processArr["isDeleted"] = 1;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);
                $this->db->where('usId', $id);
                $this->db->update("users", $processArr, array('usId' => $id));
                echo 1;
                break;


            // About Us
            case "getAboutUs":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT abId, theText, thePhoto, langId FROM about_us WHERE (theText LIKE '%" . $sSearch . "%')  ORDER BY abId ASC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM about_us WHERE abId in(1,2)")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {
                    if($dt->abId < 3){

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }

                    $actions = "<div class='actionsIcon'><a href='/admin/edit_aboutUs/".$dt->abId."'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    if($dt->abId == 1){
                    $thePhoto = '<img src="/public/uploads/php/files/aboutUs/' . $dt->thePhoto . '" width="80">';
                    }else{
                        $thePhoto = $dt->thePhoto;
                    }
                    $returnToServer["aaData"][] = array(
                        $thePhoto,
                        $theLang,
                        strip_tags(word_limiter($dt->theText, 20)),
                        $actions
                    );
                }
                }
                echo json_encode($returnToServer);
                break;

            case "editAboutUs":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('langId', 'Language', 'required');
                $this->form_validation->set_rules('theText', 'Text', 'required');
                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));
                $id = $this->Checkdata->checkInputData($this->input->post("id"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $processArr = array();
                    $processArr["langId"] = $this->input->post("langId");
                    $processArr["theText"] = $this->input->post("theText");

                    $processArr["PageTitle"] = $this->Checkdata->checkInputData($this->input->post("PageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");

                    if ($thePhoto && $id == 1)
                        $processArr["thePhoto"] = $thePhoto;

                    $checkPhoto = $this->db->query("SELECT thePhoto FROM about_us WHERE abId = $id")->result();
                    if ($thePhoto && $checkPhoto) {
                        unlink('public/uploads/php/files/aboutUs/' . $checkPhoto[0]->thePhoto);
                        unlink('public/uploads/php/files/aboutUs/thumbnail/' . $checkPhoto[0]->thePhoto);
                        unlink('public/uploads/php/files/aboutUs/medium/' . $checkPhoto[0]->thePhoto);
                    }

                    $this->db->update("about_us", $processArr, array('abId' => $id));

                    echo 1;
                }
                break;

                            // Home Slider
            case "getHomeSlider":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");
                $langId = $this->input->post("langId");
                if($langId == 0){
                    $addtion = " ";
                }else{
                    $addtion = " WHERE langId = $langId ";
                }

                $result = $this->db->query("SELECT hoId, theText1, theText2, thePhoto, langId FROM home_slider $addtion ORDER BY hoId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM home_slider $addtion")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_home_slider/{$dt->hoId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteHomeSlider/{$dt->hoId}' data-name='{$dt->theText1}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";

                    $returnToServer["aaData"][] = array(
                        '<img src="/public/uploads/php/files/homeSlider/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theText1,
                        $dt->theText2,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditHomeSlider":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Photo', 'required');


                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["theText1"] = $this->input->post("theText1");
                    $processArr["theText2"] = $this->input->post("theText2");

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM home_slider WHERE hoId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            unlink('public/uploads/php/files/homeSlider/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/homeSlider/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/homeSlider/medium/' . $checkPhoto[0]->thePhoto);
                        }

                        $this->db->update("home_slider", $processArr, array('hoId' => $id));
                    } else {
                        $this->db->insert("home_slider", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteHomeSlider":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM home_slider WHERE hoId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/homeSlider/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/homeSlider/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/homeSlider/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("home_slider", array('hoId' => $id));
                echo 1;
                break;


      // Orders
            case "getOrders":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT * FROM orders ORDER BY orId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM orders")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

//                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_tags/{$dt->taId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";


                    $returnToServer["aaData"][] = array(
                        $dt->First_Name.'<br>'.$dt->Last_Name,
                        $dt->planId,
                        'Adults:'.$dt->Adults.'<br> Child:'.$dt->Child.'<br>Baby:'.$dt->Baby.'<br>',
                        $dt->Email_Address,
                        $dt->Phone_Number,
                        'Departure :'.$dt->Departure_Date.'<br>'.'Returning :'.$dt->Returning_Date,
                        $dt->How_Many_stars,
                        $dt->Message,
//                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;


        // Our Tags
            case "getTags":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT taId, enTitle, arTitle FROM tags WHERE (enTitle LIKE '%" . $sSearch . "%' OR arTitle LIKE '%" . $sSearch . "%') AND isDeleted = 0 ORDER BY taId LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM tags WHERE isDeleted = 0")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_tags/{$dt->taId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $gallery = $this->db->query("SELECT gaId FROM gallery WHERE productId = $dt->taId")->result_object();
                if(!$gallery){
                $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteTags/{$dt->taId}' data-name='{$dt->arTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
                }

                    $returnToServer["aaData"][] = array(
                        $dt->enTitle,
                        $dt->arTitle,
                        '<a href="/admin/gallery/'.$dt->taId.'" class="btn btn-primary right"><i class="fa fa-plus" aria-hidden="true"></i> Gallery</a>',
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditTags":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('enTitle', 'English Title', 'required');
                $this->form_validation->set_rules('arTitle', 'Arabic Title', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["enTitle"] = $this->Checkdata->checkInputData($this->input->post("enTitle"));
                    $processArr["arTitle"] = $this->Checkdata->checkInputData($this->input->post("arTitle"));


                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $this->db->update("tags", $processArr, array('taId' => $id));
                    } else {
                        $this->db->insert("tags", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteTags":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $this->db->delete("tags", array('taId' => $id));
                echo 1;
                break;

   //  Town
            case "getTowns":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");
                $langId = $this->input->post("langId");
                if($langId == 0){
                    $addtion = " ";
                }else{
                    $addtion = " AND langId = $langId ";
                }

                $result = $this->db->query("SELECT toId, enName, arName, enDesc, arDesc FROM towns WHERE (enName LIKE '%" . $sSearch . "%' OR arName LIKE '%" . $sSearch . "%')  AND isDeleted = 0 ORDER BY toId ASC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM towns WHERE isDeleted = 0 $addtion")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_towns/{$dt->toId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $plans = $this->db->query("SELECT evId FROM events WHERE townId = $dt->toId")->result_object();
                    if(!$plans){
                        $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteTowns/{$dt->toId}' data-name='{$dt->enName}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
                    }

                    $returnToServer["aaData"][] = array(
                        $dt->enName,
                        $dt->arName,
                        strip_tags(word_limiter($dt->enDesc, 10)),
                        strip_tags(word_limiter($dt->arDesc, 10)),
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditTowns":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('enName', 'English Name', 'required');
                $this->form_validation->set_rules('arName', 'Arabic Name', 'required');

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["enName"] = $this->Checkdata->checkInputData($this->input->post("enName"));
                    $processArr["arName"] = $this->Checkdata->checkInputData($this->input->post("arName"));
                    $processArr["enDesc"] = $this->input->post("enDesc");
                    $processArr["arDesc"] = $this->input->post("arDesc");

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $this->db->update("towns", $processArr, array('toId' => $id));
                    } else {
                        $this->db->insert("towns", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteTowns":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $processArr = Array();
                $processArr['isDeleted'] = 1;
                $this->db->update("towns",$processArr,array('toId' => $id));
                echo 1;
                break;



        //  HomePage
            case "getHomePage":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");
                $langId = $this->input->post("langId");
                if($langId == 0){
                    $addtion = " ";
                }else{
                    $addtion = " AND langId = $langId ";
                }

                $result = $this->db->query("SELECT hoId, theName, langId,  theNumber, thePhoto FROM home_page WHERE (theName LIKE '%" . $sSearch . "%' OR langId LIKE '%" . $sSearch . "%') $addtion ORDER BY hoId LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM home_page $addtion")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }


                        $actions = "<div class='actionsIcon'><a href='/admin/add_edit_homePage/{$dt->hoId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";

                    $returnToServer["aaData"][] = array(
                        '<img src="/public/uploads/php/files/homePage/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theName,
                        $dt->theNumber,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditHomePage":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('theName', ' Name', 'required');
                $this->form_validation->set_rules('theNumber', 'Number', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theName"] = $this->Checkdata->checkInputData($this->input->post("theName"));
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["theNumber"] = $this->Checkdata->checkInputData($this->input->post("theNumber"));

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM home_page WHERE hoId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            if (isset($checkPhoto[0]->thePhoto) && ($checkPhoto[0]->thePhoto != NULL)) {
                            unlink('public/uploads/php/files/homePage/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/homePage/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/homePage/medium/' . $checkPhoto[0]->thePhoto);
                        }}
                        $this->db->update("home_page", $processArr, array('hoId' => $id));
                    } else {
                        $this->db->insert("home_Page", $processArr);
                    }
                    echo 1;
                }
                break;



        //  Photos
            case "getPhotos":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT phId, theTitle, thePhoto FROM photos WHERE (theTitle LIKE '%" . $sSearch . "%')  ORDER BY phId LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM photos ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                        $actions = "<div class='actionsIcon'><a href='/admin/edit_photos/{$dt->phId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";

                    $returnToServer["aaData"][] = array(
                        '<img src="/public/uploads/php/files/photos/' . $dt->thePhoto . '" width="100">',
                        $dt->theTitle,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "editPhotos":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', ' ID', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM photos WHERE phId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            unlink('public/uploads/php/files/photos/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/photos/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/photos/medium/' . $checkPhoto[0]->thePhoto);
                        }
                        $this->db->update("photos", $processArr, array('phId' => $id));

                    echo 1;
                }
                break;


        //  Categories
            case "getCategories":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");
                $langId = $this->input->post("langId");
                if($langId == 0){
                    $addtion = " ";
                }else{
                    $addtion = " AND langId = $langId ";
                }

                $result = $this->db->query("SELECT caId, theTitle, langId, thePhoto FROM categories WHERE (theTitle LIKE '%" . $sSearch . "%' OR langId LIKE '%" . $sSearch . "%') $addtion AND isDeleted = 0 ORDER BY caId LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM categories WHERE isDeleted = 0 $addtion")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }

                    $excel = "<div class='btn-group' role='group' aria-label='...'>
            <a href='/admin/productsExcelExport/".$dt->caId."' class='btn btn-primary right'> Export Excel </a></div>";
                        $actions = "<div class='actionsIcon'><a href='/admin/add_edit_categories/{$dt->caId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $plans = $this->db->query("SELECT plId FROM plans WHERE categoryId = $dt->caId")->result_object();
                    if(!$plans){
                        $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteCategories/{$dt->caId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
                    }

                    $returnToServer["aaData"][] = array(
                        '<img src="/public/uploads/php/files/categories/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theTitle,
                        '<a href="/admin/plans/'.$dt->caId.'" class="btn btn-primary right"><i class="fa fa-plus" aria-hidden="true"></i> The Sub</a>',
//                        $excel,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditCategories":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('theTitle', ' Title', 'required');
                $this->form_validation->set_rules('langId', 'Language', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theTitle"] = $this->Checkdata->checkInputData($this->input->post("theTitle"));
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["PageTitle"] = $this->Checkdata->checkInputData($this->input->post("PageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM categories WHERE caId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            unlink('public/uploads/php/files/categories/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/categories/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/categories/medium/' . $checkPhoto[0]->thePhoto);
                        }
                        $this->db->update("categories", $processArr, array('caId' => $id));
                    } else {
                        $this->db->insert("categories", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteCategories":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM categories WHERE caId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/categories/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/categories/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/categories/medium/' . $checkPhoto[0]->thePhoto);
                }
                $processArr = Array();
                $processArr['isDeleted'] = 1;
                $this->db->update("categories",$processArr,array('caId' => $id));
                echo 1;
                break;


          // Plans
            case "getPlans":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT plId, theTitle, theText, code, langId, categoryId, thePhoto, isActive FROM plans WHERE (theTitle LIKE '%" . $sSearch . "%' OR code LIKE '%" . $sSearch . "%')  AND categoryId = $param2 ORDER BY plId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM plans WHERE categoryId = $param2 ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }

                    if ($dt->isActive == 1) {
                        $mainPhoto = "<div class='actionsIcon published'> <a href='javascript:;'><i class='glyphicon glyphicon-ok-sign' style='color:#4cae4c;'></i></a> </div>";
                    } else {
                        $mainPhoto = "<div class='actionsIcon unPublished'><a href='javascript:;'  data-href='/admin/ajax/changePlanActive/{$param2}/{$dt->plId}' data-name='{$dt->theTitle}'  title='On Home Page' class='publishButton'><i class='glyphicon glyphicon-remove-sign'></i></a> </div>";
                    }

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_plans/{$dt->categoryId}/{$dt->plId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deletePlans/{$dt->plId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
//                    $events = $this->db->query("SELECT evId FROM events WHERE planId = $dt->plId")->result_object();
//                    if(!$events){
//                        $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deletePlans/{$dt->plId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
//                    }

                    $returnToServer["aaData"][] = array(
//                        'EP-'.$dt->code,
                        '<img src="/public/uploads/php/files/plans/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theTitle,
                        strip_tags(word_limiter($dt->theText, 20)),
//                        '<a href="/admin/events/'.$dt->plId.'" class="btn btn-primary right"><i class="fa fa-plus" aria-hidden="true"></i>Cours Event</a>',
//                        $mainPhoto,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditPlans":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('theTitle', ' Title', 'required');
                $this->form_validation->set_rules('theText', ' Text', 'required');
                $this->form_validation->set_rules('langId', 'Language', 'required');
                $this->form_validation->set_rules('categoryId', 'Category', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theTitle"] = $this->Checkdata->checkInputData($this->input->post("theTitle"));
                    $processArr["theText"] = $this->input->post("theText");
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["categoryId"] = $this->Checkdata->checkInputData($this->input->post("categoryId"));
                    $processArr["PageTitle"] = $this->Checkdata->checkInputData($this->input->post("PageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");

//                    $cods = $this->input->post("code");
//                     preg_match_all('!\d+!', $cods, $matches);
//                    $processArr["code"] = $matches[0][0];

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM plans WHERE plId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            if (isset($checkPhoto[0]->thePhoto) && ($checkPhoto[0]->thePhoto != NULL)) {
                            unlink('public/uploads/php/files/plans/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/plans/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/plans/medium/' . $checkPhoto[0]->thePhoto);
                        } }
                        $this->db->update("plans", $processArr, array('plId' => $id));
                    } else {
                        $this->db->insert("plans", $processArr);
                    }
                    echo 1;
                }
                break;

            case "changePlanActive":
                $ProductId = $param2;
                 $id = $param3;
                $processArr = array();
                $processArr2 = array();
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $check = $this->db->query("SELECT plId FROM plans WHERE categoryId = '$ProductId' AND isActive = 1")->result();
                if ($check) {
                    $processArr['isActive'] = 0;
                    $this->db->update("plans", $processArr, array('plId' => $check[0]->plId));
                }
                $processArr2['isActive'] = 1;
                $this->db->update("plans", $processArr2, array('plId' => $id));

                echo 1;
                break;

            case "deletePlans":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM plans WHERE plId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/plans/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/plans/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/plans/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("plans", array('plId' => $id));
                echo 1;
                break;


        //  Categories
            case "getCategories4":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");
                $langId = $this->input->post("langId");
                if($langId == 0){
                    $addtion = " ";
                }else{
                    $addtion = " AND langId = $langId ";
                }

                $result = $this->db->query("SELECT caId, theTitle, langId, thePhoto FROM categories4 WHERE (theTitle LIKE '%" . $sSearch . "%' OR langId LIKE '%" . $sSearch . "%') $addtion AND isDeleted = 0 ORDER BY caId LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM categories4 WHERE isDeleted = 0 $addtion")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }

                    $excel = "<div class='btn-group' role='group' aria-label='...'>
            <a href='/admin/productsExcelExport/".$dt->caId."' class='btn btn-primary right'> Export Excel </a></div>";
                        $actions = "<div class='actionsIcon'><a href='/admin/add_edit_categories4/{$dt->caId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $plans = $this->db->query("SELECT plId FROM plans4 WHERE categoryId = $dt->caId")->result_object();
                    if(!$plans){
                        $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteCategories4/{$dt->caId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
                    }

                    $returnToServer["aaData"][] = array(
                        '<img src="/public/uploads/php/files/categories/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theTitle,
                        '<a href="/admin/plans4/'.$dt->caId.'" class="btn btn-primary right"><i class="fa fa-plus" aria-hidden="true"></i> The Sub</a>',
//                        $excel,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditCategories4":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('theTitle', ' Title', 'required');
                $this->form_validation->set_rules('langId', 'Language', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theTitle"] = $this->Checkdata->checkInputData($this->input->post("theTitle"));
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["PageTitle"] = $this->Checkdata->checkInputData($this->input->post("PageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM categories4 WHERE caId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            unlink('public/uploads/php/files/categories/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/categories/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/categories/medium/' . $checkPhoto[0]->thePhoto);
                        }
                        $this->db->update("categories4", $processArr, array('caId' => $id));
                    } else {
                        $this->db->insert("categories4", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteCategories4":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM categories4 WHERE caId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/categories/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/categories/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/categories/medium/' . $checkPhoto[0]->thePhoto);
                }
                $processArr = Array();
                $processArr['isDeleted'] = 1;
                $this->db->update("categories4",$processArr,array('caId' => $id));
                echo 1;
                break;


          // Plans
            case "getPlans4":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT plId, theTitle, theText, code, langId, categoryId, thePhoto, isActive FROM plans4 WHERE (theTitle LIKE '%" . $sSearch . "%' OR code LIKE '%" . $sSearch . "%') ORDER BY plId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM plans4  ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }

                    if ($dt->isActive == 1) {
                        $mainPhoto = "<div class='actionsIcon published'> <a href='javascript:;'><i class='glyphicon glyphicon-ok-sign' style='color:#4cae4c;'></i></a> </div>";
                    } else {
                        $mainPhoto = "<div class='actionsIcon unPublished'><a href='javascript:;'  data-href='/admin/ajax/changePlanActive/{$param2}/{$dt->plId}' data-name='{$dt->theTitle}'  title='On Home Page' class='publishButton'><i class='glyphicon glyphicon-remove-sign'></i></a> </div>";
                    }

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_plans4/{$dt->plId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deletePlans4/{$dt->plId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
//                    $events = $this->db->query("SELECT evId FROM events WHERE planId = $dt->plId")->result_object();
//                    if(!$events){
//                        $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deletePlans/{$dt->plId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
//                    }

                    $returnToServer["aaData"][] = array(
//                        'EP-'.$dt->code,
                        '<img src="/public/uploads/php/files/plans/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theTitle,
                        strip_tags(word_limiter($dt->theText, 20)),
//                        '<a href="/admin/events/'.$dt->plId.'" class="btn btn-primary right"><i class="fa fa-plus" aria-hidden="true"></i>Cours Event</a>',
//                        $mainPhoto,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditPlans4":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('theTitle', ' Title', 'required');
                $this->form_validation->set_rules('theText', ' Text', 'required');
                $this->form_validation->set_rules('langId', 'Language', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theTitle"] = $this->Checkdata->checkInputData($this->input->post("theTitle"));
                    $processArr["theText"] = $this->input->post("theText");
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["categoryId"] = $this->Checkdata->checkInputData($this->input->post("categoryId"));
                    $processArr["PageTitle"] = $this->Checkdata->checkInputData($this->input->post("PageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");

//                    $cods = $this->input->post("code");
//                     preg_match_all('!\d+!', $cods, $matches);
//                    $processArr["code"] = $matches[0][0];

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM plans4 WHERE plId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            if (isset($checkPhoto[0]->thePhoto) && ($checkPhoto[0]->thePhoto != NULL)) {
                            unlink('public/uploads/php/files/plans/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/plans/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/plans/medium/' . $checkPhoto[0]->thePhoto);
                        } }
                        $this->db->update("plans4", $processArr, array('plId' => $id));
                    } else {
                        $this->db->insert("plans4", $processArr);
                    }
                    echo 1;
                }
                break;

            case "changePlanActive4":
                $ProductId = $param2;
                 $id = $param3;
                $processArr = array();
                $processArr2 = array();
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $check = $this->db->query("SELECT plId FROM plans WHERE categoryId = '$ProductId' AND isActive = 1")->result();
                if ($check) {
                    $processArr['isActive'] = 0;
                    $this->db->update("plans", $processArr, array('plId' => $check[0]->plId));
                }
                $processArr2['isActive'] = 1;
                $this->db->update("plans", $processArr2, array('plId' => $id));

                echo 1;
                break;

            case "deletePlans4":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM plans4 WHERE plId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/plans/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/plans/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/plans/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("plans4", array('plId' => $id));
                echo 1;
                break;


          //  Categories
            case "getCategories2":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");
                $langId = $this->input->post("langId");
                if($langId == 0){
                    $addtion = " ";
                }else{
                    $addtion = " AND langId = $langId ";
                }

                $result = $this->db->query("SELECT caId, theTitle, langId, thePhoto FROM categories2 WHERE (theTitle LIKE '%" . $sSearch . "%' OR langId LIKE '%" . $sSearch . "%') $addtion AND isDeleted = 0 ORDER BY caId LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM categories2 WHERE isDeleted = 0 $addtion")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }

                    $excel = "<div class='btn-group' role='group' aria-label='...'>
            <a href='/admin/productsExcelExport/".$dt->caId."' class='btn btn-primary right'> Export Excel </a></div>";
                        $actions = "<div class='actionsIcon'><a href='/admin/add_edit_categories2/{$dt->caId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $plans = $this->db->query("SELECT plId FROM plans2 WHERE categoryId = $dt->caId")->result_object();
                    if(!$plans){
                        $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteCategories2/{$dt->caId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
                    }

                    $returnToServer["aaData"][] = array(
                        '<img src="/public/uploads/php/files/categories/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theTitle,
                        '<a href="/admin/plans2/'.$dt->caId.'" class="btn btn-primary right"><i class="fa fa-plus" aria-hidden="true"></i> The Sub</a>',
//                        $excel,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditCategories2":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('theTitle', ' Title', 'required');
                $this->form_validation->set_rules('langId', 'Language', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theTitle"] = $this->Checkdata->checkInputData($this->input->post("theTitle"));
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["PageTitle"] = $this->Checkdata->checkInputData($this->input->post("PageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM categories2 WHERE caId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            unlink('public/uploads/php/files/categories/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/categories/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/categories/medium/' . $checkPhoto[0]->thePhoto);
                        }
                        $this->db->update("categories2", $processArr, array('caId' => $id));
                    } else {
                        $this->db->insert("categories2", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteCategories2":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM categories2 WHERE caId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/categories/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/categories/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/categories/medium/' . $checkPhoto[0]->thePhoto);
                }
                $processArr = Array();
                $processArr['isDeleted'] = 1;
                $this->db->update("categories2",$processArr,array('caId' => $id));
                echo 1;
                break;


          // Plans
            case "getPlans2":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT plId, theTitle, theText, code, langId, categoryId, thePhoto, isActive FROM plans2 WHERE (theTitle LIKE '%" . $sSearch . "%' OR code LIKE '%" . $sSearch . "%')  AND categoryId = $param2 ORDER BY plId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM plans2 WHERE categoryId = $param2 ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }

                    if ($dt->isActive == 1) {
                        $mainPhoto = "<div class='actionsIcon published'> <a href='javascript:;'><i class='glyphicon glyphicon-ok-sign' style='color:#4cae4c;'></i></a> </div>";
                    } else {
                        $mainPhoto = "<div class='actionsIcon unPublished'><a href='javascript:;'  data-href='/admin/ajax/changePlanActive/{$param2}/{$dt->plId}' data-name='{$dt->theTitle}'  title='On Home Page' class='publishButton'><i class='glyphicon glyphicon-remove-sign'></i></a> </div>";
                    }

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_plans2/{$dt->categoryId}/{$dt->plId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deletePlans2/{$dt->plId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
//                    $events = $this->db->query("SELECT evId FROM events WHERE planId = $dt->plId")->result_object();
//                    if(!$events){
//                        $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deletePlans/{$dt->plId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
//                    }

                    $returnToServer["aaData"][] = array(
//                        'EP-'.$dt->code,
                        '<img src="/public/uploads/php/files/plans/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theTitle,
                        strip_tags(word_limiter($dt->theText, 20)),
//                        '<a href="/admin/events/'.$dt->plId.'" class="btn btn-primary right"><i class="fa fa-plus" aria-hidden="true"></i>Cours Event</a>',
//                        $mainPhoto,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditPlans2":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('theTitle', ' Title', 'required');
                $this->form_validation->set_rules('theText', ' Text', 'required');
                $this->form_validation->set_rules('langId', 'Language', 'required');
                $this->form_validation->set_rules('categoryId', 'Category', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theTitle"] = $this->Checkdata->checkInputData($this->input->post("theTitle"));
                    $processArr["theText"] = $this->input->post("theText");
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["categoryId"] = $this->Checkdata->checkInputData($this->input->post("categoryId"));
                    $processArr["PageTitle"] = $this->Checkdata->checkInputData($this->input->post("PageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");

//                    $cods = $this->input->post("code");
//                     preg_match_all('!\d+!', $cods, $matches);
//                    $processArr["code"] = $matches[0][0];

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM plans2 WHERE plId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            if (isset($checkPhoto[0]->thePhoto) && ($checkPhoto[0]->thePhoto != NULL)) {
                            unlink('public/uploads/php/files/plans/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/plans/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/plans/medium/' . $checkPhoto[0]->thePhoto);
                        } }
                        $this->db->update("plans2", $processArr, array('plId' => $id));
                    } else {
                        $this->db->insert("plans2", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deletePlans2":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM plans2 WHERE plId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/plans/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/plans/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/plans/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("plans2", array('plId' => $id));
                echo 1;
                break;


                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM plans2 WHERE plId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/plans/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/plans/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/plans/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("plans2", array('plId' => $id));
                echo 1;
                break;



          //  Categories
            case "getCategories3":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");
                $langId = $this->input->post("langId");
                if($langId == 0){
                    $addtion = " ";
                }else{
                    $addtion = " AND langId = $langId ";
                }

                $result = $this->db->query("SELECT caId, theTitle, langId, thePhoto FROM categories3 WHERE (theTitle LIKE '%" . $sSearch . "%' OR langId LIKE '%" . $sSearch . "%') $addtion AND isDeleted = 0 ORDER BY caId LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM categories3 WHERE isDeleted = 0 $addtion")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }

                    $excel = "<div class='btn-group' role='group' aria-label='...'>
            <a href='/admin/productsExcelExport/".$dt->caId."' class='btn btn-primary right'> Export Excel </a></div>";
                        $actions = "<div class='actionsIcon'><a href='/admin/add_edit_categories3/{$dt->caId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $plans = $this->db->query("SELECT plId FROM plans2 WHERE categoryId = $dt->caId")->result_object();
                    if(!$plans){
                        $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteCategories3/{$dt->caId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
                    }

                    $returnToServer["aaData"][] = array(
                        '<img src="/public/uploads/php/files/categories/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theTitle,
                        '<a href="/admin/plans3/'.$dt->caId.'" class="btn btn-primary right"><i class="fa fa-plus" aria-hidden="true"></i> The Sub</a>',
//                        $excel,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditCategories3":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('theTitle', ' Title', 'required');
                $this->form_validation->set_rules('langId', 'Language', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theTitle"] = $this->Checkdata->checkInputData($this->input->post("theTitle"));
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["PageTitle"] = $this->Checkdata->checkInputData($this->input->post("PageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM categories3 WHERE caId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            unlink('public/uploads/php/files/categories/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/categories/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/categories/medium/' . $checkPhoto[0]->thePhoto);
                        }
                        $this->db->update("categories3", $processArr, array('caId' => $id));
                    } else {
                        $this->db->insert("categories3", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteCategories3":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM categories3 WHERE caId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/categories/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/categories/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/categories/medium/' . $checkPhoto[0]->thePhoto);
                }
                $processArr = Array();
                $processArr['isDeleted'] = 1;
                $this->db->update("categories3",$processArr,array('caId' => $id));
                echo 1;
                break;


          // Plans
            case "getPlans3":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT plId, theTitle, theText, code, langId, categoryId, thePhoto, isActive FROM plans3 WHERE (theTitle LIKE '%" . $sSearch . "%' OR code LIKE '%" . $sSearch . "%') ORDER BY plId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM plans3 ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }

                    if ($dt->isActive == 1) {
                        $mainPhoto = "<div class='actionsIcon published'> <a href='javascript:;'><i class='glyphicon glyphicon-ok-sign' style='color:#4cae4c;'></i></a> </div>";
                    } else {
                        $mainPhoto = "<div class='actionsIcon unPublished'><a href='javascript:;'  data-href='/admin/ajax/changePlanActive/{$param2}/{$dt->plId}' data-name='{$dt->theTitle}'  title='On Home Page' class='publishButton'><i class='glyphicon glyphicon-remove-sign'></i></a> </div>";
                    }

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_plans3/{$dt->plId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deletePlans3/{$dt->plId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
//                    $events = $this->db->query("SELECT evId FROM events WHERE planId = $dt->plId")->result_object();
//                    if(!$events){
//                        $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deletePlans/{$dt->plId}' data-name='{$dt->theTitle}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
//                    }

                    $returnToServer["aaData"][] = array(
//                        'EP-'.$dt->code,
                        '<img src="/public/uploads/php/files/plans/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theTitle,
                        strip_tags(word_limiter($dt->theText, 20)),
//                        '<a href="/admin/events/'.$dt->plId.'" class="btn btn-primary right"><i class="fa fa-plus" aria-hidden="true"></i>Cours Event</a>',
//                        $mainPhoto,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditPlans3":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('theTitle', ' Title', 'required');
                $this->form_validation->set_rules('theText', ' Text', 'required');
                $this->form_validation->set_rules('langId', 'Language', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theTitle"] = $this->Checkdata->checkInputData($this->input->post("theTitle"));
                    $processArr["theText"] = $this->input->post("theText");
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["categoryId"] = 1;
                    $processArr["PageTitle"] = $this->Checkdata->checkInputData($this->input->post("PageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");

//                    $cods = $this->input->post("code");
//                     preg_match_all('!\d+!', $cods, $matches);
//                    $processArr["code"] = $matches[0][0];

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $checkPhoto = $this->db->query("SELECT thePhoto FROM plans3 WHERE plId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            if (isset($checkPhoto[0]->thePhoto) && ($checkPhoto[0]->thePhoto != NULL)) {
                            unlink('public/uploads/php/files/plans/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/plans/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/plans/medium/' . $checkPhoto[0]->thePhoto);
                        } }
                        $this->db->update("plans3", $processArr, array('plId' => $id));
                    } else {
                        $this->db->insert("plans3", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deletePlans3":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM plans3 WHERE plId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/plans/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/plans/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/plans/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("plans3", array('plId' => $id));
                echo 1;
                break;






          // Events
            case "getEvents":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");


                $result = $this->db->query("SELECT EV.*, TOW.enName, TOW.arName FROM events EV INNER JOIN towns TOW "
                        . " ON TOW.toId = EV.townId WHERE (EV.eventCode LIKE '%" . $sSearch . "%' OR EV.thePrice LIKE '%" . $sSearch . "%')  AND EV.planId = $param2 ORDER BY EV.evId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM events EV INNER JOIN towns TOW "
                        . " ON TOW.toId = EV.townId WHERE EV.planId = $param2 ")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $lang = $this->db->query("SELECT langId FROM plans WHERE plId = $param2 ")->result_object();
                    if($lang[0]->langId == 1){
                        $theLang = $dt->arName;
                    }else{
                        $theLang = $dt->enName;
                    }

                    if ($dt->isActive == 1) {
                        $mainPhoto = "<div class='actionsIcon published'> <a href='javascript:;' data-href='/admin/ajax/changeEventActive/{$dt->evId}' data-name='{$dt->eventCode}'  title='Cancel This Event' class='publishButton2'><i class='glyphicon glyphicon-ok-sign' style='color:#4cae4c;'></i></a> </div>";
                    } else {
                        $mainPhoto = "<div class='actionsIcon unPublished'><a href='javascript:;' data-href='/admin/ajax/changeEventActive2/{$dt->evId}' data-name='{$dt->eventCode}' title='Active This Event' class='publishButton'><i class='glyphicon glyphicon-remove-sign'></i></a> </div>";
                    }

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_events/{$dt->planId}/{$dt->evId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteEvents/{$dt->evId}' data-name='{$dt->eventCode}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";

                    $returnToServer["aaData"][] = array(
                        'SQ-481'.$dt->evId,
                        $dt->openDate,
                        $dt->closeDate,
                        $dt->daysNumber.' Days',
                        $theLang,
                        $dt->thePrice,
                        $mainPhoto,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

        case "changeEventActive":
                $id = $param2;
                $processArr2 = array();
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                    $processArr2['isActive'] = 0;

                $this->db->update("events", $processArr2, array('evId' => $id));

                echo 1;
                break;

        case "changeEventActive2":
                $id = $param2;
                $processArr2 = array();
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                    $processArr2['isActive'] = 1;

                $this->db->update("events", $processArr2, array('evId' => $id));

                echo 1;
                break;

            case "addEditEvents":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('eventCode', ' Event Code', 'required');
                $this->form_validation->set_rules('openDate', ' Open Date', 'required');
                $this->form_validation->set_rules('closeDate', 'Close Date', 'required');
                $this->form_validation->set_rules('thePrice', 'Price', 'required');
                $this->form_validation->set_rules('townId', 'Town', 'required');


                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["thePrice"] = $this->Checkdata->checkInputData($this->input->post("thePrice"));
                    $processArr["openDate"] = $this->input->post("openDate");
                    $processArr["closeDate"] = $this->input->post("closeDate");
                    $processArr["planId"] = $this->Checkdata->checkInputData($this->input->post("planId"));
                    $processArr["townId"] = $this->Checkdata->checkInputData($this->input->post("townId"));
                    $processArr["daysNumber"] = $this->Checkdata->checkInputData($this->input->post("daysNumber"));

                    $cods = $this->input->post("eventCode");
                     preg_match_all('!\d+!', $cods, $matches);
                    $processArr["eventCode"] = $matches[0][0];


                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $this->db->update("events", $processArr, array('evId' => $id));
                    } else {
                        $this->db->insert("events", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteEvents":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $this->db->delete("events", array('evId' => $id));
                echo 1;
                break;

         // Blog
            case "getBlog":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");
                $langId = $this->input->post("langId");
                if($langId == 0){
                    $addtion = " ";
                    $addtion2 = " ";
                }else{
                    $addtion2 = " WHERE langId = $langId ";
                    $addtion = " AND langId = $langId ";
                }
                $result = $this->db->query("SELECT blId, theName, langId, theText, thePhoto, dateTime FROM blog WHERE (theName LIKE '%" . $sSearch . "%' OR theText LIKE '%" . $sSearch . "%') $addtion ORDER BY blId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM blog $addtion2")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {
                    $lang = $this->db->query("SELECT theName FROM lang WHERE laId = $dt->langId ")->result_object();
                    if($lang){
                        $theLang = $lang[0]->theName;
                    }else{
                        $theLang = " ";
                    }
                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_blog/{$dt->blId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteBlog/{$dt->blId}' data-name='{$dt->theName}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";

                    $returnToServer["aaData"][] = array(
                        '<img src="/public/uploads/php/files/blog/' . $dt->thePhoto . '" width="80">',
                        $theLang,
                        $dt->theName,
                        strip_tags(word_limiter($dt->theText, 10)),
                        Date("d/m/Y", strtotime($dt->dateTime)),
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditBlog":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('langId', 'Language', 'required');
                $this->form_validation->set_rules('theName', 'Name', 'required');
                $this->form_validation->set_rules('theText', 'Text', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["theName"] = $this->Checkdata->checkInputData($this->input->post("theName"));
                    $processArr["langId"] = $this->Checkdata->checkInputData($this->input->post("langId"));
                    $processArr["theText"] = $this->input->post("theText");

                    $processArr["PageTitle"] = $this->Checkdata->checkInputData($this->input->post("PageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");
                    $processArr["dateTime"] = Date("Y-m-d H:i:s");

                    if ($thePhoto)
                        $processArr["thePhoto"] = $thePhoto;

                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM blog WHERE blId = $id")->result();
                        if ($thePhoto && $checkPhoto) {
                            unlink('public/uploads/php/files/blog/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/blog/thumbnail/' . $checkPhoto[0]->thePhoto);
                            unlink('public/uploads/php/files/blog/medium/' . $checkPhoto[0]->thePhoto);
                        }
                        $this->db->update("blog", $processArr, array('blId' => $id));
                    } else {
                        $this->db->insert("blog", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteBlog":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM blog WHERE blId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/blog/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/blog/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/blog/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("blog", array('blId' => $id));
                echo 1;
                break;

            // Gallery
            case "getGallery":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");
                $typeId = $this->input->post("typeId");
                $ProductId = $param2;

                $result = $this->db->query("SELECT gaId, productId, thePhoto FROM gallery WHERE productId = '$ProductId' ORDER BY gaId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM gallery  WHERE productId = '$ProductId'")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                $actions = " ";
                $mainPhoto = ' ';
                foreach ($result as $dt) {

                    $actions = "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteGallery/{$dt->gaId}' data-name='This Photo' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";
                    if ($dt->gaId == 1) {
                        $mainPhoto = "<div class='actionsIcon published'><a href='javascript:;' data-name='This Photo'><i class='glyphicon glyphicon-ok-sign' style='color:#4cae4c;'></i></a> </div>";
                    } else {
                        $mainPhoto = "<div class='actionsIcon unPublished'><a href='javascript:;'  data-href='/admin/ajax/changeMainPhoto/{$dt->gaId}/{$dt->productId}' data-name='This Photo' title='Make it Main Photo' class='publishButton'><i class='glyphicon glyphicon-remove-sign'></i></a> </div>";
                    }
                    $returnToServer["aaData"][] = array(
                        '<img src="/public/uploads/php/files/gallery/thumbnail/' . $dt->thePhoto . '" width="80">',
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addGallery":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('file', 'Photo ', 'required');

                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));
                $files = explode("|", $thePhoto);

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $ProductId = $this->Checkdata->checkInputData($this->input->post("menuId"));

            foreach ($files as $value) {

                if ($value != "") {
                    $processArr = array(
                        'thePhoto' => $value,
                        'productId'=> $ProductId
                    );
                   $this->db->insert("gallery", $processArr);
                }
            }

                    echo 1;
                }
                break;


            case "deleteGallery":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $checkPhoto = $this->db->query("SELECT thePhoto FROM gallery WHERE gaId = $id")->result();
                if ($checkPhoto) {
                    unlink('public/uploads/php/files/gallery/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/gallery/thumbnail/' . $checkPhoto[0]->thePhoto);
                    unlink('public/uploads/php/files/gallery/medium/' . $checkPhoto[0]->thePhoto);
                }

                $this->db->delete("gallery", array('gaId' => $id));
                echo 1;
                break;

            // Contact Us
            case "getContactUs":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT coId, emailAddress, emailAddress2, phoneNumber, phoneNumber2, phoneNumber3, phoneNumber4, enAddress, arAddress, companyName, latitude, longitude FROM contact_us WHERE coId = 1")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM contact_us")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_contact_us'><i class='glyphicon glyphicon-pencil'></i></a></div>";

                    $returnToServer["aaData"][] = array(
                        $dt->companyName,
                        $dt->emailAddress.'<br>'.$dt->emailAddress2,
                        $dt->phoneNumber.'<br>-'.$dt->phoneNumber2.'<br>-'.$dt->phoneNumber3.'<br>-'.$dt->phoneNumber4,
                        strip_tags(word_limiter($dt->enAddress, 20)),
                        strip_tags(word_limiter($dt->arAddress, 20)),
                        $dt->latitude,
                        $dt->longitude,
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;


            case "addEditContactUs":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('emailAddress', 'Email Address', 'required');
                $this->form_validation->set_rules('phoneNumber', 'Phone Number', 'required');
                $this->form_validation->set_rules('enDetails', ' English Details', 'required');
                $this->form_validation->set_rules('enDetails', ' Arabic Details', 'required');

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["companyName"] = $this->Checkdata->checkInputData($this->input->post("companyName"));
                    $processArr["emailAddress"] = $this->Checkdata->checkInputData($this->input->post("emailAddress"));
                    $processArr["emailAddress2"] = $this->Checkdata->checkInputData($this->input->post("emailAddress2"));
                    $processArr["phoneNumber"] = $this->Checkdata->checkInputData($this->input->post("phoneNumber"));
                    $processArr["phoneNumber2"] = $this->Checkdata->checkInputData($this->input->post("phoneNumber2"));
                    $processArr["phoneNumber3"] = $this->Checkdata->checkInputData($this->input->post("phoneNumber3"));
                    $processArr["phoneNumber4"] = $this->Checkdata->checkInputData($this->input->post("phoneNumber4"));
                    $processArr["enAddress"] = $this->input->post("enDetails");
                    $processArr["arAddress"] = $this->input->post("arDetails");
                    $processArr["latitude"] = $this->input->post("latitude");
                    $processArr["longitude"] = $this->input->post("longitude");
                    $processArr["enPageTitle"] = $this->Checkdata->checkInputData($this->input->post("enPageTitle"));
                    $processArr["arPageTitle"] = $this->Checkdata->checkInputData($this->input->post("arPageTitle"));
                    $processArr["pageDesc"] = $this->input->post("pageDesc");
                    $processArr["traceCode"] = $this->input->post("traceCode");

                    $this->db->update("contact_us", $processArr, array('coId' => 1));

                    echo 1;
                }
                break;


            // Social Media
            case "getSocialMedia":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT coId, facebook, instagram, twitter, snapchat, whatsapp, whatsapp2, messanger FROM contact_us WHERE coId = 1")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM contact_us")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_social_media'><i class='glyphicon glyphicon-pencil'></i></a></div>";

                    $returnToServer["aaData"][] = array(
                        '<a href="' . $dt->facebook . '" target="_blank">' . $dt->facebook . '</a>',
                        '<a href="' . $dt->instagram . '" target="_blank">' . $dt->instagram . '</a>',
                        '<a href="' . $dt->twitter . '" target="_blank">' . $dt->twitter . '</a>',
                        '<a href="' . $dt->snapchat . '" target="_blank">' . $dt->snapchat . '</a>',
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditSocialMedia":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'id', 'required');


                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["facebook"] = $this->Checkdata->checkInputData($this->input->post("facebook"));
                    $processArr["instagram"] = $this->Checkdata->checkInputData($this->input->post("instagram"));
                    $processArr["twitter"] = $this->Checkdata->checkInputData($this->input->post("twitter"));
                    $processArr["snapchat"] = $this->Checkdata->checkInputData($this->input->post("snapchat"));
                    $processArr["whatsapp"] = $this->Checkdata->checkInputData($this->input->post("whatsapp"));
                    $processArr["whatsapp2"] = $this->Checkdata->checkInputData($this->input->post("whatsapp2"));
                    $processArr["messanger"] = $this->Checkdata->checkInputData($this->input->post("messanger"));

                    $this->db->update("contact_us", $processArr, array('coId' => 1));

                    echo 1;
                }
                break;


            // common Questions
            case "getCommonQuestions":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT * FROM common_questions WHERE (questionEn LIKE '%" . $sSearch . "%' OR questionAr LIKE '%" . $sSearch . "%') ORDER BY coId ASC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM common_questions")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_common_questions/{$dt->coId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
                    $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteCommonQuestions/{$dt->coId}' data-name='{$dt->questionAr}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";

                    $returnToServer["aaData"][] = array(
//                        '<img src="/public/uploads/php/files/ourServices/' . $dt->thePhoto . '" width="80">',
                        strip_tags(word_limiter($dt->questionEn, 10)),
                        strip_tags(word_limiter($dt->questionAr, 10)),
                        strip_tags(word_limiter($dt->answerEn, 10)),
                        strip_tags(word_limiter($dt->answerAr, 10)),
                        $actions
                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditCommonQuestions":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('enName', 'English Quest', 'required');
                $this->form_validation->set_rules('arName', 'Arabic Ques', 'required');
                $this->form_validation->set_rules('enText', 'English Answer', 'required');
                $this->form_validation->set_rules('arText', 'Arabic Answer', 'required');

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {
                    $id = $this->Checkdata->checkInputData($this->input->post("id"));
                    $processArr = array();
                    $processArr["questionEn"] = $this->Checkdata->checkInputData($this->input->post("enName"));
                    $processArr["questionAr"] = $this->Checkdata->checkInputData($this->input->post("arName"));
                    $processArr["answerEn"] = $this->input->post("enText");
                    $processArr["answerAr"] = $this->input->post("arText");


                    if ($id != 0) {
                        $this->Checkdata->isNotNumeric($id);
                        $this->Checkdata->ifEmptyOrZero($id);

                        $this->db->update("common_questions", $processArr, array('coId' => $id));
                    } else {
                        $this->db->insert("common_questions", $processArr);
                    }
                    echo 1;
                }
                break;

            case "deleteCommonQuestions":
                $id = $param2;
                $this->Checkdata->isNotNumeric($id);
                $this->Checkdata->ifEmptyOrZero($id);

                $this->db->delete("common_questions", array('coId' => $id));
                echo 1;
                break;


      // setting
            case "getSetting":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT seId, theName, theValue FROM site_setting ORDER BY FIELD(seId,'9','3')DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = 7;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {
                    if ($dt->seId < 7 || $dt->seId == 9) {
                    if ($dt->seId == 3 || $dt->seId == 9) {
                        $theValue = '<img src="/public/uploads/php/files/logos/thumbnail/' . $dt->theValue . '" width="80">';
                    } elseif ($dt->seId == 1 || $dt->seId == 2 || $dt->seId == 7 || $dt->seId == 8) {
                        $theValue = '<div  class="btn btn-primary color" style=" background-color:' . $dt->theValue . ';"> Color </div>';
                    } else {
                        $theValue = strip_tags(word_limiter($dt->theValue, 20));
                    }
                    $actions = "<div class='actionsIcon'><a href='/admin/add_edit_setting/{$dt->seId}'><i class='glyphicon glyphicon-pencil'></i></a></div>";
//                    $actions .= "<div class='actionsIcon delete'><a href='javascript:;' data-href='/admin/ajax/deleteMenuList/{$dt->meId}' data-name='{$dt->arName}' class='deleteButton'><i class='glyphicon glyphicon-trash'></i></a> </div>";

                    $returnToServer["aaData"][] = array(
                        $dt->theName,
                        $theValue,
                        $actions
                    );
                    }
                }
                echo json_encode($returnToServer);
                break;

     // subscribers
            case "getSubscribers":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT * FROM subscribers WHERE (emailAddress LIKE '%" . $sSearch . "%') ORDER BY suId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM subscribers")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $key =>$dt) {

                    $returnToServer["aaData"][] = array(
                        $key+1,
                        $dt->emailAddress,

                    );
                }
                echo json_encode($returnToServer);
                break;


     // Contact Us Form
            case "getContactUsForm":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT * FROM contactus_form WHERE (theName LIKE '%" . $sSearch . "%' OR emailAddress LIKE '%" . $sSearch . "%') ORDER BY coId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM contactus_form")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $returnToServer["aaData"][] = array(
                        $dt->theName,
                        $dt->companyName,
                        $dt->phoneNumber,
                        $dt->emailAddress,
                        str_replace("_"," ","$dt->howToContact"),
                        $dt->note,

                    );
                }
                echo json_encode($returnToServer);
                break;

// Course Form
            case "getCourseForm":
                $sEcho = $this->input->post("sEcho");
                $sSearch = $this->input->post("sSearch");
                $iDisplayStart = $this->input->post("iDisplayStart");
                $iDisplayLength = $this->input->post("iDisplayLength");

                $result = $this->db->query("SELECT * FROM forms WHERE (The_Name LIKE '%" . $sSearch . "%' OR Department LIKE '%" . $sSearch . "%' OR Courses_Name LIKE '%" . $sSearch . "%' OR Email_Address LIKE '%" . $sSearch . "%') ORDER BY foId DESC LIMIT $iDisplayStart, $iDisplayLength")->result();
                $resultCount = $this->db->query("SELECT COUNT(1) as cnt FROM forms")->row()->cnt;
                $returnToServer = array();
                $returnToServer["sEcho"] = $sEcho;
                $returnToServer["iTotalRecords"] = $resultCount;
                $returnToServer["iTotalDisplayRecords"] = $resultCount;
                $returnToServer["aaData"] = array();
                foreach ($result as $dt) {

                    $returnToServer["aaData"][] = array(
                        $dt->The_Name,
                        $dt->Entity,
                        $dt->Job_Position,
                        $dt->Phone_Number,
                        $dt->Email_Address,
                        $dt->Department,
                        $dt->Courses_Name,
                        $dt->Course_Country,
                        $dt->Course_Date,
                        $dt->Message,

                    );
                }
                echo json_encode($returnToServer);
                break;

            case "addEditSetting":
                $this->load->helper('form');
                $this->load->library('form_validation');

                $id = $this->Checkdata->checkInputData($this->input->post("id"));
                if ($id == 1 || $id == 2 || $id == 7 || $id == 8) {
                    $this->form_validation->set_rules('theColor', 'Color', 'required');
                }
                $this->form_validation->set_rules('id', 'id', 'required');
                $thePhoto = $this->Checkdata->checkInputData($this->input->post("file"));

                if ($this->form_validation->run() === FALSE) {
                    echo validation_errors();
                } else {

                    $processArr = array();
//                    $prcessArr["theName"] = $this->Checkdata->checkInputData($this->input->post("theName"));
                    if ($id == 3 || $id == 9) {
                        if ($thePhoto) {
                            $processArr["theValue"] = $thePhoto;
                        }
                    } elseif ($id == 1 || $id == 2 || $id == 7 || $id == 8) {
                        $processArr["theValue"] = $this->input->post("theColor");
                    } elseif ($id == 4 || $id == 5) {
                        $processArr["theValue"] = $this->input->post("theData");
                    } elseif ($id == 6) {
                        $processArr["theValue"] = $this->input->post("theData2");
                    }
                    $this->Checkdata->isNotNumeric($id);
                    $this->Checkdata->ifEmptyOrZero($id);
                    $this->db->update("site_setting", $processArr, array('seId' => $id));

                    echo 1;
                }
                break;
        }
    }

}

//$medicalEquipmentsSubCategories = $this->db->query("SELECT meSubCatId, theTitle, categoryId, theDetails FROM medical_equipments_sub_categories WHERE meSubCatId = $id")->result_object();
