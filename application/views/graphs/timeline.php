<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Vertical Responsive Timeline UI - Template Monster Demo</title>
  <meta name="author" content="Jake Rocheleau">
  <link rel="shortcut icon" href="http://static.tmimgcdn.com/img/favicon.ico">
  <link rel="icon" href="http://static.tmimgcdn.com/img/favicon.ico">
  <link rel="stylesheet" type="text/css" media="all" href="/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" media="all" href="/css/bootstrap-glyphicons.css">
  <link rel="stylesheet" type="text/css" media="all" href="/css/timeline.css">
  <script type="text/javascript" src="/js/jquery-1.11.0.js"></script>
</head>

<body>
<div class="container">
  <header class="page-header">
    <h1>Dark Responsive Timeline with Bootstrap</h1>
  </header>
  
  <ul class="timeline">
    <li><div class="tldate">Mar 2015<div></li>
    
    <li>
      <div class="tl-circ"></div>
      <div class="timeline-panel">
        <div class="tl-heading">
          <h4>Surprising Headline Right Here</h4>
          <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 3 hours ago</small></p>
        </div>
        <div class="tl-body">
          <p>Lorem Ipsum and such.</p>
        </div>
      </div>
    </li>
    
    <li class="timeline-inverted">
      <div class="tl-circ"></div>
      <div class="timeline-panel">
        <div class="tl-heading">
          <h4>Breaking into Spring!</h4>
          <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 3/26/2015</small></p>
        </div>
        <div class="tl-body">
          <p>Hope the weather gets a bit nicer...</p>
            
          <p>Y'know, with more sunlight.</p>
        </div>
      </div>
    </li>
    

  </ul>
</div>
</body>

<script>
//Add some timeline entries
var date = 'Insert some Bogus Date';
var message = 'This is just a test message for the timeline experiment';
var totalposts = 2;

updateTimeline(totalposts, 3);

function updateTimeline(total, addNumPosts) {
	var mytable;

	for (var i = total + 1; i <= total + addNumPosts; i++) {
		//console.log("total = " + total + ", i = " + i);
		if (i % 2 == 1) {
			mytable += '<li>';
		}
		else {
			mytable += '<li class="timeline-inverted">';
		}

		mytable += '<div class="tl-circ"></div>';
		mytable += '<div class="timeline-panel">';
		mytable += '<div class="tl-heading">';
		mytable += '<h4>This is Header Number: ' + i + '</h4>';
		mytable += '<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> ' + date + '</small></p>';
		mytable += '</div>';
		mytable += '<div class="tl-body">';
		mytable += '<p>' + message + '</p>';
		mytable += '</div></div></li>';
	}

	$( ".timeline" ).append( mytable );
	
	totalposts = total + addNumPosts;
}

$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
       updateTimeline(totalposts, 3);
   }
});

</script>

</html>


































