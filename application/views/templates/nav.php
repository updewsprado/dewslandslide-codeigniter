<!-- 
You can create a separate view (header_<your_page>) to link the css and js 
files that are used only for your specific pages and add them to the page 
composition using the controller

- Prado Arturo Bognot
 -->

</head>

<body>
    
    <div id="wrapper">

        <!-- Navigation -->
        
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <a  class=" btn btn-dark  btn-lg toggle" id="menu-toggle"> <i class="fa fa-bars"></i> </a>
            <!-- Brand and toggle get grouped for better mobile display -->

            <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse" style="position:fixed;left:7px">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- Top Menu Items -->

            <ul class="nav navbar-right top-nav">
                <a class="navbar-brand navbar-brand-centered" href="<?php echo base_url() . $version; ?>/">DEWS Landslide <?php echo $version; ?></a>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <!-- <img class="media-object" src="http://placehold.it/50x50" alt=""> -->
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $first_name; ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <!-- <img class="media-object" src="http://placehold.it/50x50" alt=""> -->
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $first_name; ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <!-- <img class="media-object" src="http://placehold.it/50x50" alt=""> -->
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $first_name; ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $first_name; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div id="sidebar-wrapper">
                <!-- <ul class="sidebar-nav"> -->

                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li <?php echo $monitoring; ?> >
                             <a href="<?php echo base_url() . $version; ?>/monitoring"><i class="fa fa-fw fa-th"></i> Sensor Monitoring</a>
                        </li>
                        <li>
                             <a href="<?php echo base_url() . $version; ?>/monitoring_dashboard"><i class="fa fa-fw fa-exclamation-triangle"></i> Alert Monitoring</a>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#dropdown_chatterbox"><i class="fa fa-fw fa-comment"></i> ChatterBox Menu<i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="dropdown_chatterbox" class="collapse">
                                <li>
                                    <a href="<?php echo base_url() . $version; ?>/chatterbox"><i class="fa fa-fw fa-comment"></i> Chatter Box <i class="text-warning">*NEW*</i> </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() . $version; ?>/responsetracker"><i class="fa fa-fw fa-bar-chart-o"> </i>Response Tracker <i class="text-warning">*BETA*</i></a>
                                </li>
                            </ul>
                        </li>
                        <li <?php echo $dropdown_chart; ?> >
                            <a href="javascript:;" data-toggle="collapse" data-target="#dropdown_chart"><i class="fa fa-fw fa-bar-chart-o"></i> Visual Charts <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="dropdown_chart" class="collapse">
                                <li>
                                    <a href="<?php echo base_url() . $version; ?>/site">Site Level</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() . $version; ?>/node">Node Level</a>
                                </li>
                                <li>
                                 <a href="<?php echo base_url() . $version; ?>/GroundMeas"> Ground Measurement</a>
                            	</li>
                            	<li>
                                      <a href="<?php echo base_url() . $version; ?>/chartlist">Sub-Surface Analysis</a>
                                </li>
                            </ul>
                        </li>
                        <li <?php echo $reportevent; ?> >
                            <a href="<?php echo base_url() . $version; ?>/nodereport"><i class="fa fa-fw fa-list-alt"></i> Report Node Status</a>
                        </li>
                        <li <?php echo $reportevent; ?> >
                            <a href="<?php echo base_url() . $version; ?>/publicrelease/faq"><i class="fa fa-fw fa-question-circle"></i> Monitoring Primer And FAQs</a>
                        </li>
                        <li <?php echo $reportevent; ?> >
                            <a href="javascript:;" data-toggle="collapse" data-target="#dropdown_public_release"><i class="fa fa-fw fa-bar-chart-o"></i> Early Warning Release <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="dropdown_public_release" class="collapse">
                                <li>
                                    <a href="<?php echo base_url() . $version; ?>/publicrelease">Release Early Warning Announcement</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() . $version; ?>/publicrelease/event/all">View All Monitoring Events</a>
                                </li>
                            </ul>
                        </li>
                        <li <?php echo $reportevent; ?> >
                            <a href="javascript:;" data-toggle="collapse" data-target="#dropdown_accomplishment"><i class="fa fa-fw fa-bar-chart-o"></i> Accomplishment Report <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="dropdown_accomplishment" class="collapse">
                                <li>
                                    <a href="<?php echo base_url() . $version; ?>/accomplishmentreport">File Accomplishment Report</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() . $version; ?>/accomplishmentreport/all">View All Accomplishment Reports</a>
                                </li>
                            </ul>
                        </li>
                        <li <?php echo $reportevent; ?> >
                            <a href="javascript:;" data-toggle="collapse" data-target="#dropdown_site_maintenance"><i class="fa fa-fw fa-bar-chart-o"></i> Site Maintenance Report <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="dropdown_site_maintenance" class="collapse">
                                <li>
                                    <a href="<?php echo base_url() . $version; ?>/sitemaintenancereport">File Site Maintenance Report</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() . $version; ?>/sitemaintenancereport/all">View All Site Maintenance Reports</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>


             <!-- /.navbar-collapse -->
        </nav>