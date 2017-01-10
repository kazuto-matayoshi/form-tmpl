(function($) {


	// text option
	var valCheckTarget = [
		'input[type="text"]',
		'input[type="email"]',
		'input[type="tel"]',
		'input[type="radio"]',
		'select',
		'textarea',
	];

	var checkTarget = valCheckTarget.join(',');

	$( checkTarget ).on('change', function(){
		if ( $(this).val() ) {
			if ( $(this).context.type == 'radio' || $(this).context.type == 'checkbox' ) {
				var type   = $(this).context.type;
				var name   = $(this).context.name;
				var target = $('input[type="'+type+'"][name="'+name+'"]');
				if ( target.is(':checked') ) {
					target.addClass('inText');
				} else {
					target.removeClass('inText');
				}
			} else {
				$(this).addClass('inText');
			}
		} else {
			$(this).removeClass('inText');
		};
	});

	// オプション等→http://js.studio-kingdom.com/jqueryui/widgets/datepicker
	$( '.datepicker' ).datepicker({
		// 日付の有効範囲
		minDate: '0',
	});

	// Validation
	// 参考はコチラ→http://studio-key.com/1139.html
	$(function(){
		$("form").validationEngine( 'attach', {
			autoPositionUpdate: true,
			promptPosition: "centerRight",
		});
	});

	// $('.main_sec10 a').on('click', function(){
	// 	var data = $(this).attr('data-val');
	// 	$('select.hope option').removeAttr('selected');
	// 	$('select.hope option[value="' + data + '"]').attr('selected', 'selected');
	// 	$('select.hope').addClass('inText');
	// 	return false;
	// });
})(jQuery);