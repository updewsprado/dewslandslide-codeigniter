    </div>


    <script id="messages-template-both" type="text/x-handlebars-template">
        {{#each messages}}
        {{#if isyou}}
        <li class="right clearfix">
        <input type="text" id="msg_details" value="{{type}}<split>{{user}}<split>{{timestamp}}<split>{{user_number}}<split>{{msg}}<split>{{sms_id}}<split>{{table_used}}" hidden>
            <span class="chat-img pull-right" id="badge-id-you">
                <img src="/images/Chatterbox/dewsl_03.png" alt="User Avatar">
                {{else}}
                <li class="left clearfix">
                <input type="text" id="msg_details" value="{{type}}<split>{{user}}<split>{{timestamp}}<split>{{user_number}}<split>{{msg}}<split>{{sms_id}}<split>{{table_used}}" hidden>
                    <span class="chat-img pull-left" id="badge-id-user">
                        <img src="/images/Chatterbox/boy_avatar.png" alt="User Avatar">
                        {{/if}}
                    </span>
                    <div class="chat-body clearfix" id="id_{{timestamp}}">
                        <div class="header">
                            <strong class="primary-font" id="chat-user" >{{user}}</strong>
                            {{#if isyou}}
                            <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <span id="timestamp-written" title="Timestamp: Written">{{timestamp}}</span>, <i class="fa fa-clock-o"></i> <span id="timestamp-sent" title="Timestamp: GSM Sent">{{timestamp_sent}}</span></small>
                            {{else}}
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

            <script id="selected-contact-template" type="text/x-handlebars-template">
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{fullname}}</strong> {{numbers}}
                </div>
            </script>
        </body>

        </html>
