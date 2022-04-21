<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../../../">
		<meta charset="utf-8" />
		<title><?php echo $this->appinfo->app_company() ?> | Forgot Password </title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="<?php echo base_url('assets/css/pages/login/classic/login-3.css') ?>" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="<?php echo base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/plugins/custom/prismjs/prismjs.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/css/themes/layout/header/base/light.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/css/themes/layout/header/menu/light.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/css/themes/layout/brand/dark.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/css/themes/layout/aside/dark.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/media/logos/favicon.ico') ?>" rel="shortcut icon"/>
		<!--end::Layout Themes-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-3 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url(<?php echo $this->appinfo->admin_bg();?>);">
					<div class="login-form text-center text-white p-7 position-relative overflow-hidden">
						<div class="d-flex flex-center mb-15">
							<a href="javascript:;">
								<img src="<?php echo $this->appinfo->app_logo();?>"  class="max-h-70px img-fluid" alt="" />
							</a>
						</div>
						<div class="login-passReset">
			                <div class="mb-20">
			                    <h3 class="opacity-40 font-weight-normal text-white ">Create New Password</h3>
			                    <p class="opacity-40 text-white ">Fill the form below to change your password</p>
			                </div>
			                <form class="form" id="kt_login_passReset_form">
			                    <div class="form-group">
			                        <!-- <input type="hidden" name="selector" value="<?php echo $selector; ?>"> -->
			                        <input type="hidden" name="reset_validator" value="<?php echo $_GET['validator'] ?>">
			                        <input type="hidden" id="reset_token" name="reset_token" value="'.$token.'">
			                        <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" placeholder="Enter new password" name="password"/>
			                    </div>
			                    
			                    <div class="form-group">
			                        <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" placeholder="Confirm Password" name="cpassword"/>
			                    </div>


			                    <div class="form-group text-center mt-10">
			                        <button id="kt_login_passReset_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3">Confirm</button>
			                    </div>
			                </form>
			            </div>
					</div>
				</div>
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script type="text/javascript">
			var base_url = "<?php echo base_url(); ?>";
		</script>
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/custom/prismjs/prismjs.bundle.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/scripts.bundle.js')?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/admin-js/login.js') ?>"></script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>