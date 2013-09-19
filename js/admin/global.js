$(document).ready(function(){

	$('html').click(function(){
		$('ul#main-menu > li > a').removeClass('active').next('ul.submenu').hide();
	});
	
	$('ul#main-menu > li > a').click(function(){
		$('ul#main-menu > li > a').not(this).removeClass('active');
		
		if ($(this).hasClass('has-submenu'))
		{
			if ($(this).hasClass('active'))
			{
				$(this).removeClass('active').next('ul.submenu').hide();
			}
			else
			{
				$('ul#main-menu > li > ul.submenu').hide();
				$(this).addClass('active').next('ul.submenu').show();
			}
			return false;
		}
	});
	
});