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
    a.checkStampdate, 
    a.checkStampuser,
    a.checkHeader,
    a.checkStatus,
    a.checkRemarks
    FROM tracecheckpointhawb a 
    WHERE a.checkNumberAwb = {$awb}";

    if ($result = mysqli_query($conn2, $query)) {
        $rowcount = mysqli_num_rows($result);
        if ($rowcount > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $response[] = array(
                    "timeline" => $row['checkStampdate'],
                    "user" => $row['checkStampuser'],
                    "header" => $row['checkHeader'],
                    "status" => $row['checkStatus'],
                    "remarks" => $row['checkRemarks']
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
