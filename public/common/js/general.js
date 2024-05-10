$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    keyboardNavigation : true ,
});

function loaddata2(data, formID){
 	$.each(data.data, function( key, val ) {
		var $el = $('form#'+formID+' [name="'+key+'"]'),
		type = $el.attr('type');

		switch(type){
			case 'checkbox':
				if(val == 1){
					$el.attr('checked', 'checked');
				}
				break;
			case 'radio':
				$el.filter('[value="'+val+'"]').attr('checked', 'checked');
				break;
			case 'select':
				$el.filter('[value="'+val+'"]').attr('selected', 'selected');
				break;
			default:
				$el.val(val);
		}
	});
}

function loaddata(data){
	$.each(data.data, function( key, val ) {
		var $el = $('form#form-edit-releaving [name="'+key+'"]'),
		type = $el.attr('type');

		console.log($el);

		switch(type){
			case 'checkbox':
				if(val == 1){
					$el.attr('checked', 'checked');
				}
				break;
			case 'radio':
				$el.filter('[value="'+val+'"]').attr('checked', 'checked');
				break;
			default:
				$el.val(val);
		}
	});
}

function preloader_init(){
    $('#overlay').fadeIn();
}
function preloader_off(){
    $('#overlay').fadeOut();
}

function sessionCheckingLogin(){
    var csrfToken = "{{ csrf_token() }}";
    axios.post(SITE_URL+'sessionCheckingLogin',{
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-Token': csrfToken}}
    ).then(function(response){
        if(response.data.data != "true"){   
            window.location.href = '/login';  
        }
    });
}

function setDefaultAdminNotification(){

	var sel_value = $("#notification_default_gobal").val();

	preloader_init();
	axios.get(SITE_URL+'setDefaultNotification?id='+sel_value
	).then(function (response) {

		preloader_off();
		Swal.fire('Great Job !','Notification user changed successfully!','success');
		setTimeout(location.reload.bind(location), 1500);
    })
    .catch(function (error) {

    	preloader_off();
    	setTimeout(location.reload.bind(location), 1500);
    }); 	
}
