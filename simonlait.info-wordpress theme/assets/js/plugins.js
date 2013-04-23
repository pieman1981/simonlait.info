// Plugins
$(function(){

    $("ul.dropdown > li").hover(function(){
    
        $(this).addClass("hover");
        $('ul:first',this).css('visibility', 'visible').show();
    
    }, function(){
    
        $(this).removeClass("hover");
        $('ul:first',this).css('visibility', 'hidden').hide();
    
    });
    
    $("ul.dropdown li ul li:has(ul)").find("a:first").append(" &raquo; ");
	
	$('.opac').css({ opacity: 0.6 });
	
	$('input[type="submit"]').val('Submit Form');

});