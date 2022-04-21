'use strict';
var KTAjaxClient = function() {

	var _initCarousel = function(){
		$(document).ready(function () {
			    var itemsMainDiv = ('.MultiCarousel');
			    var itemsDiv = ('.MultiCarousel-inner');
			    var itemWidth = "";

			    $('.leftLst, .rightLst').click(function () {
			        var condition = $(this).hasClass("leftLst");
			        if (condition)
			            click(0, this);
			        else
			            click(1, this)
			    });

			    ResCarouselSize();


			    $(window).resize(function () {
			        ResCarouselSize();
			    });

			    //this function define the size of the items
			    function ResCarouselSize() {
			        var incno = 0;
			        var dataItems = ("data-items");
			        var itemClass = ('.item');
			        var id = 0;
			        var btnParentSb = '';
			        var itemsSplit = '';
			        var sampwidth = $(itemsMainDiv).width();
			        var bodyWidth = $('body').width();
			        $(itemsDiv).each(function () {
			            id = id + 1;
			            var itemNumbers = $(this).find(itemClass).length;
			            btnParentSb = $(this).parent().attr(dataItems);
			            itemsSplit = btnParentSb.split(',');
			            $(this).parent().attr("id", "MultiCarousel" + id);


			            if (bodyWidth >= 1200) {
			                incno = itemsSplit[3];
			                itemWidth = sampwidth / incno;
			            }
			            else if (bodyWidth >= 992) {
			                incno = itemsSplit[2];
			                itemWidth = sampwidth / incno;
			            }
			            else if (bodyWidth >= 768) {
			                incno = itemsSplit[1];
			                itemWidth = sampwidth / incno;
			            }
			            else {
			                incno = itemsSplit[0];
			                itemWidth = sampwidth / incno;
			            }
			            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
			            $(this).find(itemClass).each(function () {
			                $(this).outerWidth(itemWidth);
			            });

			            $(".leftLst").addClass("over");
			            $(".rightLst").removeClass("over");

			        });
			    }


			    //this function used to move the items
			    function ResCarousel(e, el, s) {
			        var leftBtn = ('.leftLst');
			        var rightBtn = ('.rightLst');
			        var translateXval = '';
			        var divStyle = $(el + ' ' + itemsDiv).css('transform');
			        var values = divStyle.match(/-?[\d\.]+/g);
			        var xds = Math.abs(values[4]);
			        if (e == 0) {
			            translateXval = parseInt(xds) - parseInt(itemWidth * s);
			            $(el + ' ' + rightBtn).removeClass("over");

			            if (translateXval <= itemWidth / 2) {
			                translateXval = 0;
			                $(el + ' ' + leftBtn).addClass("over");
			            }
			        }
			        else if (e == 1) {
			            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
			            translateXval = parseInt(xds) + parseInt(itemWidth * s);
			            $(el + ' ' + leftBtn).removeClass("over");

			            if (translateXval >= itemsCondition - itemWidth / 2) {
			                translateXval = itemsCondition;
			                $(el + ' ' + rightBtn).addClass("over");
			            }
			        }
			        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
			    }

			    //It is used to get some elements from btn
			    function click(ell, ee) {
			        var Parent = "#" + $(ee).parent().attr("id");
			        var slide = $(Parent).attr("data-slide");
			        ResCarousel(ell, Parent, slide);
			    }
			});
	}
	var _ajaxloader = async function(thisURL,type,val,sub){
		  $.ajax({
	             url: baseURL + thisURL,
	             type: type,
	             data: val,
	             dataType:"json",
	             beforeSend: function()
	             {

	             },
                 complete: function(){

                  },
                  success: function(response)
                  {
                  	  _initView(sub,response);
                  },
                 error: function(xhr,status,error){
                       console.log(xhr);
                       console.log(status);
                       console.log(error);
                       console.log(xhr.responseText);
                       // Swal.fire("Oopps!", "Something went wrong, Please try again later", "info");    
                 }                                      
		});	
	}
	var _ajaxForm = async function(thisURL,type,val,sub){
		$.ajax({
		  enctype: 'multipart/form-data',
              url: thisURL,
              type: type,
              data: val,
              cache: false,
	        contentType: false,
	        processData: false,
              dataType:"json",
            beforeSend: function(){
             },
            complete: function(){
             },
             success: function(response)
             {
                  _initView(sub,response);
             },
             error: function(xhr,status,error){
                       console.log(xhr);
                       console.log(status);
                       console.log(error);
                       console.log(xhr.responseText);  
              }
		});
	}



	var _ViewController = async function(view){
		switch(view){
			case "team":
			case "contact":
			case "production":
			case "index":
			case "footer":
			case "header":{
				_initCarousel();
				_ajaxloader('app/dashboard',"POST",false,"index");
				_ajaxloader('app/production',"POST",false,"production");
				_ajaxloader('app/team',"POST",false,"team");
				 $(document).on("click","#submit",function() {  
				 	alert('ok')
				       let name    =  $('#name').val();
				       let mobile  =  $('#mobile').val();
				       let email   =  $('#email').val();
				       let subject =  $('#subject').val();
				       let message =  $('#message').val();
			             let val = {name:name,mobile:mobile,email:email,subject:subject,message:message};  
			             _ajaxloader('app/contact',"POST",val,"contact");	
			       });
			       $(document).on("click",".advisor",function() {     
				         let advisor_code = $(this).attr('id');
				         let val = {advisor_code:advisor_code};
				         _ajaxloader('app/team_view',"POST",val,"team_view");
				 });
				break;
			}
			
		}
	}

	var _initView = async function(view,response)
	{
	  switch(view){
	  	case "index":{
	  		$('.advisor').attr('id',response.advisor_code);
	  		$('#fullname').text(response.fullname);
	  		$('#fullname1').text(response.fullname);

	  		$('#position').text(response.position);

	  		$('#location').text(response.location);
	  		$('#location1').text(response.location);
	  		$('#location2').text(response.location);

	  		$('#email').text(response.email);
	  		$('#email1').text(response.email);
	  		$('#email2').text(response.email);

	  		$('#mobile_no').text(response.mobile_no);
	  		$('#mobile_no1').text(response.mobile_no);
	  		$('#mobile_no2').text(response.mobile_no);
	  		$('#mobile_no3').text(response.mobile_no);

	  	
	  		$('#company').text(response.company);
	  		$('#company1').text(response.company);
	  		
	  		$('#tel_no').text(response.tel_no);
	  		$('#tel_no1').text(response.tel_no);
	  		$('#tel_no2').text(response.tel_no);

	  		$('#mission').text(response.mission);
	  		$('#vision').text(response.vision);
	  		
	  		$("#avatar").attr("src",baseURL +'vendor/images/advisor/'+response.avatar);
			$("#avatar1").attr("src",baseURL +'vendor/images/advisor/'+response.avatar);

  			$("#logo").attr("src",baseURL + 'vendor/images/webpic/'+response.logo);
  			$("#logo1").attr("src",baseURL +'vendor/images/webpic/'+response.logo);
	  		break;
	  	}
	  	case "contact":{
	  		if(data.status == 'success'){
                        swal("Good!", "Message has been successfully sent!", "success");
                        $('#name').val('');
		      	$('#mobile').val('');
		   		$('#email').val('');
		     		$('#subject').val('');
		       	$('#message').val('');
                    }
	  		break;
	  	}
	  	case "production":{
	  		var html='';
	  		html +='<table class="table table-bordered table-striped" style="background-color: white;">'
                   +'<thead><tr><th style="text-align: center; background-color: #ffbf00;" colspan="4">LIVES</th></tr>'
                   +'<tr style="background-color: #00ffff;">'
                   +'<th style="text-align: center;">TEAM</th>'
                   +'<th style="text-align: center;">'+response.year1+'</th>'
                   +'<th style="text-align: center;">'+response.year2+'</th>'
                   +'<th style="text-align: center;">'+response.year3+'</th></tr></thead><tbody>';
		  		for(let i=0;i<response.app.length;i++){
		  		 	html +='<tr><td>'+response.app[i].team+'</td>'
	                       +'<td style="text-align: right;">'+response.app[i].app_year1+'</td>'
	                       +'<td style="text-align: right;">'+response.app[i].app_year2+'</td>'
	                       +'<td style="text-align: right;">'+response.app[i].app_year3+'</td></tr>';
		  		 }
	  		  html +='<tr style="background-color:#ebf52f;">'
                    +'<td >TOTAL : </td>'
                    +'<td style="text-align: right;">'+response.app_total1+'</td>'
                    +'<td style="text-align: right;">'+response.app_total2+'</td>'
                    +'<td style="text-align: right;">'+response.app_total3+'</td></tr></tbody></table>';
                  $('#appsettled').html(html);


                  var html1='';
	  		html1 +='<table class="table table-bordered table-striped" style="background-color: white;">'
                   +'<thead><tr><th style="text-align: center; background-color: #ffbf00;" colspan="4">AC</th></tr>'
                   +'<tr style="background-color: #00ffff;">'
                   +'<th style="text-align: center;">TEAM</th>'
                   +'<th style="text-align: center;">'+response.year1+'</th>'
                   +'<th style="text-align: center;">'+response.year2+'</th>'
                   +'<th style="text-align: center;">'+response.year3+'</th></tr></thead><tbody>';
		  		for(let i=0;i<response.ac.length;i++){
		  		 	html1 +='<tr><td>'+response.ac[i].team+'</td>'
	                       +'<td style="text-align: right;">'+response.ac[i].ac_year1+'</td>'
	                       +'<td style="text-align: right;">'+response.ac[i].ac_year2+'</td>'
	                       +'<td style="text-align: right;">'+response.ac[i].ac_year3+'</td></tr>';
		  		 }
	  		  html1 +='<tr style="background-color:#ebf52f;">'
                    +'<td >TOTAL : </td>'
                    +'<td style="text-align: right;">'+response.ac_total1+'</td>'
                    +'<td style="text-align: right;">'+response.ac_total2+'</td>'
                    +'<td style="text-align: right;">'+response.ac_total3+'</td></tr></tbody></table>';
                  $('#ac').html(html1);

                  var html2='';
	  		html2 +='<table class="table table-bordered table-striped" style="background-color: white;">'
                   +'<thead><tr><th style="text-align: center; background-color: #ffbf00;" colspan="4">NSC</th></tr>'
                   +'<tr style="background-color: #00ffff;">'
                   +'<th style="text-align: center;">TEAM</th>'
                   +'<th style="text-align: center;">'+response.year1+'</th>'
                   +'<th style="text-align: center;">'+response.year2+'</th>'
                   +'<th style="text-align: center;">'+response.year3+'</th></tr></thead><tbody>';
		  		for(let i=0;i<response.nsc.length;i++){
		  		 	html2 +='<tr><td>'+response.nsc[i].team+'</td>'
	                       +'<td style="text-align: right;">'+response.nsc[i].nsc_year1+'</td>'
	                       +'<td style="text-align: right;">'+response.nsc[i].nsc_year2+'</td>'
	                       +'<td style="text-align: right;">'+response.nsc[i].nsc_year3+'</td></tr>';
		  		 }
	  		  html2 +='<tr style="background-color:#ebf52f;">'
                    +'<td >TOTAL : </td>'
                    +'<td style="text-align: right;">'+response.nsc_total1+'</td>'
                    +'<td style="text-align: right;">'+response.nsc_total2+'</td>'
                    +'<td style="text-align: right;">'+response.nsc_total3+'</td></tr></tbody></table>';
                  $('#nsc').html(html2);



	  		break;
	  	}
	  	case "team":{

	  		for(let i=0;i<response.data.length;i++){
	  		 $('#team').append('<div class="item">'
	                	  +'<div class="single-team-member-area text-center mb-100">'
	                	  +'<div class="team-thumb">'
	                    +'<img src="'+baseURL +'vendor/images/advisor/'+response.data[i].avatar+'" alt="" style="border-radius:50%;">'
	                    +'<div class="view-more">'
	                    +'<a type="button" class="advisor" id="'+response.data[i].advisor_code+'" data-toggle="modal" >+</button>'
	                    +'</div></div>'
	                    +'<p class="lead"></p>'
	                    +'<div class="team-info">'
	                    +'<p style=" font-size: 12px;">'+response.data[i].fullname+'</br>'+response.data[i].position+'</p>'
	                    +'</div></div></div>');
	            }
	  		break;
	  	}
	  	case "team_view":{
	  		var data ='';
	  		data +='<h2>'+response.fullname+' - '+response.team+'</h2>';
	  		data +='<table id="example2" class="table table-bordered" style="text-align: center; width: 100%;">'
	  			+'<thead style="background-color: #00ffff;"><th>Name</th><th>Date Coding</th></thead><tbody>';
	  		for(let i=0;i<response.data.length;i++){
	  			data +='<tr> <td>'+response.data[i].fullname+'</td><td>'+response.data[i].date_created+'</td></tr>';
	  		}
	  		data +='</tbody></table>';
  		   $('#modal_recruites').modal('show');
		   $('#table_recruites').html(data);
	  	   break;
	  	}
	  }
	}
	return {

		//main function to initiate the module
		init: function() {
			var viewForm = $('#kt_content').attr('data-table');
			_ViewController(viewForm);
			_initView();
		},

	};

}();

jQuery(document).ready(function() {
	KTAjaxClient.init();
});
		