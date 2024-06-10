<?php

include "configuration/config_connect.php";
include "configuration/config_include.php";
session();
$jumlah = 0;
$bayar = 0;

if (isset($_POST['awb'])) {
    $awb        = $_POST['awb'];
    $query = "
    SELECT  
    a.trnNamePicture AS pod, 
    CONCAT(a.trnLatitudeGps,',',a.trnLongitudeGps) AS map, 
    a.trnSignature AS signature,
    a.trnNameLocation AS location, 
    a.trnPictReceiver AS receiver
    FROM traceheaderhawb a WHERE a.trnNumberAwb =  {$awb} limit 1";

    if ($result = mysqli_query($conn2, $query)) {
        $rowcount = mysqli_num_rows($result);
        if ($rowcount > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $response[] = array(
                    "pod" => $row['pod'],
                    "map" => $row['map'],
                    "signature" => $row['signature'],
                    "location" => $row['location'],
                    "receiver" => $row['receiver']
                );
            }
            $response2 = array(
                "Status" => 'Success',
                "Data"  => $response
            );
            echo json_encode($response2);
        } else {
            echo json_encode(array('Status' => 'Failed'));
        }
    } else {
        echo json_encode(array('Status' => 'Failed'));
    }
} else {
    echo json_encode(array('Status' => 'Failed'));
}
exit;
