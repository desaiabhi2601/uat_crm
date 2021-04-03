		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

				<!-- begin:: Aside -->

				<!-- Uncomment this to display the close button of the panel
<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
-->
				<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

					<!-- begin:: Aside -->
					<div class="kt-aside__brand kt-grid__item " id="kt_aside_brand" style="background: #fff;">
						<div class="kt-aside__brand-logo">
							<a href="index.html">
								<img alt="Logo" src="assets/media/logos/logo.png" width="150" height="50" />
							</a>
						</div>
						<div class="kt-aside__brand-tools">
							<button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
								<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon points="0 0 24 0 24 24 0 24" />
											<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) " />
											<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) " />
										</g>
									</svg></span>
								<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon points="0 0 24 0 24 24 0 24" />
											<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero" />
											<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) " />
										</g>
									</svg></span>
							</button>
						</div>
					</div>
					<!-- end:: Aside -->

					<!-- begin:: Aside Menu -->
					<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
						<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
							<ul class="kt-menu__nav ">
							<?php if(in_array('home', $this->session->userdata('module'))){ ?>
								<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true">
									<a href="<?php echo site_url('home/dashboard'); ?>" class="kt-menu__link ">
										<span class="kt-menu__link-icon">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24" />
													<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
													<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
												</g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Dashboard</span>
									</a>
								</li>
							<?php } ?>

							<?php if(in_array('quotations', $this->session->userdata('module'))){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											
											<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
											    <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
											    <title>Stockholm-icons / Communication / Clipboard-list</title>
											    <desc>Created with Sketch.</desc>
											    <defs></defs>
											    <g id="Stockholm-icons-/-Communication-/-Clipboard-list" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
											        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" id="Combined-Shape" fill="#000000" opacity="0.5"></path>
											        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" id="Combined-Shape" fill="#000000"></path>
											        <rect id="Rectangle-152" fill="#000000" opacity="1" x="10" y="9" width="7" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-2" fill="#000000" opacity="1" x="7" y="9" width="2" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-3" fill="#000000" opacity="1" x="7" y="13" width="2" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy" fill="#000000" opacity="1" x="10" y="13" width="7" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-5" fill="#000000" opacity="1" x="7" y="17" width="2" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-4" fill="#000000" opacity="1" x="10" y="17" width="7" height="2" rx="1"></rect>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Quotations</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<?php if(!in_array($this->session->userdata('role'), array(4, 5, 6, 12, 7))){?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quotations/add');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Add New</span></a></li>
											<?php } ?>
											<?php if(!in_array($this->session->userdata('role'), array(12, 13, 7))){?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quotations/list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">List</span></a></li>
											<?php } ?>
											<?php if(!in_array($this->session->userdata('role'), array(4, 5, 6, 12, 13, 7))){?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quotations/list/draft');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Draft List</span></a></li>
											<?php } ?>
											<?php if(in_array($this->session->userdata('role'), array(1, 2, 3, 5, 12, 7)) || in_array($this->session->userdata('user_id'), array(22, 23, 25, 33, 38, 39, 40))){?>
												<?php if(!in_array($this->session->userdata('user_id'), array(38, 39, 40, 29))){?>
													<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quotations/followup');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Follow Up List</span></a></li>
												<?php } ?>
												<?php if(!in_array($this->session->userdata('role'), array(12)) || in_array($this->session->userdata('user_id'), array(38, 39, 40))){?>
													<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('proforma/list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Proforma List</span></a></li>
												<?php } ?>
											<?php } ?>
										</ul>
									</div>
								</li>
							<?php } ?>

							<?php if(in_array('invoices', $this->session->userdata('module')) || in_array($this->session->userdata('user_id'), array(23))){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											
											<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
											    <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
											    <title>Stockholm-icons / Communication / Clipboard-list</title>
											    <desc>Created with Sketch.</desc>
											    <defs></defs>
											    <g id="Stockholm-icons-/-Communication-/-Clipboard-list" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
											        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" id="Combined-Shape" fill="#000000" opacity="0.5"></path>
											        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" id="Combined-Shape" fill="#000000"></path>
											        <rect id="Rectangle-152" fill="#000000" opacity="1" x="10" y="9" width="7" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-2" fill="#000000" opacity="1" x="7" y="9" width="2" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-3" fill="#000000" opacity="1" x="7" y="13" width="2" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy" fill="#000000" opacity="1" x="10" y="13" width="7" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-5" fill="#000000" opacity="1" x="7" y="17" width="2" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-4" fill="#000000" opacity="1" x="10" y="17" width="7" height="2" rx="1"></rect>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Invoices</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<?php if(!in_array($this->session->userdata('user_id'), array(23))){?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('invoices/new');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Add New</span></a></li>
											<?php } ?>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('invoices/list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">List</span></a></li>
										</ul>
									</div>
								</li>
							<?php } ?>

							<?php /*if(!in_array($this->session->userdata('user_id'), array(22, 23, 24, 25, 26)) && !in_array($this->session->userdata('role'), array(5)))*/ if(in_array($this->session->userdata('role'), array(1,2))) { ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
											    <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
											    <title>Stockholm-icons / Communication / Group</title>
											    <desc>Created with Sketch.</desc>
											    <defs></defs>
											    <g id="Stockholm-icons-/-Communication-/-Group" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
											        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
											        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero"></path>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Clients</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('client/addClients');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Add New Client</span></a></li>
											<?php if($this->session->userdata('role') == 1){ ?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('client/client_list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Client List</span></a></li>
												<!-- <li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('client/addMembers');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Add New Member</span></a></li> -->
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('client/member_list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Member List</span></a></li>
											<?php } ?>
										</ul>
									</div>
								</li>
							<?php } ?>

							<?php if(in_array('leads', $this->session->userdata('module'))){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											
											<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
											    <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
											    <title>Stockholm-icons / Communication / Clipboard-list</title>
											    <desc>Created with Sketch.</desc>
											    <defs></defs>
											    <g id="Stockholm-icons-/-Communication-/-Clipboard-list" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
											        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" id="Combined-Shape" fill="#000000" opacity="0.5"></path>
											        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" id="Combined-Shape" fill="#000000"></path>
											        <rect id="Rectangle-152" fill="#000000" opacity="1" x="10" y="9" width="7" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-2" fill="#000000" opacity="1" x="7" y="9" width="2" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-3" fill="#000000" opacity="1" x="7" y="13" width="2" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy" fill="#000000" opacity="1" x="10" y="13" width="7" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-5" fill="#000000" opacity="1" x="7" y="17" width="2" height="2" rx="1"></rect>
											        <rect id="Rectangle-152-Copy-4" fill="#000000" opacity="1" x="10" y="17" width="7" height="2" rx="1"></rect>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Leads Management</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<?php /*if($this->session->userdata('role') != 5 ){?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Fuzzy Matched</span></a></li>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/fuzzy_exp_imp_list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Fuzzy Matched - EXP - IMP - FOB</span></a></li>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/fuzzy_imp_list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Fuzzy Matched- IMP - FOB</span></a></li>
											<?php }*/ ?>
											<?php if($this->session->userdata('role') == 1){ ?>
												<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
													<a href="javascript:;" class="kt-menu__link kt-menu__toggle" style="color: #fff;">Piping</a>
													<div class="kt-menu__submenu ">
														<span class="kt-menu__arrow"></span>
														<ul class="kt-menu__subnav">
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/pipes');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Piping Products</span></a></li>
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/Shipyards');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Shipyard Companies</span></a></li>
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/Chemical Companies');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Chemical Companies</span></a></li>
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/Water Companies');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Water Companies</span></a></li>
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/EPC companies');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">EPC Companies</span></a></li>
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/sugar companies');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Sugar Companies</span></a></li>
														</ul>
													</div>
												</li>
												<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
													<a href="javascript:;" class="kt-menu__link kt-menu__toggle" style="color: #fff;">Instrumentation</a>
													<div class="kt-menu__submenu ">
														<span class="kt-menu__arrow"></span>
														<ul class="kt-menu__subnav">
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/tubes');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Tube Fittings & Valves</span></a></li>
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/process control');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Process Control</span></a></li>
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/distributors');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Tube Fitting Distributors</span></a></li>
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/Heteregenous Tubes India');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Tube Fittings & Valves India</span></a></li>
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/PVF companies');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">PVF Companies</span></a></li>
														</ul>
													</div>
												</li>
												<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
													<a href="javascript:;" class="kt-menu__link kt-menu__toggle" style="color: #fff;">Other</a>
													<div class="kt-menu__submenu ">
														<span class="kt-menu__arrow"></span>
														<ul class="kt-menu__subnav">
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/tubing');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Tubing</span></a></li>
															<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/hammer union');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Hammer Union</span></a></li>
														</ul>
													</div>
												</li>
											<?php } else if($this->session->userdata('role') == 5){ ?>
												<?php if(in_array('pipes', $this->session->userdata('sales_access')) || in_array('shipyards', $this->session->userdata('sales_access')) || in_array('chemical companies', $this->session->userdata('sales_access')) || in_array('water companies', $this->session->userdata('sales_access')) || in_array('epc companies', $this->session->userdata('sales_access')) || in_array('sugar companies', $this->session->userdata('sales_access'))){ ?>
													<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
														<a href="javascript:;" class="kt-menu__link kt-menu__toggle" style="color: #fff;">Piping</a>
														<div class="kt-menu__submenu ">
															<span class="kt-menu__arrow"></span>
															<ul class="kt-menu__subnav">
																<?php if(in_array('pipes', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/pipes');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Piping Products</span></a></li>
																<?php } if(in_array('shipyards', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/Shipyards');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Shipyard Companies</span></a></li>
																<?php } if(in_array('chemical companies', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/Chemical Companies');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Chemical Companies</span></a></li>
																<?php } if(in_array('water companies', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/Water Companies');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Water Companies</span></a></li>
																<?php } if(in_array('epc companies', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/EPC companies');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">EPC Companies</span></a></li>
																<?php } if(in_array('sugar companies', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/sugar companies');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Sugar Companies</span></a></li>
																<?php } ?>
															</ul>
														</div>
													</li>
													<?php } if(in_array('tubes', $this->session->userdata('sales_access')) || in_array('process control', $this->session->userdata('sales_access')) || in_array('distributors', $this->session->userdata('sales_access')) || in_array('heteregenous tubes india', $this->session->userdata('sales_access')) || in_array('pvf companies', $this->session->userdata('sales_access'))){ ?>
													<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
														<a href="javascript:;" class="kt-menu__link kt-menu__toggle" style="color: #fff;">Instrumentation</a>
														<div class="kt-menu__submenu ">
															<span class="kt-menu__arrow"></span>
															<ul class="kt-menu__subnav">
																<?php if(in_array('tubes', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/tubes');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Tube Fittings & Valves</span></a></li>
																<?php } if(in_array('process control', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/process control');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Process Control</span></a></li>
																<?php } if(in_array('distributors', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/distributors');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Tube Fitting Distributors</span></a></li>
																<?php } if(in_array('heteregenous tubes india', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/Heteregenous Tubes India');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Tube Fittings & Valves India</span></a></li>
																<?php } if(in_array('pvf companies', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/hetregenous_leads/PVF companies');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">PVF Companies</span></a></li>
																<?php } ?>
															</ul>
														</div>
													</li>
													<?php } if(in_array('tubing', $this->session->userdata('sales_access')) || in_array('hammer union', $this->session->userdata('sales_access'))) { ?>
													<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
														<a href="javascript:;" class="kt-menu__link kt-menu__toggle" style="color: #fff;">Other</a>
														<div class="kt-menu__submenu ">
															<span class="kt-menu__arrow"></span>
															<ul class="kt-menu__subnav">
																<?php if(in_array('tubing', $this->session->userdata('sales_access'))){ ?>
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/tubing');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Tubing</span></a></li>
																<?php } if(in_array('hammer union', $this->session->userdata('sales_access'))){ ?>	
																	<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/hammer union');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Hammer Union</span></a></li>
																<?php } ?>
															</ul>
														</div>
													</li>
													<?php } 
												} else if($this->session->userdata('role') == 13){
												if($this->session->userdata('user_id') == 42){ ?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/tubes');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Tubes</span></a></li>
												<?php } else if($this->session->userdata('user_id') == 43){ ?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('leads/primary_leads_list/pipes');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Primary Leads - Pipes</span></a></li>
											<?php }} ?>
										</ul>
									</div>
								</li>
							<?php } ?>
							<?php if(in_array('pq', $this->session->userdata('module'))){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <polygon points="0 0 24 0 24 24 0 24"/>
											        <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
											        <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000"/>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Pre Qualification</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<?php if(!in_array($this->session->userdata('role'), array(5))){ ?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('pq/add');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Add New</span></a></li>
											<?php } ?>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('pq/pending_list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Pending List</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('pq/approved_list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Approved List</span></a></li>
										</ul>
									</div>
								</li>
							<?php } ?>
							<?php if(in_array('procurement', $this->session->userdata('module'))){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <polygon points="0 0 24 0 24 24 0 24"/>
											        <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
											        <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000"/>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Procurement</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<?php if($this->session->userdata('role') == 6 || $this->session->userdata('role') == 1 || $this->session->userdata('user_id') == 22 || $this->session->userdata('user_id') == 33 || $this->session->userdata('user_id') == 38){?>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('procurement/addRFQ');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Add New</span></a></li>
											<?php } ?>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('procurement/rfq_list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">RFQ List</span></a></li>
										</ul>
									</div>
								</li>
							<?php } ?>
							<?php if(in_array('quality', $this->session->userdata('module')) || in_array($this->session->userdata('user_id'), array(23))){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <rect x="0" y="0" width="24" height="24"/>
											        <path d="M8,4 L16,4 C17.1045695,4 18,4.8954305 18,6 L18,17.726765 C18,18.2790497 17.5522847,18.726765 17,18.726765 C16.7498083,18.726765 16.5087052,18.6329798 16.3242754,18.4639191 L12.6757246,15.1194142 C12.2934034,14.7689531 11.7065966,14.7689531 11.3242754,15.1194142 L7.67572463,18.4639191 C7.26860564,18.8371115 6.63603827,18.8096086 6.26284586,18.4024896 C6.09378519,18.2180598 6,17.9769566 6,17.726765 L6,6 C6,4.8954305 6.8954305,4 8,4 Z" fill="#000000"/>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Quality</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<?php if(!in_array($this->session->userdata('user_id'), array(23))){?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quality/add_mtc');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Add MTC</span></a></li>
											<?php } ?>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quality/mtc_list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">MTC List</span></a></li>
											<?php if(!in_array($this->session->userdata('user_id'), array(23))){?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quality/add_marking');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Add Marking</span></a></li>
											<?php } ?>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quality/marking_list/proforma');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Marking List - Proforma</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quality/marking_list/sample');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Marking List - Sample</span></a></li>
										</ul>
									</div>
								</li>
							<?php } ?>
							<?php if(in_array('tasks', $this->session->userdata('module'))){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <rect x="0" y="0" width="24" height="24"/>
											        <path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z" fill="#000000"/>
											        <path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z" fill="#000000" opacity="0.3"/>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Tasks Management</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('tasks/list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Tasks List</span></a></li>
										</ul>
									</div>
								</li>
							<?php } ?>
							<?php if(in_array('vendors', $this->session->userdata('module'))){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <polygon points="0 0 24 0 24 24 0 24"/>
											        <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
											        <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000"/>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Vendors</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('vendors/add_vendor');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Add New</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('vendors/list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Vendors List</span></a></li>
										</ul>
									</div>
								</li>
							<?php } ?>
							<?php if(in_array($this->session->userdata('role'), array(1, 12))){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <rect x="0" y="0" width="24" height="24"/>
											        <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
											        <path d="M8.7295372,14.6839411 C8.35180695,15.0868534 7.71897114,15.1072675 7.31605887,14.7295372 C6.9131466,14.3518069 6.89273254,13.7189711 7.2704628,13.3160589 L11.0204628,9.31605887 C11.3857725,8.92639521 11.9928179,8.89260288 12.3991193,9.23931335 L15.358855,11.7649545 L19.2151172,6.88035571 C19.5573373,6.44687693 20.1861655,6.37289714 20.6196443,6.71511723 C21.0531231,7.05733733 21.1271029,7.68616551 20.7848828,8.11964429 L16.2848828,13.8196443 C15.9333973,14.2648593 15.2823707,14.3288915 14.8508807,13.9606866 L11.8268294,11.3801628 L8.7295372,14.6839411 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Reports</span>
											<i class="kt-menu__ver-arrow la la-angle-right"></i>
										</a>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<?php if(!in_array($this->session->userdata('role'), array(12))){?>
												<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('client/touchpoint_list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Touch Points List</span></a></li>
											<?php } ?>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('reports/daily_task_list');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Daily Task Report</span></a></li>
										</ul>
									</div>
								</li>
							<?php } if(in_array($this->session->userdata('role'), array(1, 5, 6, 8))){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <rect x="0" y="0" width="24" height="24"/>
											        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
											        <path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Queries</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quotations/query_list/sales/open');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Sales Queries - Open</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quotations/query_list/sales/closed');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Sales Queries - Closed</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quotations/query_list/proforma/open');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Proforma Queries - Open</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quotations/query_list/proforma/closed');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Proforma Queries - Closed</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quotations/query_list/purchase/open');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Purchase Queries - Open</span></a></li>
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('quotations/query_list/purchase/closed');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Purchase Queries - Closed</span></a></li>
										</ul>
									</div>
								</li>
							<?php }if($this->session->userdata('role') == 1){ ?>
								<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon" style="color: #fff;">
											
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <rect x="0" y="0" width="24" height="24"/>
											        <path d="M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
											        <path d="M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Settings</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo site_url('home/currency');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Currency Rates</span></a></li>
										</ul>
									</div>
								</li>
							<?php } ?>
								<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true">
									<a href="<?php echo site_url('home/calendar'); ?>" class="kt-menu__link ">
										<span class="kt-menu__link-icon">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											        <rect x="0" y="0" width="24" height="24"/>
											        <rect fill="#000000" opacity="0.3" x="7" y="4" width="10" height="4"/>
											        <path d="M7,2 L17,2 C18.1045695,2 19,2.8954305 19,4 L19,20 C19,21.1045695 18.1045695,22 17,22 L7,22 C5.8954305,22 5,21.1045695 5,20 L5,4 C5,2.8954305 5.8954305,2 7,2 Z M8,12 C8.55228475,12 9,11.5522847 9,11 C9,10.4477153 8.55228475,10 8,10 C7.44771525,10 7,10.4477153 7,11 C7,11.5522847 7.44771525,12 8,12 Z M8,16 C8.55228475,16 9,15.5522847 9,15 C9,14.4477153 8.55228475,14 8,14 C7.44771525,14 7,14.4477153 7,15 C7,15.5522847 7.44771525,16 8,16 Z M12,12 C12.5522847,12 13,11.5522847 13,11 C13,10.4477153 12.5522847,10 12,10 C11.4477153,10 11,10.4477153 11,11 C11,11.5522847 11.4477153,12 12,12 Z M12,16 C12.5522847,16 13,15.5522847 13,15 C13,14.4477153 12.5522847,14 12,14 C11.4477153,14 11,14.4477153 11,15 C11,15.5522847 11.4477153,16 12,16 Z M16,12 C16.5522847,12 17,11.5522847 17,11 C17,10.4477153 16.5522847,10 16,10 C15.4477153,10 15,10.4477153 15,11 C15,11.5522847 15.4477153,12 16,12 Z M16,16 C16.5522847,16 17,15.5522847 17,15 C17,14.4477153 16.5522847,14 16,14 C15.4477153,14 15,14.4477153 15,15 C15,15.5522847 15.4477153,16 16,16 Z M16,20 C16.5522847,20 17,19.5522847 17,19 C17,18.4477153 16.5522847,18 16,18 C15.4477153,18 15,18.4477153 15,19 C15,19.5522847 15.4477153,20 16,20 Z M8,18 C7.44771525,18 7,18.4477153 7,19 C7,19.5522847 7.44771525,20 8,20 L12,20 C12.5522847,20 13,19.5522847 13,19 C13,18.4477153 12.5522847,18 12,18 L8,18 Z M7,4 L7,8 L17,8 L17,4 L7,4 Z" fill="#000000"/>
											    </g>
											</svg>
										</span>
										<span class="kt-menu__link-text">Daily Report</span>
									</a>
								</li>
							
							</ul>
						</div>
					</div>

					<!-- end:: Aside Menu -->
				</div>

				<!-- end:: Aside -->

				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<!-- begin:: Header -->
					<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

						<!-- begin:: Header Menu -->

						<!-- Uncomment this to display the close button of the panel
<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
-->
						<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
							<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
								<ul class="kt-menu__nav ">
									<li class="kt-menu__item  kt-menu__item--open kt-menu__item--here kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open kt-menu__item--here kt-menu__item--active" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
										<h3 class="kt-subheader__title"><?php echo $title; ?></h3>
									</li>
									
								</ul>
							</div>
						</div>

						<!-- end:: Header Menu -->

						<!-- begin:: Header Topbar -->
						<div class="kt-header__topbar">

							<!--begin: Search -->

							<!--begin: Search -->
							<!-- <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown" id="kt_quick_search_toggle">
								<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
									<span class="kt-header__topbar-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
												<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
											</g>
										</svg> </span>
								</div>
								<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
									<div class="kt-quick-search kt-quick-search--dropdown kt-quick-search--result-compact" id="kt_quick_search_dropdown">
										<form method="get" class="kt-quick-search__form">
											<div class="input-group">
												<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
												<input type="text" class="form-control kt-quick-search__input" placeholder="Search...">
												<div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close"></i></span></div>
											</div>
										</form>
										<div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="325" data-mobile-height="200">
										</div>
									</div>
								</div>
							</div> -->

							<!--end: Search -->

							<!--end: Search -->
							<!-- add to jump -->
							<div class="kt-header__topbar-item kt-header__topbar-item--search dropdown" id="kt_quick_search_toggle">
								<p>Current Login Time: <?php echo date('d M Y h:i A', strtotime($this->session->userdata('current_login')));?><br/>
								Current IP Address: <?php echo $this->session->userdata('current_ip');?></p>
							</div>
									<div class="dropdown dropdown-inline" id="add_jump" data-toggle-="kt-tooltip" title="Quick actions" data-placement="left">
											<a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success kt-svg-icon--md">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24" />
														<path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000" />
													</g>
												</svg>

												<!--<i class="flaticon2-plus"></i>-->
											</a>

											<?php //if($this->session->userdata('role') == 5){ ?>
											<div class="dropdown-menu dropdown-menu-fit dropdown-menu-md dropdown-menu-right">

												<!--begin::Nav-->
												<ul class="kt-nav">
													
													<li class="kt-nav__item">
														<a id="task_update_btn" data-target="#daily_task_modal" data-toggle="modal" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-calendar"></i>
															<span class="kt-nav__link-text">Daily Task Update</span>
														</a>
													</li>
												</ul>

												<!--end::Nav-->
											</div>
											<?php //} ?>
										</div>
							<!-- add to jump -->

							<?php if($this->session->userdata('role') == 5){?>
							<!--begin: Notifications -->
							<div class="kt-header__topbar-item dropdown">
								<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="true">
									<span class="kt-header__topbar-icon kt-pulse kt-pulse--brand">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
												<path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
											</g>
										</svg> <span class="kt-pulse__ring"></span>
									</span>

									<!--
                Use dot badge instead of animated pulse effect:
                <span class="kt-badge kt-badge--dot kt-badge--notify kt-badge--sm kt-badge--brand"></span>
            -->
								</div>

								<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg" style="width: 1000px !important;">
									<form action="<?php echo site_url('client/clientConnect'); ?>" method="post" id="qc_frm">
										<!--begin: Head -->
										<div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background-image: url(assets/media/misc/bg-1.jpg)">
											<h3 class="kt-head__title" style="font-size: 2rem;">
												Touch Points
											</h3>
											<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist" id="qc_tabs">
												<li class="nav-item">
													<a class="nav-link active show" data-toggle="tab" href="#connect_list" role="tab" aria-selected="true" style="font-size: 1.3rem;">List</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#add_connect" role="tab" aria-selected="false" style="font-size: 1.3rem;">Add New</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#qc_performance" role="tab" aria-selected="false" style="font-size: 1.3rem;">Performance</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#qc_no_points" role="tab" aria-selected="false" style="font-size: 1.3rem;">No Touch Points</a>
												</li>
											</ul>
										</div>

										<!--end: Head -->
										<div class="tab-content container">
											<div class="tab-pane active show" id="connect_list" role="tabpanel">
												<div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
													<!-- <div class="row">
														<div class="col-md-4 form-group">
															<label for="qc_start">Start Date</label>
															<input type="text" class="form-control input-sm hasdatepicker" id="qc_start">
														</div>
														<div class="col-md-4 form-group">
															<label for="qc_start">Start Date</label>
															<input type="text" class="form-control input-sm hasdatepicker" id="qc_start">
														</div>
														<div class="col-md-4 form-group">
															<button type="button" class="btn btn-sm btn-warning" id="qc_search">Filter</button>
														</div>
													</div> -->
													<style type="text/css">
														#qc_table th{
															text-align: center;
														}
													</style>
													<table class="table table-bordered" id="qc_table">
														<thead>
															<tr>
																<th width="5%">Sr #</th>
																<th width="8%">Contacted On</th>
																<th width="20%">Client Name</th>
																<th width="17%">Person Name</th>
																<th width="8%">Contacted Via</th>
																<th width="7%">Email Sent</th>
																<th width="22%">Comments</th>
																<th width="13%">Action</th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
											<div class="tab-pane" id="add_connect" role="tabpanel">
												<div class="kt-notification kt-margin-t-10 kt-margin-b-10" data-scroll="false" data-height="300" data-mobile-height="200" id="quick_connect_div">
													<div class="row">
														<div class="col-md-6 form-group">
															<label for="qc_contacted_on">Contacted On</label>
															<input type="text" class="form-control hasdatepicker validate[required]" id="qc_contacted_on" name="qc_contacted_on" value="<?php echo date('d-m-Y'); ?>">
														</div>

														<div class="col-md-6 form-group">
															<label for="qc_client">Client</label>
															<div class="input-group">
																<select class="form-control validate[required]" id="qc_client" name="qc_client">
																	<option value="">Select</option>
																</select>
																<div class="input-group-append">
																	<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#qc_add_company">+</button>
																</div>
															</div>
														</div>

														<div class="col-md-6 form-group">
															<label for="qc_person">Person spoken to</label>
															<div class="input-group">
																<select class="form-control validate[required]" id="qc_member" name="qc_member">
																	<option value="">Select</option>
																</select>
																<div class="input-group-append">
																	<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#qc_add_member">+</button>
																</div>
															</div>
														</div>

														<div class="col-md-6 form-group">
															<label for="qc_contact_via">Contacted Via</label>
															<select class="form-control validate[required]" name="qc_contact_via" id="qc_contact_via">
																<option value="">Select</option>
																<option value="whatsapp">Whatsapp</option>
																<option value="call">Call</option>
																<option value="linkedin">LinkedIn</option>
															</select>
														</div>

														<div class="col-md-6 form-group">
															<label for="qc_email_sent" id="qc_email_sent_lbl">Email Sent</label>
															<select class="form-control" name="qc_email_sent" id="qc_email_sent">
																<option value="No">No</option>
																<option value="Yes">Yes</option>
															</select> 
														</div>

														<div class="col-md-6 form-group">
															<label for="qc_comments">Comments</label>
															<textarea class="form-control validate[required]" id="qc_comments" name="qc_comments"></textarea>
														</div>
													</div>

													<div class="row">
														<div class="col-md-3 offset-3 form-group">
															<input type="hidden" name="qc_connect_id" id="qc_connect_id" >
															<button type="submit" id="qc_submit" class="form-control btn btn-success">Submit</button>
														</div>
														<div class="col-md-3 form-group">
															<button type="button" id="qc_cancel" class="form-control btn btn-warning">Cancel</button>
														</div>
													</div>
													<style>
														#quick_connect_div .select2-container{
															width: 90% !important;
														}
													</style>
												</div>
											</div>
											<div class="tab-pane" id="qc_performance" role="tabpanel">
												<div class="kt-notification kt-margin-t-10 kt-margin-b-10" data-scroll="false" data-height="300" data-mobile-height="200" id="">
													<div class="row">
														<div class="col-md-7">
															<figure class="highcharts-figure">
															    <div id="container-touch-points"></div>
															</figure>

															<style>
																.highcharts-figure, .highcharts-data-table table {
																    min-width: 360px; 
																    max-width: 800px;
																    margin: 1em auto;
																}

																.highcharts-data-table table {
																	font-family: Verdana, sans-serif;
																	border-collapse: collapse;
																	border: 1px solid #EBEBEB;
																	margin: 10px auto;
																	text-align: center;
																	width: 100%;
																	max-width: 500px;
																}
																.highcharts-data-table caption {
																    padding: 1em 0;
																    font-size: 1.2em;
																    color: #555;
																}
																.highcharts-data-table th {
																	font-weight: 600;
																    padding: 0.5em;
																}
																.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
																    padding: 0.5em;
																}
																.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
																    background: #f8f8f8;
																}
																.highcharts-data-table tr:hover {
																    background: #f1f7ff;
																}

															</style>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-12">
																	<div class="card text-center">
																		<div class="card-body">
																			<div class="card-title">Your Average Touch-points</div>
																			<div class="row">
																				<div class="col-md-6">For <?php echo date('M'); ?> <h2 id="user_monthly_avg"></h2></div>
																				<div class="col-md-6">From Start <h2 id="user_total_avg"></h2></div>
																			</div>
																		</div>
																	</div>
																</div>

																<div class="col-md-12">
																	<div class="card text-center">
																		<div class="card-body">
																			<div class="card-title">Sales Team Average Touch-points</div>
																			<div class="row">
																				<div class="col-md-6">
																					For <?php echo date('M'); ?> <h2 id="team_monthly_avg"></h2></div>
																				<div class="col-md-6">
																					From Start <h2 id="team_monthly_connects"></h2></div>
																			</div>
																		</div>
																	</div>
																</div>

																<div class="col-md-12">
																	<div class="card text-center">
																		<div class="card-body">
																			<div class="card-title">Your Total Touch-points</div>
																			<div class="row">
																				<div class="col-md-6">For <?php echo date('M'); ?> <h2 id="user_monthly_connects"></h2></div>
																				<div class="col-md-6">From Start <h2 id="user_total_connects"></h2></div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="qc_no_points" role="tabpanel">
												<div class="kt-notification kt-margin-t-10 kt-margin-b-10" data-scroll="false" data-height="300" data-mobile-height="200" id="">
													<div class="row">
														<div class="col-md-3 form-group">
															<label for="no_date">Date</label>
															<input type="text" id="qc_no_date" class="form-control hasdatepicker" value="<?php echo date('d-m-Y'); ?>">
														</div>
														<div class="col-md-4 form-group">
															<label for="no_reason">Reason</label>
															<textarea id="qc_no_reason" class="form-control"></textarea>
														</div>
														<div class="col-md-3">
															<button style="margin-top: 50px;" type="button" class="btn btn-sm btn-warning" id="qc_updateReason">Update</button>
														</div>
													</div>
"
													<div class="row">
														<div class="offset-1 col-md-4">
															<table class="table table-bordered" id="pendingUpdate" style="text-align: center;">
																<thead>
																	<tr>
																		<td>Sr #</td>
																		<td>Touchpoints update pending</td>
																	</tr>
																</thead>
																<tbody></tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
											<!-- <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
												<div class="kt-grid kt-grid--ver" style="min-height: 200px;">
													<div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
														<div class="kt-grid__item kt-grid__item--middle kt-align-center">
															All caught up!
															<br>No new notifications.
														</div>
													</div>
												</div>
											</div> -->
										</div>
									</form>
								</div>
							</div>
							<!--end: Notifications -->

							<?php } ?>

							<div class="kt-header__topbar-item dropdown">
								<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="true" id="user_noti">
									<span class="kt-header__topbar-icon kt-pulse kt-pulse--brand">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										        <path d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z" fill="#000000"/>
										        <rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4" rx="2"/>
										    </g>
										</svg> 
										<span class="kt-pulse__ring"></span>
									</span>
								</div>
								<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg">
									<form>

										<!--begin: Head -->
										<div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background-image: url(assets/media/misc/bg-1.jpg)">
											<h3 class="kt-head__title">
												User Notifications
												&nbsp;
												<span class="btn btn-success btn-sm btn-bold btn-font-md" id="notify_count">0</span>
											</h3>
											<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist">
												<li class="nav-item" style="display: none;">
													<a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications" role="tab" aria-selected="true">Alerts</a>
												</li>
											</ul>
										</div>

										<!--end: Head -->
										<div class="tab-content">
											<div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
												<div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200" id="notify_div">
													
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>

							<!--begin: My Cart --><!--end: My Cart -->

							<!--begin: Quick panel toggler -->
							
							

							<!--end: Quick panel toggler -->

							<!--begin: Language bar -->	<!--end: Language bar -->

							<!--begin: User Bar -->
							<div class="kt-header__topbar-item kt-header__topbar-item--user">
								

								<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
									<div class="kt-header__topbar-user">
										<span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
										<span class="kt-header__topbar-username kt-hidden-mobile"><?php echo ucwords($this->session->userdata('username')); ?></span>
										<img class="kt-hidden" alt="Pic" src="assets/media/users/300_25.jpg" />

										<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
										<span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"><?php echo strtoupper(substr($this->session->userdata('name'), 0, 1)); ?></span>
									</div>
								</div>
								<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

									<!--begin: Head -->
									<div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(assets/media/misc/bg-1.jpg)">
										<div class="kt-user-card__avatar">
											<img class="kt-hidden" alt="Pic" src="assets/media/users/300_25.jpg" />

											<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
											<span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success"><?php echo strtoupper(substr($this->session->userdata('name'), 0, 1)); ?></span>
										</div>
										<div class="kt-user-card__name">
											<?php echo ucwords($this->session->userdata('name')); ?>
										</div>
										<div class="kt-user-card__badge">
											<?php 
												if($this->session->userdata('sub_users')){
													foreach ($this->session->userdata('sub_users') as $key => $value) {
														echo '<form action="'.site_url('login/otherLogin').'" method="post">
															<input type="hidden" name="current_user" value="'.$this->session->userdata('user_id').'">
															<input type="hidden" name="next_user" value="'.$value['user_id'].'">
															<button class="btn btn-sm btn-warning" type="submit">Login as '.$value['name'].'</button>
														</form><br/>
														';
													}
												}
											?>
											<a href="<?php echo site_url('login/changePassword'); ?>" class="btn btn-success btn-sm btn-bold btn-font-md">Change Password</a><br/><br/>
											<a href="<?php echo site_url('login/logout'); ?>" class="btn btn-success btn-sm btn-bold btn-font-md">Sign Out</a>
											
										</div>
									</div>

									<!--end: Head -->

									<!--begin: Navigation -->
									<!-- <div class="kt-notification">
										<a href="custom/apps/user/profile-1/personal-information.html" class="kt-notification__item">
											<div class="kt-notification__item-icon">
												<i class="flaticon2-calendar-3 kt-font-success"></i>
											</div>
											<div class="kt-notification__item-details">
												<div class="kt-notification__item-title kt-font-bold">
													My Profile
												</div>
												<div class="kt-notification__item-time">
													Account settings and more
												</div>
											</div>
										</a>
										<a href="custom/apps/user/profile-3.html" class="kt-notification__item">
											<div class="kt-notification__item-icon">
												<i class="flaticon2-mail kt-font-warning"></i>
											</div>
											<div class="kt-notification__item-details">
												<div class="kt-notification__item-title kt-font-bold">
													My Messages
												</div>
												<div class="kt-notification__item-time">
													Inbox and tasks
												</div>
											</div>
										</a>
										<a href="custom/apps/user/profile-2.html" class="kt-notification__item">
											<div class="kt-notification__item-icon">
												<i class="flaticon2-rocket-1 kt-font-danger"></i>
											</div>
											<div class="kt-notification__item-details">
												<div class="kt-notification__item-title kt-font-bold">
													My Activities
												</div>
												<div class="kt-notification__item-time">
													Logs and notifications
												</div>
											</div>
										</a>
										<a href="custom/apps/user/profile-3.html" class="kt-notification__item">
											<div class="kt-notification__item-icon">
												<i class="flaticon2-hourglass kt-font-brand"></i>
											</div>
											<div class="kt-notification__item-details">
												<div class="kt-notification__item-title kt-font-bold">
													My Tasks
												</div>
												<div class="kt-notification__item-time">
													latest tasks and projects
												</div>
											</div>
										</a>
										<a href="custom/apps/user/profile-1/overview.html" class="kt-notification__item">
											<div class="kt-notification__item-icon">
												<i class="flaticon2-cardiogram kt-font-warning"></i>
											</div>
											<div class="kt-notification__item-details">
												<div class="kt-notification__item-title kt-font-bold">
													Billing
												</div>
												<div class="kt-notification__item-time">
													billing & statements <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">2 pending</span>
												</div>
											</div>
										</a>
										<div class="kt-notification__custom kt-space-between">
											<a href="custom/user/login-v2.html" target="_blank" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
											<a href="custom/user/login-v2.html" target="_blank" class="btn btn-clean btn-sm btn-bold">Upgrade Plan</a>
										</div>
									</div> -->

									<!--end: Navigation -->
								</div>
							</div>

							<!--end: User Bar -->
						</div>

						<!-- end:: Header Topbar -->
					</div>

					<!-- end:: Header -->

<!--begin::Modal-->
<div class="modal fade" id="qc_add_company" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<?php echo form_open('', array('id' => 'addCompany', 'class' => 'kt-form kt-form--label-right'));?>
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Client</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="recipient-name" class="form-control-label">Company Name:</label>
								<input type="text" class="form-control validate[required]" id="company_name" name="company_name">
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="message-text" class="form-control-label">Country:</label>
								<select class="form-control validate[required]" id="country" name="country">
									<option value="" disbaled>Select</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="message-text" class="form-control-label">Region:</label>
								<select class="form-control validate[required]" id="region" name="region">
									<option value="" disbaled>Select</option>
								</select>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="message-text" class="form-control-label">Website:</label>
								<input type="text" class="form-control validate[custom[url]]" id="website" name="website">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add Client</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="modal fade" id="qc_add_member" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<?php echo form_open('', array('id' => 'addMember', 'class' => 'kt-form kt-form--label-right'));?>
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Company Member</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Name:</label>
							<input type="text" class="form-control validate[required]" id="name" name="name">
						</div>

						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Email:</label>
							<input type="email" class="form-control validate[required,custom[email]]" id="email" name="email">
						</div>

						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Mobile #:</label>
							<input type="number" class="form-control validate[custom[onlyNumberSp]]" id="mobile" name="mobile">
						</div>

						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Whatsapp #:</label>
							<input type="number" class="form-control validate[custom[onlyNumberSp]]" id="whatsapp" name="whatsapp">
						</div>

						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Skype ID:</label>
							<input type="text" class="form-control" id="skype" name="skype">
						</div>

						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Telephone:</label>
							<input type="number" class="form-control validate[custom[onlyNumberSp]]" id="telephone" name="telephone">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" id="addMemberBtn" class="btn btn-primary">Add Member</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="modal fade" id="daily_task_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Daily Task Update</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist" id="qc_tabs">
					<li class="nav-item">
						<a class="nav-link active show" data-toggle="tab" href="#add_new" role="tab" aria-selected="true">Add Task Update</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#view_previous" role="tab" aria-selected="false" style="font-size: 1.3rem;">View Previous Updates</a>
					</li>
				</ul>
				<div class="tab-content container">
					<div class="tab-pane active show" id="add_new" role="tabpanel">
						<?php echo form_open('', array('id' => 'taskUpdate', 'class' => 'kt-form kt-form--label-right'));?>
							<div class="row">
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label class="form-control-label">Date:</label>
										<input type="text" class="form-control hasdatepicker validate[required]" value="<?php echo date('d-m-Y'); ?>" id="date" name="date">
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label for="task_accomplished" class="form-control-label">Task Accomplished:</label>
										<textarea class="form-control validate[required]" id="task_accomplished" name="task_accomplished"></textarea>
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label for="work_in_progress" class="form-control-label">Work in Progress:</label>
										<textarea class="form-control validate[required]" id="work_in_progress" name="work_in_progress"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label for="plan_for_tomorrow" class="form-control-label">Plan Tomorrow:</label>
										<textarea class="form-control validate[required]" id="plan_for_tomorrow" name="plan_for_tomorrow"></textarea>
									</div>
								</div>
								<?php if($this->session->userdata('role') == 5){ ?>
								<div class="col-md-8 col-sm-12">
									<div class="form-group">
										<label for="touch_points" class="form-control-label">Touch Points:</label>
										<div id="touch_points_count"></div>
									</div>
								</div>
								<?php } ?>
							</div>
							<?php if($this->session->userdata('role') == 5){ ?>
							<div class="row">
								<div class="col-md-4 col-sm-12">
									<label for="ca" class="form-control-label">No of calls attempted (CA)</label>
									<input type="text" name="ca" id="ca" class="form-control validate[required,custom[onlyNumberSp]]">
								</div>

								<div class="col-md-4 col-sm-12">
									<label for="cc" class="form-control-label">No of calls connected (CC)</label>
									<input type="text" name="cc" id="cc" class="form-control validate[required,custom[onlyNumberSp]]">
								</div>

								<div class="col-md-4 col-sm-12">
									<label for="rc" class="form-control-label">No of email replies received from unique clients (RC)</label>
									<input type="text" name="rc" id="rc" class="form-control validate[required,custom[onlyNumberSp]]">
								</div>

								<div class="col-md-4 col-sm-12">
									<label for="wa" class="form-control-label">No of conversations with clients on whatsapp (WA)</label>
									<input type="text" name="wa" id="wa" class="form-control validate[required,custom[onlyNumberSp]]">
								</div>

								<div class="col-md-4 col-sm-12">
									<label for="qs" class="form-control-label">No of quotation submitted (QS)</label>
									<input type="text" name="qs" id="qs" class="form-control validate[required,custom[onlyNumberSp]]">
								</div>
							</div>
							<?php } else if($this->session->userdata('role') == 6 || $this->session->userdata('role') == 8){ ?>
							<div class="row">
								<div class="col-md-4 col-sm-12">
									<label for="rd" class="form-control-label">No of rfq done today (RD)</label>
									<input type="text" name="rd" id="rd" class="form-control validate[required,custom[onlyNumberSp]]">
								</div>

								<div class="col-md-4 col-sm-12">
									<label for="rp" class="form-control-label">No of rfq pending as of today (RP)</label>
									<input type="text" name="rp" id="rp" class="form-control validate[required,custom[onlyNumberSp]]">
								</div>

								<div class="col-md-4 col-sm-12">
									<label for="qp" class="form-control-label">Queries pending as of today (QP)</label>
									<input type="text" name="qp" id="qp" class="form-control validate[required,custom[onlyNumberSp]]">
								</div>
							</div>
							<?php } ?>
							<div class="row">
								<div class="col-md-2 offset-10">
									<input type="hidden" id="master_id" name="master_id">
									<button type="submit" class="btn btn-primary">Update</button>
									<button type="button" class="btn btn-default" id="reset">Reset</button>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
					<div class="tab-pane" id="view_previous" role="tabpanel">
						<table class="table table-bordered">
							<thead>
								<tr>
									<td>Sr #</td>
									<td>Date</td>
									<td>Task Accomplished</td>
									<td>Work in Progress</td>
									<td>Plan for Next Day</td>
									<td>Action</td>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!--end::Modal-->