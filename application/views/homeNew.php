<!doctype html>
<html lang="en">
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
</head>

<body>
	<div id="container">
		<p>My View has been loaded</p>

		<?php 
		foreach($rows as $r) {
			echo '<h1>' . $r->title . '</h1>';
		} 
		?>
		
		<?php foreach($rows as $r): ?>
		<h1><?php echo $r->title; ?></h1>
		<p><?php echo $r->author; ?></p>
		<div><?php echo $r->contents; ?></div>
		<?php endforeach; ?>
	</div>
</body>	
	
</html>