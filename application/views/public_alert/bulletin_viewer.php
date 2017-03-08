<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A page that calls PhantomJS to generate
     PDF reports
     
     Linked at [host]/gold/bulletin
     
 -->

<?php  

//$pdf_base64 = "d:\\Documents\\Senslope\\PhantomJS\\examples\\output.txt";
//echo $pdf_base64;

//Get File content from txt file
//$pdf_base64_handler = fopen($pdf_base64,'r');
//$pdf_content = fread($pdf_base64_handler,filesize($pdf_base64));
//echo $pdf_content;

//fclose ($pdf_base64_handler);

/*$b64Doc = chunk_split(base64_encode(file_get_contents("d:\\Documents\\Senslope\\PhantomJS\\examples\\z.pdf")));
$pdf = fopen("d:\\Documents\\Senslope\\PhantomJS\\examples\\output2.txt",'w');
fwrite($pdf, $b64Doc);
fclose($pdf);


$pdf_base64 = "d:\\Documents\\Senslope\\PhantomJS\\examples\\output2.txt";
$pdf_base64_handler = fopen($pdf_base64,'r');
$pdf_content = fread($pdf_base64_handler,filesize($pdf_base64));
//Decode pdf content
$pdf_decoded = base64_decode($pdf_content);
//echo $pdf_decoded;

//Write data back to pdf file
$pdf = fopen ('d:\\Documents\\Senslope\\PhantomJS\\examples\\test.pdf','w');
fwrite($pdf, $pdf_decoded);
//close output file
fclose($pdf);*/

/*$command = $_SERVER['DOCUMENT_ROOT'] . "/js/phantomjs/phantomjs" . " " . $_SERVER['DOCUMENT_ROOT'] . "/js/bulletin-maker.js";

echo $command;
$response = exec( $command );*/

/*switch ($id) {
	case 'A0':
		$file = "bulletin-A0.pdf";
		$filename = 'bulletin-A0.pdf';
		break;
	case 'A1-D':
	case 'ND-D':
		$file = "bulletin-A1D.pdf";
		$filename = 'bulletin-A1D.pdf';
		break;
	case 'A1-R':
	case 'ND-R':
		$file = "bulletin-A1R.pdf";
		$filename = 'bulletin-A1R.pdf';
		break;
	case 'A1-E':
	case 'ND-E':
		$file = "bulletin-A1E.pdf";
		$filename = 'bulletin-A1E.pdf';
		break;
	case 'A2':
		$file = "bulletin-A2.pdf";
		$filename = 'bulletin-A2.pdf';
		break;
	case 'A3':
		$file = "bulletin-A3.pdf";
		$filename = 'bulletin-A3.pdf';
		break;
	default:
		# code...
		break;
}*/

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $file = $_SERVER['DOCUMENT_ROOT'] . "/bulletin.pdf";
else $file = $_SERVER['DOCUMENT_ROOT'] . "/js/dewslandslide/public_alert/bulletin.pdf";
//$filename = 'bulletin.pdf';
header('HTTP/1.0 200 OK');  
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $str . '"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
readfile($file);
//echo file_get_contents($file);

//unlink($file);

// $file= "d:\\Documents\\Senslope\\PhantomJS\\examples\\z.pdf";
// $filename = 'test.pdf';
// @header("Content-type: application/pdf");
// @header("Content-Disposition: attachment; filename=$filename");
// echo file_get_contents($file);

/*$fsize = filesize($fullPath);
header("Content-length: $fsize");
header("Cache-control: private"); //use this to open files directly
while(!feof($fd)) {
    $buffer = fread($fd, 2048);
    echo $buffer;
}*/

//$response = system('phantomjs D:/Documents/Senslope/PhantomJS/examples/z.js');

//$response = exec('phantomjs z.js');


?>

