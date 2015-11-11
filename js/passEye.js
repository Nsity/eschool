$(function() {
			//PassEye
			$(".passEye").append('<span class="eye" title="Показать/скрыть пароль"></span>');
			$(".passEye .eye").click(function() {
				$(this).toggleClass('openEye');
				var passVal = $(this).prev().attr('type');
				if (passVal === 'password') {
					$(this).prev().attr('type', 'text');
				} else {
					$(this).prev().attr('type', 'password');
				}
			});
		});
