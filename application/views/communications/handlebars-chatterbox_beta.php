    <script id="messages-template-both" type="text/x-handlebars-template">
        {{#each messages}}
        {{#if isyou}}
        {{#if hasTag}}
            <li class="right clearfix tagged" title="Tagged Messaged">
        {{else}}
            <li class="right clearfix">
        {{/if}}
        <input type="text" id="msg_details" value="{{type}}<split>{{user}}<split>{{timestamp}}<split>{{user_number}}<split>{{msg}}<split>{{sms_id}}<split>{{table_used}}" hidden>
            <span class="chat-img pull-right" id="badge-id-you">
                <img src="/images/Chatterbox/dewsl_03.png" alt="User Avatar">
                {{else}}
                {{#if hasTag}}
                    <li class="left clearfix tagged" title="Tagged Messaged">
                {{else}}
                    <li class="left clearfix">
                {{/if}}
                <input type="text" id="msg_details" value="{{type}}<split>{{user}}<split>{{timestamp}}<split>{{user_number}}<split>{{msg}}<split>{{sms_id}}<split>{{table_used}}" hidden>
                    <span class="chat-img pull-left" id="badge-id-user">
                        <img src="/images/Chatterbox/boy_avatar.png" alt="User Avatar">
                        {{/if}}
                    </span>
                    <div class="chat-body clearfix tagged" id="id_{{timestamp}}">
                        <div class="header">
                            {{#if isyou}}
                            <small class="pull-left text-muted"><i class="fa fa-clock-o"></i> <span id="timestamp-written" title="Timestamp: Written">{{timestamp}}</span>, <i class="fa fa-clock-o"></i> <span id="timestamp-sent" title="Timestamp: GSM Sent">{{timestamp_sent}}</span></small>
                            <strong class="primary-font right-content" id="chat-user" style="display: block;">{{user}}</strong>
                            {{else}}
                            <strong class="primary-font" id="chat-user" >{{user}}</strong>
                            <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <span>{{timestamp}}</span></small>
                            {{/if}}
                        </div>
                        <p>
                            {{msg}}
                        </p>
                    </div>
                </li>
                {{/each}}
            </script>

            <script id="quick-inbox-template" type="text/x-handlebars-template">
                {{#each quick_inbox_messages}}
                <li>
                    <input id="'{{user}}'" type="text" value="{{name}} - {{user}}" hidden>
                    <a href="#" class="clearfix">   
                        <img src="/images/Chatterbox/boy_avatar.png" alt="" class="img-circle">
                        <div class="friend-name">   
                            {{#if isunknown}}
                            <strong class="unknown-number">{{user}} </strong>
                            {{else}}
                            <strong>{{name}} </strong>
                            {{/if}}
                        </div>
                        <div class="last-message text-muted">{{msg}}</div>
                        <small class="time text-muted"> {{timestamp}}</small>
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

            <script id="group-message-template" type="text/x-handlebars-template">
                {{#each group_message}}
                <li>
                    <input type="text" value="{{name}}" hidden>  
                    <a href="#" class="clearfix">   
                        <img src="/images/Chatterbox/dewsl_03.png" alt="" class="img-circle">
                        <div class="friend-name" id="{{site}}_grpmsg">   
                            <strong style="text-transform: uppercase;">{{site}} - {{barangay}}, {{municipality}},{{province}}</strong>
                        </div>
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
