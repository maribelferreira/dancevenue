$(document).ready(function(){
	$('nav').addClass('collapsedInNarrowScreen');

	$('#menuExpand').click(function() {
		$('nav').removeClass('collapsedInNarrowScreen');
	});

	$('#menuCollapse').click(function() {
		$('nav').addClass('collapsedInNarrowScreen');
	});
});

