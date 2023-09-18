<!-- Debug the user object -->

<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>@yield('pageTitle')</title>

		<!-- Site favicon -->
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="/back/vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="/back/vendors/images/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="/back/vendors/images/favicon-16x16.png"
		/>

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="/back/vendors/styles/icon-font.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />

		@stack('stylesheets')
	</head>
	<body class="login-page">
		<div class="login-header box-shadow">
			<div
				class="container-fluid d-flex justify-content-between align-items-center"
			>
				<div class="brand-logo">
					<a href="#">
						<img src="/back/vendors/images/walleticon.png" alt="" />
					</a>
				</div>
				<div class="login-menu">
					<ul>
						<li><a href="#">E-WALLET</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div
			class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
		>
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 col-lg-7">
						<img src="/back/vendors/images/register-page-img.png" alt="" />
					</div>
					<div class="col-md-6 col-lg-5">
						<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">E-Wallet Account</h2>
							</div>
							<form action="{{ route('register.save', ['id' => $id]) }}" method="POST">	
							@csrf
							@method('PUT')
							<div class="input-group custom">
								
									<input
										type="text"
										class="form-control form-control-lg @error('full_name') is-invalid @enderror"
										placeholder="Full Name" name="full_name" value="{{ $full_name }}"
									/>
									@error('full_name')
									<span class="invalid-feedback">{{ $message }}</span>
									@enderror
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>	
								<div class="input-group custom">
								
									<input
										type="text"
										class="form-control form-control-lg @error('full_name') is-invalid @enderror"
										placeholder="Course of study" name="std_course" value="{{ $std_course }}"
									/>
									@error('std_course')
									<span class="invalid-feedback">{{ $message }}</span>
									@enderror
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
							<div class="input-group custom">
								
									<input
										type="email"
										class="form-control form-control-lg @error('email_address') is-invalid @enderror"
										placeholder="Email Address" name="email" value="{{ old('email') }}"
									/>
									@error('email')
    								<span class="invalid-feedback">{{ $message }}</span>
									@enderror
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-mail"></i></span>
									</div>
								</div>	
								<div class="input-group custom">
								
									<input
										type="text"
										class="form-control form-control-lg @error('phone_no') is-invalid @enderror"
										placeholder="Mobile No" name="phone_no" value="{{ old('phone_no') }}"
									/>
									@error('phone_no')
    								<span class="invalid-feedback">{{ $message }}</span>
									@enderror
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-browser2"></i></span>
									</div>
								</div>	
								
								<div class="input-group custom">
								
									<select name="gender" class="form-control form-control-lg @error('gender') is-invalid @enderror"  >
									<option>{{ old('gender') }}</option>
									<option>Male</option>
									<option>Female</option>
									</select>
									@error('gender')
    								<span class="invalid-feedback">{{ $message }}</span>
									@enderror
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user-3"></i></span>
									</div>
								</div>
															
								<div class="input-group custom">
									<input
										type="text"
										class="form-control form-control-lg @error('user_name') is-invalid @enderror"
										placeholder="Username" name="user_name" value="{{ old('user_name') }}"
									/>
									@error('user_name')
    								<span class="invalid-feedback">{{ $message }}</span>
									@enderror
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
								<div class="input-group custom">
									<input
										type="password"
										class="form-control form-control-lg @error('password') is-invalid @enderror"
										placeholder="Password" name="password" 
									/>
									@error('password')
    								<span class="invalid-feedback">{{ $message }}</span>
									@enderror
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="dw dw-padlock1"></i
										></span>
									</div>
								</div>
								<div class="input-group custom">
									<input
										type="password"
										class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
										placeholder="Confirm Password" name="password_confirmation" 
									/>
									@error('password_confirmation')
    								<span class="invalid-feedback">{{ $message }}</span>
									@enderror
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="dw dw-padlock1"></i
										></span>
									</div>
								</div>
								<div class="row pb-30">
									<div class="col-6">
										
									</div>
									
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group mb-0">
											<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										-->
										<input type="hidden" name="account_status" value="1" />
										<input class="btn btn-primary btn-lg btn-block" type="submit" value="Create Account">
										</div>
										<div
											class="font-16 weight-600 pt-10 pb-10 text-center"
											data-color="#707373"
										>											
										</div>
										
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- js -->
		<script src="/back/vendors/scripts/core.js"></script>
		<script src="/back/vendors/scripts/script.min.js"></script>
		<script src="/back/vendors/scripts/process.js"></script>
		<script src="/back/vendors/scripts/layout-settings.js"></script>
		@stack('scripts')
	</body>
</html>
