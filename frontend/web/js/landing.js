function submitForm(obj) {
	$(obj).children('span').html('');
	$(obj).children('img').removeClass('hide');
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	
	$.ajax({
		url : 'site/index',
		type : 'post',
		data : {email:$('.registration-input').value,_csrf: csrfToken},
		dataType: 'json',
		success : function() {
			$(obj).children('span').html('Submitted!');
			$(obj).addClass('green');
			$(obj).children('img').addClass('hide');
			$('.registration-input').val('');
		},
		error : function() {
			alert('error!');
		}
	});
}