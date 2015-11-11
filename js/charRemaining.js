function declOfNum(number, titles)
{
    cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}

$(function()
{
    $('textarea').keyup(function()
    {
	    var maxLength = $(this).attr('maxlength');
        var curLength = $(this).val().length;

        $(this).val($(this).val().substr(0, maxLength));
        var remaning = maxLength - curLength;
        if (remaning < 0) remaning = 0;
        try {
	        var textareaFeedback = $(this).closest("div").find($('.textareaFeedback'));

	        if(remaning == maxLength) {
		        textareaFeedback.html('');
	        } else {
		        textareaFeedback.html('Осталось ' + remaning + ' ' + declOfNum(remaning, ['символ', 'символа', 'символов']));
	        }
        }
        catch (e) {

        }

    })
})