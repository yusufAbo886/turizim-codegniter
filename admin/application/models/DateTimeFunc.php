<?php 
class DateTimeFunc extends CI_Model{

    function fromDatepickerToSqlDate($var){
        $theDate = explode("/", $var);
        $theData = $theDate[2] . "-" . $theDate[1] . "-" . $theDate[0];
        return $theData;
    }

    function fromSqlDateToDatepicker($var){
        $theDate = explode("-", $var);
        $theData = $theDate[2] . "/" . $theDate[1] . "/" . $theDate[0];
        return $theData;
    }

}

?>