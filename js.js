$(document).ready(function(){
    var button = $('#button');
    var text = $('#value');
    var container = $('#container');

    button.on('click', function (e) {
        if(text.val() == '') {
            alert('Please enter Something');
        } else {
            button.hide();
            text.hide();
            console.log(text.val());
            saveCSV(text.val());
        }
    });


    function saveCSV(text) {
		var ajaxurl = 'data.php',
		data =  {'action': text};
		$.post(ajaxurl, data, function (response) {
			console.log(response);
            container.append(response);
		});
	};

});