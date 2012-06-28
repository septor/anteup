$(document).ready(function(){
	$(".addentry").hide();
	$(".toggleadd").show();
    $('.toggleadd').click(function(){
		$(".addentry").slideToggle();
    });
	
	$('#item_name').change(function() {
    $('#other').css('display', ($(this).val() == '--Other--') ? 'block' : 'none');
});
});