    </div>
    <!-- /#wrapper -->



    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>



    <!-- Morris Charts JavaScript
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
    -->

    <!-- Flot Charts JavaScript -->
    <!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/flot-data.js"></script>
    -->
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
                        $("#bpright").hasClass('glyphicon glyphicon-menu-left');/*Change the menu button icon*/
                    }else{
                        $("#bpright").hasClass('glyphicon glyphicon-menu-right');/*If the menu is closed, change to the original button icon*/
                    }
                    /*Just for presentation purposes, to appear over the Push Left Menu - you can use it if you have the two, but it's not required*/
                    // }
                 });


    });

     //hide NODE name





</script>

</body>

</html>
