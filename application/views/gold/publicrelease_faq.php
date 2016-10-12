<!--
    
     Refined by: Kevin Dhale dela Cruz
     
     A view form for frequently asked quesstions about monitoring
     located at /application/views/gold/
     
     Linked at [host]/gold/publicrelease
     
 -->

<?php
    
?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<style type="text/css">
    .panel-title {
        font-size: 20px;
    }

    .panel-body {
        font-size: 16px;
        text-shadow: 0.5px 0.4px gray;
        line-height: 1.5;
        color: black;
    }

    #check h3 { margin-top: 0; margin-bottom: 0; }
    #check li { font-size: 16px; }

    p { text-indent: 50px; }
</style>

<div id="page-wrapper">
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    DEWS-Landslide Early Warning Information <br><small>Monitoring Primer and Frequently Asked Questions (FAQ)</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="panel panel-primary" id="check">
            <div class="panel-heading"><h3>THINGS TO CHECK BEFORE CLICKING THE PRECIOUS SUBMIT BUTTON<h3></div>
            <div class="panel-body">
                <ul>
                    <li><strong>Refresh the form.</strong> - This is to purge any remnants from the previous release that might have remained unintentionally due to the user's site navigation activities (i.e. clicking "BACK" on browser retains input of the previous release).</li>
                    <li><strong>Check the data timestamp.</strong> - Is it 30 minutes before the intended release? If instantaneous, is it rounded to the nearest 30 minutes? Did I used the time when the data is validated? Is it in 24-hour format?</li>
                    <li><strong>Check the release timestamp.</strong> - Does it correspond to my data timestamp? (e.g. A 16:00 release time for a 15:30 data timestamp, not 04:00 release time) Is it in 24-hour format?</li>
                    <li><strong>Check accordingly the operational triggers.</strong> - <strong>DO I HAVE ANY NEW TRIGGERS?</strong> If <strong>YES</strong>, note the timestamp and include it on the release along with its basic information detail. If there is <strong>NO DATA</strong>, check accordingly the necessary checkbox (see <strong>OPERATION CONCERNS</strong> below). If there is <strong>NO NEW TRIGGERS</strong>, no additional information needed.</li>
                    <li><strong>Check the internal alert level.</strong> - Is the internal alert level dubious? Does it correspond to our intended release? Does my A1 public alert level has s/S or g/G triggers included? (There should be no g or s triggers on an A1 release!)</li>

                </ul>
            </div>
        </div>


        <h3>OPERATIONS CONCERNS</h3>
        
        <div class="panel-group" id="accordion">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse1">1. What do ND, R0, g0, and s0 mean? What are their similarities and differences?</h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p>All of the given are operational triggers we are using that are also represented on the internal alert level. Their purpose is to easily identify the triggers involved for an event monitoring. All of them indicates “No Data” but for different triggers and functions.</p>
                        <ul>
                            <li><strong>ND</strong> – <strong>used for alerts A0 and A1</strong> to indicate <strong>lack of data for BOTH ground and sensor</strong>; important for events with A1 alerts since we cannot lower an event to A0 at end of its validity if no ground AND sensor data is available to prove no significant movement happened on the site, hence an extension of four hours will be added to its validity.</li>
                            <li><strong>R0</strong> – signifies <strong>no data for rainfall</strong> (read as R-null); note that <strong>it is different from lower-case r-zero (r0)</strong> that denotes presence of rainfall data below threshold level</li>
                            <li><strong>g0</strong> – stands for <strong>no ground data</strong> (regardless if alert is A2 or A3); purpose similar to ND (i.e. extension of validity)</li>
                            <li><strong>s0</strong> – represents <strong>no sensor data</strong> (regardless if alert is A2 or A3); purpose similar to ND (i.e. extension of validity)</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse2">2. What is exclusive-lowering protocol?
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p>Exclusive-lowering protocol means that to lower an alert on a specific site, <strong>the operational trigger/s that occurred within the event monitoring must provide substantial evidence to conclude the said monitoring</strong>. This applies to ground (g/G) and sensor triggers (s/S).</p>

                        <p><strong>Sites with A1 alerts MUST also provide either ground OR sensor data</strong> indicating no significant ground movement in order to lower the alert to A0.</p>

                        <p><strong><i>Sites without data for their specific operational triggers at the end of their monitoring period would warrant an extension of four (4) hours on the validity of the monitoring.</i></strong></p>

                        <p>Example: An A2 alert was raised on a site due to ground measurement data (L2/g). To lower the site’s alert to A0, a ground data must show no significant movement at the end of its validity. Failure to do so would mean extension of the validity by four (4) hours.</p>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse3">3. Why should I NOT release another early warning information for the same data timestamp?</h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p>Every release we issue on the site has an equivalent <strong>bulletin tracker number</strong>. The tracker number is shown on the PDF bulletin we send every regular release. For whatever reason, releasing another EWI for a same timestamp would add 1 to the current bulletin tracker number, hence, a flaw on data continuity and consistency. For the sake of data integrity and consistency, we prohibit the deletion of releases and advocate <strong>responsible EWI release</strong>.</p>

                        <p>If you have any mistakes made on your monitoring shift, see <strong>HUMAN ERRORS section</strong> below.</p>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse4">4. What are the prefered timestamps for data timestamps and trigger timestamps?</h4>
                </div>
                <div id="collapse4" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p>For instantenous releases and ground measurement triggers, use the timestamp when you verified the trigger is valid, rounded to the nearest 30 minutes, or when the monitoring scripts had run the needed calculations and the result appeared valid on the PublicAlert.json.</p>

                        <p>For the regular four-hour event-monitoring releases and routine releases, use the data timestamps 30 minutes before the actual release.</p>

                        <p>Rationale: Rounding off the data and trigger timestamps to the nearest 30 minutes would provide consistency on our data since the outputs produced by the monitoring scripts run on every 15- and 45-minute of an hour and released on the 0 and 30-minute of an hour.</p>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse5">5. What are the statuses of monitoring?</h4>
                </div>
                <div id="collapse5" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            <li><strong>ON-GOING</strong> – Refers to an on-going event monitoring due to values exceeding thresholds on our operational triggers</li>
                            <li><strong>ROUTINE</strong> – Refers to our weekly monitoring on all sites; done every Wednesday on dry season and every Tuesday and Friday on wet season</li>
                            <li><strong>FINISHED</strong> – Refers to the end of an event monitoring</li>
                            <li><strong>EXTENDED</strong> – Refers to the three-day extended monitoring done after we lower a heightened alert on a site; a temporary status that will eventually change to FINISHED either after three days of releasing EWI OR if new triggers occured on the site</li>
                            <li><strong>INVALID</strong> – Refers to invalidated on-going site monitoring</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse6">6. Is it important to release EWI on sites under three-day extended monitoring?</h4>
                </div>
                <div id="collapse6" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><strong>YES!</strong> In order to totally conclude an event monitoring for a site, you must release EWI for three days under the extended monitoring status unless a new trigger occured on the site within three days. The site's logic does not automatically change the EXTENDED status to FINISHED.</p>

                        <p>In this way, we are also sticking to our monitoring protocols and being strict on our data collection policies.</p>
                    </div>
                </div>
            </div>
        </div>

        <h3>HUMAN ERRORS</h3>

        <div class="panel-group" id="accordion2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion2" href="#collapse1b">1. I made a mistake on entering timestamps. What should I do?</h4>
                </div>
                <div id="collapse1b" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p>Remember that we are using a <strong>24-hour format</strong> on our timestamps so check accordingly if you have made any mistakes. Edit the timestamps on EWI Individual Event View (site links on the monitoring dashboard then click the edit button for the specific release).</p>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion2" href="#collapse2b">2. I forgot to include a recent trigger on my release! What should I do?
                    </h4>
                </div>
                <div id="collapse2b" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p>Stand up and face the consequences of your wrongdoing! (Kidding!) Remember that we only release EWI every four hours so double-check every information you will disseminate. <strong>DO NOT release another EWI for the same timestamp</strong>. Include the unreleased trigger information on the next bulletin release (or just use the most recent trigger timestamp if there is any). Rest assured, the validity will still be updated.</p>

                        <p>If data editing is <strong>IMMENSELY NEEDED</strong>, refer to <strong>ACTION Z</strong>.</p>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion2" href="#collapse3b">3. I entered a wrong timestamp on a trigger for a release! What should I do?</h4>
                </div>
                <div id="collapse3b" class="panel-collapse collapse">
                    <div class="panel-body">Reflect and remember not to do it again! (Kidding!) Some timestamp errors might have minimal effects in an immediate on-going monitoring but grave errors might lead to extreme changes and problems (e.g. severe jumps on the validity of the event). These kinds of errors need data editing on the database. <strong>Refer to ACTION Z.</strong></div>
                </div>
            </div>
        </div>

        <h3>ACTION Z</h3>

        <div class="panel-group" id="accordion3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion2" href="#collapseZ">If you have immediate concerns...</h4>
                </div>
                <div id="collapseZ" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p>Contact the database manager for the Early Warning Info Releases and Bulletin. Message Kevin through Facebook or through mobile at 09773922070.</p>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->   
        
<script>

    let setElementHeight = function () {
        let window_h = $(window).height();
        $('#page-wrapper').css('min-height', window_h);
        //$('#map').css('min-height', final);
    };

    $(window).on("resize", function () {
        setElementHeight();
    }).resize();

    $('.panel-title').hover(function() {
        $(this).css('cursor','pointer');
    });

</script>

<script src='http://codepen.io/assets/editor/live/css_live_reload_init.js'></script>






























