    </div>
    <!-- /#wrapper -->



    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>

<?php if ($title == "chatterbox"): ?>
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <script id="messages-template-both" type="text/x-handlebars-template">
    {{#each messages}}
        {{#if isyou}}
        <li class="right clearfix">
            <span class="chat-img pull-right">
                <img src="/goldF/images/Chatterbox/dewsl_03.png" alt="User Avatar">
        {{else}}
        <li class="left clearfix">
            <span class="chat-img pull-left">
                <img src="/goldF/images/Chatterbox/boy_avatar.png" alt="User Avatar">
        {{/if}}
            </span>
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font">{{user}}</strong>
                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> {{timestamp}}</small>
                </div>
                <p>
                    {{msg}}
                </p>
            </div>
        </li>
    {{/each}}
    </script>

    <script id="selected-contact-template" type="text/x-handlebars-template">
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{fullname}}</strong> {{numbers}}
        </div>
    </script>
    
    <script src="/goldF/js/awesomplete.min.js"></script>
    <script src="/goldF/js/dewslandslide/dewschatterbox.js"></script>
<?php else: ?>
    <script type="text/javascript">
        var others = "others";
    </script>
<?php endif; ?>
    <script>
    



    $(document).ready(function()
    {

        // Closes the sidebar menu on menu-close button click event
        $("#menu-close").click(function(e)                          //declare the element event ...'(e)' = event (shorthand)
        {
                                                                    // - will not work otherwise")
            $("#sidebar-wrapper").toggleClass("active");            //instead on click event toggle active CSS element
            e.preventDefault();                                     //prevent the default action ("Do not remove as the code

            /*!
            ======================= Notes ===============================
            * see: .sidebar-wrapper.active in: style.css
            ==================== END Notes ==============================
            */
        });                                                         //Close 'function()'

        // Open the Sidebar-wrapper on Hover
        $("#menu-toggle").hover(function(e)                         //declare the element event ...'(e)' = event (shorthand)
        {
            $("#sidebar-wrapper").toggleClass("active",true);       //instead on click event toggle active CSS element
            e.preventDefault();                                     //prevent the default action ("Do not remove as the code
        });

        $("#menu-toggle").bind('click',function(e)                  //declare the element event ...'(e)' = event (shorthand)
        {
            $("#sidebar-wrapper").toggleClass("active",true);       //instead on click event toggle active CSS element
            e.preventDefault();                                     //prevent the default action ("Do not remove as the code
        });                                                         //Close 'function()'

        $('#sidebar-wrapper').mouseleave(function(e)                //declare the jQuery: mouseleave() event
                                                                    // - see: ('//api.jquery.com/mouseleave/' for details)
        {
            /*! .toggleClass( className, state ) */
            $('#sidebar-wrapper').toggleClass('active',false);      /* toggleClass: Add or remove one or more classes from each element
                                                                    in the set of matched elements, depending on either the class's
                                                                    presence or the value of the state argument */
            e.stopPropagation();                                    //Prevents the event from bubbling up the DOM tree
                                                                    // - see: ('//api.jquery.com/event.stopPropagation/' for details)


            e.preventDefault();                                     // Prevent the default action of the event will not be triggered
                                                                    // - see: ('//api.jquery.com/event.preventDefault/' for details)
        });
    });
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
        placement : 'left'
    });
});
    // sliding toggle
     $(document).ready(function(){
                $("#button_right").click(function(){
                    $("#slide_right").toggleClass("slide_right_open");/*Opens and closes the menu*/
                    if($("#slide_right").hasClass("slide_right_open")){/*If the menu is open, then:*/
                        $("#bpright").toggleClass('glyphicon glyphicon-menu-left').toggleClass('glyphicon glyphicon-menu-right')
                    }else{
                        $("#bpright").toggleClass('glyphicon glyphicon-menu-right').toggleClass('glyphicon glyphicon-menu-left');
                    }
                 });


    });

</script>

</body>

</html>
