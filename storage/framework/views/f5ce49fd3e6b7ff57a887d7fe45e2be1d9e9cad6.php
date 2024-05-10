<?php $__env->startSection('scripts'); ?>
	<script>
		$(document).ready(function() {

			//var $form = $(this);
            //if (!$form.valid) return false;

			var form = $("#subscriptionform");
	        form.children("div").steps({
	            headerTag: "h3",
	            bodyTag: "section",
	            transitionEffect: "slideLeft",
	            onStepChanging: function (event, currentIndex, newIndex){
	            	
	                console.log("Changed"+currentIndex+"--"+newIndex);
	                if (newIndex > currentIndex){
	                	var currentBlock = currentIndex+1;
	                	if (false === $('#subscriptionform').parsley().validate('block' + currentBlock)){
		                    return false;
		                }
		            }else{
		            	return true;
		            }

		            if (newIndex == 2) {
		            	console.log("Changed section"+newIndex);
		            	jointApplicant();
		            }

		            saveScubscriptionDraft();
		            return true;
	            },
	            onFinishing: function (event, currentIndex, newIndex){
	                
	                saveScubscription();
	                console.log("Submitted");
	            },
	            onFinished: function (event, currentIndex){
	                saveScubscription();
	                console.log("Submitted From");
	            }
	        });

			$('#country_id').change(function(){
	            $.ajax({
	                url: SITE_URL+'selectBoxStateList?country_id='+$(this).val(),
	                type:"GET",
	                success: function(data) {

	                    var state = data.data;
	                    $('#state_id').empty();
	                    for (var key in state) {
	                        if (state.hasOwnProperty(key)) {
	                            $('#state_id').append('<option value="'+key+'" >'+state[key]+'</option>');
	                        }
	                    }
	                }
	            });
	        });

	        var country_id = $('#country_id').val();
	        if(country_id){
	            $.ajax({
	                url: SITE_URL+'selectBoxStateList?country_id='+country_id,
	                type:"GET",
	                success: function(data) {
	                    var default_state = "<?php echo e(old('state') ? old('state') : $userData->state); ?>";

	                    var state = data.data;
	                    $('#state_id').empty();
	                    for (var key in state) {
	                        if (state.hasOwnProperty(key)) {
	                            $('#state_id').append('<option value="'+key+'" >'+state[key]+'</option>');
	                        }
	                    }

	                    $('#state_id').val(default_state);
	                }
	            });
	        }

			$('#ja_country_id').change(function(){
	            $.ajax({
	                url: SITE_URL+'selectBoxStateList?country_id='+$(this).val(),
	                type:"GET",
	                success: function(data) {
	                    var state = data.data;
	                    $('#ja_state_id').empty();
	                    for (var key in state) {
	                        if (state.hasOwnProperty(key)) {
	                            $('#ja_state_id').append('<option value="'+key+'" >'+state[key]+'</option>');
	                        }
	                    }
	                }
	            });
	        });

	        var ja_country_id = $('#ja_country_id').val();
	        if(ja_country_id){
	            $.ajax({
	                url: SITE_URL+'selectBoxStateList?country_id='+ja_country_id,
	                type:"GET",
	                success: function(data) {
	                    var default_state = "<?php echo e($edit ?  $subscription->ja_state : old('ja_state')); ?>";

	                    var state = data.data;
	                    $('#ja_state_id').empty();
	                    for (var key in state) {
	                        if (state.hasOwnProperty(key)) {
	                            $('#ja_state_id').append('<option value="'+key+'" >'+state[key]+'</option>');
	                        }
	                    }

	                    $('#ja_state_id').val(default_state);
	                }
	            });
	        }

	        if($("#is_joint_account").val() == "2"){
	        	jointApplicant();
	        }else{
	        	jointApplicant();
	        }
	        
	        
	        $('#os_country_id').change(function(){
	            $.ajax({
	                url: SITE_URL+'selectBoxStateList?country_id='+$(this).val(),
	                type:"GET",
	                success: function(data) {
	                    var state = data.data;
	                    $('#os_state_id').empty();
	                    for (var key in state) {
	                        if (state.hasOwnProperty(key)) {
	                            $('#os_state_id').append('<option value="'+key+'" >'+state[key]+'</option>');
	                        }
	                    }
	                }
	            });
	        });

	        var os_country_id = $('#os_country_id').val();
	        if(os_country_id){
	            $.ajax({
	                url: SITE_URL+'selectBoxStateList?country_id='+os_country_id,
	                type:"GET",
	                success: function(data) {
	                    var default_state = "<?php echo e($edit ?  $subscription->os_state : old('os_state')); ?>";

	                    var state = data.data;
	                    $('#os_state_id').empty();
	                    for (var key in state) {
	                        if (state.hasOwnProperty(key)) {
	                            $('#os_state_id').append('<option value="'+key+'" >'+state[key]+'</option>');
	                        }
	                    }
	                    $('#os_state_id').val(default_state);
	                }
	            });
	        }
	        
	        /////////////////////
	        if($("#legal_status").val() == "6"){
            	changeLegal_status();
            }else{
            	changeLegal_status();
            }
            
            /////////////////////
            var ownership_status_value = $('input:radio[name=ownership_status]').val();
    	    if (ownership_status_value == '1') { 
    			$("#ownership_status_details").hide();
    
    			$("#os_name").removeAttr("required");
                $("#os_address_line1").removeAttr("required");
                $("#os_city").removeAttr("required");
                $("#os_country_id").removeAttr("required");
                $("#os_post_code").removeAttr("required");
                $("#os_state_id").removeAttr("required");
            }
            if (ownership_status_value == '2') {
    			$("#ownership_status_details").show();
    
    			$("#os_name").attr("required", "required");
                $("#os_address_line1").attr("required", "required");
                $("#os_city").attr("required", "required");
                $("#os_country_id").attr("required", "required");
                $("#os_post_code").attr("required", "required");
                $("#os_state_id").attr("required", "required");
    
            }
    		if (ownership_status_value == '3') {
    			$("#ownership_status_details").show();
    
    			$("#os_name").attr("required", "required");
                $("#os_address_line1").attr("required", "required");
                $("#os_city").attr("required", "required");
                $("#os_country_id").attr("required", "required");
                $("#os_post_code").attr("required", "required");
                $("#os_state_id").attr("required", "required");
            }
            /////////////////////

            var subscriber_type = $('#subscriber_type').val();
	        if(subscriber_type == ''){
	        	changeSubscriberType();
	        } else {
	        	changeSubscriberType();
	        }
            
         	// var subscriber_type = $('#subscriber_type').val();
	        // if(subscriber_type){
	        // 	changeSubscriberType();
	        // }

			$('input:radio[name=ownership_status]').change(function() {
		        if (this.value == '1') { 
					$("#ownership_status_details").hide();

					$("#os_name").removeAttr("required");
	                $("#os_address_line1").removeAttr("required");
	                $("#os_city").removeAttr("required");
	                $("#os_country_id").removeAttr("required");
	                $("#os_post_code").removeAttr("required");
	                $("#os_state_id").removeAttr("required");
		        }
		        if (this.value == '2') {
					$("#ownership_status_details").show();

					$("#os_name").attr("required", "required");
	                $("#os_address_line1").attr("required", "required");
	                $("#os_city").attr("required", "required");
	                $("#os_country_id").attr("required", "required");
	                $("#os_post_code").attr("required", "required");
	                $("#os_state_id").attr("required", "required");

		        }
				if (this.value == '3') {
					$("#ownership_status_details").show();

					$("#os_name").attr("required", "required");
	                $("#os_address_line1").attr("required", "required");
	                $("#os_city").attr("required", "required");
	                $("#os_country_id").attr("required", "required");
	                $("#os_post_code").attr("required", "required");
	                $("#os_state_id").attr("required", "required");
		        }
		    });
            /////////////////////


            ///////////////////// Single Account ////////////////

            var peb_declaration_status_value = $('input[name=peb_declaration_status]:checked', '#subscriptionform').val();
    	    if (peb_declaration_status_value == '0') { 
    			$("#peb_declaration_other_status").hide();
	    		$("#origin_fund_wealth").removeAttr("required");
            } else {
            	$("#peb_declaration_other_status").hide();
	    		$("#origin_fund_wealth").removeAttr("required");
            }

            if (peb_declaration_status_value == '1') { 
    			$("#peb_declaration_other_status").hide();
	    		$("#origin_fund_wealth").removeAttr("required");
            }

            if (peb_declaration_status_value == '2') { 
    			$("#peb_declaration_other_status").show();
	    		$("#origin_fund_wealth").attr("required", "required");
            }

            ///////////////////////

            $('input:radio[name=peb_declaration_status]').change(function() {

		        if (this.value == '0') { 
	    			$("#peb_declaration_other_status").hide();
	    			$("#origin_fund_wealth").removeAttr("required");
	            }

	    	    if (this.value == '1') { 
	    			$("#peb_declaration_other_status").hide();
	    			$("#origin_fund_wealth").removeAttr("required");
	            }

	            if (this.value == '2') {
	    			$("#peb_declaration_other_status").show();
	    			$("#origin_fund_wealth").attr("required", "required");
	            }
		    });

            /////////////////////

            ///////////////////////

            var principalOrginFundValue = null; 
			var inputElements = document.getElementsByClassName('origin_fund_wealth');
			for(var i=0; inputElements[i]; ++i){

				console.log('pricipal origin_fund called');

			    if(inputElements[i].checked){
			        principalOrginFundValue = inputElements[i].value;
			        
	                if(principalOrginFundValue == "Other"){
	                    $('#origin_wealth_other').show();
	                    $("#origin_fund_wealth_other").attr("required", "required");
	                }else{
	                    $('#origin_wealth_other').hide();
	                    $("#origin_fund_wealth_other").removeAttr("required"); 
	                }
			    } else {
			    	$('#origin_wealth_other').hide();
	                $("#origin_fund_wealth_other").removeAttr("required"); 
			    }
			}


            $(".origin_fund_wealth").click(function(){
	            $("#origin_fund_wealth:checked").each(function(){
	                var radioValue =$(this).val();
	                if(radioValue == "Other"){
	                    $('#origin_wealth_other').show();
	                    $("#origin_fund_wealth_other").attr("required", "required");
	                }else{
	                    $('#origin_wealth_other').hide();
	                    $("#origin_fund_wealth_other").removeAttr("required"); 
	                }
	            });
	        });


            var principalSourceOfWealthValue = null; 
			var inputElements = document.getElementsByClassName('source_of_wealth');
			for(var i=0; inputElements[i]; ++i){

				console.log('pricipal source_of_wealth called');

			    if(inputElements[i].checked){
			        principalSourceOfWealthValue = inputElements[i].value;
			        
	                if(principalSourceOfWealthValue == "Other"){
	                    $('#individual_source_of_wealth_other').show();
                    	$("#source_of_wealth_other").attr("required", "required");
	                }else{
	                    $('#individual_source_of_wealth_other').hide();
                    	$("#source_of_wealth_other").removeAttr("required"); 
	                }
			    } else {
			    	$('#individual_source_of_wealth_other').hide();
                    $("#source_of_wealth_other").removeAttr("required"); 
			    }
			}


            $(".source_of_wealth").click(function(){
	            $("#source_of_wealth:checked").each(function(){
	                var radioValue =$(this).val();
	                if(radioValue == "Other"){
	                    $('#individual_source_of_wealth_other').show();
	                    $("#source_of_wealth_other").attr("required", "required");
	                }else{
	                    $('#individual_source_of_wealth_other').hide();
	                    $("#source_of_wealth_other").removeAttr("required"); 
	                }
	            });
	        });


	        var principalSourceOfWealthFundComesValue = null; 
			var inputElements = document.getElementsByClassName('source_of_wealth_funds_comes');
			for(var i=0; inputElements[i]; ++i){

				console.log('pricipal source_of_wealth_funds_comes called');

			    if(inputElements[i].checked){
			        principalSourceOfWealthFundComesValue = inputElements[i].value;
			        
	                if(principalSourceOfWealthFundComesValue == "Other"){
	                    $('#individual_source_of_wealth_other_comes_other').show();
                    	$("#source_of_wealth_funds_comes_other").attr("required", "required");
	                }else{
	                    $('#individual_source_of_wealth_other_comes_other').hide();
                    	$("#source_of_wealth_funds_comes_other").removeAttr("required"); 
	                }
			    } else {
			    	$('#individual_source_of_wealth_other_comes_other').hide();
                    $("#source_of_wealth_funds_comes_other").removeAttr("required"); 
			    }
			}


            $(".source_of_wealth_funds_comes").click(function(){
	            $("#source_of_wealth_funds_comes:checked").each(function(){
	                var radioValue =$(this).val();
	                if(radioValue == "Other"){
	                    $('#individual_source_of_wealth_other_comes_other').show();
	                    $("#source_of_wealth_funds_comes_other").attr("required", "required");
	                }else{
	                    $('#individual_source_of_wealth_other_comes_other').hide();
	                    $("#source_of_wealth_funds_comes_other").removeAttr("required"); 
	                }
	            });
	        });

            ///////////////////// Joint Account holder //////////

            var ja_peb_declaration_status_value = $('input[name=ja_peb_declaration_status]:checked', '#subscriptionform').val();
    	    if (ja_peb_declaration_status_value == '0') { 
    			$(".ja_peb_declaration_other_status").hide();
	    		$("#ja_origin_fund_wealth").removeAttr("required");
            }else {
            	$(".ja_peb_declaration_other_status").hide();
	    		$("#ja_origin_fund_wealth").removeAttr("required");
            }

            if (ja_peb_declaration_status_value == '1') { 
    			$(".ja_peb_declaration_other_status").hide();
	    		$("#ja_origin_fund_wealth").removeAttr("required");
            }

            if (ja_peb_declaration_status_value == '2') { 
    			$(".ja_peb_declaration_other_status").show();
	    		$("#ja_origin_fund_wealth").attr("required", "required");
            }

            ///////////////////////
            
            $('input:radio[name=ja_peb_declaration_status]').change(function() {
		        if (this.value == '0') { 
	    			$(".ja_peb_declaration_other_status").hide();
	    			$("#ja_origin_fund_wealth").removeAttr("required");
	            }

	    	    if (this.value == '1') { 
	    			$(".ja_peb_declaration_other_status").hide();
	    			$("#ja_origin_fund_wealth").removeAttr("required");
	            }

	            if (this.value == '2') {
	    			$(".ja_peb_declaration_other_status").show();
	    			$("#ja_origin_fund_wealth").attr("required", "required");
	            }
		    });

            /////////////////////

            ///////////////////////

            var jointOrginFundValue = null; 
			var inputElements = document.getElementsByClassName('ja_origin_fund_wealth');
			for(var i=0; inputElements[i]; ++i){

				console.log('joint origin_fund called')

			    if(inputElements[i].checked){
			        jointOrginFundValue = inputElements[i].value;
			        
	                if(jointOrginFundValue == "Other"){
	                    $('#ja_origin_wealth_other').show();
                    	$("#ja_origin_fund_wealth_other").attr("required", "required");
	                }else{
	                    $('#ja_origin_wealth_other').hide();
                    	$("#ja_origin_fund_wealth_other").removeAttr("required");
	                }
			    } else {
			    	$('#ja_origin_wealth_other').hide();
                    $("#ja_origin_fund_wealth_other").removeAttr("required");
			    }
			}


            $(".ja_origin_fund_wealth").click(function(){
	            $("#ja_origin_fund_wealth:checked").each(function(){
	                var radioValue =$(this).val();
	                if(radioValue == "Other"){
	                    $('#ja_origin_wealth_other').show();
	                    $("#ja_origin_fund_wealth_other").attr("required", "required");
	                }else{
	                    $('#ja_origin_wealth_other').hide();
	                    $("#ja_origin_fund_wealth_other").removeAttr("required"); 
	                }
	            });
	        });


	        var jointSourceOfWealthValue = null; 
			var inputElements = document.getElementsByClassName('ja_source_of_wealth');
			for(var i=0; inputElements[i]; ++i){

				console.log('joint jsource_of_wealth called');

			    if(inputElements[i].checked){
			        jointSourceOfWealthValue = inputElements[i].value;
			        
	                if(jointSourceOfWealthValue == "Other"){
	                    $('#joint_source_of_wealth_other').show();
                    	$("#ja_source_of_wealth_other").attr("required", "required");
	                }else{
	                    $('#joint_source_of_wealth_other').hide();
                    	$("#ja_source_of_wealth_other").removeAttr("required"); 
	                }
			    } else {
			    	$('#joint_source_of_wealth_other').hide();
                    $("#ja_source_of_wealth_other").removeAttr("required");
			    }
			}


            $(".ja_source_of_wealth").click(function(){
	            $("#ja_source_of_wealth:checked").each(function(){
	                var radioValue =$(this).val();
	                if(radioValue == "Other"){
	                    $('#joint_source_of_wealth_other').show();
	                    $("#ja_source_of_wealth_other").attr("required", "required");
	                }else{
	                    $('#joint_source_of_wealth_other').hide();
	                    $("#ja_source_of_wealth_other").removeAttr("required"); 
	                }
	            });
	        });


            var jointSourceOfWealthFundComesValue = null; 
			var inputElements = document.getElementsByClassName('ja_source_of_wealth_funds_comes');
			for(var i=0; inputElements[i]; ++i){

				console.log('joint ja_source_of_wealth_funds_comes called');

			    if(inputElements[i].checked){
			        jointSourceOfWealthFundComesValue = inputElements[i].value;
			        
	                if(jointSourceOfWealthFundComesValue == "Other"){
	                    $('#joint_source_of_wealth_other_comes_other').show();
                    	$("#ja_source_of_wealth_funds_comes_other").attr("required", "required");
	                }else{
	                    $('#joint_source_of_wealth_other_comes_other').hide();
                    	$("#ja_source_of_wealth_funds_comes_other").removeAttr("required"); 
	                }
			    } else {
			    	$('#joint_source_of_wealth_other_comes_other').hide();
                    $("#ja_source_of_wealth_funds_comes_other").removeAttr("required");
			    }
			}


            $(".ja_source_of_wealth_funds_comes").click(function(){
	            $("#ja_source_of_wealth_funds_comes:checked").each(function(){
	                var radioValue =$(this).val();
	                if(radioValue == "Other"){
	                    $('#joint_source_of_wealth_other_comes_other').show();
	                    $("#ja_source_of_wealth_funds_comes_other").attr("required", "required");
	                }else{
	                    $('#joint_source_of_wealth_other_comes_other').hide();
	                    $("#ja_source_of_wealth_funds_comes_other").removeAttr("required"); 
	                }
	            });
	        });

            /////////////////////

            
            var drEvent = $('.dropify').dropify();

            drEvent.on('dropify.beforeClear', function(event, element){
            	console.log(element);
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function(event, element){
                var main_type = $("#subscriber_type").val();
                var sub_type = $(this).attr('attr-sub-type')
                
                var csrfToken = "<?php echo e(csrf_token()); ?>";
				var fd = new FormData();
				var file = $(this)[0].files[0];
				fd.append('main_type', main_type);
				fd.append('sub_type', sub_type);  

				axios.post(SITE_URL+'ssdocumentRemove',fd,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-Token': csrfToken}}
	            ).then(function(response){
	                alert('File deleted');	               
	            })
	            .catch(function(){
	                alert('Faild File deleted');
	            });
            });


            /////////////////////
		    $('.dropify').change(function() {
                
                if ($(this).get(0).files.length) {

                	preloader_init();
                	var csrfToken = "<?php echo e(csrf_token()); ?>";
    				var fd = new FormData();
    				var file = $(this)[0].files[0];
    				fd.append('file', file);
    				fd.append('sub_type', $(this).attr('attr-sub-type'));
    				fd.append('main_type', $("#subscriber_type").val());
    				fd.append('remarks', $(this).attr('attr-remarks'));  
    
    				axios.post(SITE_URL+'ssdocumentUpload',fd,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
    	            ).then(function(response){

    	            	preloader_off();
    	                //Swal.fire('Great Job !','Contract Information create successfully!','success');	               
    	            })
    	            .catch(function(){

    	            	preloader_off();
    	                //Swal.fire('Sorry !','Contract Information edit faild!','error');
    	            });
                }else{
                    $(this).attr("required", "required");
                }
            });

            //////////////////////
            
            $(document).on('change', '.sw-supporting-docs', function(e) {
                e.preventDefault();

                if ($(this).get(0).files.length) {

                	preloader_init();

                	var subscriptionId = $("#subscriptionId").val();

                	var csrfToken = "<?php echo e(csrf_token()); ?>";
    				var fd = new FormData();
    				var file = $(this)[0].files[0];

    				for (var index = 0; index < $(this).get(0).files.length; index++) {
			            fd.append('file[]', $(this)[0].files[index]);
			        }
    				
    				fd.append('sub_type', $(this).attr('attr-sub-type'));
    				// fd.append('subscription_id', subscriptionId);

    				axios.post(SITE_URL+'sSupportDocumentUpload',fd,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
    	            ).then(function(response){

    	            	var item = response.data;
    	            	console.log(item.data)
    	            	if (item.data == 'success') {

    	            		Swal.fire('Great Job !','Supporting documents successfully uploaded!','success');	
    	            	} else if(item.data == 'error') {
    	            		Swal.fire('Sorry !', item.message ,'error');
    	            	}	

    	            	preloader_off();
    	                               
    	            })
    	            .catch(function(){

    	            	preloader_off();
    	                Swal.fire('Sorry !','Uploading faild!','error');
    	            });

                }else{
                    $(this).attr("required", "required");
                }
            });

            
		});
        
        

            <?php
            	if($edit):
            		if(!empty($subscription['SsDocumentAs'])):
                       	$documents = getDocument($subscription['SsDocumentAs']);
                       	foreach ($documents as $document):
                       		$subtype = $document['sub_type'];
        		?>
        				var subtype = "<?php echo e($subtype); ?>";
        				var imagenUrl = "<?php echo e(asset('storage/'.$document['file'])); ?>";
    		            $("#subtype"+subtype).attr("data-default-file", imagenUrl);
    		            $("#subtype"+subtype).removeAttr("required");
    		            $("#subtype"+subtype).attr("data-remove-required", 1);
    
            <?php 
                		endforeach;
            		endif; 
        		endif; 
        	?>

        var csrfToken = "<?php echo e(csrf_token()); ?>";
        
		function jointApplicant() {

			getSupportedDocuments();

		  	var x = document.getElementById("is_joint_account").value;
			if(x == 2){
				$(".joint-applicant-blocks").show();
				$(".joint-account-holder").show();

				$("#joint_account_holder_docs_upload").show();

				//$(".status-sign").show();	

				$("#ja_name").attr("required", "required");
                $("#ja_address_line1").attr("required", "required");

                // $("#ja_address_line2").attr("required", "required");
                
                $("#ja_city").attr("required", "required");
                $("#ja_country_id").attr("required", "required");
                $("#ja_post_code").attr("required", "required");
                $("#ja_state_id").attr("required", "required");


               	$("#peb_declaration_status").attr("required", "required");

                // $("#origin_fund_wealth").attr("required", "required");

                $("#source_of_wealth").attr("required", "required");
                $("#source_of_wealth_funds_comes").attr("required", "required");
                $("#ja_peb_declaration_status").attr("required", "required");
                $("#ja_source_of_wealth").attr("required", "required");
                $("#ja_source_of_wealth_funds_comes").attr("required", "required");

                // $("#ja_origin_fund_wealth").attr("required", "required");

                $(".manual_signed_joint_pep_docs").attr("required", "required");
                $(".manual_signed_joint_fund_docs").attr("required", "required");

			}else if(x == 1){
				$(".joint-applicant-blocks").hide();
				$(".joint-account-holder").hide();	

				$("#joint_account_holder_docs_upload").hide();

				//$(".status-sign").hide();

				$("#ja_name").removeAttr("required");
                $("#ja_address_line1").removeAttr("required");
                $("#ja_address_line2").removeAttr("required");
                $("#ja_city").removeAttr("required");
                $("#ja_country_id").removeAttr("required");
                $("#ja_post_code").removeAttr("required");
                $("#ja_state_id").removeAttr("required");


                $("#peb_declaration_status").attr("required", "required");

                // $("#origin_fund_wealth").attr("required", "required");

                $("#source_of_wealth").attr("required", "required");
                $("#source_of_wealth_funds_comes").attr("required", "required");
                $("#ja_peb_declaration_status").removeAttr("required");
                $("#ja_source_of_wealth").removeAttr("required");
                $("#ja_source_of_wealth_funds_comes").removeAttr("required");

                // $("#ja_origin_fund_wealth").removeAttr("required");

                $(".manual_signed_joint_pep_docs").removeAttr("required");
                $(".manual_signed_joint_fund_docs").removeAttr("required");
				
			}
		}
		
		function getSupportedDocuments() {

			console.log('supporting documents function called');

		  	$(".Principal-Source-Wealth-Docs-List").html("");
			$(".Principal-Group-Source-Wealth-Docs-List").html("");
			$(".Joint-Group-Source-Wealth-Docs-List").html("");

		  	var subscriptionId = $("#subscriptionId").val();

            axios.get(SITE_URL+'user/subscription?subscription_id='+subscriptionId).then(function (response) {

                var principleWealthDocs = "";
                var principleGroupWealthDocs = "";
                var jointGroupWealthDocs = "";

                var is_joint_ac = response.data.is_joint;
                var principleWealthDocuments =response.data.principleWealthDocuments;
                var jointWealthDocuments =response.data.jointWealthDocuments;

                console.log(principleWealthDocuments)

                if (is_joint_ac == false) {

                	///////// principle user ///////////

                	Object.keys(principleWealthDocuments).forEach(function (key) {

	                	Object.keys(principleWealthDocuments[key]['user_source_wealth_documents']).forEach(function (key2) {

		                	// var sourceWealthName = principleWealthDocuments[key]['name'];
		                    var documentName = principleWealthDocuments[key].user_source_wealth_documents[key2]['document_name'];
		                    var documentDescription = principleWealthDocuments[key].user_source_wealth_documents[key2]['description'];
		                    var attrSubType = principleWealthDocuments[key].user_source_wealth_documents[key2]['attr_sub_type'];

		                    principleWealthDocs += '<span class="ml-0">* '+ documentDescription +'</span><br>';

	                    });
	                });

                } else {

                	///////// principle user ///////////

                	Object.keys(principleWealthDocuments).forEach(function (key) {

	                	Object.keys(principleWealthDocuments[key]['user_source_wealth_documents']).forEach(function (key2) {

		                	// var sourceWealthName = principleWealthDocuments[key]['name'];
		                    var documentName = principleWealthDocuments[key].user_source_wealth_documents[key2]['document_name'];
		                    var documentDescription = principleWealthDocuments[key].user_source_wealth_documents[key2]['description'];
		                    var attrSubType = principleWealthDocuments[key].user_source_wealth_documents[key2]['attr_sub_type'];

		                    principleGroupWealthDocs += '<span class="ml-0">* '+ documentDescription +'</span><br>';

	                    });

	                });

	                ///////// joint user ///////////
	                Object.keys(jointWealthDocuments).forEach(function (key) {

	                	Object.keys(jointWealthDocuments[key]['user_source_wealth_documents']).forEach(function (key2) {

		                    var documentName = jointWealthDocuments[key].user_source_wealth_documents[key2]['document_name'];
		                    var documentDescription = jointWealthDocuments[key].user_source_wealth_documents[key2]['description'];
		                    var attrSubType = jointWealthDocuments[key].user_source_wealth_documents[key2]['attr_sub_type'];

		                    jointGroupWealthDocs += '<span class="ml-0">* '+ documentDescription +'</span><br>';

	                    });
	                });
                }

                $(".Principal-Source-Wealth-Docs-List").html("");
                $(".Principal-Source-Wealth-Docs-List").html(principleWealthDocs);

                $(".Principal-Group-Source-Wealth-Docs-List").html("");
                $(".Principal-Group-Source-Wealth-Docs-List").html(principleGroupWealthDocs);

                $(".Joint-Group-Source-Wealth-Docs-List").html("");
                $(".Joint-Group-Source-Wealth-Docs-List").html(jointGroupWealthDocs);
            })
            .catch(function (error) {
                console.log('additional supporting documents list data retrieve problem');
            });
		}

		
		$(".PrincipalDocsListDiv").hide();
		$(".PrincipalJointDocsListDiv").hide();	

		$(".PricipalJointSourceWealthGroupDropifyDiv").hide();	
		$(".PrincipalSourceWealthDropifyDiv").hide();
		
		
		function classType(e)
		{
		   	if(e.checked) {
		   		// console.log('value of checkbox : ', e.value);
		   		var class_value = $('#class_type_id_'+e.value).attr('class_attr_val');
		   		if(e.value == 2){
		   			$(".additional_subscription_amount_div").show();
		   			$(".class_b_signedPdfDownload_div").show();
		   			$(".manual_signed_doc_b").show();
		   			
		  			$("#additional_amount").attr("required", "required");
		  			$("#file_b").attr("required", "required");

		   		} else {
			  		$(".additional_subscription_amount_div").hide();
			  		$(".class_b_signedPdfDownload_div").hide();
			  		$(".manual_signed_doc_b").hide();
			  		$("#additional_amount").removeAttr("required");
			  		$("#file_b").removeAttr("required");
			  	}
		   	} else {
		   		$(".additional_subscription_amount_div").hide();
		   		$(".class_b_signedPdfDownload_div").hide();
		   		$(".manual_signed_doc_b").hide();
		   		$("#additional_amount").removeAttr("required");
		   		$("#file_b").removeAttr("required");
		   	}
		}

		function changeLegal_status() {
		  	var x = document.getElementById("legal_status").value;
		  	if(x == 6){
		  		$(".legal_status_other_div").show();
		  		$("#legal_status_other").attr("required", "required");
		  	    
		  	}else{
		  		$(".legal_status_other_div").hide();
		  		$("#legal_status_other").removeAttr("required");
		  	}
		}

		function changeSubscriberType() {

			getSupportedDocuments();

		  	var x = document.getElementById("subscriber_type").value;
		  
		  	if(x == 1){
		  		$(".status-individual").show();
		  		$(".status-private").hide();
		  		$(".status-trust").hide();
		  		$(".status-fund").hide();
		  		$(".status-regular").hide();
		  		$(".status-investment").hide();
		  		
				var remove_required11 = $("#subtype11").attr("data-remove-required");
				var remove_required12 = $("#subtype12").attr("data-remove-required");
				var remove_required13 = $("#subtype13").attr("data-remove-required");
				var remove_required14 = $("#subtype14").attr("data-remove-required");
				var remove_required15 = $("#subtype15").attr("data-remove-required");
				
				if(remove_required11 == 1){
				    $("#subtype11").removeAttr("required");
				}else{
				    $("#subtype11").attr("required", "required");
				}
				
				if(remove_required12 == 1){
				    $("#subtype12").removeAttr("required");
				}else{
				    $("#subtype12").attr("required", "required");
				}
				
				if(remove_required13 == 1){
				    $("#subtype13").removeAttr("required");
				}else{
				    $("#subtype13").attr("required", "required");
				}
				
				if(remove_required14 == 1){
				    $("#subtype14").removeAttr("required");
				}else{
				    $("#subtype14").attr("required", "required");
				}
				
				if(remove_required15 == 1){
				    $("#subtype15").removeAttr("required");
				}else{
				    $("#subtype15").attr("required", "required");
				}
				
				$("#subtype21").removeAttr("required");
				$("#subtype22").removeAttr("required");
				$("#subtype23").removeAttr("required");
				$("#subtype24").removeAttr("required");
				$("#subtype25").removeAttr("required");
				$("#subtype26").removeAttr("required");
				
				$("#subtype31").removeAttr("required");
				$("#subtype32").removeAttr("required");
				$("#subtype33").removeAttr("required");
				$("#subtype34").removeAttr("required");
				$("#subtype35").removeAttr("required");
				
				$("#subtype41").removeAttr("required");
				$("#subtype42").removeAttr("required");
				$("#subtype43").removeAttr("required");
				$("#subtype44").removeAttr("required");
				$("#subtype45").removeAttr("required");
				
				$("#subtype51").removeAttr("required");
				$("#subtype52").removeAttr("required");
				$("#subtype53").removeAttr("required");
				$("#subtype54").removeAttr("required");
				$("#subtype55").removeAttr("required");
				
				$("#subtype61").removeAttr("required");
			    $("#subtype62").removeAttr("required");
				$("#subtype63").removeAttr("required");

				var jaVal = document.getElementById("is_joint_account").value;
	            if(jaVal == 2){
	                $(".PrincipalDocsListDiv").hide();
	                $(".PrincipalJointDocsListDiv").show(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").show();  
	                $(".PrincipalSourceWealthDropifyDiv").hide();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").show();

	                $("#subtype16").attr("required", "required");

	                // $("#joint_account_holder_docs_upload").show();
	                

	            }else if(jaVal == 1){
	                $(".PrincipalDocsListDiv").show();
	                $(".PrincipalJointDocsListDiv").hide(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").hide();  
	                $(".PrincipalSourceWealthDropifyDiv").show();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").hide();

	                $("#subtype16").removeAttr("required");

	                // $("#joint_account_holder_docs_upload").hide();
	            }
				
		  	}else if(x == 2){
		  		$(".status-private").show();
		  		$(".status-individual").hide();	
		  		$(".status-trust").hide();
		  		$(".status-fund").hide();
		  		$(".status-regular").hide();
		  		$(".status-investment").hide();
		  		
		  		var remove_required21 = $("#subtype21").attr("data-remove-required");
				var remove_required22 = $("#subtype22").attr("data-remove-required");
				var remove_required23 = $("#subtype23").attr("data-remove-required");
				var remove_required24 = $("#subtype24").attr("data-remove-required");
				var remove_required25 = $("#subtype25").attr("data-remove-required");
				var remove_required26 = $("#subtype26").attr("data-remove-required");
				
				if(remove_required21 == 1){
				    $("#subtype21").removeAttr("required");
				}else{
				    $("#subtype21").attr("required", "required");
				}
				
				if(remove_required22 == 1){
				    $("#subtype22").removeAttr("required");
				}else{
				    $("#subtype22").attr("required", "required");
				}
				
				if(remove_required23 == 1){
				    $("#subtype23").removeAttr("required");
				}else{
				    $("#subtype23").attr("required", "required");
				}
				
				if(remove_required24 == 1){
				    $("#subtype24").removeAttr("required");
				}else{
				    $("#subtype24").attr("required", "required");
				}
				
				if(remove_required25 == 1){
				    $("#subtype25").removeAttr("required");
				}else{
				    $("#subtype25").attr("required", "required");
				}
				
				if(remove_required26 == 1){
				    $("#subtype26").removeAttr("required");
				}else{
				    $("#subtype26").attr("required", "required");
				}
				
				$("#subtype11").removeAttr("required");
				$("#subtype12").removeAttr("required");
				$("#subtype13").removeAttr("required");
				$("#subtype14").removeAttr("required");
				$("#subtype15").removeAttr("required");

				$("#subtype31").removeAttr("required");
				$("#subtype32").removeAttr("required");
				$("#subtype33").removeAttr("required");
				$("#subtype34").removeAttr("required");
				$("#subtype35").removeAttr("required");
				
				$("#subtype41").removeAttr("required");
				$("#subtype42").removeAttr("required");
				$("#subtype43").removeAttr("required");
				$("#subtype44").removeAttr("required");
				$("#subtype45").removeAttr("required");
				
				$("#subtype51").removeAttr("required");
				$("#subtype52").removeAttr("required");
				$("#subtype53").removeAttr("required");
				$("#subtype54").removeAttr("required");
				$("#subtype55").removeAttr("required");
				
				$("#subtype61").removeAttr("required");
			    $("#subtype62").removeAttr("required");
				$("#subtype63").removeAttr("required");

				var jaVal = document.getElementById("is_joint_account").value;
	            if(jaVal == 2){
	                $(".PrincipalDocsListDiv").hide();
	                $(".PrincipalJointDocsListDiv").show(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").show();  
	                $(".PrincipalSourceWealthDropifyDiv").hide();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").show();

	                $("#subtype16").attr("required", "required");

	                // $("#joint_account_holder_docs_upload").show();
	                

	            }else if(jaVal == 1){
	                $(".PrincipalDocsListDiv").show();
	                $(".PrincipalJointDocsListDiv").hide(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").hide();  
	                $(".PrincipalSourceWealthDropifyDiv").show();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").hide();

	                $("#subtype16").removeAttr("required");

	                // $("#joint_account_holder_docs_upload").hide();
	            }
				
		  	}else if(x == 3){
		  		$(".status-trust").show();
		  		$(".status-individual").hide();
		  		$(".status-private").hide();
		  		$(".status-fund").hide();
		  		$(".status-regular").hide();
		  		$(".status-investment").hide();	
		  		
		  		var remove_required31 = $("#subtype31").attr("data-remove-required");
				var remove_required32 = $("#subtype32").attr("data-remove-required");
				var remove_required33 = $("#subtype33").attr("data-remove-required");
				var remove_required34 = $("#subtype34").attr("data-remove-required");
				var remove_required35 = $("#subtype35").attr("data-remove-required");

				if(remove_required31 == 1){
				    $("#subtype31").removeAttr("required");
				}else{
				    $("#subtype31").attr("required", "required");
				}
				
				if(remove_required32 == 1){
				    $("#subtype32").removeAttr("required");
				}else{
				    $("#subtype32").attr("required", "required");
				}
				
				if(remove_required33 == 1){
				    $("#subtype33").removeAttr("required");
				}else{
				    $("#subtype33").attr("required", "required");
				}
				
				if(remove_required34 == 1){
				    $("#subtype34").removeAttr("required");
				}else{
				    $("#subtype34").attr("required", "required");
				}
				
				if(remove_required35 == 1){
				    $("#subtype35").removeAttr("required");
				}else{
				    $("#subtype35").attr("required", "required");
				}
				
				$("#subtype11").removeAttr("required");
				$("#subtype12").removeAttr("required");
				$("#subtype13").removeAttr("required");
				$("#subtype14").removeAttr("required");
				$("#subtype15").removeAttr("required");
				
				$("#subtype21").removeAttr("required");
				$("#subtype22").removeAttr("required");
				$("#subtype23").removeAttr("required");
				$("#subtype24").removeAttr("required");
				$("#subtype25").removeAttr("required");
				$("#subtype26").removeAttr("required");
				
				$("#subtype41").removeAttr("required");
				$("#subtype42").removeAttr("required");
				$("#subtype43").removeAttr("required");
				$("#subtype44").removeAttr("required");
				$("#subtype45").removeAttr("required");
				
				$("#subtype51").removeAttr("required");
				$("#subtype52").removeAttr("required");
				$("#subtype53").removeAttr("required");
				$("#subtype54").removeAttr("required");
				$("#subtype55").removeAttr("required");
				
				$("#subtype61").removeAttr("required");
			    $("#subtype62").removeAttr("required");
				$("#subtype63").removeAttr("required");

				var jaVal = document.getElementById("is_joint_account").value;
	            if(jaVal == 2){
	                $(".PrincipalDocsListDiv").hide();
	                $(".PrincipalJointDocsListDiv").show(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").show();  
	                $(".PrincipalSourceWealthDropifyDiv").hide();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").show();

	                $("#subtype16").attr("required", "required");

	                // $("#joint_account_holder_docs_upload").show();
	                

	            }else if(jaVal == 1){
	                $(".PrincipalDocsListDiv").show();
	                $(".PrincipalJointDocsListDiv").hide(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").hide();  
	                $(".PrincipalSourceWealthDropifyDiv").show();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").hide();

	                $("#subtype16").removeAttr("required");

	                // $("#joint_account_holder_docs_upload").hide();
	            }
				
		  	}else if(x == 4){
		  		$(".status-fund").show();
		  		$(".status-individual").hide();
		  		$(".status-private").hide();
		  		$(".status-trust").hide();
		  		$(".status-regular").hide();
		  		$(".status-investment").hide();	
		  		
		  		var remove_required41 = $("#subtype41").attr("data-remove-required");
				var remove_required42 = $("#subtype42").attr("data-remove-required");
				var remove_required43 = $("#subtype43").attr("data-remove-required");
				var remove_required44 = $("#subtype44").attr("data-remove-required");
				var remove_required45 = $("#subtype45").attr("data-remove-required");

				if(remove_required41 == 1){
				    $("#subtype41").removeAttr("required");
				}else{
				    $("#subtype41").attr("required", "required");
				}
				
				if(remove_required42 == 1){
				    $("#subtype42").removeAttr("required");
				}else{
				    $("#subtype42").attr("required", "required");
				}
				
				if(remove_required43 == 1){
				    $("#subtype43").removeAttr("required");
				}else{
				    $("#subtype43").attr("required", "required");
				}
				
				if(remove_required44 == 1){
				    $("#subtype44").removeAttr("required");
				}else{
				    $("#subtype44").attr("required", "required");
				}
				
				if(remove_required45 == 1){
				    $("#subtype45").removeAttr("required");
				}else{
				    $("#subtype45").attr("required", "required");
				}
				
				$("#subtype11").removeAttr("required");
				$("#subtype12").removeAttr("required");
				$("#subtype13").removeAttr("required");
				$("#subtype14").removeAttr("required");
				$("#subtype15").removeAttr("required");
				
				$("#subtype21").removeAttr("required");
				$("#subtype22").removeAttr("required");
				$("#subtype23").removeAttr("required");
				$("#subtype24").removeAttr("required");
				$("#subtype25").removeAttr("required");
				$("#subtype26").removeAttr("required");
				
				$("#subtype31").removeAttr("required");
				$("#subtype32").removeAttr("required");
				$("#subtype33").removeAttr("required");
				$("#subtype34").removeAttr("required");
				$("#subtype35").removeAttr("required");
				
				$("#subtype51").removeAttr("required");
				$("#subtype52").removeAttr("required");
				$("#subtype53").removeAttr("required");
				$("#subtype54").removeAttr("required");
				$("#subtype55").removeAttr("required");
				
				$("#subtype61").removeAttr("required");
			    $("#subtype62").removeAttr("required");
				$("#subtype63").removeAttr("required");

				var jaVal = document.getElementById("is_joint_account").value;
	            if(jaVal == 2){
	                $(".PrincipalDocsListDiv").hide();
	                $(".PrincipalJointDocsListDiv").show(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").show();  
	                $(".PrincipalSourceWealthDropifyDiv").hide();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").show();

	                $("#subtype16").attr("required", "required");

	                // $("#joint_account_holder_docs_upload").show();
	                

	            }else if(jaVal == 1){
	                $(".PrincipalDocsListDiv").show();
	                $(".PrincipalJointDocsListDiv").hide(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").hide();  
	                $(".PrincipalSourceWealthDropifyDiv").show();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").hide();

	                $("#subtype16").removeAttr("required");

	                // $("#joint_account_holder_docs_upload").hide();
	            }
				
		  	}else if(x == 5){
		  		$(".status-regular").show();
		  		$(".status-individual").hide();
		  		$(".status-private").hide();
		  		$(".status-trust").hide();	
		  		$(".status-fund").hide();
		  		$(".status-investment").hide();
		  		
		  		var remove_required51 = $("#subtype51").attr("data-remove-required");
				var remove_required52 = $("#subtype52").attr("data-remove-required");
				var remove_required53 = $("#subtype53").attr("data-remove-required");
				var remove_required54 = $("#subtype54").attr("data-remove-required");
				var remove_required55 = $("#subtype55").attr("data-remove-required");

				if(remove_required51 == 1){
				    $("#subtype51").removeAttr("required");
				}else{
				    $("#subtype51").attr("required", "required");
				}
				
				if(remove_required52 == 1){
				    $("#subtype52").removeAttr("required");
				}else{
				    $("#subtype52").attr("required", "required");
				}
				
				if(remove_required53 == 1){
				    $("#subtype53").removeAttr("required");
				}else{
				    $("#subtype53").attr("required", "required");
				}
				
				if(remove_required54 == 1){
				    $("#subtype54").removeAttr("required");
				}else{
				    $("#subtype54").attr("required", "required");
				}
				
				if(remove_required55 == 1){
				    $("#subtype55").removeAttr("required");
				}else{
				    $("#subtype55").attr("required", "required");
				}
				
				$("#subtype11").removeAttr("required");
				$("#subtype12").removeAttr("required");
				$("#subtype13").removeAttr("required");
				$("#subtype14").removeAttr("required");
				$("#subtype15").removeAttr("required");
				
				$("#subtype21").removeAttr("required");
				$("#subtype22").removeAttr("required");
				$("#subtype23").removeAttr("required");
				$("#subtype24").removeAttr("required");
				$("#subtype25").removeAttr("required");
				$("#subtype26").removeAttr("required");
				
				$("#subtype31").removeAttr("required");
				$("#subtype32").removeAttr("required");
				$("#subtype33").removeAttr("required");
				$("#subtype34").removeAttr("required");
				$("#subtype35").removeAttr("required");
				
				$("#subtype41").removeAttr("required");
				$("#subtype42").removeAttr("required");
				$("#subtype43").removeAttr("required");
				$("#subtype44").removeAttr("required");
				$("#subtype45").removeAttr("required");
				
				$("#subtype61").removeAttr("required");
			    $("#subtype62").removeAttr("required");
				$("#subtype63").removeAttr("required");

				var jaVal = document.getElementById("is_joint_account").value;
	            if(jaVal == 2){
	                $(".PrincipalDocsListDiv").hide();
	                $(".PrincipalJointDocsListDiv").show(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").show();  
	                $(".PrincipalSourceWealthDropifyDiv").hide();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").show();

	                $("#subtype16").attr("required", "required");

	                // $("#joint_account_holder_docs_upload").show();
	                

	            }else if(jaVal == 1){
	                $(".PrincipalDocsListDiv").show();
	                $(".PrincipalJointDocsListDiv").hide(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").hide();  
	                $(".PrincipalSourceWealthDropifyDiv").show();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").hide();

	                $("#subtype16").removeAttr("required");

	                // $("#joint_account_holder_docs_upload").hide();
	            }
		  		
		  	}else if(x == 6){
		  		$(".status-investment").show();
		  		$(".status-individual").hide();
		  		$(".status-private").hide();
		  		$(".status-trust").hide();	
		  		$(".status-fund").hide();
		  		$(".status-regular").hide();
		  		
		  		var remove_required61 = $("#subtype61").attr("data-remove-required");
				var remove_required62 = $("#subtype62").attr("data-remove-required");
				var remove_required63 = $("#subtype63").attr("data-remove-required");

				if(remove_required61 == 1){
				    $("#subtype61").removeAttr("required");
				}else{
				    $("#subtype61").attr("required", "required");
				}
				
				if(remove_required62 == 1){
				    $("#subtype62").removeAttr("required");
				}else{
				    $("#subtype62").attr("required", "required");
				}
				
				if(remove_required63 == 1){
				    $("#subtype63").removeAttr("required");
				}else{
				    $("#subtype63").attr("required", "required");
				}
				
				$("#subtype11").removeAttr("required");
				$("#subtype12").removeAttr("required");
				$("#subtype13").removeAttr("required");
				$("#subtype14").removeAttr("required");
				$("#subtype15").removeAttr("required");
				
				$("#subtype21").removeAttr("required");
				$("#subtype22").removeAttr("required");
				$("#subtype23").removeAttr("required");
				$("#subtype24").removeAttr("required");
				$("#subtype25").removeAttr("required");
				$("#subtype26").removeAttr("required");
				
				$("#subtype31").removeAttr("required");
				$("#subtype32").removeAttr("required");
				$("#subtype33").removeAttr("required");
				$("#subtype34").removeAttr("required");
				$("#subtype35").removeAttr("required");
				
				$("#subtype41").removeAttr("required");
				$("#subtype42").removeAttr("required");
				$("#subtype43").removeAttr("required");
				$("#subtype44").removeAttr("required");
				$("#subtype45").removeAttr("required");
				
				$("#subtype51").removeAttr("required");
				$("#subtype52").removeAttr("required");
				$("#subtype53").removeAttr("required");
				$("#subtype54").removeAttr("required");
				$("#subtype55").removeAttr("required");
				
				var jaVal = document.getElementById("is_joint_account").value;
	            if(jaVal == 2){
	                $(".PrincipalDocsListDiv").hide();
	                $(".PrincipalJointDocsListDiv").show(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").show();  
	                $(".PrincipalSourceWealthDropifyDiv").hide();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").show();

	                $("#subtype16").attr("required", "required");

	                // $("#joint_account_holder_docs_upload").show();
	                

	            }else if(jaVal == 1){
	                $(".PrincipalDocsListDiv").show();
	                $(".PrincipalJointDocsListDiv").hide(); 

	                $(".PricipalJointSourceWealthGroupDropifyDiv").hide();  
	                $(".PrincipalSourceWealthDropifyDiv").show();

	                $(".principal-holder-source-fund").show();
	                $(".joint-holder-source-fund").hide();

	                $("#subtype16").removeAttr("required");

	                // $("#joint_account_holder_docs_upload").hide();
	            }

		  	}else if(x == 0){
		  		$(".status-investment").hide();
		  		$(".status-individual").hide();
		  		$(".status-private").hide();
		  		$(".status-trust").hide();	
		  		$(".status-fund").hide();
		  		$(".status-regular").hide();
		  	}else if(x == null){
		  		$(".status-investment").hide();
		  		$(".status-individual").hide();
		  		$(".status-private").hide();
		  		$(".status-trust").hide();	
		  		$(".status-fund").hide();
		  		$(".status-regular").hide();
		  	}
		}
		

        function saveScubscriptionDraft(){

        	preloader_init();
            const form = document.getElementById('subscriptionform');
            let formData = new FormData(form);

            axios.post(SITE_URL+'investor/subscriptionEditSaveDraft',formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-Token': csrfToken}}
            ).then(function(response){
                preloader_off();

                var subscription =response.data.subscription;
                console.log(subscription.id)
                $("#subscriptionId").val(subscription.id);
            });
        }

        function saveScubscription(){
        	if ($('#subscriptionform').parsley().validate()) {

        		//$('#subscriptionform').submit();
        		preloader_init();
	            const form = document.getElementById('subscriptionform');
	            let formData = new FormData(form);

	            axios.post(SITE_URL+'investor/subscriptionEditSave',formData,{
	                    headers: {
	                        'Content-Type': 'multipart/form-data',
	                        'X-CSRF-Token': csrfToken}}
	            ).then(function(response){

	            	preloader_off();
	                var item =response.data.data;
                    if(item === "success"){
                        window.location = SITE_URL+"investor/subscriptions";
                    }else{
                        Swal.fire('Sorry!',"Please try again.",'error');
                    }
	            });
	        }
        }
        

        $(document).on("click",".download_signed_applications",function() {
	        var subscriptionId = $('#subscriptionId').val();

	        if(subscriptionId){

	            preloader_init();

	            var csrfToken = "<?php echo e(csrf_token()); ?>"; 

	            const form = document.getElementById('subscriptionform');
	            let formData = new FormData(form);
	            formData.set('subscriptionId', subscriptionId);
	                
	            axios.post(SITE_URL+'investor/signedPdfApplicationsDownload',formData,{
	                    headers: {
	                        'Content-Type': 'multipart/form-data',
	                        'X-CSRF-Token': csrfToken
	                    }
	                }
	            ).then(function(response){

	                console.log(response.data);
	                if(response.data.data === "success"){ 

	                    preloader_off();

	                    var isJointApplicant = response.data.is_joint_applicant;
	                    var pdfDocs = response.data.pdfDocs;

	                    var temporaryDownloadLink = document.createElement("a");
					    temporaryDownloadLink.style.display = 'none';

					    document.body.appendChild( temporaryDownloadLink );

	                    Object.keys(pdfDocs).forEach(function (key) {

	                    	// console.log(docFile)
	                    	var docFile = pdfDocs[key];
	                    	var fileLink = base_url+docFile;
	                    	// console.log(filename)
	                    	var filename = /[^/]*$/.exec(fileLink)[0];
	                    	// console.log(filename)
					        temporaryDownloadLink.setAttribute( 'href', fileLink );
					        temporaryDownloadLink.setAttribute( 'download', filename );

					        temporaryDownloadLink.click();
		                });

	                    document.body.removeChild(temporaryDownloadLink);

	                }else{
	                    Swal.fire('Sorry!',"Please try again.",'error');
	                    preloader_off();
	                }

	            })
	            .catch(error => {
				    console.log(error)
				})
	        }
	    });

        
        <?php	

        	function getDocument($ssDocumentAs){

		        $output = [];
		        foreach ($ssDocumentAs as $document) {
		                                            
		            $id = $document['id'];
		            $main_type = $document['main_type'];
		            $sub_type = $document['sub_type'];
		            $file = $document['file'];
		            $name = $document['remarks'];

		            
		            if($main_type == 1){
		                ///********5*******///
		                if($sub_type == 11){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file"=> $file, "name"=> $name];
		                }else if($sub_type == 12){
		                    
		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file"=> $file, "name" => $name];
		                }else if($sub_type == 13){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file"=> $file, "name" => $name];
		                }else if($sub_type == 14){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 15){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 16){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 71){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 72){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 73){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 74){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }
		                
		            }else if($main_type == 2){
		                ///*******6********///
		                if($sub_type == 21){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 22){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 23){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 24){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 25){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 26){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }
		                
		            }else if($main_type == 3){
		                ///*******5********///
		                if($sub_type == 31){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 32){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 33){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 34){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 35){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }
		               
		            }else if($main_type == 4){
		                ///*******5********///
		                if($sub_type == 41){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 42){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 43){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 44){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 45){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }
		            }else if($main_type == 5){
		                ///*******5********///
		                if($sub_type == 51){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 52){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 53){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 54){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 55){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }
		            }else if($main_type == 6){
		                //*******3********///
		                if($sub_type == 61){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 62){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }else if($sub_type == 63){

		                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
		                }
		            }
		        }// For Loop
		        return $output;
		    }//End Function
        ?>


	</script>
<?php $__env->stopSection(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/investor/elements/editSubscriptionScript.blade.php ENDPATH**/ ?>