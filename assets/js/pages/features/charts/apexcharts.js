"use strict";

// Shared Colors Definition
const primary = '#6993FF';
const success = '#1BC5BD';
const info = '#8950FC';
const warning = '#FFA800';
const danger = '#F64E60';

// Class definition
function generateBubbleData(baseval, count, yrange) {
    var i = 0;
    var series = [];
    while (i < count) {
      var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
      var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
      var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;
  
      series.push([x, y, z]);
      baseval += 86400000;
      i++;
    }
    return series;
  }

function generateData(count, yrange) {
    var i = 0;
    var series = [];
    while (i < count) {
        var x = 'w' + (i + 1).toString();
        var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

        series.push({
            x: x,
            y: y
        });
        i++;
    }
    return series;
}

var KTApexChartsDemo = function () {
	// Private functions
 var _initvalidation = function (graph, date) {
        let element = document.getElementById(graph);
        let ac = [];
        let nsc = [];
        let team =[];
        if (!element) {return;}
        $.ajax({
            url: base_url+"AdminController/Chart",
            type: "POST",
            data:{action: "chart",
                  type : graph,
                  date : date},
            dataType: "json",
            beforeSend: function(){
            // KTApp.blockPage();
            },
            complete: function(){
			$('#'+graph).empty();
		var options = {
						series: [{
							name: 'AC',
							data: ac
						}, {
							name: 'NSC',
							data: nsc
						}],
						chart: {
							type: 'bar',
							 height: 350
						},
						plotOptions: {
							bar: {
								horizontal: true,
								// columnWidth: '55%',
								// endingShape: 'rounded'
							},
						},
						dataLabels: {
							enabled: false
						},
						stroke: {
							show: true,
							width: 2,
							colors: ['transparent']
						},
						xaxis: {
							categories: team,
						},
						// xaxis: {
						// 	title: {
						// 		text: 'Validation'
						// 	},
						// 	labels: {
						// 	    formatter: function (val) {
						// 	      return parseFloat(val).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
						// 	    }
						// 	  }
						// },
						fill: {
							opacity: 1
						},

						tooltip: {
							y: {
								formatter: function (val) {
                                return parseFloat(val).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
                            	}
							}

						},
						colors: [primary, success]
					};
				var chart = new ApexCharts(element, options);
				chart.render();
            },
             success:function(response){
             	let total_submitted = 0;
             	let total_settled = 0;
             	let total_ac = 0;
             	let total_nsc = 0;
                if(response != false){
                  if(response.length >= 1){
                     for(var i = 0; response.length > i; i++){
                     	team.push(response[i].team);
						ac.push(Number(response[i].ac));
						nsc.push(Number(response[i].nsc));

						total_submitted += parseFloat(response[i].submitted);
						total_settled += parseFloat(response[i].settled);
						total_ac += parseFloat(response[i].ac);
						total_nsc += parseFloat(response[i].nsc);
                     }
                     $('.total_submitted').text(parseFloat(total_submitted).toFixed(2));
                     $('.total_settled').text(parseFloat(total_settled).toFixed(2));
                     $('.total_ac').text(parseFloat(total_ac).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                     $('.total_nsc').text(parseFloat(total_nsc).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                  }else{
                    const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                              toast.addEventListener('mouseenter', Swal.stopTimer)
                              toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                          })
                          Toast.fire({
                            icon: 'info',
                            title: 'Cant load sales chart!'
                          })
                  }
                }
              }         
          });
	}
	var _initvalidationSubmitted = function (graph, date) {
        let element = document.getElementById(graph);
        let submitted = [];
        let settled = [];
        let team =[];
        if (!element) {return;}
        $.ajax({
            url: base_url+"AdminController/Chart",
            type: "POST",
            data:{action: "chart",
                  type : graph,
                  date : date},
            dataType: "json",
            beforeSend: function(){
            // KTApp.blockPage();
            },
            complete: function(){
			$('#'+graph).empty();
		var options = {
						series: [{
							name: 'Submitted',
							data: submitted
						}, {
							name: 'Settled',
							data: settled
						}],
						chart: {
							type: 'bar',
							 height: 350
						},
						plotOptions: {
							bar: {
								horizontal: true,
								// columnWidth: '55%',
								// endingShape: 'rounded'
							},
						},
						dataLabels: {
							enabled: false
						},
						stroke: {
							show: true,
							width: 2,
							colors: ['transparent']
						},
						xaxis: {
							categories: team,
						},
						// xaxis: {
						// 	title: {
						// 		text: 'Validation'
						// 	},
						// 	labels: {
						// 	    formatter: function (val) {
						// 	      return parseFloat(val).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
						// 	    }
						// 	  }
						// },
						fill: {
							opacity: 1
						},

						tooltip: {
							y: {
								formatter: function (val) {
                                return parseFloat(val).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
                            	}
							}

						},
						colors: [primary, success]
					};
				var chart = new ApexCharts(element, options);
				chart.render();
            },
             success:function(response){
                if(response != false){
                  if(response.length >= 1){
                     for(var i = 0; response.length > i; i++){
                     	team.push(response[i].team);
						submitted.push(Number(response[i].submitted));
						settled.push(Number(response[i].settled));
						
                     }
                  }else{
                    const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                              toast.addEventListener('mouseenter', Swal.stopTimer)
                              toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                          })
                          Toast.fire({
                            icon: 'info',
                            title: 'Cant load sales chart!'
                          })
                  }
                }
              }         
          });
	}
	

	return {
		// public functions
		init: function (view,date) {
			if(view == 'chart_validation'){
				_initvalidation(view, date);
			}
			if(view == 'chart_validation_submitted'){
				_initvalidationSubmitted(view,date);
			}
		}
	};
}();

// jQuery(document).ready(function () {
// 	KTApexChartsDemo.init();
// });
