$(document).ready(function(){
    $('.tooltip_basic').tooltip();
    
    $(".select2").select2();
    
    $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            language: 'es',
            format: 'dd/mm/yyyy'
    });  
    
    $('#main-menu-wrapper ul li a').each(function(n) {        
            var url = $(this).attr('href');       
            if(location.pathname == url)
            {
                $(this).parents('li').addClass('active open');
            }
            else
            {
                $(this).parent('li').removeClass('active open');    
            }
        })

});

function blockUI(el) {		
            $(el).block({
                message: '<div class="loading-animator"></div>',
                css: {
                    border: 'none',
                    padding: '2px',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.3,
                    cursor: 'wait'
                }
            });
     }
	 
     // wrapper function to  un-block element(finish loading)
     function unblockUI(el) {
            $(el).unblock();
    }
	
	$(window).resize(function() {
			calculateHeight();
	});
	
	$(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });