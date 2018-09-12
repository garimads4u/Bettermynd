var flag=false;
jQuery(function($){

    fields = ['credit_card_number',
              'credit_card_expiry',
              'credit_card_cvc',
//             'dd_mm_yyyy',
//             'yyyy_mm_dd',
//             'email',
//             'number',
             'phone_number',
//             'postal_code',
//             'time_yy_mm',
//             'uk_sort_code',
//             'ontario_drivers_license_number',
//             'ontario_photo_health_card_number',
//             'ontario_outdoors_card_number'
              ]

     $.each( fields, function (index, value) {
         $('input.'+value).formance('format_'+value)
                         .addClass('form-control');
                         // .wrap('<div class=\'form-group\' />')
                         // .parent()
                            // .append('<label class=\'control-label\'>Try This Demo!</label>');

        $('input.'+value).on('keyup change blur', function (value) {
            return function (event) {
                $this = $(this);
                if ($this.formance('validate_'+value)) {
                    $this.parent()
                            .removeClass('has-success has-error')
                            .addClass('has-success');
                    var card_type= $.formance.creditCardType($this.val());
                    
                    switch(card_type){
                        case 'mastercard':
                        $('.cccard').addClass('mastercard_icon');
                        break;
                        case 'visa':
                        $('.cccard').addClass('visa_icon');
                        break;
                        case 'discover':
                        $('.cccard').addClass('discover-card_icon');
                        break;
                    }
                            //.children(':last').hide();
                               // .text('Valid data!');
								flag=false;
								
                } else {
//                    $this.parent()
                            $this.removeClass('has-success has-error valid')
                            .addClass('error');
                     $('.cccard').removeClass().addClass('cccard');
                   // $('input.'+value).append("<span class='error'>Invalid</span>");
                           
                            //.children(':last').hide()
                                //.text('Entered value is invalid.');
								flag=true;
                }
            }
        }(value));
     });
$("#signupform").submit(function(e){
	if(flag){
	e.preventDefault();
	}
	else{
		return true;
	}
});
});
