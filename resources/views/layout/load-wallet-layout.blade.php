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
		<link
			rel="stylesheet"
			type="text/css"
			href="src/plugins/cropperjs/dist/cropper.css"
		/>
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script
			async
			src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"
		></script>
		<script
			async
			src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
			crossorigin="anonymous"
		></script>
		stack('stylesheets')
	</head>
	<body>
		<!-- <div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-logo">
					<img src="/back/vendors/images/deskapp-logo.svg" alt="" />
				</div>
				<div class="loader-progress" id="progress_div">
					<div class="bar" id="bar1"></div>
				</div>
				<div class="percent" id="percent1">0%</div>
				<div class="loading-text">Loading...</div>
			</div>
		</div> -->

		<div class="header">
			<div class="header-left">
				<div class="menu-icon bi bi-list"></div>
				<div
					class="search-toggle-icon bi bi-search"
					data-toggle="header_search"
				></div>
				<div class="header-search">
					<form>
						<div class="form-group mb-0">
							<i class="dw dw-search2 search-icon"></i>
							<input
								type="text"
								class="form-control search-input"
								placeholder="Search Here"
							/>
							<div class="dropdown">
								<a
									class="dropdown-toggle no-arrow"
									href="#"
									role="button"
									data-toggle="dropdown"
								>
									<i class="ion-arrow-down-c"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right">								
									
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="header-right">
				<div class="dashboard-setting user-notification">
					<div class="dropdown">
						<a
							class="dropdown-toggle no-arrow"
							href="#"
							
						>
							<i class="dw dw-settings2"></i>
						</a>
					</div>
				</div>
				
				<div class="user-info-dropdown">
					<div class="dropdown">
						<a
							class="dropdown-toggle"
							href="#"
							role="button"
							data-toggle="dropdown"
						>
							<span class="user-icon">
								<img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="" />
							</span>
							<span class="user-name">{{ auth()->user()->user_name }}</span>
						</a>
						<div
							class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
						>
						<a class="dropdown-item" href="{{ route('profile') }}"
								><i class="dw dw-user1"></i> Profile</a
							>
							<a class="dropdown-item" href="{{ route('contact') }}"
								><i class="dw dw-help"></i> Help</a
							>
							<a class="dropdown-item" href="{{ route('logout') }}"
								><i class="dw dw-logout"></i> Log Out</a
							>
						</div>
					</div>
				</div>
				
			</div>
		</div>

		<div class="right-sidebar">
			<div class="sidebar-title">
				<h3 class="weight-600 font-16 text-blue">
					Layout Settings
					<span class="btn-block font-weight-400 font-12"
						>User Interface Settings</span
					>
				</h3>
				<div class="close-sidebar" data-toggle="right-sidebar-close">
					<i class="icon-copy ion-close-round"></i>
				</div>
			</div>
			<div class="right-sidebar-body customscroll">
				<div class="right-sidebar-body-content">
					<h4 class="weight-600 font-18 pb-10">Header Background</h4>
					<div class="sidebar-btn-group pb-30 mb-10">
						<a
							href="javascript:void(0);"
							class="btn btn-outline-primary header-white active"
							>White</a
						>
						<a
							href="javascript:void(0);"
							class="btn btn-outline-primary header-dark"
							>Dark</a
						>
					</div>

					<h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
					<div class="sidebar-btn-group pb-30 mb-10">
						<a
							href="javascript:void(0);"
							class="btn btn-outline-primary sidebar-light"
							>White</a
						>
						<a
							href="javascript:void(0);"
							class="btn btn-outline-primary sidebar-dark active"
							>Dark</a
						>
					</div>					
				</div>
			</div>
		</div>

		<div class="left-side-bar">
			<div class="brand-logo">
				<a href="#">
					<img src="/back/vendors/images/walleticon.png" alt="" class="dark-logo" />
					<img
						src="/back/vendors/images/apple-touch-icon.png"
						alt=""
						class="light-logo"
					/>
				</a>
				<div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul id="accordion-menu">
					<li>
							<a href="{{ route('dashboard') }}" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-house"></span
								><span class="mtext">Dashboard</span>
							</a>
						</li>
					<li>
							<a href="{{ route('load-wallet') }}" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-calendar4-week"></span
								><span class="mtext">Fund Wallet</span>
							</a>
						</li>						
						
						<li>
							<a href="{{ route('pay-wallet') }}" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-back"></span
								><span class="mtext">Pay from wallet</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon bi bi-textarea-resize"></span
								><span class="mtext">Transfer Funds</span>
							</a>
							<ul class="submenu">
								<li><a href="{{ route('pay-other-wallet') }}">To other Wallet</a></li>
								<li>
									<a href="{{ route('refund-bank') }}">Refund to bank</a>
								</li>								
							</ul>
						</li>
						<li>
							<a href="{{ route('transaction-history') }}" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-receipt-cutoff"></span
								><span class="mtext">Transaction History</span>
							</a>
						</li>				
						<li>
							<div class="dropdown-divider"></div>
						</li>
						
						<li>
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon bi bi-command"></span
								><span class="mtext">Account</span>
							</a>
							<ul class="submenu">
								<li><a href="{{ route('profile') }}">Profile</a></li>
							</ul>
						</li>
						<li>
							<a href="{{ route('contact') }}" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-diagram-3"></span
								><span class="mtext">Contact</span>
							</a>
						</li>
						<li>
							<a href="{{ route('logout') }}" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-hdd-stack"></span
								><span class="mtext">Log out</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="title">
									<h4>Payment</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="{{ route('dashboard') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Fund Wallet
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					<div class="row">					
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
							<div class="card-box height-100-p overflow-hidden">
								<div class="profile-tab height-100-p">
									<div class="tab height-100-p">
										<ul class="nav nav-tabs customtab" role="tablist">
											
											<li class="nav-item">
												<a
													class="nav-link active"
													data-toggle="tab"
													href="#setting"
													role="tab"
													>Basic Information</a
												>
											</li>
										</ul>
										<div class="tab-content">										
											
											<!-- Setting Tab start -->
											<div
												class="tab-pane fade show active"
												id="setting"
												role="tabpanel"
											>
												<div class="profile-setting">
													<form action="{{ route('load-wallet-payment-save') }}" method="POST">
														@csrf														
														<ul class="profile-edit-list row">
															<li class="weight-500 col-md-6">
															@if(session('success'))
															<div class="alert alert-success">
																{{ session('success') }}
															</div>
															@endif
																<p class="text-blue h6 mb-12">
																	Confirm the details below before you proceed.
																</p>
																<hr>
                                                                <div class="form-group">
																	<strong><label>Transaction Reference</label></strong>
																	<p> {{ $transaction_id }} </p>																	
																</div>

																<div class="form-group">
																	<strong><label>Email Address</label></strong>
																	<p> {{ auth()->user()->email }} </p>																	
																</div>	

																<div class="form-group">
																	<strong><label>Mobile Number</label></strong>
																	<p> {{ auth()->user()->phone_no }} </p>		
																</div>

																<div class="form-group">
																	<strong><label>Full Name</label></strong>
																	<p> {{ auth()->user()->full_name }} </p>																	
																</div>

																<div class="form-group">
																	<strong><label>Student No</label></strong>
																	<p> {{ auth()->user()->std_no }} </p>																	
																</div>	

																<div class="form-group">
																	<strong><label>Student Course</label></strong>
																	<p> {{ auth()->user()->std_course }} </p>																	
																</div> 
																<hr>
																<div class="form-group">
																	<strong><label>Amount to fund</label></strong>
																	<input type="text" name="amount" class="form-control form-control-lg">																	
																</div> 

																<div class="form-group mb-0">
																	<input type="hidden" name="account_id" value="{{ auth()->user()->id }}"/>
																	<input type="hidden" name="email" value="{{ auth()->user()->email }}"/>
																	<input type="hidden" name="full_name" value="{{ auth()->user()->full_name }}"/>
																	<input type="hidden" name="std_no" value="{{ auth()->user()->std_no }}"/>
																	<input type="hidden" name="std_course" value="{{ auth()->user()->std_course }}"/>
																	<input type="hidden" name="phone_no" value="{{ auth()->user()->phone_no }}"/>
																	<input type="hidden" name="wallet_id" value="{{ auth()->user()->wallet_id }}"/>
																	<input type="hidden" name="transaction_type" value="Fund Wallet"/>
																	
																	<input type="hidden" name="transaction_id" value="{{ $transaction_id }}"/>
																	<input
																		type="submit"
																		class="btn btn-primary"
																		value="Proceed to Confirmation Page"
																	/>
																</div>
															</li>															
														</ul>
													</form>
												</div>
											</div>
											<!-- Setting Tab End -->
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
							<div class="pd-20 card-box height-100-p">
								<br>
							<ul class="nav nav-tabs customtab" role="tablist">
											
											<li class="nav-item">
												<a
													class="nav-link active"
													data-toggle="tab"
													href="#setting"
													role="tab"
													></a
												>
											</li>
										</ul>
								<br>
								<div class="profile-info">
								<p align='center'>
										<img
										src="back/vendors/images/debit-card.png"
										width="182" 
										height="36"
										alt=""
										class="avatar-photo"
									/>
										</p>
										<p>If you have any problem with your payment, please contact us through the following channels:<br>
- Send a mail to icttech@oyshct.edu.ng<br>
<a href="https://wa.me/2347038899203" target="_blank"><img src="back/vendors/images/WhatsAppButtonGreenSmall.png" width="169" height="34"></a>
</p>
									
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="footer-wrap pd-20 mb-20 card-box">
					OYSCHST WALLET - 2023
					
				</div>
			</div>
		</div>
		
		<!-- js -->
		<script src="/back/vendors/scripts/core.js"></script>
		<script src="/back/vendors/scripts/script.min.js"></script>
		<script src="/back/vendors/scripts/process.js"></script>
		<script src="/back/vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/cropperjs/dist/cropper.js"></script>
		<script>
			window.addEventListener("DOMContentLoaded", function () {
				var image = document.getElementById("image");
				var cropBoxData;
				var canvasData;
				var cropper;

				$("#modal")
					.on("shown.bs.modal", function () {
						cropper = new Cropper(image, {
							autoCropArea: 0.5,
							dragMode: "move",
							aspectRatio: 3 / 3,
							restore: false,
							guides: false,
							center: false,
							highlight: false,
							cropBoxMovable: false,
							cropBoxResizable: false,
							toggleDragModeOnDblclick: false,
							ready: function () {
								cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
							},
						});
					})
					.on("hidden.bs.modal", function () {
						cropBoxData = cropper.getCropBoxData();
						canvasData = cropper.getCanvasData();
						cropper.destroy();
					});
			});
		</script>
		<!-- Google Tag Manager (noscript) -->
		@stack('scripts')
	</body>
</html>
