// Class definition
var KTFormControls = function () {
	var validation;
	var _showToast = function(type,message) {
        const Toast = Swal.mixin({toast: true,position: 'top-end',showConfirmButton: false,timer: 3000,timerProgressBar: true,onOpen: (toast) => {toast.addEventListener('mouseenter', Swal.stopTimer),toast.addEventListener('mouseleave', Swal.resumeTimer)}});Toast.fire({icon: type,title: message});
    }
    var _showSwal  = function(type,message) {
        swal.fire({
          text: message,
          icon: type,
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary"
          }
          })
    }
	var _ajaxForm = function(formData,val=null,val2=null){
		 $.ajax({
                url: base_url+"WebsiteController/Action",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend: function(){
                  // KTApp.blockPage();
                },
                complete: function(){
                  // KTApp.unblockPage();
                },
                success: function(response){
                    if(response.status=="success"){
                        res=JSON.parse(window.atob(response.payload));
                        	_initResponse(res,val,val2);
                    }else if(response.status == "failed"){
                        Swal.fire("Oopps!", response.message, "info");
                    }else if(response.status == "error"){
                       Swal.fire("Oopps!", response.message, "info");
                    }else{
                       Swal.fire("Oopps!", "Something went wrong, Please try again later", "info");
                       console.log(JSON.parse(window.atob(response.payload)));
                    }
                  },
                  error: function(xhr,status,error){
                      console.log(xhr);
                      console.log(status);
                      console.log(error);
                      console.log(xhr.responseText);
                      Swal.fire("Oopps!", "Something went wrong, Please try again later", "info");
                 } 
            })
	}
	var _InitView = function(form,id){
		switch(form){
			case "contact_us":{
				var form = KTUtil.getById('contact_us');
		       	var validation = FormValidation.formValidation(
		            form,{
		                fields: {
							name: {
								validators: {
									notEmpty: {
										message: 'Fullname is required'
									},
								}
							},
							mobile: {
								validators: {
									notEmpty: {
										message: 'Fullname is required'
									},
								}
							},
							email: {
								validators: {
									notEmpty: {
										message: 'Fullname is required'
									},
								}
							},
							subject: {
								validators: {
									notEmpty: {
										message: 'Fullname is required'
									},
								}
							},
							message: {
								validators: {
									notEmpty: {
										message: 'Fullname is required'
									},
								}
							},

		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                     icon: new FormValidation.plugins.Icon({
			                    valid: 'fa fa-check',
			                    invalid: 'fa fa-times',
			                    validating: 'fa fa-refresh'
			                }),
		                }
		            }
		        );
				$('.btn-submit').on('click',function(e){
		            e.preventDefault();
		            validation.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form);
		                        formData.append("action", "contact_us");
		                        formData.append("type", 'contact_us');
		                        _ajaxForm(formData,'contact_us',false);
		                }	
	                });                
	            });
				break;	
			}

		}
	}
	var _initResponse = function(response,val,val2){
		switch(val){
			case "contact_us":{
				 if (response!=false){
				 	_showToast('success','Email Sent');
                }else{
                	_showToast('info','Nothing changes');
                }
				break;
			}

		}
	}
	return {
		// public functions
		init: function(){
			let form  = $('form').attr('class');
			if(form=='contact_us'){
				_InitView(form);
			}
			
		}
	};
}();

jQuery(document).ready(function() {
	KTFormControls.init();
});
