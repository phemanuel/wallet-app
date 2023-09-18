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
			href="back/vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="back/vendors/images/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="back/vendors/images/favicon-16x16.png"
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
		<link rel="stylesheet" type="text/css" href="back/vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="back/vendors/styles/icon-font.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="back/vendors/styles/style.css" />

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
		stack('stylesheet')
		<!-- End Google Tag Manager -->
	</head>
	<body>
		<!-- <div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-logo">
					<img src="back/vendors/images/deskapp-logo.svg" alt="" />
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
								<img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" width="50" 
										height="50" alt="" />
							</span>
							<span class="user-name">{{ auth()->user()->user_name }}</span>
						</a>
						<div
							class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
						>
							<a class="dropdown-item" href="{{ route('profile') }}"
								><i class="dw dw-user1"></i> Profile</a							>
							
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
			<div class="pd-ltr-20 height-100-p xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="title">
									<h4>Bank Refund</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="{{ route('dashboard') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Bank Refund
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					<div class="blog-wrap">
						<div class="container pd-0">
							<div class="row">
								<div class="col-md-8 col-sm-12">
									<div class="blog-list">
										<ul>
											<li>
												<div class="row no-gutters">
													<div class="col-lg-4 col-md-12 col-sm-12">
														<div class="blog-img">
															<img
																src="back/vendors/images/img7.jpg"
																alt=""
																class="bg_img"
															/>
														</div>
													</div>
													<div class="col-lg-8 col-md-12 col-sm-12">
														<div class="blog-caption">
															<h4>
																<a href="#"
																	></a
																>
															</h4>
															<div class="blog-by">
																<p align='justifyS'>
                                                                Our upcoming bank refund feature to enhance your experience with our wallet application,is not available 
                                                                at the moment.
																</p>
															</div>
														</div>
													</div>
												</div>
											</li>	
										</ul>
									</div>
									
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
		<script src="back/vendors/scripts/core.js"></script>
		<script src="back/vendors/scripts/script.min.js"></script>
		<script src="back/vendors/scripts/process.js"></script>
		<script src="back/vendors/scripts/layout-settings.js"></script>
		<!-- Google Tag Manager (noscript) -->
		stack('scripts')
		<!-- End Google Tag Manager (noscript) -->
	</body>
</html>
