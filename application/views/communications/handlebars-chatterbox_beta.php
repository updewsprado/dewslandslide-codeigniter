<script id="messages-template-both" type="text/x-handlebars-template">
    {{#each messages}}
        {{#if isYou}}
            {{#if hasTag}}
            <li class="right clearfix tagged" title="Tagged Messaged">
            {{else}}
            <li class="right clearfix">
            {{/if}}

            <input type="text" class="msg_details" value="{{convo_id}}<split>{{mobile_id}}<split>{{user}}<split>{{timestamp}}<split>{{sms_msg}}" hidden>
            <span class="chat-img pull-right" id="badge-id-you">
            <img src="/images/Chatterbox/dewsl_03.png" class="user-avatar" alt="User Avatar">
        {{else}} 
            {{#if hasTag}}
            <li class="left clearfix tagged" title="Tagged Messaged">
            {{else}}
            <li class="left clearfix">
            {{/if}}
            <input type="text" class="msg_details" value="{{convo_id}}<split>{{mobile_id}}<split>{{user}}<split>{{timestamp}}<split>{{sms_msg}}" hidden>
            <span class="chat-img pull-left" id="badge-id-user">
            <img src="/images/Chatterbox/boy_avatar.png" class="user-avatar" alt="User Avatar">
        {{/if}}
        </span>
        <div class="chat-body clearfix tagged" id="id_{{timestamp}}">
        <div class="header">
        {{#if isYou}}
            <small class="pull-left text-muted"><i class="fa fa-clock-o"></i> <span id="timestamp-written" title="Timestamp: Written">{{ts_written}}</span>, <i class="fa fa-clock-o"></i> <span id="timestamp-sent" title="Timestamp: GSM Sent">{{ts_sent}}</span></small>
            <strong class="primary-font right-content" id="chat-user" style="display: block;">{{user}}</strong>
            {{else}}
            <strong class="primary-font" id="chat-user" >{{user}}</strong>
            <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <span>{{ts_received}}</span></small>
        {{/if}}
        </div>
        <p>
        {{sms_msg}}
        </p>
        </div>
        </li>
    {{/each}}
</script>

<script id="quick-inbox-template" type="text/x-handlebars-template">
    {{#each quick_inbox_messages}}
    <li>
        <input id="'{{mobile_id}}'" type="text" value="{{full_name}}" hidden>
        <a href="#" class="clearfix">   
            <img src="/images/Chatterbox/boy_avatar.png" alt="" class="img-circle">
            <div class="friend-name">   
                {{#if isunknown}}
                <strong class="unknown-number">{{user_number}} </strong>
                {{else}}
                <strong>{{full_name}} </strong>
                {{/if}}
            </div>
            <div class="last-message text-muted">{{msg}}</div>
            <small class="time text-muted"> {{ts_received}}</small>
        </a>
    </li>  
    {{/each}}
</script>

<script id="quick-release-template" type="text/x-handlebars-template">
    {{#each quick_release}}
    <li>
        <input type="text" value="{{name}}" hidden>  
        <a href="#" class="clearfix">   
            <img src="/images/Chatterbox/dewsl_03.png" alt="" class="img-circle">
            <div class="friend-name">   
                <strong style="text-transform: uppercase;">{{name}} - Region ({{region}}) - {{internal_alert_level}}</strong>
            </div>
            <div class="last-message text-muted">{{barangay}}, {{municipality}},{{province}}</div>
        </a>
    </li>  
    {{/each}}
</script>

<script id="selected-contact-template" type="text/x-handlebars-template">
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{fullname}}</strong> {{numbers}}
    </div>
</script>

<script id="ewi-template" type="text/x-handlebars-template">
    <!-- TODO -->
</script>
</body>

</html>