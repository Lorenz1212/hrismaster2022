<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
		<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold my-1 mr-5">Employee List</h5>
					<!--end::Page Title-->
				</div>
				<!--end::Page Heading-->
			</div>
			<!--end::Info-->
		</div>
	</div>
<!--end::Subheader-->
   		<div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom card-stretch gutter-bs">
                    <div class="card-body p-0" >
                        <div class="card-body">
                            <form class="mb-15" id="search_member">
                                <div class="row mb-6">
                                    <div class="col-md-6 col-lg-4 col-xl-2 mb-lg-0 mb-6" >
                                        <div search-bar="2">
                                        <label>Username:</label>
                                        <input type="text" class="form-control datatable-input" placeholder="Username" data-col-index="2" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-2 mb-lg-0 mb-6" >
                                        <div search-bar="2">
                                        <label>First name:</label>
                                        <input type="text" class="form-control datatable-input" placeholder="First name" data-col-index="10" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-2 mb-lg-0 mb-6" >
                                        <div search-bar="2">
                                        <label>Last name:</label>
                                        <input type="text" class="form-control datatable-input" placeholder="Last name" data-col-index="11" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-2 mb-lg-0 mb-6">
                                        <div  search-bar="3">
                                        <label>Email:</label>
                                        <input type="text" class="form-control datatable-input" placeholder="Email" data-col-index="3" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-2 mb-lg-0 mb-6" >
                                        <div search-bar="5">
                                        <label>Date Registered:</label>
                                        <div class="input-daterange input-group" name="kt_datepicker">
                                            <input type="text" class="form-control datatable-input" autocomplete="off" name="start" placeholder="From" data-col-index="5" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-ellipsis-h"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control datatable-input" autocomplete="off" name="end" placeholder="To" data-col-index="5" />
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-2 mb-lg-0 mb-6 d-flex align-self-end justify-content-center" >
                                        <button class="btn btn-primary btn-primary--icon" id="kt_search_member"><span><i class="la la-search"></i><span>Search</span></span></button>&#160;&#160;
                                        <button class="btn btn-secondary btn-secondary--icon" id="kt_reset_member"><span><i class="la la-close"></i><span>Reset</span></span></button>
                                    </div>
                                    
                                </div>
                            </form>
                            <table class="table table-head-custom table-head-bg table-vertical-center table-bordered table-hover" id="tbl_members" >
                                <thead>
                                    <tr>
                                        <th>COUNT</th>
                                        <th>MEMBER</th>
                                        <th>USERNAME</th>
                                        <th>POSITION</th>
                                        <th>DATE REGISTERED</th>
                                        <th>EMAIL</th>
                                        <th>MOBILE</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
