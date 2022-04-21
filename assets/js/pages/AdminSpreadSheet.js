// Class definition
var KTSpreadSheetControls = function () {
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
                url: base_url+"SpreadSheetController/AdminAction",
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
			case "validation":{
		        var form_create = KTUtil.getById('import_validation');
		       	var validation_create = FormValidation.formValidation(
		            form_create,{
		                fields: {
							year_target: {
								validators: {
									notEmpty: {
										message: 'Year is required'
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
		        $('.btn-import-export').on('click',function(e){
		            e.preventDefault();
		            validation_create.validate().then(function(status) {
		                if (status == 'Valid') {
		                	if(!$('input[name=file]').val()){
		                		_showToast('error','Please choose file to upload');
		                	}else{
		                		  let formData = new FormData(form_create);
		                        formData.append("action", "validation");
		                        formData.append("type", 'import_validation');
		                        _ajaxForm(formData,'import_validation',false);
		                	}
		                  
		                }	
	                });                
	            });
	            $('.btn-import-create').on('click',function(e){
		            e.preventDefault();
		            let element = $('.generate_date_target');
		            let team = Array.from(document.getElementsByClassName('td-team')).map(item => item.textContent);
	            	let advisor_code = Array.from(document.getElementsByClassName('td-advisor')).map(item => item.textContent);
	            	let name = Array.from(document.getElementsByClassName('td-name')).map(item => item.textContent);	
	            	let submitted = Array.from(document.getElementsByClassName('td-submitted')).map(item => item.textContent);
	            	let settled = Array.from(document.getElementsByClassName('td-settled')).map(item => item.textContent);
	            	let ac = Array.from(document.getElementsByClassName('td-ac')).map(item => item.textContent);
	            	let nsc = Array.from(document.getElementsByClassName('td-nsc')).map(item => item.textContent);
		            	  Swal.fire({
				          title: "Are you sure?",
				          text: "You want to import this!",
				          icon: "warning",
				          showCancelButton: true,
				          confirmButtonText: "Yes, import it!",
				          cancelButtonText: "No, cancel!",
				          reverseButtons: true
				      }).then(function(result) {
				          if (result.value) {
				             	let formData = new FormData();
			                    formData.append("action", "validation");
			                    formData.append("type", 'create_validation');
			                    formData.append("date_target", element.attr('data-date'));
			                    formData.append("month_target",element.attr('data-month'));
			                    formData.append("year_target", element.attr('data-year'));
			                    formData.append("team", team);
			                    formData.append("advisor_code", advisor_code);
			                    formData.append("name", name);
			                    formData.append("submitted", submitted);
			                    formData.append("settled", settled);
			                    formData.append("ac", ac.join('|'));
			                    formData.append("nsc", nsc.join('|'));
			                    _ajaxForm(formData,'create_validation',false);
				          } 
				      });
	            });
				break;
			}
			case "medallion":{
		        var form_create = KTUtil.getById('import_validation');
		        $('.btn-import-export').on('click',function(e){
		            e.preventDefault();
                	if(!$('input[name=file]').val()){
                		_showToast('error','Please choose file to upload');
                	}else{
                		  let formData = new FormData(form_create);
                        formData.append("action", "medallion");
                        formData.append("type", 'import_medallion');
                        _ajaxForm(formData,'import_medallion',false);
                	}
	            });
	            $('.btn-import-create').on('click',function(e){
		            e.preventDefault();
		            	let element = $('.generate_date_target');
		            	let team = Array.from(document.getElementsByClassName('td-team')).map(item => item.textContent);
		            	let advisor_code = Array.from(document.getElementsByClassName('td-advisor')).map(item => item.textContent);
		            	let name = Array.from(document.getElementsByClassName('td-name')).map(item => item.textContent);	
		            	let submitted = Array.from(document.getElementsByClassName('td-submitted')).map(item => item.textContent);
		            	let settled = Array.from(document.getElementsByClassName('td-settled')).map(item => item.textContent);
		            	let ac = Array.from(document.getElementsByClassName('td-ac')).map(item => item.textContent);
		            	let nsc = Array.from(document.getElementsByClassName('td-nsc')).map(item => item.textContent);
	                    Swal.fire({
				          title: "Are you sure?",
				          text: "You want to import this!",
				          icon: "warning",
				          showCancelButton: true,
				          confirmButtonText: "Yes, import it!",
				          cancelButtonText: "No, cancel!",
				          reverseButtons: true
				      }).then(function(result) {
				          if (result.value) {
				             	let formData = new FormData();
			                    formData.append("action", "medallion");
			                    formData.append("type", 'create_medallion');
			                    formData.append("date_target", element.attr('data-date'));
			                    formData.append("month_target",0);
			                    formData.append("year_target", 0);
			                    formData.append("team", team);
			                    formData.append("advisor_code", advisor_code);
			                    formData.append("name", name);
			                    formData.append("submitted", submitted);
			                    formData.append("settled", settled);
			                    formData.append("ac", ac.join('|'));
			                    formData.append("nsc", nsc.join('|'));
			                    _ajaxForm(formData,'create_medallion',false);
				          } 
				      });
	            });
				break;
			}
			case "macaulay":{
		        var form_create = KTUtil.getById('import_validation');
		        $('.btn-import-export').on('click',function(e){
		            e.preventDefault();
                	if(!$('input[name=file]').val()){
                		_showToast('error','Please choose file to upload');
                	}else{
                		  let formData = new FormData(form_create);
                        formData.append("action", "macaulay");
                        formData.append("type", 'import_macaulay');
                        _ajaxForm(formData,'import_macaulay',false);
                	}
	            });
	            $('.btn-import-create').on('click',function(e){
		            e.preventDefault();
		            	let element = $('.generate_date_target');
		            	let team = Array.from(document.getElementsByClassName('td-team')).map(item => item.textContent);
		            	let advisor_code = Array.from(document.getElementsByClassName('td-advisor')).map(item => item.textContent);
		            	let name = Array.from(document.getElementsByClassName('td-name')).map(item => item.textContent);	
		            	let submitted = Array.from(document.getElementsByClassName('td-submitted')).map(item => item.textContent);
		            	let settled = Array.from(document.getElementsByClassName('td-settled')).map(item => item.textContent);
		            	let ac = Array.from(document.getElementsByClassName('td-ac')).map(item => item.textContent);
		            	let nsc = Array.from(document.getElementsByClassName('td-nsc')).map(item => item.textContent);
	                    Swal.fire({
				          title: "Are you sure?",
				          text: "You want to import this!",
				          icon: "warning",
				          showCancelButton: true,
				          confirmButtonText: "Yes, import it!",
				          cancelButtonText: "No, cancel!",
				          reverseButtons: true
				      }).then(function(result) {
				          if (result.value) {
				             let formData = new FormData();
			                    formData.append("action", "macaulay");
			                    formData.append("type", 'create_macaulay');
			                    formData.append("date_target", element.attr('data-date'));
			                    formData.append("month_target",0);
			                    formData.append("year_target", 0);
			                    formData.append("team", team);
			                    formData.append("advisor_code", advisor_code);
			                    formData.append("name", name);
			                    formData.append("submitted", submitted);
			                    formData.append("settled", settled);
			                    formData.append("ac", ac.join('|'));
			                    formData.append("nsc", nsc.join('|'));
			                    _ajaxForm(formData,'create_macaulay',false);
				          } 
				      });
	            });
				break;
			}

		}
	}
	var _initResponse = function(response,val,val2){
		switch(val){
			case "import_validation":{
					let  total_submitted = 0;
					let total_settled = 0;
					let total_ac = 0;
					let total_nsc = 0;	
				    var container = $('#KT_table_import_validation > tbody');
					var result = [];
					let html="";
					response.reduce(function(res, value) {
					  if (!res[value.advisor_code]) {
					    res[value.advisor_code] = {team:value.team,advisor_code: value.advisor_code,name: value.name,submitted: 0,settled: 0,ac: 0,nsc: 0};
					    result.push(res[value.advisor_code])
					  }
					  res[value.advisor_code].submitted += value.submitted;
					  res[value.advisor_code].settled += value.settled;
					  res[value.advisor_code].ac += value.ac;
					  res[value.advisor_code].nsc += value.nsc;
					  return res;
					}, {});
					$('.generate_date_target').text(response[0].from+'-'+response[0].to+' ('+response[0].monthname+'-'+response[0].year+')');
					$('.generate_date_target').attr('data-date',response[0].id);
					$('.generate_date_target').attr('data-month',response[0].month);
					$('.generate_date_target').attr('data-year',response[0].year);
					$('.generate_date_target').attr('data-lenght',result.length);
					for (let i = 1; i < result.length; i++) {
					  html += '<tr>\
								<td class="td-team">'+result[i].team+'</td>\
								<td class="td-advisor">' + result[i].advisor_code + '</td>\
								<td class="td-name">' + result[i].name + '</td>\
								<td class="td-submitted">' + parseFloat(result[i].submitted).toFixed(2) + '</td>\
								<td class="td-settled">' + parseFloat(result[i].settled).toFixed(2)+ '</td>\
								<td class="td-ac">' + parseFloat(result[i].ac).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>\
								<td class="td-nsc">' + parseFloat(result[i].nsc).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>\
							</tr>';
							total_submitted += parseFloat(result[i].submitted);
							total_settled += parseFloat(result[i].settled);
							total_ac += parseFloat(result[i].ac);
							total_nsc += parseFloat(result[i].nsc);
					}
					html +='<tr class="bg-success">\
								<td colspan="3" class="text-center">TOTAL:</td>\
								<td>'+parseFloat(total_submitted).toFixed(2)+'</td>\
								<td>'+parseFloat(total_settled).toFixed(2)+'</td>\
								<td>'+parseFloat(total_ac).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') +'</td>\
								<td>'+parseFloat(total_nsc).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') +'</td>\
							</tr>';
					container.empty();
					container.append(html);
					$('#fetch_import_data').modal('show');
				break;
			}
			case "create_validation":{
				document.getElementById('import_validation').reset();
				$('select[name="search"]').trigger('change');
				_showToast('success','Importing Data was successfully inserted');
				$('#KT_table_import_validation > tbody').empty();
				$('#fetch_import_data').modal('hide');
				break;
			}
			case "import_medallion":{
				let  total_submitted = 0;
				let total_settled = 0;
				let total_ac = 0;
				let total_nsc = 0;	
				let container = $('#KT_table_import_validation > tbody');
				let html="";
					var result = [];
					response.reduce(function(res, value) {
					  if (!res[value.advisor_code]) {
					    res[value.advisor_code] = {team:value.team,advisor_code: value.advisor_code,name: value.name,submitted: 0,settled: 0,ac: 0,nsc: 0};
					    result.push(res[value.advisor_code])
					  }
					  res[value.advisor_code].submitted += value.submitted;
					  res[value.advisor_code].settled += value.settled;
					  res[value.advisor_code].ac += value.ac;
					  res[value.advisor_code].nsc += value.nsc;
					  return res;
					}, {});
					$('.generate_date_target').text(response[0].from+'-'+response[0].to);
					$('.generate_date_target').attr('data-date',response[0].id);
					$('.generate_date_target').attr('data-lenght',result.length);
					for (let i = 1; i < result.length; i++) {
					  html += '<tr>\
								<td class="td-team">'+result[i].team+'</td>\
								<td class="td-advisor">' + result[i].advisor_code + '</td>\
								<td class="td-name">' + result[i].name + '</td>\
								<td class="td-submitted">' + parseFloat(result[i].submitted).toFixed(2) + '</td>\
								<td class="td-settled">' + parseFloat(result[i].settled).toFixed(2)+ '</td>\
								<td class="td-ac">' + parseFloat(result[i].ac).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>\
								<td class="td-nsc">' + parseFloat(result[i].nsc).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>\
							</tr>';
							total_submitted += parseFloat(result[i].submitted);
							total_settled += parseFloat(result[i].settled);
							total_ac += parseFloat(result[i].ac);
							total_nsc += parseFloat(result[i].nsc);
					}
					html +='<tr class="bg-success">\
								<td colspan="3" class="text-center">TOTAL:</td>\
								<td>'+parseFloat(total_submitted).toFixed(2)+'</td>\
								<td>'+parseFloat(total_settled).toFixed(2)+'</td>\
								<td>'+parseFloat(total_ac).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') +'</td>\
								<td>'+parseFloat(total_nsc).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') +'</td>\
							</tr>';
					container.empty();
					container.append(html);
					$('#fetch_import_data').modal('show');
				break;
			}
			case "create_medallion":{
				document.getElementById('import_validation').reset();
				$('select[name="search"]').trigger('change');
				_showToast('success','Importing Data was successfully inserted');
				$('#KT_table_import_validation > tbody').empty();
				$('#fetch_import_data').modal('hide');
				break;
			}
			case "import_macaulay":{
				let  total_submitted = 0;
				let total_settled = 0;
				let total_ac = 0;
				let total_nsc = 0;	
				let container = $('#KT_table_import_validation > tbody:last-child');
				let html ="";
					var result = [];
					response.reduce(function(res, value) {
					  if (!res[value.advisor_code]) {
					    res[value.advisor_code] = {team:value.team,advisor_code: value.advisor_code,name: value.name,submitted: 0,settled: 0,ac: 0,nsc: 0};
					    result.push(res[value.advisor_code])
					  }
					  res[value.advisor_code].submitted += value.submitted;
					  res[value.advisor_code].settled += value.settled;
					  res[value.advisor_code].ac += value.ac;
					  res[value.advisor_code].nsc += value.nsc;
					  return res;
					}, {});
					$('.generate_date_target').text(response[0].from+'-'+response[0].to);
					$('.generate_date_target').attr('data-date',response[0].id);
					$('.generate_date_target').attr('data-lenght',result.length);
					for (let i = 1; i < result.length; i++) {
					  html += '<tr>\
								<td class="td-team">'+result[i].team+'</td>\
								<td class="td-advisor">' + result[i].advisor_code + '</td>\
								<td class="td-name">' + result[i].name + '</td>\
								<td class="td-submitted">' + parseFloat(result[i].submitted).toFixed(2) + '</td>\
								<td class="td-settled">' + parseFloat(result[i].settled).toFixed(2)+ '</td>\
								<td class="td-ac">' + parseFloat(result[i].ac).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>\
								<td class="td-nsc">' + parseFloat(result[i].nsc).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>\
							</tr>';
							total_submitted += parseFloat(result[i].submitted);
							total_settled += parseFloat(result[i].settled);
							total_ac += parseFloat(result[i].ac);
							total_nsc += parseFloat(result[i].nsc);
					}
					html +='<tr class="bg-success">\
								<td colspan="3" class="text-center">TOTAL:</td>\
								<td>'+parseFloat(total_submitted).toFixed(2)+'</td>\
								<td>'+parseFloat(total_settled).toFixed(2)+'</td>\
								<td>'+parseFloat(total_ac).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') +'</td>\
								<td>'+parseFloat(total_nsc).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') +'</td>\
							</tr>';
					container.empty();
					container.append(html);
					$('#fetch_import_data').modal('show');
				break;
			}
			case "create_macaulay":{
				document.getElementById('import_validation').reset();
				$('select[name="search"]').trigger('change');
				_showToast('success','Importing Data was successfully inserted');
				$('#KT_table_import_validation > tbody:last-child').empty();
				$('#fetch_import_data').modal('hide');
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
