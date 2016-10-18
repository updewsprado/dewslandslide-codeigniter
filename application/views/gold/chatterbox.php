<div id="page-wrapper">
  <div class="container bootstrap snippet">
    <div class="row">
      <div id="search-contacts" class="col-md-3">
        <label>Search for contact:</label><Br/>
        <input class="dropdown-input" placeholder="Type name..." data-multiple />
        <button type="button" class="btn btn-xs btn-primary" id="go-chat">Go Chat!</button><Br/>

        <!-- Uncomment to enable bootstrap type button -->
<!--                             <div class="input-group">
<input type="text" class="form-control dropdown-input" placeholder="Type name..." data-multiple />
<span class="input-group-btn">
<button id="go-chat" class="btn btn-primary" type="button">Go Chat!</button>
</span>
</div> -->
</div>
<div id="div-advanced-search" class="col-md-6">
  <button type="button" class="btn btn-link btn-sm" id="btn-advanced-search" 
  data-toggle="modal" data-target="#advanced-search" title="Quick Community Group Selection">
  <span class="glyphicon glyphicon-list-alt"></span>
</button>

<button type="button" class="btn btn-link btn-sm" id="btn-contact-settings" 
data-toggle="modal" data-target="#contact-settings" title="Contact Settings"><span class="glyphicon glyphicon-user"></span>
</button>

<button type="button" class="btn btn-link btn-sm" id="btn-gbl-search" title="Search Message"><span class="glyphicon glyphicon-search"></span></button>

</div>

<div id="current-contacts" class="col-md-8 col-sm-6 col-xs-8">
  <div id="search-lbl" class="bg-success">
    <div>
      <h4 ></h4> <span class="glyphicon glyphicon-search" id="btn-standard-search"></span>
    </div>
    <input type="text" id="search-key" class="form-control" placeholder="Search for..." hidden>
  </div>
<!--         
<div class="bg-white">
<div class="input-group">
<input type="text" id="searchbox" name="searchbox" class="form-control border no-shadow no-rounded dropdown-input" placeholder="Search contacts here" data-multiple />
<span class="input-group-btn">
<button class="btn btn-success no-rounded" type="button" id="go-chat">Go Chat!</button>
</span>
</div>
</div>   
-->        
</div>

<div class="row">
  <div id="possible-contacts" class="col-md-4">

  </div>
</div>

<div class="row">
  <div class="col-md-4 bg-white ">

    <ul class="nav nav-tabs inbox-tab">
      <li class="active"><a data-toggle="tab" href="#registered">Registered</a></li>
      <li><a data-toggle="tab" href="#unknown">Unknown</a></li>
    </ul>

    <div class="tab-content">
      <div id="registered" class="tab-pane fade in active">
        <h1></h1>
        <!-- start of inbox display for Registered Numbers -->
        <ul id="quick-inbox-display" class="friend-list">        
        </ul>
        <!-- end of inbox display for Registered Numbers -->
      </div>
      <div id="unknown" class="tab-pane fade">
        <h1></h1>
        <!-- start of inbox display for Unknown Numbers -->
        <ul id="quick-inbox-unknown-display" class="friend-list">
        </ul>
        <!-- end of inbox display for Unknown Numbers -->
      </div>
    </div>
<!--             
<div class=" row border-bottom padding-sm friend-list-header" style="height: 40px;">
Contacts
</div> -->

</div>

<!--=========================================================-->
<!-- selected chat -->
<div id="main-container" class="col-md-8 bg-white hidden">
  <!-- <button type="button" id="leave-room">Leave</button> -->
  <div class="chat-message">
    <ul id="messages" class="chat">

    </ul>
  </div>
  <div class="chat-box bg-white">
    <div class="row">
      <div class="col-xs-10">
        <textarea id="msg" name="msg" class="form-control border no-shadow no-rounded" placeholder="Type your message here" rows="4"></textarea>
      </div>
      <div class="col-xs-2" id="chat-commands">
        <button class="btn btn-success no-rounded" type="button" id="send-msg">Send</button>
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

<!-- Modal: WSS Connection disconnected -->
<div class="modal fade" id="connectionStatusModal" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title text-danger">You have been disconnected!</h4>
      </div>
      <div class="modal-body">
        <p>Chatterbox App will automatically reconnect when internet connection is detected.</p>
        <p>PHIVOLCS Internet is restarted every:</p>
        <ul>
          <li>5:00 AM to 5:05 AM</li>
          <li>12:00 PM to 12:05 PM</li>
          <li>7:00 PM to 7:05 PM</li>
        </ul>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Refresh</button> -->
      </div>
    </div>
  </div>
</div>

<!-- Modal: Advanced Search Options -->
<div class="modal fade col-lg-10" id="advanced-search" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-info">Quick Community Group Selection of Recipients</h4>
      </div>
      <div class="modal-body row-fluid">
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
            <label class="opt-ewi-recipients"><input type="radio" name="opt-ewi-recipients" value="false" checked>All</label>
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
      <div class="modal-footer">
        <button id="go-load-groups" type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
        <button id="exit-load-group" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<div class="modal fade col-lg-10" id="contact-settings" role="dialog">
  <div class="modal-dialog modal-md" id="modal-cs-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-info">Contact Settings</h4>
      </div>

      <button type="button" class="btn btn-link btn-sm" id="btn-contact-settings" 
      data-toggle="modal" data-dismiss="modal" data-target="#edit-contact-settings">
      <span class="glyphicon glyphicon-search"></span>
      Edit Contact
    </button>

    <div class="modal-body row-fluid">
      <!-- content here -->
      <div class="contact-settings-container">
        <div class="contact-settings-wrapper">
          <h4>Employee Contacts</h4>
          <form action="../chatterbox/addcontacts" method="post" onsubmit="return confirm('Are you sure you want to add this contact?');">
            <input type="hidden" name="category" value="dewslcontacts">
            <div class="form-group">
              <label for="firstname">Firstname:</label>
              <input type="text" class="form-control" id="firstname" name="firstname" maxlength="16" required>
            </div>

            <div class="form-group">
              <label for="lastname">Lastname:</label>
              <input type="text" class="form-control" id="lastname" name="lastname" maxlength="16" required>
            </div>

            <div class="form-group">
              <label for="nickname">Nickname:</label>
              <input type="text" class="form-control" id="nickname" name="nickname" maxlength="16" required>
            </div>

            <div class="form-group">
              <label for="birthdate">Birthdate:</label>
              <input type="date" class="form-control" id="birthdate" name="birthdate" required>
            </div>

            <div class="form-group">
              <label for="email">Email:</label>
              <input type="text" class="form-control" id="email" name="email" maxlength="16" required>
            </div>

            <div class="form-group">
              <label for="numbers">Contact #:</label>
              <input type="text" class="form-control" id="numbers" name="numbers" required>
            </div>

            <div class="form-group">
              <label for="grouptags">Group tags:</label>
              <input type="text" class="form-control" id="grouptags" name="grouptags" required>
            </div>

            <button type="submit" value="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" id="btn-clear-ec" >Clear</button>
          </form>
        </div>


        <div class="contact-settings-wrapper">
          <h4>Community Contacts</h4>
          <form action="../chatterbox/addcontacts/" method="post" onsubmit="return confirm('Are you sure you want to add this contact?');">
            <input type="hidden" name="category" value="communitycontacts">
            <div class="form-group">
              <label for="firstname">Firstname:</label>
              <input type="text" class="form-control" id="firstname" name="firstname" maxlength="16" required>
            </div>

            <div class="form-group">
              <label for="lastname">Lastname:</label>
              <input type="text" class="form-control" id="lastname" name="lastname" maxlength="16" required>
            </div>

            <div class="form-group">
              <label for="prefix">Prefix:</label>
              <input type="text" class="form-control" id="prefix" name="prefix" maxlength="16" required>
            </div>

            <div class="form-group">
              <label for="office">Office:</label>
              <select name="office" id="office"></select>
              <input type="text" class="form-control" id="other-officename" name="other_officename" placeholder="Office" hidden>
            </div>

            <div class="form-group">
              <label for="sitename">Sitename:</label>
              <select name="sitename" id="sitename"></select>
              <input type="text" class="form-control" id="other-sitename" name="other_sitename" placeholder="Sitename" hidden>
            </div>

            <div class="form-group">
              <label for="number">Number:</label>
              <input type="text" class="form-control" id="number" name="number" required>
            </div>

            <div class="form-group">
              <label for="rel">Reliability:</label>
              <select name="rel" id="rel" class="form-control">
                <option value="Y">Y</option>
                <option value="N">N</option>
                <option value="Q">Q</option>
              </select>
            </div>

            <div class="form-group">
              <label for="ewirecipient">EWI Recipient:</label>
              <select name="ewirecipient" id="ewirecipient" class="form-control">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
            <button type="submit" value="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" id="btn-clear-cc">Clear</button>
          </form>
        </div>
        <!-- end content -->
      </div>
    </div>
  </div>
</div>

</div>
<!-- /#page-wrapper -->

<!-- Search contacts Modal -->

<div class="modal fade col-lg-10" id="edit-contact-settings" role="dialog">
  <div class="modal-dialog modal-md" id="modal-cs-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-info">Edit Contacts</h4>
      </div>
      <div class="modal-body row-fluid"> 
        <h4>SEARCH CONTACTS</h4>
        <div class="search-category">
          <label class="radio-inline"><input type="radio" id="optcommunity_contacts" name="category" value="community_contacts_radio">Community Contacts</label>
          <label class="radio-inline"><input type="radio" id="optemployee_contacts" name="category" value="employee_contacts_radio">Employee Contacts</label>
        </div>
        <table id="response-contact-container" class="display" cellspacing="0" width="100%" hidden>
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
      </div>
    </div>
  </div>
</div>

<!-- end modal -->

<div class="modal fade col-lg-10" id="edit-contact" role="dialog">
  <div class="modal-dialog modal-md" id="modal-cs-dialog">
    <div class="modal-content" id="update-contact-content">
      <div class="modal-header">
        <button type="button" class="close" id="btn-close-edit-settings">&times;</button>
        <h4>EDIT CONTACT</h4>
      </div>
      <div class="modal-body row-fluid"> 
       <form action="../chatterbox/updatecontacts" method="post" onsubmit="return confirm('Are you sure you want to add this contact?');">
        <div id="contact-settings-wrapper">
        </div>
        <div>
         <button type="submit" value="submit" class="btn btn-primary" id="sbt-update-contact-info">Save</button>
         <button type="button" class="btn btn-danger" id="btn-cancel-update">Cancel</button>
       </div>
     </form>
   </div>
 </div>
</div>
</div>

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
          <div class="alert-site-container">
            <div class="form-group" id="alert-group">
              <label for="alert-lvl">Alert Level :</label>
              <select name="" id="alert-lvl" class="form-control">
              </select>
            </div>
            <div class="form-group" id="site-group">
              <label for="sites">Sites :</label>
              <select name="" id="sites" name="sites" class="form-control">
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="ewi-date-picker">Schedules :</label>
            <input type="date" id="ewi-date-picker" class="form-control"/>
          </div>
          <div class="form-group">
            <button type="submit" value="submit" id="confirm-ewi" class="btn btn-primary" data-dismiss="modal">Confirm</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<!-- END OF EWI MODAL -->

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
        <div class="input-group">
          <input type="text" id="search-global-keyword" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button" id="btn-search-global" ><span class="glyphicon glyphicon-search"></span></button>
          </span>
        </div>
      </div>
      <div class="modal-body row-fluid"> 
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

<!-- EWI RECIPIENTS MODAL -->
  <div class="modal fade col-lg-10" id="ewi-recipient-update-modal" role="dialog">
  <div class="modal-dialog modal-md" id="search-global-dialog">
    <div class="modal-content" id="search-global-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>Update Profiles</h4>
      </div>
      <div class="modal-body row-fluid"> 
        <div class="ewi-recipients-container">
          <div class="alert alert-info">
            <strong>NOTICE!</strong> Some contacts needs to be updated. please select users that will be receiving Early warning information alerts.
          </div>
          <ul class="list-ewi-recipient"></ul>
          <button type="button" class="btn btn-info" id="confirm-ewi-recipients">Confirm</button>
        </div>
      </div>
    </div>  
  </div>
</div>  
<!-- END OF EWI RECIPIENTS MODAL -->

</div>

</div>

<script type="text/javascript">
  first_name = "<?php echo $first_name; ?>";
</script>