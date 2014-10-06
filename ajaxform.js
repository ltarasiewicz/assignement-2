jQuery( document ).ready(function() 
{
       
    jQuery( "#ajax_form" ).submit(function(event) 
    {        
        jQuery.post( 
            AjaxForm.ajaxurl,
            jQuery("#ajax_form :input").serialize(), 
            function(error)
            {
                if (error !== '')
                {                    
                    for(key in error)
                    {
                        jQuery('#' + error[key]).addClass('form_error').attr('placeholder', error[key]);
                    }
                } 
                else
                {
                    window.uploadObject.startUpload();
                }
            }, 
            "json"
        )
        .fail(function() 
        {

        });
        
        event.preventDefault();
    });
});