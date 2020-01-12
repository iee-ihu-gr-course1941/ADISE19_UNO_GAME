<?php


    include('../server.php');
    $gameName = $_SESSION['gamename'];
    $latestCashedVersionNumber = $_POST['latestCashedVersionNumber'];

    $sql_get_latestVersionNumber = "SELECT versionNumber from gametoVersion where gameName = '$gameName'";
    $sqlResult_get_latestVersionNumber = mysqli_query($db, $sql_get_latestVersionNumber);
    $sqlResult_get_latestVersionNumber_first_row = mysqli_fetch_assoc($sqlResult_get_latestVersionNumber);
    $latestVersionNumber = $sqlResult_get_latestVersionNumber_first_row['versionNumber'];

    $jsonToReturn = new ObjectToReturn();

    if ($latestVersionNumber > $latestCashedVersionNumber)  {
        $jsonToReturn->shouldUpdate = true;
        $jsonToReturn->latestVersionNewNumber = $latestVersionNumber;
        echo ("Refresh");
    } else {
        $jsonToReturn->shouldUpdate = false;
        $jsonToReturn->latestVersionNewNumber = $latestVersionNumber;
    }

    echo json_encode($jsonToReturn);

?>