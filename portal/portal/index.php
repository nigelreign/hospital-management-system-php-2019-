<?
require_once '../page_includes/connections.php';
require_once '../inc/head.php';

?>
<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading">
<? require_once '../page_includes/aside.php' ?>
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid page">
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <? require_once '../page_includes/top_bar.php' ?>
            <? require_once '../page_includes/breadcrumb.php' ?>
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="d-flex flex-column-fluid">

                    <div class="container">
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-xl-4">
                                <!--begin::Stats Widget 1-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-6">
                                        <h3 class="card-title">
                                            <span class="card-label font-weight-bolder font-size-h4 text-dark-75">Total Patients</span>
                                        </h3>
                                        <div class="card-toolbar">
                                            <div class="dropdown dropdown-inline" data-toggle="tooltip"
                                                 title="Quick actions" data-placement="left">
                                                <a href="#"
                                                   class="btn btn-icon-primary btn-clean btn-hover-light-primary btn-sm btn-icon"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<span class="svg-icon svg-icon-lg">
																<!--begin::Svg Icon | path:/keen/theme/demo6/dist/assets/media/svg/icons/Text/Dots.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1">
																		<rect x="14" y="9" width="6" height="6" rx="3"
                                                                              fill="black"/>
																		<rect x="3" y="9" width="6" height="6" rx="3"
                                                                              fill="black" fill-opacity="0.7"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                                    <!--begin::Navigation-->
                                                    <ul class="navi navi-hover py-5">
                                                        <li class="navi-item">
                                                            <a href="manage-patients" class="navi-link">
																		<span class="navi-icon">
																			<span class="svg-icon svg-icon-md svg-icon-primary">
																				<!--begin::Svg Icon | path:/keen/theme/demo6/dist/assets/media/svg/icons/Communication/Add-user.svg-->
																				<svg xmlns="http://www.w3.org/2000/svg"
                                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                     width="24px" height="24px"
                                                                                     viewBox="0 0 24 24" version="1.1">
																					<g stroke="none" stroke-width="1"
                                                                                       fill="none" fill-rule="evenodd">
																						<polygon
                                                                                                points="0 0 24 0 24 24 0 24"/>
																						<path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                                                              fill="#000000"
                                                                                              fill-rule="nonzero"
                                                                                              opacity="0.3"/>
																						<path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                                                              fill="#000000"
                                                                                              fill-rule="nonzero"/>
																					</g>
																				</svg>
                                                                                <!--end::Svg Icon-->
																			</span>
																		</span>
                                                                <span class="navi-text">Manage Patients</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <!--end::Navigation-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body d-flex align-items-center justify-content-between pt-7 flex-wrap">
                                        <!--begin::label-->
                                        <span class="font-weight-bolder display5 text-dark-75 py-4 pl-5 pr-5">
												<span class="font-weight-normal font-size-h6 text-muted pr-1"></span><?php
                                            $query = DB::query("SELECT * FROM patients");
                                            echo DB::count();

                                            ?></span>
                                        <!--end::label-->
                                        <!--begin::Chart-->
                                        <div class="progress-vertical w-200px h-125px">
                                            <div class="progress bg-light-primary" data-toggle="tooltip" title="30%">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                     style="height: 30%" aria-valuenow="30" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress bg-light-primary" data-toggle="tooltip" title="80%">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                     style="height: 80%" aria-valuenow="30" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress bg-light-primary" data-toggle="tooltip" title="50%">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                     style="height: 50%" aria-valuenow="30" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress bg-light-primary" data-toggle="tooltip" title="15%">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                     style="height: 15%" aria-valuenow="30" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress bg-light-primary" data-toggle="tooltip" title="30%">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                     style="height: 30%" aria-valuenow="30" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress bg-light-primary" data-toggle="tooltip" title="70%">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                     style="height: 70%" aria-valuenow="30" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Stats Widget 1-->
                            </div>

                            <div class="col-xl-4">
                                <!--begin::Stats Widget 2-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-6">
                                        <h3 class="card-title">
                                            <span class="card-label font-weight-bolder font-size-h4 text-dark-75">Admitted Patients</span>
                                        </h3>
                                        <div class="card-toolbar">
                                            <div class="dropdown dropdown-inline" data-toggle="tooltip"
                                                 title="Quick actions" data-placement="left">

                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body d-flex align-items-center justify-content-between pt-7 flex-wrap">
                                        <!--begin::Label-->
                                        <span class="font-weight-bolder display5 text-dark-75 pl-5 pr-10"><?php
                                            $query = DB::query("SELECT * FROM patients where status = 1");
                                            echo DB::count();

                                            ?></span>
                                        <!--end::Label-->
                                        <!--begin::Visuals-->
                                        <!--end::Visuals-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Stats Widget 2-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin::Stats Widget 3-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-6">
                                        <h3 class="card-title">
                                            <span class="card-label font-weight-bolder font-size-h4 text-dark-75">Total Wards</span>
                                        </h3>
                                        <div class="card-toolbar">
                                            <div class="dropdown dropdown-inline" data-toggle="tooltip"
                                                 title="Quick actions" data-placement="left">
                                                <a href="#"
                                                   class="btn btn-icon-primary btn-clean btn-hover-light-primary btn-sm btn-icon"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<span class="svg-icon svg-icon-lg">
																<!--begin::Svg Icon | path:/keen/theme/demo6/dist/assets/media/svg/icons/Text/Dots.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1">
																		<rect x="14" y="9" width="6" height="6" rx="3"
                                                                              fill="black"/>
																		<rect x="3" y="9" width="6" height="6" rx="3"
                                                                              fill="black" fill-opacity="0.7"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                                    <!--begin::Navigation-->
                                                    <ul class="navi navi-hover py-5">
                                                        <li class="navi-item">
                                                            <a href="manage-wards.php" class="navi-link">
																		<span class="navi-icon">
																			<span class="svg-icon svg-icon-md svg-icon-primary">
																				<!--begin::Svg Icon | path:/keen/theme/demo6/dist/assets/media/svg/icons/Code/Settings4.svg-->
																				<svg xmlns="http://www.w3.org/2000/svg"
                                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                     width="24px" height="24px"
                                                                                     viewBox="0 0 24 24" version="1.1">
																					<g stroke="none" stroke-width="1"
                                                                                       fill="none" fill-rule="evenodd">
																						<rect x="0" y="0" width="24"
                                                                                              height="24"/>
																						<path d="M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z"
                                                                                              fill="#000000"
                                                                                              fill-rule="nonzero"
                                                                                              opacity="0.3"/>
																						<path d="M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                                                              fill="#000000"/>
																					</g>
																				</svg>
                                                                                <!--end::Svg Icon-->
																			</span>
																		</span>
                                                                <span class="navi-text">View wards</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <!--end::Navigation-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body d-flex align-items-center justify-content-between pt-7 flex-wrap">
                                        <!--begin::label-->
                                        <span class="font-weight-bolder display5 text-dark-75 pl-5 pr-10"><?php
                                            $query = DB::query("SELECT * FROM wards");
                                            echo DB::count();

                                            ?></span>
                                        <!--end::label-->
                                        <!--begin::Chart-->
                                        <div id="kt_stats_widget_3_chart" class="w-200px"></div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Stats Widget 3-->
                            </div>

                            <div class="col-xl-4">
                                <!--begin::Stats Widget 3-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-6">
                                        <h3 class="card-title">
                                            <span class="card-label font-weight-bolder font-size-h4 text-dark-75">Occupied Wards</span>
                                        </h3>
                                        <div class="card-toolbar">
                                            <div class="dropdown dropdown-inline" data-toggle="tooltip"
                                                 title="Quick actions" data-placement="left">
                                                <a href="#"
                                                   class="btn btn-icon-primary btn-clean btn-hover-light-primary btn-sm btn-icon"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<span class="svg-icon svg-icon-lg">
																<!--begin::Svg Icon | path:/keen/theme/demo6/dist/assets/media/svg/icons/Text/Dots.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1">
																		<rect x="14" y="9" width="6" height="6" rx="3"
                                                                              fill="black"/>
																		<rect x="3" y="9" width="6" height="6" rx="3"
                                                                              fill="black" fill-opacity="0.7"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                                    <!--begin::Navigation-->
                                                    <ul class="navi navi-hover py-5">
                                                        <li class="navi-item">
                                                            <a href="manage-wards.php" class="navi-link">
																		<span class="navi-icon">
																			<span class="svg-icon svg-icon-md svg-icon-primary">
																				<!--begin::Svg Icon | path:/keen/theme/demo6/dist/assets/media/svg/icons/Code/Settings4.svg-->
																				<svg xmlns="http://www.w3.org/2000/svg"
                                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                     width="24px" height="24px"
                                                                                     viewBox="0 0 24 24" version="1.1">
																					<g stroke="none" stroke-width="1"
                                                                                       fill="none" fill-rule="evenodd">
																						<rect x="0" y="0" width="24"
                                                                                              height="24"/>
																						<path d="M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z"
                                                                                              fill="#000000"
                                                                                              fill-rule="nonzero"
                                                                                              opacity="0.3"/>
																						<path d="M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                                                              fill="#000000"/>
																					</g>
																				</svg>
                                                                                <!--end::Svg Icon-->
																			</span>
																		</span>
                                                                <span class="navi-text">View wards</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <!--end::Navigation-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body d-flex align-items-center justify-content-between pt-7 flex-wrap">
                                        <!--begin::label-->
                                        <span class="font-weight-bolder display5 text-dark-75 pl-5 pr-10"><?php
                                            $query = DB::query("SELECT * FROM wards where status = 1");
                                            echo DB::count();

                                            ?></span>
                                        <!--end::label-->
                                        <!--begin::Chart-->
                                        <div id="kt_stats_widget_3_chart" class="w-200px"></div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Stats Widget 3-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <? require_once '../page_includes/page_footer.php' ?>
        </div>
    </div>
</div>

<? require_once '../inc/footer.php' ?>

<script src="../../assets/js/pages/widgetsb68f.js?v=2.0.7"></script>
