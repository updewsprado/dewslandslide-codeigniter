<?php
// Database login information
$servername = "localhost";
$username = "updews";
$password = "october50sites";
$dbname = "senslopedb";

//Weather Stations
$GndMeasurementFull;
$GndMeasurement;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT DISTINCT site_id FROM senslopedb.gndmeas order by site_id asc";
$result = mysqli_query($conn, $sql);

$numSites = 0;
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $GndMeasurementFull[$numSites++]["site_id"] = $row["site_id"];
    
    }
} 


$sql2 = "SELECT DISTINCT crack_id FROM senslopedb.gndmeas where site_id ='agb' order by site_id asc";
$result2 = mysqli_query($conn, $sql2);

$numSites2 = 0;
if (mysqli_num_rows($result2) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result2)) {
        $GndMeasurement[$numSites2++]["crack_id"] = $row["crack_id"];
    
    }
} 

echo json_encode($GndMeasurementFull);
mysqli_close($conn);
?>