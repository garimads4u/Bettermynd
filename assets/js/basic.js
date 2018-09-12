$(function () {
      $('.datetimepicker').datetimepicker({
         format: 'DD/MM/YYYY',		   
      });
      $('.dob').datetimepicker({
         format: 'MM/DD/YYYY',	
         maxDate: new Date() 
      });

    $(".mobilemark").inputmask("999-999-9999", {"placeholder": "___-___-____"});
});