<!-- ChatterBox CSS -->
<link rel="stylesheet" type="text/css" href="/css/third-party/awesomplete.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewschatterbox.css">

<script src="/js/dewslandslide/communications/dewschatterbox.js"></script>
<script src="/js/third-party/awesomplete.js"></script>
<script src="/js/third-party/handlebars.js"></script>
<script src="/js/third-party/moment-locales.js"></script>
<script src="/js/third-party/bootstrap-tagsinput.js"></script>

<div id="chatterbox-page-wrapper">

<!-- WEBSITE SERVER INDICATOR -->
<div class="row" id="testing-site-indicator">
  <div class="col-md-3">
      <strong><span>TEST SITE</span></strong>
  </div>
</div>
<!-- WEBSITE SERVER INDICATOR -->

  <div class="row">
    <div id="search-contacts" class="col-md-3">
      <label>Search for contact:</label><Br/>
      <input class="dropdown-input" placeholder="Type name..." data-multiple />
      <button type="button" class="btn btn-xs btn-primary" id="go-chat" data-toggle="tooltip" title="">Go Chat!</button><Br/>
    </div>
    <div id="div-advanced-search" class="col-md-6">
      <button type="button" class="btn btn-link btn-sm" id="btn-advanced-search" 
      data-toggle="modal" data-toggle="tooltip" title="Quick Group Selection">
      <span class="glyphicon glyphicon-list-alt"></span>
      </button>

      <button type="button" class="btn btn-link btn-sm" id="btn-contact-settings" 
      data-toggle="modal" data-toggle="tooltip" title="Contact Settings"><span class="glyphicon glyphicon-user"></span>
      </button>
      
      <button type="button" class="btn btn-link btn-sm" id="btn-gbl-search" title="Search Message"><span class="glyphicon glyphicon-search"></span></button>
    </div>
  </div>

<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-tabs inbox-tab">
      <li class="active"><a data-toggle="tab" href="#registered">Registered</a></li>
      <li><a data-toggle="tab" href="#unknown">Unknown</a></li>
    </ul>
    <div class="tab-content">
      <div id="registered" class="tab-pane fade in active">
        <h1></h1>
        <ul id="quick-inbox-display" class="friend-list">        
        </ul>
      </div>
      <div id="unknown" class="tab-pane fade">
        <h1></h1>
        <ul id="quick-inbox-unknown-display" class="friend-list">
        </ul>
      </div>
    </div>

    <div id="current-contacts" class="col-md-8 col-sm-6 col-xs-8">
      <div id="search-lbl" class="bg-success">
        <div>
          <h4 ></h4> <span class="glyphicon glyphicon-search" id="btn-standard-search"></span>
        </div>
        <input type="text" id="search-key" class="form-control" placeholder="Search for..." hidden>
      </div>    
    </div>


  </div>
  <div class="col-md-9">
    <div id="main-container" class="col-md-8 hidden">
      <div class="chat-message">
        <ul id="messages" class="chat"></ul>
      </div>
      <div class="chat-box bg-white">
        <div class="row">
          <div class="col-xs-10">
            <textarea id="msg" name="msg" class="form-control border no-shadow no-rounded" placeholder="Type your message here" rows="4"></textarea>
          </div>
          <div class="col-xs-2" id="chat-commands">
            <span id="sms-msg-wrapper" data-toggle="tooltip" title="">
              <button class="btn btn-success no-rounded" type="button" id="send-msg">Send</button>
            </span>
          </div>
          <div class="col-xs-2" id="chat-commands">
            <button class="btn btn-primary no-rounded" type="button" id="btn-ewi"
            data-toggle="modal" data-dismiss="modal" data-target="#early-warning-modal">EWI</button>
          </div>
        </div>
        <p>Remaining characters: <b id="remaining_chars">800</b></p>
      </div>            
    </div>  
  </div>
</div>

<div class="row">

</div>
</div>
<script type="text/javascript">
  first_name = "<?php echo $first_name; ?>";
  tagger_user_id = "<?php echo $user_id; ?>";
</script>

<!-- Modal: Advanced Search Options -->
<div class="modal fade col-lg-10" id="advanced-search" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-info">Quick Group Selection of Recipients</h4>
      </div>
      <div class="modal-body row-fluid">

        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#comm-group" id="comm-grp-flag">Community Group Selection</a></li>
          <li><a data-toggle="tab" href="#emp-group" id="emp-grp-flag">Employee Group Selection<i class="text-warning"> *BETA*</i></a></li>
        </ul>

        <div class="tab-content grp-selection">
          <div id="comm-group" class="tab-pane fade in active">
            <div class="row">
              <p>Select Offices:
                <button id="checkAllOffices" type="button" class="btn btn-primary btn-xs">Check All</button>
                <button id="uncheckAllOffices" type="button" class="btn btn-info btn-xs">Uncheck All</button>
              </p>
              <div id="modal-select-offices">
                <div id="offices-0" class="col-md-2 col-sm-2 col-xs-2"></div>
                <div id="offices-1" class="col-md-2 col-sm-2 col-xs-2"></div>
                <div id="offices-2" class="col-md-2 col-sm-2 col-xs-2"></div>
                <div id="offices-3" class="col-md-2 col-sm-2 col-xs-2"></div>
                <div id="offices-4" class="col-md-2 col-sm-2 col-xs-2"></div>
                <div id="offices-5" class="col-md-2 col-sm-2 col-xs-2"></div>
              </div>
            </div>
            <div class="row">
              <p>Early Warning Information Recipients:</p>
              <div id="modal-select-recipients">
                <label class="opt-ewi-recipients"><input type="radio" name="opt-ewi-recipients" value="false" checked="true">All</label>
                <label class="opt-ewi-recipients"><input type="radio" name="opt-ewi-recipients" value="true">Only selected EWI Receivers</label>
              </div>
            </div>
            <Br/>
            <div class="row">
              <p>Select Site Names:
                <button id="checkAllSitenames" type="button" class="btn btn-primary btn-xs">Check All</button>
                <button id="uncheckAllSitenames" type="button" class="btn btn-info btn-xs">Uncheck All</button>
              </p>
              <div id="modal-select-sitenames">
                <div id="sitenames-0" class="col-md-2 col-sm-2 col-xs-2"></div>
                <div id="sitenames-1" class="col-md-2 col-sm-2 col-xs-2"></div>
                <div id="sitenames-2" class="col-md-2 col-sm-2 col-xs-2"></div>
                <div id="sitenames-3" class="col-md-2 col-sm-2 col-xs-2"></div>
                <div id="sitenames-4" class="col-md-2 col-sm-2 col-xs-2"></div>
                <div id="sitenames-5" class="col-md-2 col-sm-2 col-xs-2"></div>
              </div>
            </div>
          </div>
          <div id="emp-group" class="tab-pane fade">
            <div class="row">
              <p>Select Tag:
                <button id="checkAllTags" type="button" class="btn btn-primary btn-xs">Check All</button>
                <button id="uncheckAllTags" type="button" class="btn btn-info btn-xs">Uncheck All</button>
              </p>
              <div id="modal-select-grp-tags">
                <div id="tag-0" class="col-md-3 col-sm-2 col-xs-2"></div>
                <div id="tag-1" class="col-md-3 col-sm-2 col-xs-2"></div>
                <div id="tag-2" class="col-md-3 col-sm-2 col-xs-2"></div>
                <div id="tag-3" class="col-md-3 col-sm-2 col-xs-2"></div>
                <div id="tag-4" class="col-md-3 col-sm-2 col-xs-2"></div>
                <div id="tag-5" class="col-md-3 col-sm-2 col-xs-2"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <span id="load-groups-wrapper" data-toggle="tooltip" title="">
          <button id="go-load-groups" type="button" class="btn btn-success" data-dismiss="modal" >Okay</button>
        </span>
        <button id="exit-load-group" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>   
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->


<!-- Contact Settings Modal -->
<div class="modal fade col-lg-10" id="contact-settings" role="dialog">
  <div class="modal-dialog modal-md" id="modal-cs-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-info">Contact Settings</h4>
      </div>

    <div class="modal-body row-fluid">
      <div class="contact-settings-container">

        <div class="row">
          <div class="col-md-6">
            <label for="contact-category">Contact Category</label>
            <select id="contact-category" class="btn btn-default" name="contact-category" title="Contact Category">
              <option disabled selected value="default">Ex. Employee Contacts</option>
              <option value="econtacts">Employee Contacts</option>
              <option value="ccontacts">Community Contacts</option>
            </select>  
          </div>

          <div class="col-md-6">
            <label for="settings-cmd">What do you want to do?</label>
            <select id="settings-cmd" class="btn btn-default" disabled>
              <option disabled selected value="default">Ex. Add Contact</option>
              <option value="addcontact">Add Contact</option>
              <option value="updatecontact">Update Existing Contact</option>
            </select>  
          </div>

        </div>

        <hr>

        <div id="update-contact-container" hidden>
          <div>
           <button type="submit" value="submit" class="btn btn-primary" id="sbt-update-contact-info">Save</button>
           <button type="button" class="btn btn-danger" id="btn-cancel-update">Cancel</button>
          </div>
        </div>

        <table id="response-contact-container" class="display table table-striped" cellspacing="0" width="100%" hidden>
          <thead>
            <tr>
              <th>Name</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Name</th>
            </tr>
          </tfoot>
        </table>

        <div id="employee-contact-wrapper" hidden>
          <div class="row">
            <div class="col-md-6">
              <label for="firstname_ec">Firstname:</label>
              <input type="text" class="form-control" id="firstname_ec" name="firstname_ec" maxlength="16" required>
            </div>

            <div class="col-md-6">
              <label for="firstname_ec">Lastname:</label>
              <input type="text" class="form-control" id="lastname_ec" name="lastname_ec" maxlength="16" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label for="nickname_ec">Nickname:</label>
              <input type="text" class="form-control" id="nickname_ec" name="nickname_ec" maxlength="16" required>
            </div>

            <div class="col-md-6">
              <label for="birthdate_ec">Birthdate:</label>
              <div class="input-group date datetime">
                <input type="date" class="form-control" id="birthdate_ec" aria-required="true" aria-invalid="false">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
          </div> 

          <div class="row">
            <div class="col-md-6">
              <label for="email_ec">Email:</label>
              <input type="email" class="form-control" id="email_ec" name="email_ec" required>
            </div>
            <div class="col-md-6" title="Notes: If contact number is more than one seprate it by a comma.">
              <label for="numbers_ec">Contact #:</label>
              <input type="text"  id="numbers_ec" class="form-control" name="numbers_ec" data-role="tagsinput" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6" title="Notes: If group tag is more than one seprate it by a comma.">
              <label for="grouptags_ec">Group tags:</label>
              <input type="text" id="grouptags_ec" class="form-control" name="grouptags_ec" data-role="tagsinput" required>
            </div>
          </div>
          <hr>
          <div id="emp-settings-cmd">
            <button type="submit" value="submit" class="btn btn-primary">Save</button>
            <button class="btn btn-danger" id="btn-clear-ec" >Reset</button>
          </div>
        </div>

        <div id="community-contact-wrapper" hidden>
          <div class="row">
            <div class="col-md-6">
              <label for="firstname_cc">Firstname:</label>
              <input type="text" class="form-control" id="firstname_cc" name="firstname_cc" maxlength="16" required>
            </div>

            <div class="col-md-6">
              <label for="lastname_cc">Lastname:</label>
              <input type="text" class="form-control" id="lastname_cc" name="lastname_cc" maxlength="16" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <label for="prefix_cc">Prefix:</label>
              <input type="text" class="form-control" id="prefix_cc" name="prefix_cc" maxlength="16" required>
            </div>

            <div class="col-md-4">
              <label for="office_cc">Office:</label>
              <select name="office_cc" id="office_cc"></select>
              <input type="text" class="form-control" id="other-officename" name="other_officename" placeholder="Office" hidden>
            </div>

            <div class="col-md-4">
              <label for="sitename_cc">Sitename:</label>
              <select name="sitename_cc" id="sitename_cc"></select>
              <input type="text" class="form-control" id="other-sitename" name="other_sitename" placeholder="Sitename" hidden>
            </div>
          </div> 

          <div class="row">
            <div class="col-md-6">
              <label for="numbers_cc">Contact #:</label>
              <input type="text" class="form-control" id="numbers_cc" name="numbers"  data-role="tagsinput" required>
            </div>

            <div class="col-md-3">
              <label for="rel">Reliability:</label>
              <select name="rel" id="rel" class="form-control">
                <option value="Y">Yes</option>
                <option value="N">No</option>
                <option value="Q">Q</option>
              </select>
            </div>

            <div class="col-md-3">
              <label for="ewirecipient">EWI Recipient:</label>
              <select name="ewirecipient" id="ewirecipient" class="form-control">
                <option value="Y">Yes</option>
                <option value="N">No</option>
              </select>
            </div>

          </div>
          <hr>
          <div id="comm-settings-cmd">
            <button type="submit" value="submit" class="btn btn-primary">Save</button>
            <button class="btn btn-danger" id="btn-clear-cc" >Reset</button>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
</div>
<!-- End Contact Settings Modal -->

<!-- SEARCH MESSAGE MODAL -->
<div class="modal fade col-lg-10" id="search-result-modal" role="dialog">
  <div class="modal-dialog modal-md" id="ewi-modal-cs-dialog">
    <div class="modal-content" id="ewi-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>Search Result</h4>
      </div>
      <div class="modal-body row-fluid"> 
        <div class="search-result-container">
          <div class="result-message">
            <ul id="search-result" class="chat">

            </ul>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<div class="modal fade col-lg-10" id="search-global-message-modal" role="dialog">
  <div class="modal-dialog modal-md" id="search-global-dialog">
    <div class="modal-content" id="search-global-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>Search Result</h4>
      </div>
      <div class="modal-body row-fluid">
        <div class="input-group search-opt">
          <label class="radio-inline"><input type="radio" value="global-search" name="optradio" checked >Global Search Message</label>
          <label class="radio-inline"><input type="radio" value="gintag-search" name="optradio">GINTag Search</label>  
        </div>
        <div class="input-group">
          <input type="text" id="search-global-keyword" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button" id="btn-search-global" ><span class="glyphicon glyphicon-search"></span></button>
          </span>
        </div>
        <div class="search-global-message-container">
          <div class="result-message">
            <ul id="search-global-result" class="chat">

            </ul>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>
<!-- END OF SEARCH MESSAGE MODAL -->

<!-- EWI MODAL -->
<div class="modal fade col-lg-10" id="early-warning-modal" role="dialog">
  <div class="modal-dialog modal-md" id="ewi-modal-cs-dialog">
    <div class="modal-content" id="ewi-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>EARLY WARNING INFORMATION</h4>
      </div>
      <div class="modal-body row-fluid"> 
        <div class="ewi-container">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group" id="alert-group">
              <label for="alert-lvl">Alert Level :</label>
              <select name="" id="alert-lvl" class="form-control">
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group" id="site-group">
              <label for="sites">Sites :</label>
              <select name="" id="sites" name="sites" class="form-control">
              </select>
            </div>
          </div>
        </div>
        <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="ewi-date-picker">Schedules :</label>
            <input type="date" id="ewi-date-picker" class="form-control"/>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group cmd-ewi-chatterbox">
            <button type="submit" value="submit" id="confirm-ewi" class="btn btn-primary" data-dismiss="modal">Confirm</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>   
        </div>
        </div>
        </div>
      </div>
    </div>  
  </div>
</div>
<!-- END EWI MODAL -->

<!-- GINTAGS MODAL -->
<div class="modal fade col-lg-10" id="gintag-modal" role="dialog">
  <div class="modal-dialog modal-md" id="gintag-modal-dialog">
    <div class="modal-content" id="gintag-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>General Information Tag <i class="text-warning"> *BETA*</i></h4>
      </div>
      <div class="modal-body row-fluid"> 
      <div class="alert alert-info" role="alert"><strong>New Feature!</strong> You can now tag messages in chatterbox!.</div>
       <input type="text" class="form-control" id="gintags" name="gintags"  data-role="tagsinput" placeholder="E.g #EwiMessage" required>
        <div class="form-group" id="submit-gintag">
          <button type="submit" value="submit" id="confirm-gintags" class="btn btn-primary" data-dismiss="modal">Confirm</button>
          <button type="reset" class="btn btn-danger" data-dismiss="modal">Reset</button>
        </div>  
      </div>
    </div>  
  </div>
</div>
<!-- END GINTAGS MODAL -->

