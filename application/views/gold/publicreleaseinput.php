<?php
// Database login information
$servername = "localhost";
$username = "updews";
$password = "october50sites";
$dbname = "senslopedb";

//Site Column Info

$siteColumnInfo;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM alert_public ORDER BY timestamp DESC";
$result = mysqli_query($conn, $sql);

//$sql = "SELECT s_id, name FROM site_column ORDER BY name ASC";
$sql = "SELECT DISTINCT LEFT(name , 3) as name, sitio, barangay, municipality, province FROM site_column ORDER BY name ASC";
$result = mysqli_query($conn, $sql);

$numSites = 0;
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $sitio = $row["sitio"];
        $barangay = $row["barangay"];
        $municipality = $row["municipality"];
        $province = $row["province"];

        if ($sitio == null) {
          $address = "$barangay, $municipality, $province";
        } 
        else {
          $address = "$sitio, $barangay, $municipality, $province";
        }

        $siteInfo[$numSites]["name"] = $row["name"];
        $siteInfo[$numSites++]["address"] = $address;
    }
} else {
    echo "0 results for site name";
}

$sql = "SELECT internal_alert_level FROM lut_alerts";
$result = mysqli_query($conn, $sql);

$numSites = 0;
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $internalAlerts[$numSites++]["internal_alert_level"] = $row["internal_alert_level"];
    }
} else {
    echo "0 results for internal alert level";
}

mysqli_close($conn);

$pubReleaseHTTP = null; 
if (base_url() == "http://localhost/") {
    $pubReleaseHTTP = base_url() . "temp/";
} else {
    $pubReleaseHTTP = base_url() . "ajax/";
}
?>
        <script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
        <script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="/css/bootstrap-datetimepicker.css"></script>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Public Announcement Reports <small>Create Entries for Public Releases</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="well well-sm"><b><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;For the list of all Public Releases, click <a href="<?php echo base_url(); ?>gold/publicrelease/all">here.</a></b></div>  

                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="entryTimestamp">Timestamp</label>
                    <div class='input-group date' id='datetimepickerTimestamp'>
                        <input type='text' class="form-control" id="entryTimestamp" name="entryTimestamp" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>        
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="entryRelease">Time of Info Release</label>
                    <div class='input-group date' id='datetimepickerRelease'>
                        <input type='text' class="form-control" id="entryRelease" name="entryRelease" placeholder="Enter timestamp (hh:mm:ss)" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>  
                  </div>      
                </div>

                <div class="row">
                  <div class="form-group col-sm-4">
                    <label for="entrySite">Site Name</label>
                    <select class="form-control" id="entrySite">
                      <option value="none">Select site...</option>

                      <?php foreach($siteInfo as $singleSite): ?>
                      <option value="<?php echo $singleSite['name']; ?>">
                        <?php echo $singleSite["name"] . " (" . $singleSite["address"] . ")"; ?>
                      </option>
                      <?php endforeach; ?>

                    </select>
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="entryAlert">Internal Alert Level</label>
                    <select class="form-control" id="entryAlert" onchange="autofillPublicAlertInfo();">
                      <option value="none">Select internal alert level...</option>

                      <?php foreach($internalAlerts as $singleAlert): ?>
                      <option><?php echo $singleAlert["internal_alert_level"]; ?></option>
                      <?php endforeach; ?>

                    </select>        
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="publicAlertLevel">Public Alert Level</label>
                    <input type="text" class="form-control" id="publicAlertLevel" name="publicAlertLevel" placeholder="Will be selected automatically..." disabled>     
                  </div>
                </div>   
                
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="internalAlertDesc">Internal Alert Description</label>
                    <textarea class="form-control" rows="3" id="internalAlertDesc" name="internalAlertDesc" placeholder="Will be selected automatically..." maxlength="128" disabled></textarea>
                  </div>      
                  <div class="form-group col-sm-6">
                    <label for="publicAlertDesc">Public Alert Description</label>
                    <textarea class="form-control" rows="3" id="publicAlertDesc" name="publicAlertDesc" placeholder="Will be selected automatically..." maxlength="128" disabled></textarea>
                  </div>  
                </div>
                
                <!-- Div class of dependent fields that appears on both Internal and Public Alerts -->
                <div class="row">
                  <div class="form-group col-sm-12" id="dependentFieldForBothAlerts" hidden>
                    <div class="col-sm-6" id="dependentFieldBothGroups">
                      <label for="alertGroups[]">Choose group(s) involved:</label>
                      <div class="checkbox"><label><input id="groupLGU" name="alertGroups[]" type="checkbox" value="LGU" onclick=''/>LGU</label></div>
                      <div class="checkbox"><label><input id="groupLLMC" name="alertGroups[]" type="checkbox" value="LLMC" onclick=''/>LLMC</label></div>
                      <div class="checkbox"><label><input id="groupCommunity" name="alertGroups[]" type="checkbox" value="Community" onclick=''/>Community</label></div>
                    </div>
                    <div class="form-group col-sm-6" id="dependentFieldBothReason">
                      <label for="requestReason">Reason for request:</label>
                      <textarea class="form-control" rows="3" id="requestReason" name="requestReason" placeholder="Enter reason for request" maxlength="128"></textarea>
                    </div>
                  </div>
                </div>

                <!-- Div class for dependent fields that appears only on Public Alerts -->                
                <div class="row">
                  <div class="form-group col-sm-12" id="dependentFieldPublicOnly" hidden>
                    <!-- Div classes for dependent fields (Ground, Rain, Earthquake) -->
                    <div class="form-group" id="dependentFieldSuppInfo">
                      <div class="form-group col-sm-6 dependentFieldSuppInfoEq" hidden>
                        <label for="">Magnitude</label>
                        <input type="number" class="form-control" id="magnitude" name="magnitude">
                      </div>
                      <div class="form-group col-sm-6 dependentFieldSuppInfoEq" hidden>
                        <label for="">Epicenter (km)</label>
                        <input type="number" class="form-control" id="epicenter" name="epicenter">
                      </div>
                    </div>
                    
                    <div class="col-sm-12">
                      <div class="form-group" id="">
                        <label for="suppInfoTimestamp">Date and Time of Initial Ground Movement Trigger</label>
                          <div class='input-group date' id='dependentFieldTimestamp'>
                              <input type='text' class="form-control" id="suppInfoTimestamp" name="suppInfoTimestamp" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                      </div>
                    </div>

                    <div class="form-group col-sm-12 dependentFieldSuppInfoGround" hidden>
                      <label for="">Date and Time of Significant/Critical Ground Movements Following Initial Ground Movement Trigger</label>
                      <div class='input-group date' id='dependentFieldTimestampGround'>
                          <input type='text' class="form-control" id="suppInfoTimestampGround" name="suppInfoTimestampGround" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="responseLlmcLgu">LLMC and LGU Response</label>
                    <textarea class="form-control" rows="3" id="responseLlmcLgu" name="responseLlmcLgu" placeholder="Will be selected automatically..." maxlength="128" disabled></textarea>
                  </div>      
                  <div class="form-group col-sm-6">
                    <label for="responseCommunity">Community Response</label>
                    <textarea class="form-control" rows="3" id="responseCommunity" name="responseCommunity" placeholder="Will be selected automatically..." maxlength="128" disabled></textarea>
                  </div>  
                </div>    

                <div class="form-group">
                  <label for="comments">Extra Info (optional)</label>
                  <textarea class="form-control" rows="3" id="comments" name="comments" placeholder="Enter Additional Info/Comments" maxlength="256"></textarea>
                </div>

                <label for="entryRecipient">Recipient</label>

                <div class="form-group col-sm-12">
                  <div class="row">
                    <div class="checkbox col-sm-6"><label><input id="cbox1" type="checkbox" value="BLGU" onclick='recipientChecker(this,"#entryTime1")'>BLGU</label></div>
                    <div class='input-group date entryTime col-sm-6' id='time1'>
                        <input type='text' class="form-control" id="entryTime1" name="entryTime1" placeholder="Enter time of acknowledgment for BLGU" disabled/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="checkbox col-sm-6"><label><input id="cbox2" type="checkbox" value="MLGU" onclick='recipientChecker(this,"#entryTime2")'>MLGU</label></div>
                    <div class='input-group date entryTime col-sm-6' id='time2'>
                        <input type='text' class="form-control" id="entryTime2" name="entryTime2" placeholder="Enter time of acknowledgment for MLGU" disabled/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>  
                  </div>
                  <div class="row">
                    <div class="checkbox col-sm-6"><label><input id="cbox3" type="checkbox" value="LLMC" onclick='recipientChecker(this,"#entryTime3")'>LLMC</label></div>
                    <div class='input-group date entryTime col-sm-6' id='time3'>
                        <input type='text' class="form-control" id="entryTime3" name="entryTime3" placeholder="Enter time of acknowledgment for LLMC" disabled/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="checkbox col-sm-6"><label><input id="cbox4" type="checkbox" value="MDRRMC" onclick='recipientChecker(this,"#entryTime4")'>MDRRMC</label></div>
                    <div class='input-group date entryTime col-sm-6' id='time4'>
                        <input type='text' class="form-control" id="entryTime4" name="entryTime4" placeholder="Enter time of acknowledgment for MDRRMC" disabled/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="checkbox col-sm-6"><label><input id="cbox5" type="checkbox" value="PDRRMC" onclick='recipientChecker(this,"#entryTime5")'>PDRRMC</label></div>
                    <div class='input-group date entryTime col-sm-6' id='time5'>
                        <input type='text' class="form-control" id="entryTime5" name="entryTime5" placeholder="Enter time of acknowledgment for PDRRMC" disabled/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>  
                  </div>
                </div>    

                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="entryFlagger">Entry Reporter</label>
                    <input type="text" class="form-control" id="entryFlagger" name="entryFlagger" value="<?php echo $first_name . " " . $last_name; ?>" placeholder="Enter Flagger" disabled>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="counterReporter">CT/MT Counterpart Reporter</label>
                    <select class="form-control" id="counterReporter" name="counterReporter" onchange="">
                      <option value="none">Select reporter</option>
                        
                    </select>
                  </div>

                </div>

                <button type="submit" class="btn btn-info" onclick="insertNewEntry()">Submit</button>
                <Br><Br><Br>

                <!-- Modal for Successful Entry -->
                <div class="modal fade" id="dataEntrySuccessful" role="dialog">
                  <div class="modal-dialog modal-md">
                  
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Entry Insertion Notice</h4>
                      </div>
                      <div class="modal-body">
                        <p>Successfully Inserted the Entry!</p>
                      </div>
                      <div class="modal-footer">
                        <a href="<?php echo base_url() . $version; ?>/publicreleaseinput" class="btn btn-info" role="button">Add More Entries</a>
                        <a href="#" id="viewRecentEntry" class="btn btn-success" role="button">View Recent Entry</a>
                      </div>
                    </div>
                    
                  </div>
                </div>                

                <!-- Modal for Warnings -->
                <div class="modal fade" id="dataEntryFailed" role="dialog">
                  <div class="modal-dialog modal-md">
                  
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Entry Insertion Notice</h4>
                      </div>
                      <div class="modal-body">
                        <p>Insertion of Data Failed</p>
                        <p class="text-danger"><b id="entryFailedWarning">Insert helpful tip here</b></p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Okay</button>
                      </div>
                    </div>
                    
                  </div>
                </div> 

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->   
        
<script>
  window.onload = function() {
  	$('#formGeneral').hide();
  	$('#formDate').hide();
    $('#button_right').hide();

    $.ajax ({
      //async: false,
      url: "<?php echo base_url(); ?>pubrelease/showStaff",
      type: "GET",
      dataType: "json",
    })
    .done( function (json) {
        var myData = json; // SAVE SITES TO MYDATA
        console.log(myData);
        myData.forEach(function (row) {
          $("#counterReporter").append("<option value='" + row.first_name + " " + row.last_name + "'>" + row.last_name + ", " + row.first_name + "</option>");
        });
    });

  }	

  $(function () {
      $('#datetimepickerTimestamp').datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss',
          sideBySide: true,


      });

      $('#datetimepickerRelease').datetimepicker({
          format: 'HH:mm:ss'
      });

      $('.entryTime').datetimepicker({
          format: 'HH:mm:ss'
      });

      $('#dependentFieldTimestamp').datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss',
          sideBySide: true,
      });

      $('#dependentFieldTimestampGround').datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss',
          sideBySide: true,
      });

  });

  var testVar;
  function autofillPublicAlertInfo () {
    var internalAlert = $( "#entryAlert" ).val();

    if (internalAlert == "none") {
        $('#publicAlertLevel').val("Will be selected automatically...");
        $('#internalAlertDesc').val("Will be selected automatically...");
        $('#publicAlertDesc').val("Will be selected automatically...");
        $('#responseLlmcLgu').val("Will be selected automatically...");
        $('#responseCommunity').val("Will be selected automatically...");
    }
    else {
      $.ajax({url: "<?php echo base_url(); ?>pubrelease/alertquery/" + internalAlert, success: function(result){
          testVar = $.parseJSON(result);
          var data = $.parseJSON(result);

          $('#publicAlertLevel').val(data[0].public_alert_level);
          $('#internalAlertDesc').val(data[0].internal_alert_desc);
          $('#publicAlertDesc').val(data[0].public_alert_desc + "\n\n" + data[0].supplementary_info);
          $('#responseLlmcLgu').val(data[0].response_llmc_lgu);
          $('#responseCommunity').val(data[0].response_community);

          /* Toggle Dependent Field Values */
          switch(internalAlert) {
            case "A1-D":
            case "ND-D":
                  $('#dependentFieldForBothAlerts').show();
                  $('#dependentFieldPublicOnly').hide();
                  break;
            case "A1-E":
            case "ND-E":
                  $('#dependentFieldForBothAlerts').hide();
                  $('#dependentFieldPublicOnly').show();
                  $("label[for='suppInfoTimestamp']").html("Date and Time of Occurence")
                  $('.dependentFieldSuppInfoEq').show();
                  $('.dependentFieldSuppInfoGround').hide(); 
                  break;
            case "A1-R":
            case "ND-R":
                  $('#dependentFieldForBothAlerts').hide();
                  $('#dependentFieldPublicOnly').show();
                  $("label[for='suppInfoTimestamp']").html("Date and Time of Occurence")
                  $('.dependentFieldSuppInfoEq').hide();
                  $('.dependentFieldSuppInfoGround').hide();
                  break; 
            case "A2":
            case "A3":
            case "ND-L":
                  $('#dependentFieldForBothAlerts').hide();
                  $('#dependentFieldPublicOnly').show();
                  $("label[for='suppInfoTimestamp']").html("Date and Time of Initial Ground Movement Trigger")
                  $('.dependentFieldSuppInfoEq').hide();
                  $('.dependentFieldSuppInfoGround').show();            
                  break;
            default:
                  $('#dependentFieldForBothAlerts').hide();
                  $('#dependentFieldPublicOnly').hide();
          }

      }});
    }
  }

  function recipientChecker (recipientID, timeID) {
    if($(recipientID).is(':checked')) {
        $(timeID).prop("disabled", false);
        return true;  //You can get the time data
    }
    else {
        $(timeID).prop("disabled", true);
        return false; //You can NOT get the time data
    }
  }

  function recipientData () {
    var recipients = "";
    var acktime = "";

    var listRecipients = ["#cbox1","#cbox2","#cbox3","#cbox4","#cbox5"];
    var listAckTime = ["#entryTime1","#entryTime2","#entryTime3","#entryTime4","#entryTime5"];

    var i;
    for (i = 0; i < listRecipients.length; i++) { 
        if (recipientChecker(listRecipients[i], listAckTime[i])) {
          recipients = recipients + $(listRecipients[i]).val() + ";";

          var singleAckTime = $(listAckTime[i]).val();

          if (singleAckTime == "") {
            acktime = acktime + "none;";
          } else{
            acktime = acktime + $(listAckTime[i]).val() + ";";
          };
        }        
    }

    return {entryRecipient: recipients, entryAckTime: acktime};
  }

  function alertGroupData () {
    var checkboxes = document.getElementsByName("alertGroups[]");
    var checkboxesChecked = [];
    // loop over them all
    for (var i=0; i<checkboxes.length; i++) {
       // And stick the checked ones onto an array...
       if (checkboxes[i].checked) {
          checkboxesChecked.push(checkboxes[i].value);
       }
    }
    // Return the array if it is non-empty, or null
    return checkboxesChecked.length > 0 ? checkboxesChecked : null;

  }

  function insertNewEntry () {
    var timestamp = $("#entryTimestamp").val();
    var timereleased = $("#entryRelease").val();
    var site = $("#entrySite").val();
    var internalAlert = $("#entryAlert").val();
    
    var comments = $("#comments").val();
    if (comments == '') comments = null;

    var recAck = recipientData();
    var flagger = $("#entryFlagger").val();
    var counterReporter = $("#counterReporter").val();

    //Dependent fields
    var dftimestamp = $("#suppInfoTimestamp").val();
    var alertgroup = alertGroupData();
    var request = $("#requestReason").val();
    var magnitude = $("#magnitude").val();
    var epicenter = $("#epicenter").val();
    var dftimestampground = $("#suppInfoTimestampGround").val();

    var checker = 0;
    var failedMessage = "";

    if (timestamp == "") {
      failedMessage += "Please fill out 'Timestamp'.<br>";
      checker = 1;
    }

    if (timereleased == "") {
      failedMessage += "Please fill out 'Time of Info Release'.<br>";
      checker = 1;
    }

    if (site == "none") {
      failedMessage += "Please fill out 'Site Name'.<br>";
      checker = 1;
    }

    if (internalAlert == "none") {
      failedMessage += "Please fill out 'Internal Alert Level'.<br>";
      checker = 1;
    }

    if (counterReporter == "none") {
      failedMessage += "Please fill out 'CT/MT Counterpart Reporter'.<br>";
      checker = 1;
    }

    if (internalAlert == "A1-D" || internalAlert == "ND-D") {
      if (alertgroup == null) { failedMessage += "Please select at least one 'Alert Group'.<br>"; checker = 1; }
      if (request == "") { failedMessage += "Please fill out 'Reason for request'.<br>"; checker = 1; }
    } else if (internalAlert == "A1-E" || internalAlert == "ND-E") {
      if (magnitude == "") { failedMessage += "Please fill out 'Magnitude'.<br>"; checker = 1; }
      if (epicenter == "") { failedMessage += "Please fill out 'Epicenter'.<br>"; checker = 1; }
      if (dftimestamp == "") { failedMessage += "Please fill out 'Date and Time of Occurence'.<br>"; checker = 1; }
    } else if (internalAlert == "A1-R" || internalAlert == "ND-R") {
      if (dftimestamp == "") { failedMessage += "Please fill out 'Date and Time of Occurence'.<br>"; checker = 1; }
    } else if (internalAlert == "A2" || internalAlert == "A3" || internalAlert == "ND-L") {
      if (dftimestamp == "") { failedMessage += "Please fill out 'Date and Time of Initial Ground Movement Trigger'.<br>"; checker = 1; }
    }

    if (recAck.entryRecipient == "") {
      failedMessage += "Please select at least one 'Recipient'.<br>";
      checker = 1;
    }

    if ( checker == 1 ) {
      $('#entryFailedWarning').html(failedMessage);
      $('#dataEntryFailed').modal('show');
      return;
    }

    var formData = {entryTimestamp: timestamp,
                    entryRelease: timereleased,
                    entrySite: site,
                    entryAlert: internalAlert,
                    comments: comments,
                    entryRecipient: recAck.entryRecipient,
                    entryAck: recAck.entryAckTime,
                    entryFlagger: flagger,
                    counterReporter: counterReporter,
                    entryAlertGroup: alertgroup,
                    entryRequest: request,
                    entryMagnitude: magnitude,
                    entryEpicenter: epicenter,
                    entryDfTimestamp: dftimestamp,
                    entryDfTimestampGround: dftimestampground};

    $.ajax({
      //url : "publicreleaseinsert2.php",
      url: "<?php echo base_url(); ?>pubrelease/insertdata",
      type: "POST",
      data : formData,
      success: function(result, textStatus, jqXHR)
      {
          testVar = result;
          $("#viewRecentEntry").attr("href", "<?php echo base_url(); ?>gold/publicrelease/individual/" + result);
          $('#dataEntrySuccessful').modal('show');
      }     
    });
  }


</script>

<script src='http://codepen.io/assets/editor/live/css_live_reload_init.js'></script>






























