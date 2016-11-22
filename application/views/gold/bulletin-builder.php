<!--
    
     Created by: Kevin Dhale dela Cruz
     
     The page the creates the PDF report look;
     called by and screenshot by PhantomJS
     
     Linked at [host]/gold/bulletin-builder/$id
     
 -->

<?php  


?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<style type="text/css">

	/* FOR LINUX/UBUNTU */
	body {
		zoom: 0.75;
	}

	@media print {
		color: #000;
	}

	a i {
		color: blue !important;
	}

	a[href]:after {
    	content: none !important;
  	}

	@font-face {
		font-family: 'Arial';
		src:	url('/fonts/Arial/arial.ttf'),
				url('/fonts/Arial/ArialMT.otf'),
				url('/fonts/Arial/ArialMT.woff') format('woff');
		font-weight: normal;
		font-style: normal;
	}

	@font-face {
		font-family: 'Arial';
		src: 	url('/fonts/Arial/arialbd.ttf'),
				url('/fonts/Arial/Arial-BoldMT.otf'),
				url('/fonts/Arial/Arial-BoldMT.woff') format('woff');
		font-weight: bold;
		font-style: normal;
	}

	@font-face {
		font-family: 'Arial';
		src: 	url('/fonts/Arial/ariali.ttf'),
				url('/fonts/Arial/Arial-ItalicMT.otf'),
				url('/fonts/Arial/Arial-ItalicMT.woff') format('woff');
		font-style: italic;
	}

	body {
		font-family: 'Arial', sans-serif;
		color: #000;
	}

	.text-area {
		margin: 1in;
	}

	.images > img {
		width: 15.46in;
		height: 20in;
	}

	.center-text {
		text-align: center;
	}

	#phivolcs, #dost{
		width: 123.75px; //165px*0.75
		height: 145.5px; //194px*0.75
	}

	#header-text div {
		margin: -5px;
	}

	#header-text > div:nth-child(1) {
		font-size: 20px;
		font-weight: bold;
		color: blue !important;
	}

	#header-text > div:nth-child(2) {
		font-size: 22px;
		font-weight: bold;
		color: red !important;
	}

	#header-text > div:nth-child(3) {
		font-size: 27px;
		font-weight: bold;
		color: #000080 !important;
	}

	#header-text > div:nth-child(4), #header-text > :nth-child(5), #header-text > :nth-child(6), #header-text > :nth-child(7) {
		font-size: 18px;
		color: blue !important;
	}

	#title {
		margin-top: 25px; //30
		margin-bottom: 15px; //20
	}

	.panel-default {
		border-color: black;
	}

	#bulletin, #areaSituation, #footer {
		font-size: 24px; //27
	}

	#bulletin .row {
		margin: 10px 0; //12
	}

	#bulletin .col-sm-8 {
		padding-left: 0;
		font-weight: bold;
	}

	#areaSituation .row {
		margin: 12px 0; //20
	}

	#areaSituation h3 {
		font-size: 26px; //32
		margin-top: 0;
	}

	#areaSituation p {
		text-indent: 60px;
	}

	.rowIndent {
		padding-left: 60px;
	}

	#footer	{
		margin-top: 20px;
	}

</style>

<div id="page-wrapper" style="height: 100%;">
	<div class="container-fluid">
		<?php echo $bulletin; ?>
    </div>
</div>