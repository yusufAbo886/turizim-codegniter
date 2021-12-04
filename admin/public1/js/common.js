var respajax;
this.common = new function() {
    /*
    @param text = alert description (HTML allowed);
    @param type= Bootstrap alert component type. "success","info","warning","denger"; default = "success"
    @param time = dismiss time as second, after specified seconds later, alert box dismiss; default = 0 ( timer off )
    @param selector = Jquery selector for target element; default = "form"
    @param attitude = Jquery function. "html","before","append","text" etc. ; default = "prepend"
    */
   alertId=0;
    this.showAlert = function(text,type,time,selector,attitude) { //
        type = typeof type !== 'undefined' ? type : "success";
        time = typeof time !== 'undefined' ? time : 3;
        selector = typeof selector !== 'undefined' ? selector : "form";
        attitude = typeof attitude !== 'undefined' ? attitude : "prepend";
        text=$.trim(text)
        alertHTML='<div id="alertId'+alertId+'" class="alert alert-'+type+' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+text.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ "\\" +'$2');+'</div>';
         eval("$('"+selector+":first')."+attitude+"('"+alertHTML+"');");
        if($('#alertId'+(alertId-1)).length)
            $('#alertId'+(alertId-1)).remove();
        lastAlertIdObj=$('#alertId'+alertId);
        if(time)
            setTimeout(function(){ 
                lastAlertIdObj.fadeOut();
            }, parseInt(time)*1000);
         alertId++;
    };
    
};