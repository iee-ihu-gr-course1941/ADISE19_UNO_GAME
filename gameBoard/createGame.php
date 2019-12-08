<?php
    include('../server.php');


        /* 1
         *  get from session the users name
         * get the game name from the post variable
         *
         * with user name from database we get the users id
         *
         */
        $adminUserName = $_SESSION['username'];
        echo $adminUserName;
        $gameName = $_POST['gamename'];


        $sql = "SELECT id FROM users WHERE username='$adminUserName'";
        $resultID = mysqli_query($db, $sql);
        $firstrow = mysqli_fetch_assoc($resultID);
        $adminID = $firstrow['id'];
        echo $adminID;



        /*  2
            create the game in games table with admin id the users id and default values to started and finished to false
        */

        $sql = "INSERT INTO games (adminid, gamename, finished, started) VALUES ('$adminID', '$gameName',false, false)";
        $result = mysqli_query($db, $sql);

        /* 3
         * Now we have from 1 the users id so we get the game id from the games table
         *
         */

        $sql = "SELECT gameid FROM games WHERE adminid='$adminID'";
        $resultID = mysqli_query($db, $sql);
        $firstrow = mysqli_fetch_assoc($resultID);
        $gameID = $firstrow['gameid'];
        $_SESSION['gameID'] = $gameID;
        echo $gameID;


        /* 4
            gametousersconnection keeps many to many assotiation between users and games
            we insert the assotiation between the user and the game
        */
        $sql = "INSERT INTO gametousersconnection (userid, gameid) VALUES ('$adminID','$gameID')";
        $resultID = mysqli_query($db, $sql);

        header("location: ../unogame");

?>