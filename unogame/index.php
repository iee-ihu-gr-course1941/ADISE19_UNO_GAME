<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: ../login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <link rel="stylesheet" type="text/css" href="gamecss.css">
    <script>

        function showMessage(messageHTML) {
            $("#opponents").load("loadOpponents.php", {

            })

            $("#main_board_div").load("loadMainBoard.php", {

            })

            $("#id_myCards_div").load("loadMyCards.php", {

            })
        }



         /*
         *  didSelectImage(selectedCardID) is a function that passes with post method to playCard.php the id of the card that the player just played.
         *  if it's not the current user he will get a not_your_turn data response and he will notified with an alert
         */
        function didSelectImage(selectedCardID) {

            $.ajax({
                url: "playCard.php",
                type: "POST",
                data: {"selectedCardID": selectedCardID},
                success: function(data) {
                     console.log("data = " + data);
                    if (data.localeCompare("not_your_turn") == 0) {
                        alert("It's not your turn!! ");
                    } else if (data.localeCompare("you_cant_play_this_card") == 0) {
                        alert("You can't play this card!");
                    }
                }
            });
        }


         function updateSubtitleStatus() {
            document.getElementById("id_subtitle").innerHTML = "Game started";

         }

         function buttonStartDidClick() {
            document.getElementById("btnSend").submit();
         }

         function reloadUI() {
                document.getElementById('id_reload_UI').submit();
           }


          function didClickPass() {

          }




    $(document).ready(function(){
    		var websocket = new WebSocket("ws://localhost:8090/demo/php-socket.php");
    		websocket.onopen = function(event) {
    			showMessage("Connection is established!");
    		}
    		websocket.onmessage = function(event) {
    		    updateSubtitleStatus()
    			var Data = JSON.parse(event.data);
    			showMessage("message="+Data.message_type+" "+Data.message+"");
    			$('#chat-message').val('');
    		};

    		websocket.onerror = function(event){
    			showMessage("Problem due to some Error");
    		};
    		websocket.onclose = function(event){
    			showMessage("Connection Closed");
    		};


    		$('#id_reload_UI').on("submit",function(event){
    			event.preventDefault();
    			$('#chat-user').attr("type","hidden");
    			var messageJSON = {
    				chat_user: "userData",
    				chat_message: "reload"
    			};
    			websocket.send(JSON.stringify(messageJSON));
    		});
    	});
    </script>

    <script>
        $(document).ready(function () {
            $("#opponents").load("loadOpponents.php", {

            })
        })
    </script>

    <script>
        $(document).ready(function () {
            $("#startButton").load("checkIfAdminStartButton.php", {

            })
        })

    </script>

    <script type='text/javascript'>
        function buttonStartDidClick() {
                document.getElementById('buttonStart').style.display='none';
                //window.location.href = "./startGame.php"; // uncomment me to test start.php
                $.get('startGame.php', function (data) {
                    reloadUI();
                });

        }
    </script>
    <script>
        $(window).bind('beforeunload', function(){
            $.get('deinitializeGame.php', function(data) {

            });
        });

    </script>



</head>
<body>
<div class="header">
    <h2>UNO</h2>
    <h4 id="id_subtitle">waiting for host... </h4>


    <div id="exit">
        <form>


        </form>

    </div>

    <div id="startButton">




    </div>

</div>



<div class="contentOpponents">

    <div id="opponents">


    </div>

</div>


<div id="main_board_div" class="content">


</div>


<div id="id_myCards_div" class="content">


</div>


<form name="reload_UI" id="id_reload_UI">
    <input type="submit" id="btnSend" name="form_that_reloads_sockets" value="Send" hidden=true >
</form>


</body>
</html>