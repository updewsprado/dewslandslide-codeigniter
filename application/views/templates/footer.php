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
        $("#menu-close").click(function(e)                          
        {
                                                    
            $("#sidebar-wrapper").toggleClass("active");            
            e.preventDefault();                                    
        });                                                    
        $("#menu-toggle").hover(function(e)                        
        {
            $("#sidebar-wrapper").toggleClass("active",true);       
            e.preventDefault();                                     
        });

        $("#menu-toggle").bind('click',function(e)             
        {
            $("#sidebar-wrapper").toggleClass("active",true);    
            e.preventDefault();   
        });   

        $('#sidebar-wrapper').mouseleave(function(e)            
        {
            $('#sidebar-wrapper').toggleClass('active',false);  
            e.stopPropagation();                              
            e.preventDefault();        
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
