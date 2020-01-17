<?php
    include('../server.php');
    session_start();

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

        $sql = "";
        $sql_query = "SELECT * from gametoVersion where username = '$gameName'";
        $sql_query_result = mysqli_query($db, $sql_query);
        $numberOfResults = mysqli_num_rows($sql_query_result); // We get the result of that query and if we have a result then the user wasn't the last one in the queue
        if ($numberOfResults > 0) {
        
            header("location: ../index.php");
        } else {
            $sqlInitializeGameToVersion = "INSERT INTO gametoVersion (gameName,versionNumber) VALUES ('$gameName','1')";
                    $result_sqlInitializeGameToVersion = mysqli_query($db, $sqlInitializeGameToVersion); // here we initialize for the game the game to version. This is going to be used for polling // Auto refresh

                    if (strcmp($gameName,'') > 0) {
                        $_SESSION['gamename'] = $gameName;

                        $sql = "SELECT id FROM users WHERE username='$adminUserName'";
                        $resultID = mysqli_query($db, $sql);
                        $firstrow = mysqli_fetch_assoc($resultID);
                        $adminID = $firstrow['id'];
                        echo $adminID;
                        $_SESSION["userID"] = $adminID;
                        $_SESSION["isAdmin"] = true;


                        /*  2
                            create the game in games table with admin id the users id and default values to started and finished to false
                        */

                        $sql = "INSERT INTO games (adminid, gamename, finished, started) VALUES ('$adminID', '$gameName',false, false)";
                        $result = mysqli_query($db, $sql);


                        /* 4
                            gametousersconnection keeps many to many assotiation between users and games
                            we insert the assotiation between the user and the game
                        */
                        $sql = "INSERT INTO gametousersconnection (userid, gameName) VALUES ('$adminID','$gameName')";
                        $resultID = mysqli_query($db, $sql);



                        header("location: ../unogame");
                     } else {
                        header("location: ../index.php");
                     }

        }


?>