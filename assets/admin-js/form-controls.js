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
                url: base_url+"AdminController/Action",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend: function(){
                  KTApp.blockPage();
                },
                complete: function(){
                  KTApp.unblockPage();
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
			case "profile":{
				 let validation_contact;
			     let form_contact = KTUtil.getById('contact_info_form');
			       validation_contact = FormValidation.formValidation(
			      form_contact,
			      {
			        fields: {
			           mobile: {
			                        validators: {
			                            notEmpty: {
			                                message: 'Mobile number is  required'
			                            },
			                            digits: {
			                                message: 'Mobile number can contain digits only'
			                            },
			                            stringLength: {
			                                min: 6,
			                                max: 10,
			                                message: 'The mobile number must have at least 6 to 10 digits'
			                            }
			                        }
			                    },
			                    city: {
			                        validators: {
			                            regexp: {
			                                regexp: /^[a-zA-ZÀ-ž-.\s]+$/,
			                                message: 'The city can only consist of alphabetical characters'
			                            },
			                            stringLength: {
			                                max: 20,
			                                message: 'You have reached your maximum limit of characters allowed'
			                            }
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
			    $('#contact_info_form').on('submit',function(e){
		            e.preventDefault();
		            validation_contact.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form_contact);
		                        formData.append("action", "save_user_profile");
		                        formData.append("type", 'save_contact_info');
		                        _ajaxForm(formData,'save_contact_info',false);
		                }	
	                });                
	            });
	            var validation_pass;
			     var form_pass = KTUtil.getById('change_pass_form');
			       validation_pass = FormValidation.formValidation(
			      form_pass,{
			        fields: {
			          c_password: {
			                        validators: {
			                            notEmpty: {
			                                message: 'The password is required'
			                            }
			                        }
			                    },
			                    n_password: {
			                        validators: {
			                            stringLength: {
			                                min: 8,
			                                message: 'The password must have at least 8 characters'
			                            },
			                            notEmpty: {
			                                message: 'The password is required'
			                            }
			                        }
			                    },
			                    
			                    v_password: {
			                        validators: {
			                            notEmpty: {
			                                message: 'The password confirmation is required'
			                            },
			                            identical: {
			                                compare: function() {
			                                    return form.querySelector('[name="n_password"]').value;
			                                },
			                                message: 'The password and its confirm are not the same'
			                            }
			                        }
			                    }
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
			    $('#change_pass_form').on('submit',function(e){
		            e.preventDefault();
		            validation_pass.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form_pass);
		                        formData.append("action", "save_user_profile");
		                        formData.append("type", 'save_change_pass');
		                        _ajaxForm(formData,'save_change_pass',false);
		                }	
	                });                
	            });
	             var validation_personal;
			     var form_personal = KTUtil.getById('personal_info_form');
			       validation_personal = FormValidation.formValidation(
			      form_personal,
			      {
			        fields: {
			           fname: {
			                        validators: {
			                            notEmpty: {
			                                message: 'First name is required'
			                            },
			                            regexp: {
			                                regexp: /^[a-zA-ZÀ-ž-.\s]+$/,
			                                message: 'The first name can only consist of alphabetical characters'
			                            },
			                            stringLength: {
			                                max: 20,
			                                message: 'You have reached your maximum limit of characters allowed'
			                            },
			                            
			                        }
			                    },
			                    lname: {
			                        validators: {
			                            notEmpty: {
			                                message: 'Last name is required'
			                            },
			                            regexp: {
			                                regexp: /^[a-zA-ZÀ-ž-.\s]+$/,
			                                message: 'The last name can only consist of alphabetical characters'
			                            },
			                            stringLength: {
			                                max: 20,
			                                message: 'You have reached your maximum limit of characters allowed'
			                            }
			                        }
			                    },
			                    mname: {
			                        validators: {
			                            regexp: {
			                                regexp: /^[a-zA-ZÀ-ž-.\s]+$/,
			                                message: 'The middle name can only consist of alphabetical characters'
			                            },
			                            stringLength: {
			                                max: 20,
			                                message: 'You have reached your maximum limit of characters allowed'
			                            }
			                        }
			                    }
			                },

			        plugins: { //Learn more: https://formvalidation.io/guide/plugins
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
			      $('#personal_info_form').on('submit',function(e){
		            e.preventDefault();
		            validation_personal.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form_personal);
		                        formData.append("action", "save_user_profile");
		                        formData.append("type", 'save_personal_info');
		                        _ajaxForm(formData,'save_personal_info',false);
		                }	
	                });                
	            });
				break;
			}
			case "advisor":{
		        var form = KTUtil.getById('create_advisor');
		       	validation = FormValidation.formValidation(
		            form,{
		                fields: {
							advisor_code: {
								validators: {
									notEmpty: {
										message: 'Advisor Code is required'
									},
								}
							},
							fname: {
								validators: {
									notEmpty: {
										message: 'First Name is required'
									},
								}
							},

							lname: {
								validators: {
									notEmpty: {
										message: 'Last Name is required'
									},
								}
							},

							gender: {
								validators: {
									notEmpty: {
										message: 'Gender is required'
									},
								}
							},

							position: {
								validators: {
									notEmpty: {
										message: 'Position is required'
									},
								}
							},
							team: {
								validators: {
									notEmpty: {
										message: 'Team is required'
									},
								}
							},

		                },

		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				$('.btn-create').on('click',function(e){
		            e.preventDefault();
		            validation.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form);
		                        formData.append("action", "advisor");
		                        formData.append("type", 'create_advisor');
		                        _ajaxForm(formData,'create_advisor',false);
		                }	
	                });                
	            });
	            $('#kt_image_6 > label > input[type=file]:nth-child(2)').on('change',function(e){
	            	Swal.fire({
					        title: "Are you sure?",
					        text: "You want to upload this!",
					        icon: "warning",
					        showCancelButton: true,
					        confirmButtonText: "Yes, Upload it!",
					        cancelButtonText: "No, cancel!",
					        reverseButtons: true
					    }).then(function(result) {
					        if (result.value) {
								let formData = new FormData();
		                        formData.append("action", "advisor");
		                        formData.append("type", 'update_advisor_image');
		                        formData.append("id",$('#update_advisor').attr('data-id'));
		                        formData.append("image",$('input[name=image_update]')[0].files[0]);
		                        _ajaxForm(formData,'update_advisor_image',false);
					        } else if (result.dismiss === "cancel") {
					        	$('#kt_image_6 > span:nth-child(3)').trigger('click');
					            Swal.fire("Cancelled","Your imaginary file is safe :)","error")
					        }
					    });
	            });
				break;	
			}
			case"unit":{
				var form_create = KTUtil.getById('create_unit');
		       	var validation_create = FormValidation.formValidation(
		            form_create,{
		                fields: {
							name: {
								validators: {
									notEmpty: {
										message: 'Unit Name is required'
									},
								}
							},
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				$('.btn-create').on('click',function(e){
		            e.preventDefault();
		            validation_create.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form_create);
		                        formData.append("action", "unit");
		                        formData.append("type", 'create_unit');
		                        _ajaxForm(formData,'create_unit',false);
		                }	
	                });                
	            });
	            var form = KTUtil.getById('update_unit');
		       	validation = FormValidation.formValidation(
		            form,{
		                fields: {
							name: {
								validators: {
									notEmpty: {
										message: 'Unit Name is required'
									},
								}
							},
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
	            $('.btn-update').on('click',function(e){
		            e.preventDefault();
		             e.preventDefault();
		            validation.validate().then(function(status) {
		                if (status == 'Valid') {
		                     let formData = new FormData();
	                        formData.append("action", "unit");
	                        formData.append("type", 'update_unit');
	                        formData.append("id", $('#update_unit').attr('data-id'));
	                        formData.append("name", $('input[name="name_update"]').val());
	                        _ajaxForm(formData,'update_unit',false);      
		                }	
	                });       
	            });
				break;
			}
			case "validation":{
				var form_target = KTUtil.getById('create_target');
		       	var validation_target = FormValidation.formValidation(
		            form_target,{
		                fields: {
							generate_id: {
								validators: {
									notEmpty: {
										message: 'Date From - To is required'
									},
								}
							},
							amount: {
								validators: {
									notEmpty: {
										message: 'Amount is required'
									},
								}
							}
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				 $('.btn-create-target').on('click',function(e){
		            e.preventDefault();
		            validation_target.validate().then(function(status) {
		                if (status == 'Valid') {
		                     let formData = new FormData(form_target);
	                        formData.append("action", "validation");
	                        formData.append("type", 'create_target');
	                        _ajaxForm(formData,'create_validation_target',false);      
		                }	
	                });       
	            });
				var form_date = KTUtil.getById('create_date');
		       	var validation_date = FormValidation.formValidation(
		            form_date,{
		                fields: {
							from: {
								validators: {
									notEmpty: {
										message: 'Date From is required'
									},
								}
							},
							to: {
								validators: {
									notEmpty: {
										message: 'Date To is required'
									},
								}
							},
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				 $('.btn-create-date').on('click',function(e){
		            e.preventDefault();
		            validation_date.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form_date);
	                        formData.append("action", "validation");
	                        formData.append("type", $('.form-action').attr('data-action'));
	                        formData.append('id',$('input[name="from"]').attr('data-id'));
	                        _ajaxForm(formData,'create_validation_date',false);      
		                }	
	                });       
	            });

				break;
			}
			case "medallion":{
				var form_target = KTUtil.getById('create_target');
		       	var validation_target = FormValidation.formValidation(
		            form_target,{
		                fields: {
							generate_id: {
								validators: {
									notEmpty: {
										message: 'Date From - To is required'
									},
								}
							},
							amount: {
								validators: {
									notEmpty: {
										message: 'Amount is required'
									},
								}
							}
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				 $('.btn-create-target').on('click',function(e){
		            e.preventDefault();
		            validation_target.validate().then(function(status) {
		                if (status == 'Valid') {
		                     let formData = new FormData(form_target);
	                        formData.append("action", "medallion");
	                        formData.append("type", 'create_target');
	                        _ajaxForm(formData,'create_medallion_target',false);      
		                }	
	                });       
	            });
				var form_date = KTUtil.getById('create_date');
		       	var validation_date = FormValidation.formValidation(
		            form_date,{
		                fields: {
							from: {
								validators: {
									notEmpty: {
										message: 'Date From is required'
									},
								}
							},
							to: {
								validators: {
									notEmpty: {
										message: 'Date To is required'
									},
								}
							},
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				 $('.btn-create-date').on('click',function(e){
		            e.preventDefault();
		            validation_date.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form_date);
	                        formData.append("action", "medallion");
	                        formData.append("type", $('.form-action').attr('data-action'));
	                        formData.append('id',$('input[name="from"]').attr('data-id'));
	                        _ajaxForm(formData,'create_medallion_date',false);      
		                }	
	                });       
	            });
				var form_cat = KTUtil.getById('create_date');
		       	var validation_cat = FormValidation.formValidation(
		            form_cat,{
		                fields: {
							name: {
								validators: {
									notEmpty: {
										message: 'Date From is required'
									},
								}
							},
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				 $('.btn-create-categories').on('click',function(e){
		            e.preventDefault();
		            validation_cat.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form_cat);
	                        formData.append("action", "medallion");
	                        formData.append("type", $('.form-action-cat').attr('data-action'));
	                        formData.append('id',$('input[name="name"]').attr('data-id'));
	                        formData.append('name',$('input[name="name"]').val());
	                        _ajaxForm(formData,'create_medallion_category',false);      
		                }	
	                });       
	            });
				break;
			}
			case "macaulay":{
				var form_target = KTUtil.getById('create_target');
		       	var validation_target = FormValidation.formValidation(
		            form_target,{
		                fields: {
							generate_id: {
								validators: {
									notEmpty: {
										message: 'Date From - To is required'
									},
								}
							},
							amount: {
								validators: {
									notEmpty: {
										message: 'Amount is required'
									},
								}
							}
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				 $('.btn-create-target').on('click',function(e){
		            e.preventDefault();
		            validation_target.validate().then(function(status) {
		                if (status == 'Valid') {
		                     let formData = new FormData(form_target);
	                        formData.append("action", "macaulay");
	                        formData.append("type", 'create_target');
	                        _ajaxForm(formData,'create_macaulay_target',false);      
		                }	
	                });       
	            });
				var form_date = KTUtil.getById('create_date');
		       	var validation_date = FormValidation.formValidation(
		            form_date,{
		                fields: {
							from: {
								validators: {
									notEmpty: {
										message: 'Date From is required'
									},
								}
							},
							to: {
								validators: {
									notEmpty: {
										message: 'Date To is required'
									},
								}
							},
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				 $('.btn-create-date').on('click',function(e){
		            e.preventDefault();
		            validation_date.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form_date);
	                        formData.append("action", "macaulay");
	                        formData.append("type", $('.form-action').attr('data-action'));
	                        formData.append('id',$('input[name="from"]').attr('data-id'));
	                        _ajaxForm(formData,'create_macaulay_date',false);      
		                }	
	                });       
	            });
				var form_cat = KTUtil.getById('create_date');
		       	var validation_cat = FormValidation.formValidation(
		            form_cat,{
		                fields: {
							name: {
								validators: {
									notEmpty: {
										message: 'Date From is required'
									},
								}
							},
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				 $('.btn-create-categories').on('click',function(e){
		            e.preventDefault();
		            validation_cat.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form_cat);
	                        formData.append("action", "macaulay");
	                        formData.append("type", $('.form-action-cat').attr('data-action'));
	                        formData.append('id',$('input[name="name"]').attr('data-id'));
	                        formData.append('name',$('input[name="name"]').val());
	                        _ajaxForm(formData,'create_macaulay_category',false);      
		                }	
	                });       
	            });
				break;
			}
		}
	}
	var _initResponse = function(response,val,val2){
		switch(val){
			case "save_contact_info":{
				 if (response!=false){
				 	_showToast('success','Save changes');
                }else{
                	_showToast('info','Nothing changes');
                }
				break;
			}
			case "save_change_pass":{
				if (response==true){
					_showToast('success','Save changes');
	                document.getElementById('change_pass_form').reset();
	              }else if(res=='incorrect_pass'){
	              	_showToast('error','Incorrect Password');
	              }else{
	              	_showToast('error','Nothing changes');
	              }
				break;
			}
			case "save_personal_info":{
				if (response!=false){
                  _showToast('success','Save changes');
                  $('.full_name').text($('input[name="fname"]').val()+" "+$('input[name="lname"]').val());
                  $('.f_name').text($('input[name="fname"]').val());
                }else{
                 _showToast('error','Nothing changes');
                }
				break;
			}
			case "create_advisor":{
				_showToast('success',response);
				document.getElementById('create_advisor').reset();
				 $('#kt_image_5 > span:nth-child(3)').trigger('click');
				KTDatatablesDataSourceAjaxServer.init('kt_datatable_advisor');
				break;
			}
			case "update_advisor_image":{
				if(response.status='Saved Image Changes'){
					_showToast('success',response.status);
					$('#kt_image_6').css('background-image',' url(http://localhost/salesproduction/images/profile/'+response.image+')');
					$('#kt_image_6 > label > input[type=file]:nth-child(2)').val("");
				}else{
					_showToast('error',response);
				}
				break;
			}
			case "create_unit":{
				_showToast('success',response);
				document.getElementById('create_unit').reset();
				KTDatatablesDataSourceAjaxServer.init('kt_datatable_unit');
				break;
			}
			case "update_unit":{
				_showToast('success',response);
				KTDatatablesDataSourceAjaxServer.init('kt_datatable_unit');
				break;
			}
			case "create_validation_date":{
				if(response == 'Created Successfully'){
					_showToast('success',response);
					document.getElementById('create_date').reset();
					KTDatatablesDataSourceAjaxServer.init('kt_datatable_validation_date');
				}else if(response == 'Update Successfully'){
					_showToast('success',response);
					KTDatatablesDataSourceAjaxServer.init('kt_datatable_validation_date');
				}else{
					_showToast('info',response);
					document.getElementById('create_date').reset();
				}
				break;
			}
			case "create_validation_target":{
				if(res == 'Created Successfully'){
					_showToast('success',response);
					document.getElementById('create_target').reset();
				}else{
					_showToast('success',response);
				}
				break;
			}
			case "create_medallion_date":{
				if(response == 'Created Successfully'){
					_showToast('success',response);
					document.getElementById('create_date').reset();
					KTDatatablesDataSourceAjaxServer.init('kt_datatable_medallion_date');
				}else if(response == 'Update Successfully'){
					_showToast('success',response);
					KTDatatablesDataSourceAjaxServer.init('kt_datatable_medallion_date');
				}else{
					_showToast('info',response);
					document.getElementById('create_date').reset();
				}
				break;
			}
			case "create_medallion_target":{
				if(res == 'Created Successfully'){
					_showToast('success',response);
					document.getElementById('create_target').reset();
				}else{
					_showToast('success',response);
				}
				break;
			}
			case "create_medallion_category":{
				if(response == 'Created Successfully'){
					_showToast('success',response);
					document.getElementById('create_categories').reset();
					KTDatatablesDataSourceAjaxServer.init('kt_datatable_categories_medallion');
				}else if(response == 'Update Successfully'){
					_showToast('success',response);
					KTDatatablesDataSourceAjaxServer.init('kt_datatable_categories_medallion');
				}else{
					_showToast('info',response);
					document.getElementById('create_categories').reset();
				}
				break;
			}
			case "create_macaulay_date":{
				if(response == 'Created Successfully'){
					_showToast('success',response);
					document.getElementById('create_date').reset();
					KTDatatablesDataSourceAjaxServer.init('kt_datatable_macaulay_date');
				}else if(response == 'Update Successfully'){
					_showToast('success',response);
					KTDatatablesDataSourceAjaxServer.init('kt_datatable_macaulay_date');
				}else{
					_showToast('info',response);
					document.getElementById('create_date').reset();
				}
				break;
			}
			case "create_macaulay_target":{
				if(res == 'Created Successfully'){
					_showToast('success',response);
					document.getElementById('create_target').reset();
				}else{
					_showToast('success',response);
				}
				break;
			}
			case "create_macaulay_category":{
				if(response == 'Created Successfully'){
					_showToast('success',response);
					document.getElementById('create_categories').reset();
					KTDatatablesDataSourceAjaxServer.init('kt_datatable_categories_macaulay');
				}else if(response == 'Update Successfully'){
					_showToast('success',response);
					KTDatatablesDataSourceAjaxServer.init('kt_datatable_categories_macaulay');
				}else{
					_showToast('info',response);
					document.getElementById('create_categories').reset();
				}
				break;
			}
		}
	}
	return {
		// public functions
		init: function(form,val=false){
			_InitView(form,val);
		}
	};
}();

// jQuery(document).ready(function() {
// 	KTFormControls.init();
// });
