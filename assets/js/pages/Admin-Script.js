$.getScript("assets/js/pages/draggable.js");
'use strict';
var APPHANDLER = function(){
  //apphandlerglobal
    var _init = async function(){
         _check_url(window.location.pathname);

          $(window).on("popstate", function (e) {
              e.preventDefault();
              location.reload();
          });
          Array.from($(".menu-link,.logout,.profile")).forEach(function(element){
            if(element.getAttribute('href')){
               element.addEventListener("click", function(e){
                e.preventDefault();
                $('.menu-item').removeClass('menu-item-active  menu-item-open');
                $('.'+element.getAttribute('href')).addClass('menu-item-active menu-item-open'); 
                  $(element).parent().addClass('menu-item-active menu-item-open');
                  _loadpage(element.getAttribute('href'));
              })
            }
        });
    };
    var _getParams = async function (url){
        var params = {};
        var parser = document.createElement('a');
        parser.href = url;
        var query = parser.search.substring(1);
        var vars = query.split('&');
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            params[pair[0]] = decodeURIComponent(pair[1]);
        }
        return params;
    };
    var _check_url =  async function (url){;   
          $('.menu-item').removeClass('menu-item-active menu-item-open');
          if(url.split('/')[2] == 'adminview'){
              _loadpage(url.split('/')[3]);
            $('.'+url.split('/')[3]).addClass('menu-item-active menu-item-open'); 
          }else if(url.split('/')[3] == 'adminview'){
            _loadpage(url.split('/')[4]);
            $('.'+url.split('/')[4]).addClass('menu-item-active menu-item-open'); 
          }else{
            _loadpage(url.split('/')[4]);
            $('.dashboard').addClass('menu-item-active menu-item-open'); 
          }
    };
    var _sessionStorage = function (session,val) {
      // Check browser support
      if (typeof(Storage) !== "undefined") {
        sessionStorage.setItem(session, val);
      } else {
        console.log("Sorry, your browser does not support Web Storage...");
      }
    }
    var _getItem = function (session){
      return sessionStorage.getItem(session);
    }
    var _showToast = function(type,message){
        const Toast = Swal.mixin({toast: true,position: 'top-end',showConfirmButton: false,timer: 3000,timerProgressBar: true,onOpen: (toast) => {toast.addEventListener('mouseenter', Swal.stopTimer),toast.addEventListener('mouseleave', Swal.resumeTimer)}});Toast.fire({icon: type,title: message});
    }
  var _initCurrency_format = function(action){
    $( document ).ready(function() {
      $(''+action+'').mask('000,000,000,000,000.00', {reverse: true});
    });
  } 
  var _number_seperator = function(action){
     $( document ).ready(function() {
       $(''+action+'').keyup(function(event) {
        alert('ok')
          if (event.which >= 37 && event.which <= 40) return;
          // $(this).text(function(index, value) {
          //   return value
          //     // Keep only digits, decimal points, and dashes at the start of the string:
          //     .replace(/[^\d.-]|(?!^)-/g, "")
          //     // Remove duplicated decimal points, if they exist:
          //     .replace(/^([^.]*\.)(.*$)/, (_, g1, g2) => g1 + g2.replace(/\./g, ''))
          //     // Keep only two digits past the decimal point:
          //     .replace(/\.(\d{2})\d+/, '.$1')
          //     // Add thousands separators:
          //     .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
          // });
        });
    });
  }
  var _initNumberOnly = function(action){
      $(document).on('input', action, function(evt){
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g,''));
        if ((evt.which < 48 || evt.which > 57)) 
        {
          evt.preventDefault();
        }
      });
   }
  var  GetMonthName = function(monthNumber) {
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      return months[monthNumber - 1];
  }
   var moneyformat = function(val){
      return "₱ " + parseFloat(val).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
   }
   var addcomma = function(val){
      return parseFloat(val).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
   }

    var _showSwal  = function(type,message,title) {
      if(!title){
        swal.fire({
          text: message,
          icon: type,
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary"
          }
          })
      }else{
        swal.fire({
          title: title,
          text: message,
          icon: type,
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary"
          }
          })
      } 
    }
    var _showSwalHtml = function(type,message,title){
      	if(!title){
      		title=type;
      	}
      	swal.fire({
             title: title,
  			html: message,
  			icon: type,
  			buttonsStyling: false,
  			confirmButtonText: "Ok, got it!",
  			customClass: {
  		   		confirmButton: "btn font-weight-bold btn-light-primary"
  			}
  		})
    }
    var _ShowHidePassword = function(id){
      $("#"+id+" span").on('click', function(e) {
        e.preventDefault();
        if($('#'+id+' input').attr("type") == "text"){
            $('#'+id+' input').attr('type', 'password');
            $('#'+id+' i').addClass( "fa-eye-slash" );
            $('#'+id+' i').removeClass( "fa-eye" );
        }else if($('#'+id+' input').attr("type") == "password"){
            $('#'+id+' input').attr('type', 'text');
            $('#'+id+' i').removeClass( "fa-eye-slash" );
            $('#'+id+' i').addClass( "fa-eye" );
        }
      });
    }
    var  animateValueDecimal=function(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
          if (!startTimestamp) startTimestamp = timestamp;
          const progress = Math.min((timestamp - startTimestamp) / duration, 1);
          obj.innerHTML = parseFloat(progress * (end - start) + start).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
          if (progress < 1) {
            window.requestAnimationFrame(step);
          }
        };
        window.requestAnimationFrame(step);
    }
    var  animateValue=function(obj, start, end, duration) {
      let startTimestamp = null;
      const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * (end - start) + start);
        if (progress < 1) {
          window.requestAnimationFrame(step);
        }
      };
      window.requestAnimationFrame(step);
    }
    var _getlastpath = function (url){
          let lastpath = url.split('/').pop();
          if(lastpath == 'shop'){
            return false;
          }else if(lastpath == null || lastpath == ''){
            return false;
          }else{
            return lastpath;
          }
    };
    var _yearpicker = function() {
      $('.yearpicker').datepicker({
          format: "yyyy",
          weekStart: 1,
          orientation: "bottom",
          language: "{{ app.request.locale }}",
          keyboardNavigation: false,
          viewMode: "years",
          minViewMode: "years"
      });
    }
     var _modal_image = function(){
      $("body").delegate( ".tba_image", "click", function(){
                    let modal = document.getElementById('TopupModal');
                    let img = document.getElementsByTagName('img');
                    let modalImg = document.getElementById("img01");
                    
                        modal.style.display = "block";
                        
                        if(this.src){
                          modalImg.src = this.src;
                        }else{
                          modalImg.src = $(this).css('background-image').replace(/^url\(['"]?/,'').replace(/['"]?\)$/,'');;
                        }
                        $("#caption").empty().append($(this).attr('alt'));
                  })
                  $("body").delegate( ".close,#TopupModal","click", function() {
                    let modal = document.getElementById('TopupModal');
                    modal.style.display = "none";
                  });
    }
     var _initAddr=function(){
      $('select[name="addr_region"]').on('change', function(e){
        e.preventDefault();
        $('select[name="addr_province"]').empty().append('<option value="">Select Province</option>');
        $('select[name="addr_city"]').empty().append('<option value="">Select Province first</option>');
        $('select[name="addr_barangay"]').empty().append('<option value="">Select City first</option>');
        if(this.value!=""){
         _ajaxrequest(_constructBlockUi('blockPage', false, 'Processing...'), _constructForm(['address','fetch_province',this.value]));
      }
      })
      $('select[name="addr_province"]').on('change', function(e){
        e.preventDefault();
        $('select[name="addr_city"]').empty().append('<option value="">Select City</option>');
        $('select[name="addr_barangay"]').empty().append('<option value="">Select City first</option>');
        if(this.value!=""){
          _ajaxrequest(_constructBlockUi('blockPage', false, 'Processing...'), _constructForm(['address','fetch_city',this.value]));
      }
      })
      $('select[name="addr_city"]').on('change', function(e){
        e.preventDefault();
        $('select[name="addr_barangay"]').empty().append('<option value="">Select Barangay</option>');
        if(this.value!=""){
          _ajaxrequest(_constructBlockUi('blockPage', false, 'Processing...'), _constructForm(['address','fetch_barangay',this.value]));
      }
      })
    }
    var _loadpage =  function(page){
                  $.ajax({
                    url: base_url+"view/adminpage",
                    type: "POST",
                    data: {page : page},
                    dataType: "html",
                    beforeSend: function(){
                      window.history.pushState(null, null,'view/adminview/'+page);
                      KTApp.blockPage({
                      overlayColor: '#000000',
                      state: 'primary',
                      message: 'Loading...'
                     });
                      $('.offcanvas-close, .offcanvas-overlay').trigger('click');
                    },
                    complete: function(){
                      $("#kt_content").fadeIn(3000);
                      $("html, body").animate({ scrollTop: 0 }, "slow");
                      $("head > title").empty().append(company_title+" | "+page.toUpperCase());
                       KTApp.unblockPage();
                    },
                    success: async function(response){
                        if(response){ 
                          $("#kt_content").empty();
                          $("#kt_content").append(response).promise().done(function(){_initview(page);});
                        }
                    },
                    error: function(xhr,status,error){
                      // if(xhr.status == 200){
                      //   if(xhr.responseText=="signed-out"){
                      //     Swal.fire({
                      //     title:"Oopps!",
                      //     text: "Your account was signed-out.",
                      //     icon: "info",
                      //     showCancelButton: false,
                      //     confirmButtonText: "Ok, Got it",
                      //         reverseButtons: true
                      //     }).then(function(result) {
                      //       window.location.replace("authentication/AdminLogin");
                      //     });
                      //   }else{
                      //     Swal.fire("Ops!", "Check your internet connection.", "error");
                      //   }
                      // }else 
                      if(xhr.status == 500){
                        Swal.fire("Ops!", 'Internal error: ' + xhr.responseText, "error");
                      }else if(status=="error"){
                         Swal.fire({
                          title:"Oopps!",
                          text: "Your account was signed-out.",
                          icon: "info",
                          showCancelButton: false,
                          confirmButtonText: "Ok, Got it",
                              reverseButtons: true
                          }).then(function(result) {
                            window.location.replace("authentication/AdminLogin");
                          });
                      }else{
                        console.log(xhr);
                        console.log(status);
                        Swal.fire("Ops!", 'Something went wrong..', "error");
                      }
                    }  
            });  
    };

    var _initview = async function(view){
      _yearpicker();
       _modal_image();
          $('[data-toggle="tooltip"]').tooltip();
          // _getLabel();
          if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
              top: 0,
              left: 0
            });
          }
          $('#myModal').modal({
            backdrop: false,
            show: true
          });
          $('.modal-dialog').draggable({
            handle: ".modal-header"
          });
      switch(view){
        case "dashboard":{
            $('select[name=search_option1]').on('change',function(e){
              e.preventDefault();
              KTApexChartsDemo.init('chart_validation',$(this).val());
              KTApexChartsDemo.init('chart_validation_submitted',$(this).val());
            });
            $('select[name=search_option1]').trigger('change');
          break;
        }
         case 'profile':{
                KTFormControls.init('profile');
                KTProfile.init();
                _ajaxrequest(_constructBlockUi('blockPage', false, 'Profile...'), _constructForm(['profile', 'profile']));
                break;
        }
       
      }
    };
    var _construct = async function(response, type, element, object){
        switch(type){
           case 'profile':{
                if(response!=false){
                  if(response.country){
                    let optgroup = '<optgroup label="Other countries">';
                    for(let i = 0; i<response.country.length; i++){
                       if(response.country[i].iso=="PH" || response.country[i].iso=="US" || response.country[i].iso=="GB"){
                        $('select[name="country"]').append('<option phonecode="'+response.country[i].phonecode+'" value="'+response.country[i].iso+'">'+response.country[i].country_name+'</option>')
                       }else{
                          optgroup += '<option phonecode="'+response.country[i].phonecode+'" value="'+response.country[i].iso+'">'+response.country[i].country_name+'</option>';
                       }
                    }
                    $('select[name="country"]').append(optgroup+'</optgroup>');
                  }
                  if(response.country){
                    let optgroup = '<optgroup label="Others">';
                    for(let i = 0; i<response.country.length; i++){
                       if(response.country[i].iso=="PH"){
                        $('select[name="phonecode"]').append('<option value="'+response.country[i].phonecode+'">+'+response.country[i].phonecode+'</option>');
                       }else{
                          optgroup += '<option value="'+response.country[i].phonecode+'">+'+response.country[i].phonecode+'</option>';
                       }
                    }
                    $('select[name="phonecode"]').append(optgroup+'</optgroup>');
                  }
                  $("#kt_profile_avatar").on('change',function(e) {
                    e.preventDefault();
                    if($('#profile_avatar')[0].files[0]){
                      _ajaxrequest(_constructBlockUi('blockPage', false, 'Saving...'), _constructForm(['profile','save_profile_image',$('#profile_avatar')[0].files[0]]));
                    }
                  });

                  if(response.profile){
                    $('input[name="fname"]').val(response.profile.fname);
                    $('input[name="mname"]').val(response.profile.mname);
                    $('input[name="lname"]').val(response.profile.lname);
                    $('#kt_profile_avatar').css('background-image', 'url(images/profile/'+response.profile.profile_img+')');
                    $('select[name="country"] option[value="'+response.profile.country+'"]').prop("selected", true).change();
                    $('select[name="phonecode"] option[value="'+response.profile.phone_code+'"]').prop("selected", true).change();
                    $('input[name="city"]').val(response.profile.city);
                    $('input[name="mobile"]').val(response.profile.phone);
                    $('input[name="email"]').val(response.profile.email);
                    $('input[name="username"]').val(response.profile.username);
                    //nav_bar
                    $('.username').text(response.profile.username);
                    $('.e-mail').text(response.profile.email);
                    // sidebar
                    $('.full_name').text(response.profile.fname+" "+response.profile.lname);
                    $('.user_type').text(response.profile.username);
                    $('.image').empty().append((response.profile.profile_img=='default.png')? '<span class="font-size-h3 symbol-label font-weight-boldest text-uppercase">'+response.profile.fname[0]+'</span>' : '<div class="symbol-label"  style="background-image:url(images/profile/'+response.profile.profile_img+')"><i class="symbol-badge symbol-badge-bottom bg-success"></div>');

                    }
              }
              break;
          }
          case 'save_profile_image':{
                _showToast(response.type,response.message);
                if(response.result!=false){
                $('#kt_profile_avatar > div').css('background-image', 'url(../)');
                $('#kt_header_mobile_topbar_toggle > span > div').css('background-image', 'url(images/profile/'+response.profile_img+')');
                $('#kt_profile_avatar').css('background-image', 'url(images/profile/'+response.profile_img+')');
                $('#kt_quick_user > div.offcanvas-content.pr-5.mr-n5.scroll > div.d-flex.align-items-center.mt-5 > div.symbol.symbol-100.mr-5.symbol-light-primary,#kt_quick_user_toggle > span').empty().append('<div class="symbol-label" style="background-image:url(images/profile/'+response.profile_img+')"></div>');
                $('.image').empty().append('<div class="symbol-label" style="background-image:url(images/profile/'+response.profile_img+')"></div>');
               }
                break;
          }
          
          
        }
    };
    // start making formdata
    var _constructForm = function(args){
          let formData = new FormData();
          for (var i = 1; (args.length+1) > i; i++){
             formData.append('data'+ i, args[i-1]);
           }  
          return formData;
    };
    var _constructBlockUi = function(type, element, message){
          let formData = new FormData();
           formData.append('type', type);
           formData.append('element', element);
           formData.append('message', message);
           if(formData){
             return formData;
           }
    };
    var _ajaxrequest = async function(blockUi, formData){
      return new Promise((resolve, reject) => {
             let y = true;
             $.ajax({
              url: base_url+'AdminController/Controller',
              type: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              dataType: "json",
              beforeSend: function(){
                if(blockUi.get("type") == "blockPage"){
                   if(blockUi.get("message") != "false"){
                      KTApp.blockPage({
                      overlayColor: '#000000',
                      state: 'primary',
                      message: blockUi.get("message")
                     });
                   }else{
                      KTApp.blockPage();
                   }
                }else if(blockUi.get("type") == "blockContent"){
                      KTApp.block(blockUi.get("element"));
                }else{
                }
              },
              complete: function(){
                if(blockUi.get("type") == "blockPage"){
                  KTApp.unblockPage();
                }else if(blockUi.get("type") == "blockContent"){
                  KTApp.unblock(blockUi.get("element"));
                }else{
                }
                 resolve(y)
              },
              success: function(res){
                 if(res.status == 'success'){
                    if(window.atob(res.payload) != false){
                      _construct(JSON.parse(window.atob(res.payload)), formData.get("data2"));
                    }else{
                      _construct(res.message, formData.get("data2"));
                    }
                 }else if(res.status == 'not_found'){
                    Swal.fire("Ops!", res.message, "info");
                 }else{
                    Swal.fire("Ops!", res.message, "info");
                 } 
              },
              error: function(xhr,status,error){
                // if(xhr.status == 200){
                //   if(xhr.responseText.trim()=="signed-out"){
                //     Swal.fire({
                //     title:"Oopps!",
                //     text: "Your account was signed-out.",
                //     icon: "info",
                //     showCancelButton: false,
                //     confirmButtonText: "Ok, Got it",
                //         reverseButtons: true
                //     }).then(function(result) {
                //       window.location.replace("login");
                //     });
                //   }else{
                //     Swal.fire("Ops!", "Check your internet connection.", "error");
                //   }
                // }else 
                if(xhr.status == 500){
                  Swal.fire("Ops!", 'Internal error: ' + xhr.responseText, "error");
                }else{
                  console.log(xhr);
                  console.log(status);
                  Swal.fire("Ops!", 'Something went wrong..', "error");
                }
              }       
        });      
       })
    };
 
  return {
    callFunction:  function(type,val1,val2,val3){
      
     },
    init: function(){
        _init();
    }
  };
}();
$(document).ready(function(){
   	APPHANDLER.init();
});




  