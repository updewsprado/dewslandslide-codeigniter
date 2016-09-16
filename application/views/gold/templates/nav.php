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
     
                 <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li <?php echo $monitoring; ?> >
                     <a href="<?php echo base_url() . $version; ?>/monitoring"><i class="fa fa-fw fa-th"></i> Sensor Monitoring</a>
                    </li>
                    <li>
                     <a href="<?php echo base_url() . $version; ?>/monitoring_dashboard"><i class="fa fa-fw fa-exclamation-triangle"></i> Alert Monitoring</a>
                    </li>
                    <li>
                     <a href="<?php echo base_url() . $version; ?>/chatterbox"><i class="fa fa-fw fa-comment"></i> Chatter Box <i class="text-warning">*NEW*</i> </a>
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
                    <li <?php echo $reportevent; ?> >
                        <a href="javascript:;" data-toggle="collapse" data-target="#dropdown_public_release"><i class="fa fa-fw fa-bar-chart-o"></i> Public Release <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="dropdown_public_release" class="collapse">
                            <li>
                                <a href="<?php echo base_url() . $version; ?>/publicrelease">Report Public Release</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . $version; ?>/publicrelease/edit">Edit Previous Releases</a>
                            </li>
                             <li>
                                <a href="<?php echo base_url() . $version; ?>/publicrelease/all">Public Release All</a>
                            </li>
                        </ul>
                    </li>
 <!--                    <li <?php echo $reportevent; ?> >
                        <a href="<?php echo base_url() . $version; ?>/accomplishmentreport"><i class="fa fa-fw fa-list-alt"></i> File Accomplishment Report</a>
                    </li> -->
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

                    <li></li>
            </nav>
            
            <nav>
                    <div id="slide_right" class="slide_right_close srl_menu ">
                        <button id="button_right" class="button sbutton " data-toggle="tooltip" title="Analysis Variables"> 
                            <span id="bpright" class="glyphicon glyphicon-equalizer glyphicon-menu-left" data-target="#collapseDiv"></span>

                            <!-- <img id="bsright" src="img/menu_icon.png"/> -->
                        </button>
                        <ul class="list_menu">
                            <FORM id="formGeneral">
                               <center> <h4>Variable Analysis</h4></center><br>
                              
                                <div class="form-group  col-xs-1">
                                    <label>Site:</label>
                                </div>
                                <div class="form-group col-xs-3 in" id="siteG">
<<<<<<< HEAD
                                    <select class="form-control" name="sitegeneral" id="sitegeneral" onchange="<?php //echo $showplots; ?>">
                                    </select>
=======
        	                        <select class="form-control" name="sitegeneral" id="sitegeneral" onchange="<?php //echo $showplots; ?>">
        	                        </select>
>>>>>>> master
                                </div>

                                <div  class="form-group  col-xs-1" id="nodeGeneralname">
                                    <label >Node:</label>
                                </div>
<<<<<<< HEAD
                                <div id="nodeGeneral" class="form-group   col-xs-3 in">
                                    <input class="form-control col-xs-4" name="node" id="node" onchange="<?php //echo $showplots; ?>" type="number" min="1" max="41" value="" maxlength="2" size="2" >
                                </div>
=======
        	                    <div id="nodeGeneral" class="form-group   col-xs-3 in">
        	                        <input class="form-control col-xs-4" name="node" id="node" onchange="<?php //echo $showplots; ?>" type="number" min="1" max="41" value="" maxlength="2" size="2" >
        	                    </div>
>>>>>>> master
                                <div class="form-group  col-xs-1 dbase">
                                    <label>Filter:</label>
                                </div>
                                <div class="form-group  col-xs-3 dbase in" id="dBase">
<<<<<<< HEAD
                                    <select class="form-control dbase" name="dbase" id="dbase">
                                        <option value="raw">Raw</option>
                                        <option value="filtered">Filtered</option>
                                    </select><br>
                                </div>                     
=======
        	                        <select class="form-control dbase" name="dbase" id="dbase">
        		                        <option value="raw">Raw</option>
        								<option value="filtered">Filtered</option>
        	                        </select><br>
                                </div>				       
>>>>>>> master
                            </FORM>  
                            <FORM id="formDate">

                                        <div class="form-group col-xs-1 submitclass"  onchange="" size="10">
                                         <input id="submit"  type="button" value="Submit" onclick="<?php echo $showplots; ?>">  
                                         </div>
                                       

                            </FORM>
                             <FORM  id= "withAnnotation">
                                 <div class="form-group" > 
                                    
                                            <div id="reportrange" class="pull-left form-control cols-xs-7" style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 272px;margin-bottom: 10px;">
                                              <label >Date:</label>

                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span id="dateAnnotation"></span> <b class="caret"></b>

                                       </div>
                            </FORM>
                                        <div class="form-group">
                                        
                                         <input type="checkbox"  class="form-control "  data-toggle="toggle" data-on="Show Annotation" data-off="Hide Annotation " data-width="150" id="checkAnn">
                                          <input id="submit" class="form-control pull-right submit1"  style="" type="button" value="Submit" onclick="<?php echo $showplots; ?>">  

                                          <input id="addAnn" class="form-control pull-right btn-success"  style="" type="button" value="Add Annotation" onclick="" data-toggle="modal" data-target="#annModal">   
                                            </div>
                                         
                          </ul>
                     </div>             
            
            <!-- /.navbar-collapse -->
        </nav>
         <div id="annModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Annotation Form</h4>
              </div>
              <div class="modal-body">
              <form role="form"  id="annForm"  method="POST" autocomplete="on">
                <table class="table" id="annTable">
                    <thead>
                        <tr>
                            <th>Site_id</th>
                            <th>Timestamp</th>
                            <th>Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control" id="site_id" name="site_id" value="<?php echo $site ?>" disabled= "disabled" ></td>
                            <td><div class='input-group date datetime' id="entry">
                    <input type='text' class="form-control" id="tsAnnotation" name="tsAnnotation" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div> </td>
                            <td><textarea class="form-control" rows="1" id="comment"></textarea></td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info btn-md" data-dismiss="modal" id="annSave" onclick="saveAnn()">Save</button>
              </div>
            </div>
            </form>
          </div>
        </div>
        <div class="modal fade" id="endModal" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <p>Succesfully Added</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"   onclick="myFunction1()">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="anModal" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close dismissbtn" data-dismiss="modal" >&times;</button>
                      <h4 class="modal-title">Annotation Report</h4>
                    </div>
                    <div class="modal-body">
                      <p id="link"> </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default dismissbtn" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
