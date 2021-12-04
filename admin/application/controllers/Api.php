<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller{

    function __construct(){
        parent::__construct();

        $this->load->model('Checkdata', '', TRUE);
        $this->load->model('Funcs', '', TRUE);
        $this->load->helper("text");

        date_default_timezone_set('Europe/Istanbul');
    }

    public function index(){

        $postingData = file_get_contents("php://input");

        if(isset($postingData)){
           $request = json_decode($postingData);
           $tag = $request->tag;
        }

        $response = array("tag" => $tag, "error" => FALSE);

        if($tag){

            switch ($tag) {

                case "getProducts":
                          $lang = $this->Checkdata->checkInputData($request->language);
                          if($lang == 'en'){
                              $products = $this->db->query("SELECT 	PR.prId, PR.enName as productName, PR.enText as productsText,
                                                            FROM products PR
                                                            INNER JOIN products_gallery GA ON PR.prId = GA.productId
                                                            GROUP BY GA.productId ORDER BY prId")->result_array();
                          }else{
                              $products = $this->db->query("SELECT 	PR.prId, PR.arName as productName, PR.arText as productsText,
                                                            FROM products PR
                                                            INNER JOIN products_gallery GA ON PR.prId = GA.productId
                                                            GROUP BY GA.productId ORDER BY prId")->result_array();
                          }

                          if ($products) {
                              $response['data'] = array(
                                  "products" => $products
                              );
                          }else {
                              $response['data'] = array(
                                  "products" => null
                              );
                              $response["error"] = true;
                              $response["error_msg"] = "No Data";
                          }
                    break;

                case "getProductDetails":
                          $productId = $this->Checkdata->checkInputData($request->productId);
                          $lang = $this->Checkdata->checkInputData($request->language);
                          $dataArray = array();

                          if($lang == 'en'){
                            $dataArray['theProductData'] = $this->db->query("SELECT 	prId, enName as productName, enText as productsText FROM products WHERE prId = $productId")->result_array();
                          }else{
                            $dataArray['theProductData'] = $this->db->query("SELECT 	prId, enName as productName, enText as productsText FROM products WHERE prId = $productId")->result_array();
                          }

                          $dataArray['galleryData'] = $this->db->query("SELECT thePhoto, mainPhoto FROM products_gallery WHERE productId = $productId")->result_array();


                          if (!empty($dataArray['theProductData'])) {
                              $response['data'] = array(
                                  "productsData" => $dataArray
                              );
                          }else {
                              $response['data'] = array(
                                  "productsData" => null
                              );
                              $response["error"] = true;
                              $response["error_msg"] = "No Data";
                          }
                    break;

                case "getServices":
                          $lang = $this->Checkdata->checkInputData($request->language);
                          if($lang == 'en'){
                              $services = $this->db->query("SELECT 	seId, enName as servicesName, enText as servicesText, thePhoto FROM our_services ORDER BY seId")->result_array();
                          }else{
                              $services = $this->db->query("SELECT 	seId, arName as servicesName, arText as servicesText, thePhoto FROM our_services ORDER BY seId")->result_array();
                          }

                          if ($services) {
                              $response['data'] = array(
                                  "services" => $services
                              );
                          }else {
                              $response['data'] = array(
                                  "services" => null
                              );
                              $response["error"] = true;
                              $response["error_msg"] = "No Data";
                          }
                    break;

                case "getGallery":
                          $gallery = $this->db->query("SELECT 	gaId, thePhoto FROM our_services ORDER BY seId")->result_array();

                          if ($gallery) {
                              $response['data'] = array(
                                  "gallery" => $gallery
                              );
                          }else {
                              $response['data'] = array(
                                  "gallery" => null
                              );
                              $response["error"] = true;
                              $response["error_msg"] = "No Data";
                          }
                    break;

                case "getAbout":
                          $lang = $this->Checkdata->checkInputData($request->language);
                          if($lang == 'en'){
                              $aboutData = $this->db->query("SELECT enText as theText FROM text_data WHERE abId = 1")->result_array();
                          }else {
                              $aboutData = $this->db->query("SELECT arText as theText FROM text_data WHERE abId = 1")->result_array();
                          }

                          if ($aboutData) {
                              $response['data'] = array(
                                  "aboutData" => $aboutData
                              );
                          }else {
                              $response["error"] = true;
                              $response["error_msg"] = "No Data";
                          }
                    break;

                case "getContactData":
                    $lang = $this->Checkdata->checkInputData($request->language);
                    $dataArray = array();

                    if($lang == 'en'){
                      $dataArray['theContactData'] = $this->db->query("SELECT enAddress as theAddress, phoneNumber, emailAddress, latitude, longitude, companyName, facebook, instagram, twitter, snapchat FROM contact_us WHERE coId = 1")->result_array();
                    }else{
                      $dataArray['theContactData'] = $this->db->query("SELECT arAddress as theAddress, phoneNumber, emailAddress, latitude, longitude, companyName, facebook, instagram, twitter, snapchat FROM contact_us WHERE coId = 1")->result_array();
                    }

                    if (!empty($dataArray['theContactData'])) {
                        $response['data'] = array(
                            "contactData" => $dataArray
                        );
                    }else {
                        $response['data'] = array(
                            "contactData" => null
                        );
                        $response["error"] = true;
                        $response["error_msg"] = "No Data";
                    }
                    break;

                case "getSettings":
                          $lang = $this->Checkdata->checkInputData($request->language);
                          if($lang == 'en'){
                              $settings = $this->db->query("SELECT 	prId, theValue FROM site_setting")->result_array();
                          }else{
                              $settings = $this->db->query("SELECT 	prId, theValue FROM site_setting")->result_array();
                          }

                          if ($settings) {
                              $response['data'] = array(
                                  "settings" => $settings
                              );
                          }else {
                              $response['data'] = array(
                                  "settings" => null
                              );
                              $response["error"] = true;
                              $response["error_msg"] = "No Data";
                          }
                    break;

                default:
                    break;
            }
        }else {
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameter 'tag' is missing!";
        }
        echo json_encode($response);

    }




}
