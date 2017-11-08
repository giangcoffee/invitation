/*
Name: 			View - Contact
Written by: 	Okler Themes - (http://www.okler.net)
Version: 		3.7.0
*/

function sendMessage() {
	var email = $('form#contactForm input#email').val();
	var pattern = new RegExp(/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/g);

	$('#contactMessage').remove();
	if (!pattern.test(email)) {
		$('form#contactForm input#email').parent().addClass('has-error');
		$('form#contactForm input#email').focus();
		error('form#contactForm', 'Email không hợp lệ!');
		return;
	}

	var name = $('form#contactForm input#name').val();
	if (name.length < 1) {
		$('form#contactForm input#name').parent().addClass('has-error');
		$('form#contactForm input#name').focus();
		error('form#contactForm', 'Tên không hợp lệ!');
		return;
	}

	var subject = $('form#contactForm input#subject').val();
	if (subject.length < 1) {
		$('form#contactForm input#subject').parent().addClass('has-error');
		$('form#contactForm input#subject').focus();
		error('form#contactForm', 'Tiêu đề quá ngắn!');
		return;
	}

	var message = $('form#contactForm input#message').val();
	if (message.length < 1) {
		$('form#contactForm input#message').parent().addClass('has-error');
		$('form#contactForm input#message').focus();
		error('form#contactForm', 'Nội dung quá ngắn!');
		return;
	}

	var data = {'name': name, 'email': email, 'subject': subject, 'message': message};
	$('form#contactForm button').html("<i class='fa fa-spinner fa-spin'></i>");
	$.post('/app_dev.php/contact', data, function (response) {
		info('form#contactForm', 'Thông tin cập nhật thành công !');
		$('form#contactForm input[type=email]').val('');
		$('form#contactForm button').html("Gửi");
	}, 'json');
}

function error(anchor, message) {
	var html = '<div class="alert alert-danger alert-dismissable" id="contactMessage">' +
		'    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
		message +
		'</div>';
	$(anchor).before(html);
}

function info(anchor, message) {
	var html = '<div class="alert alert-success alert-dismissable" id="contactMessage">' +
		'    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
		message +
		'</div>';
	$(anchor).before(html);
}