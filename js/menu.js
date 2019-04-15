$(document).ready(function() {
	$('div.list').hide();
	$('#left-sidebar a.close').click(function(){
		var link = $(this);
		link.next().slideToggle('fast');
		link.toggleClass('open');
		return false;
	});
});