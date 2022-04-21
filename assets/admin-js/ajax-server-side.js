"use strict";
var KTDatatablesDataSourceAjaxServer = function() {
	$.fn.dataTable.Api.register('column().title()', function() {return $(this.header()).text().trim();});
	$.fn.dataTable.ext.errMode = 'throw';
	var table;
	var initMember = function(table) {
		table = $('#'+table);
        table.DataTable().clear().destroy();
		table.DataTable({
			dom: `<'row'<'col-sm-6 text-right d-none'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
			responsive: true,
			processing: true,
			serverSide: true,
        	order: [],
        	language: {emptyTable: "No Advisor Available"},
			ajax: {
				url: base_url +'Serverside_Controller/Serverside_Members',
				type: 'POST',
			},
			columnDefs: [{ 
                    targets: [0,1,2,3,4,5,6,7],
                    className: "text-nowrap"
                },
                { targets: 0,visible: false,searchable: false},
                { responsivePriority: 1, targets: 8 },
                { responsivePriority: 2, targets: 7 },
				{
					targets: 8,
					orderable: false,
					render: function(data,type,row ) {
                    	let stat='';
						if(row[7]=='1'){
							stat='checked';
						}
						return '\
							<div class="d-flex flex-row">\
								<div class="dropdown dropdown-inline">\
									<a href="javascript:;" id="dropdownMenuButton" class="btn btn-icon btn-light btn-hover-primary btn-sm m-1" data-toggle="dropdown" aria-expanded="true">\
        									<i class="la la-cog"></i>\
        									</a>\
							        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
									    <ul class="nav nav-hoverable flex-column">\
									        <li class="nav-item">\
									            <a class="nav-link" href="javascript:;">\
									                <i class="nav-icon la la-leaf"></i>\
									                <span class="nav-text">Status</span>\
									                <span class="switch switch-sm switch-icon">\
									                    <label>\
									                        <input type="checkbox" class="update_advisor_status" '+stat+' data-status='+row[7]+' data-id='+row[8]+'><span></span>\
									                    </label>\
									                </span>\
									            </a>\
									        </li>\
									    </ul>\
									</div>\
								</div>\
								<a href="javascript:;" class="btn btn-icon btn-light btn-hover-info btn-sm m-1 view_members_user" data-status='+row[7]+'  data-id='+row[8]+'  title="Edit">\
									<i class="la la-pencil"></i>\
								</a>\
						</div>';
                	},
				},
				{
					targets: 7,
					render: function(data, type, full, meta) {
						var status = {
							'2': {'title': 'On Hold', 'state': 'warning'},
							'1': {'title': 'Active', 'state': 'success'},
							'0': {'title': 'Inactive', 'state': 'danger'}
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<div class="d-flex flex-row align-items-center"><span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
							'<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span></div>';
					},
				},

			],
		});
		$("body").delegate('#kt_search_member','click', function(e) {
								e.stopImmediatePropagation();
								e.preventDefault();
								var params = {};
								$('.datatable-input').each(function() {
									var i = $(this).data('col-index');
									if (params[i]) {
										if($(this).val()!=''){
										params[i] += '|' + $(this).val();
										}
									}
									else {
										params[i] = $(this).val();
									}
								});
								// alert(JSON.stringify(params));
								$.each(params, function(i, val) {
									// apply search params to datatable
									table.column(i).search(val ? val : '', false, false);
									// alert(val);
								});
								 table.table().draw();
							});

							$("body").delegate('#kt_reset_member','click', function(e) {
								e.stopImmediatePropagation();
								e.preventDefault();
								$('.datatable-input').each(function() {
									$(this).val('');
									table.column($(this).data('col-index')).search('', false, false);
								});
								table.table().draw();
							});
							$('div[name="kt_datepicker"]').datepicker({
								todayHighlight: true,
								templates: {
									leftArrow: '<i class="la la-angle-left"></i>',
									rightArrow: '<i class="la la-angle-right"></i>',
								},
							});
	};
	
	return {
		//main function to initiate the module
		init: function(table,action) {
			if(table == 'tbl_members'){
				initMember(table,action);
			}
			
		},
	};
}();

// jQuery(document).ready(function() {
// 	KTDatatablesDataSourceAjaxServer.init();
// });