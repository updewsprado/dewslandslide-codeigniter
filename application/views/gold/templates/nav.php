        <!-- Navigation -->
        
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <a  class=" btn btn-dark  btn-lg toggle" id="menu-toggle"> <i class="fa fa-bars"></i> </a>
            <!-- Brand and toggle get grouped for better mobile display -->
            <!-- <div class="navbar-header">
                <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                
            </div> -->
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
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
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
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
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
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
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
                    <a id="menu-close" href="#" class="btn btn-danger pull-right hidden-md hidden-lg toggle"><i class="fa fa-times"></i></a> 
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
                            <li  >
                                 <a href="<?php echo base_url() . $version; ?>/GroundMeas"> Ground Measurement</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo $reportevent; ?> >
                        <a href="<?php echo base_url() . $version; ?>/nodereport"><i class="fa fa-fw fa-list-alt"></i> Report Node Status</a>
                    </li>
                    <li <?php echo $dropdown_chart; ?> >
                        <a href="javascript:;" data-toggle="collapse" data-target="#dropdown_public_release"><i class="fa fa-fw fa-bar-chart-o"></i> Public Release <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="dropdown_public_release" class="collapse">
                            <li>
                                <a href="<?php echo base_url() . $version; ?>/publicreleaseinput">Report Public Release</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . $version; ?>/publicreleaseedit">Edit Previous Releases</a>
                            </li>
                             <li>
                                <a href="http://www.dewslandslide.com/ajax/publicreleaseall2.php">Public Release All</a>
                            </li>
                        </ul>
                    </li>
 <!--                    <li <?php echo $reportevent; ?> >
                        <a href="<?php echo base_url() . $version; ?>/accomplishmentreport"><i class="fa fa-fw fa-list-alt"></i> File Accomplishment Report</a>
                    </li> -->

                    <li <?php echo $reportevent; ?> >
                        <a href="javascript:;" data-toggle="collapse" data-target="#dropdown_report_forms"><i class="fa fa-fw fa-list-alt"></i> Report Forms <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="dropdown_report_forms" class="collapse">
                            <li>
                                <a href="<?php echo base_url() . $version; ?>/accomplishmentreport">File Accomplishment Report</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . $version; ?>/sitemaintenancereport">File Site Maintenance Report</a>
                            </li>
                        </ul>
                    </li>

                    <li></li>
            </nav>
            <nav>
                    <div id="slide_right" class="slide_right_close srl_menu">
                        <button id="button_right" class="button sbutton " data-toggle="tooltip" title="Variable Analysis"> 
                            <span id="bpright" class="glyphicon glyphicon-equalizer glyphicon-menu-left" data-target="#collapseDiv"></span>

                            <!-- <img id="bsright" src="img/menu_icon.png"/> -->
                        </button>
                        <ul class="list_menu">
                            <FORM id="formGeneral">
                               <center> <h4>Variable Analysis</h4></center><br>
                              
        	                    <div class="form-group  col-xs-1">
        	                        <label>Site:</label>
                                </div>
                                <div class="form-group    col-xs-3 " id="siteG">
        	                        <select class="form-control" name="sitegeneral" id="sitegeneral" onchange="<?php //echo $showplots; ?>">
        	                        </select>
                                </div>

        	                    <div  class="form-group  col-xs-1" id="nodeGeneralname">
                                    <label >Node:</label>
                                </div>
        	                    <div id="nodeGeneral" class="form-group   col-xs-3">
        	                        <input class="form-control col-xs-4" name="node" id="node" onchange="<?php //echo $showplots; ?>" type="number" min="1" max="41" value="" maxlength="2" size="2" >
        	                    </div>
                                <div class="form-group  col-xs-1">
                                    <label>Filter:</label>
                                </div>
                                <div class="form-group  col-xs-3 " id="dBase">
        	                        <select class="form-control" name="dbase" id="dbase">
        		                        <option value="raw">Raw</option>
        								<option value="filtered">Filtered</option>
        	                        </select><br>
                                </div>				       
                            </FORM>  
                            <FORM id="formDate">
                                       <!--  <h4>Date:</h4> -->
                                        <div class="form-group col-xs-2" > 
                                         
                                            <div class="form-group col-xs-1" id="om">
                                                <label > From: </label>
                                             </div>
                                         </div>   
                                             <input type="text" id="datepicker" class="col-xs-3 " name="dateinput" onchange="" size="10"> 
                                             <div class="form-group col-xs-1" id-"yow">
                                                 <label >    To:  </label>
                                             </div>     
            		                           <input type="text" id="datepicker2" class="col-xs-3" name="dateinput2">
                                        <div class="form-group col-xs-1"  onchange="" size="10">
                                         <input id="submit" type="button" value="Submit" onclick="<?php echo $showplots; ?>">  
                                         </div>
                                       

                            </FORM>
                          </ul>
                     </div>             
            
            <!-- /.navbar-collapse -->
        </nav>