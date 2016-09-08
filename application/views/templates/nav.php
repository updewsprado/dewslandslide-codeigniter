        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url() . $version; ?>/">DEWS Landslide <?php echo $version; ?></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Prado Arturo</strong>
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
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Prado Arturo</strong>
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
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Prado Arturo</strong>
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Prado Arturo <b class="caret"></b></a>
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
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                	<li <?php echo $monitoring; ?> >
                        <a href="<?php echo base_url() . $version; ?>/monitoring"><i class="fa fa-fw fa-th"></i> Monitoring</a>
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
                        </ul>
                    </li>
                    
                    <li></li>
                    
                    <FORM id="formGeneral">
                    <li>
	                    <div class="form-group">
	                        <label>Site:</label>
	                        <select class="form-control" name="sitegeneral" id="sitegeneral" onchange="<?php echo $showplots; ?>">
	                        </select>
	                    </div>
                    </li>
                    
                    <li>
	                    <div id="nodeGeneral" class="form-group">
	                        <label>Node:</label>
	                        <input class="form-control" name="node" id="node" onchange="<?php echo $showplots; ?>" type="number" min="1" max="41" value="" maxlength="2" size="2">
	                    </div>
                    </li>
                    
                    <li>
                        <div class="form-group">
                            <label>Database:</label>
	                        <select class="form-control" name="dbase" id="dbase">
		                        <option value="senslopedb">Raw</option>
								<option value="senslopedb_purged">Purged</option>
	                        </select>
                        </div>						
                    </li>
                    </FORM>  
                    
                    <FORM id="formDate">
                    <li>	
                    	<div class="form-group">
                            <label>Date:</label><br />                              
		                    Start: <input type="text" id="datepicker" name="dateinput" onchange="<?php echo $showdateplots; ?>" size="10"/><br />  
		                     End: <input type="text" id="datepicker2" name="dateinput2" onchange="<?php echo $showdateplots; ?>" size="10"/>
	                     </div>	
                    </li> 
                    </FORM>
                    
<!--                    
                    <li <?php echo $home; ?> >
                        <a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>                                 
                    <li <?php echo $charts; ?> >
                        <a href="<?php echo base_url(); ?>charts"><i class="fa fa-fw fa-bar-chart-o"></i> Charts</a>
                    </li>
                    <li <?php echo $tables?> >
                        <a href="<?php echo base_url(); ?>tables"><i class="fa fa-fw fa-table"></i> Tables</a>
                    </li>
                    <li <?php echo $forms; ?> >
                        <a href="<?php echo base_url(); ?>forms"><i class="fa fa-fw fa-edit"></i> Forms</a>
                    </li>
                    <li <?php echo $bselements; ?> >
                        <a href="<?php echo base_url(); ?>bselements"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
                    </li>
                    <li <?php echo $bsgrid; ?> >
                        <a href="<?php echo base_url(); ?>bsgrid"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo $blank; ?> >
                        <a href="<?php echo base_url(); ?>blank"><i class="fa fa-fw fa-file"></i> Blank Page</a>
                    </li>
-->                  
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>