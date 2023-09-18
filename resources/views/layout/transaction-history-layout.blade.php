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
			href="/back/src/plugins/datatables/css/dataTables.bootstrap4.min.css"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="/back/src/plugins/datatables/css/responsive.bootstrap4.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />
		<style>
			.pagination {
    display: flex;
    list-style: none;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
    padding: 0;
}

.pagination li {
    margin: 0 5px;
}

.pagination a {
    display: inline-block;
    padding: 8px 12px;
    background-color: #3490dc;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.pagination a:hover {
    background-color: #2779bd;
}
		</style>

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
		@stack('stylesheets')
	</head>
	<body>
		<!-- <div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-logo">
					<img src="/back/vendors/images/walleticon.png" alt="" />
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
			<div class="xs-pd-20-10 pd-ltr-20">
			@if(session('success'))
						<div class="alert alert-success">
							{{ session('success') }}
						</div>
						@elseif(session('error'))
						<div class="alert alert-danger">
							{{ session('error') }}
						</div>
						@endif
						<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Wallet Overview</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><strong><a href="#">Overall Total Fund(Bank Recharge)</a></strong></li>
									<li class="breadcrumb-item active" aria-current="page">
									<strong>=N={{ number_format(auth()->user()->total_money_spent, 2) }}</strong>
									</li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
							
						</div>
					</div>
				</div>
				

				<div class="row pb-10">
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark">=N={{ number_format($transactionTotal, 2) }}</div>
									<div class="font-14 text-secondary weight-500">
										Total Funds Spent
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#00eccf">
										<i class="icon-copy fa fa-money"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark">=N={{ number_format(auth()->user()->wallet_balance, 2) }}</div>
									<div class="font-14 text-secondary weight-500">
										Wallet Balance
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#ff5b5b">
										<span class="icon-copy fa fa-money"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark">=N={{ number_format(auth()->user()->total_money_transfer, 2) }}</div>
									<div class="font-14 text-secondary weight-500">
										Total Funds(Transfer)
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon">
										<i
											class="icon-copy fa fa-money"
											aria-hidden="true"
										></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark">=N={{ number_format(auth()->user()->total_money_recieved, 2) }}</div>
									<div class="font-14 text-secondary weight-500">Total Funds(Recieved)</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#09cc06">
										<i class="icon-copy fa fa-money" aria-hidden="true"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="footer-wrap pd-20 mb-20 card-box">
					<strong><a class="btn btn-outline-success" href="{{ route('transaction-history') }}">Fund Wallet/Other Payment Transactions</a></strong> | <strong><a class="btn btn-outline-info" href="{{ route('fund-transfer-history') }}">Fund Transfer Transactions</a></strong>
					| <strong><a class="btn btn-outline-dark" href="{{ route('fund-recieved-history') }}">Fund Recieved Transactions</a></strong>
					
				</div>

				<div class="card-box pb-10">
					<div class="h5 pd-20 mb-0">TRANSACTIONS</div>
					<table class="data-table table nowrap">
						<thead>
							<tr>
								<th class="table-plus">#</th>
								<th class="table-plus">Transaction ID</th>
								<th>Amount</th>
								<th>Amount Due</th>
								<th>Transaction Type</th>
								<th>Transaction Date</th>
								<th>Transaction Status</th>	
                                <th class="table-plus">Action</th>							
							</tr>
						</thead>
						<tbody>
		@if ($records->count() > 0)
			@foreach ($records as $rs)
				<tr>
					<td></td>
					<td class="table-plus">
						<div class="name-avatar d-flex align-items-center">										
							<div class="txt">
								<div class="weight-600">{{ $rs->transaction_id }}</div>
							</div>
						</div>
					</td>
					<td>{{ number_format($rs->amount, 2) }}</td>
					<td>{{ number_format($rs->amount_due, 2) }}</td>
					<td>{{ $rs->transaction_type }}</td>
					<td>{{ $rs->created_at }}</td>
					<td>
						<span
							class="badge badge-pill"
							data-bgcolor="#e7ebf5"
							data-color="#265ed7"
						>{{ $rs->transaction_status }}</span>
					</td>
                    @if ($rs->transaction_status=="successful")	
                    <td><a href="#"></a></td>
                    @else
                    <td><a href="{{ route('requery-transaction', ['id' => $rs->transaction_id]) }}" class="btn btn-info btn-sm">Re-query</a></td>                   	
                    @endif			
				</tr>
			@endforeach
		@else
		<tr>
			<td colspan="8">Transaction not available.</td>
		</tr>
		@endif

						</tbody>
					</table>								
					{{ $records->links()}}
				</div>

				<div class="title pb-20 pt-20">
					
				</div>


				<div class="footer-wrap pd-20 mb-20 card-box">
					OYSCHST WALLET - 2023
					
				</div>
			</div>
		</div>
		
		<!-- js -->
		<!-- js -->
		<script src="/back/vendors/scripts/core.js"></script>
		<script src="/back/vendors/scripts/script.min.js"></script>
		<script src="/back/vendors/scripts/process.js"></script>
		<script src="/back/vendors/scripts/layout-settings.js"></script>
		<script src="/back/src/plugins/apexcharts/apexcharts.min.js"></script>
		<!-- <script src="/back/src/plugins/datatables/js/jquery.dataTables.min.js"></script> -->
		<script src="/back/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script src="/back/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script src="/back/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script> 
		<script src="/back/vendors/scripts/dashboard3.js"></script>
		
		@stack('scripts')
	</body>
</html>
