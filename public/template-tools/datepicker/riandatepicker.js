$(document).ready(function(){
    var date_input=$('input[id="date"]');
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
    format: 'mm/dd/yyyy',
    container: container,
    todayHighlight: true,
    autoclose: true,
    };
    date_input.datepicker(options);
})

$(document).ready(function(){
    var date_input=$('input[id="filter"]');
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
    format: 'yyyy-mm-dd',
    container: container,
    todayHighlight: true,
    autoclose: true,
    };
    date_input.datepicker(options);
})

$(document).ready(function(){
    var date_input=$('.date_asset');
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
    format: 'dd-mm-yyyy',
    container: container,
    todayHighlight: true,
    autoclose: true,
    };
    date_input.datepicker(options);
})