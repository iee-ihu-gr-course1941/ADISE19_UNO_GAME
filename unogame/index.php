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
    <link rel="stylesheet" type="text/css" href="popUp.css">


    <script>
        $.extend(
        {
            redirectPost: function(location, argsKey, argVal)
            {
                var form = '';
                form += "<input type='hidden' name='selectedCardIDPassed' value='"+argVal+"'>";
                form += "<input type='hidden' name='colorForBalader' value='yellow'>";
                $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo($(document.body)).submit();
            }
        });

    </script>

    <script>
        var selectedCardIDForColorCase;
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
            if (selectedCardID > 100) {
                selectedCardIDForColorCase = selectedCardID;
                var modal = document.getElementById("myModal");
                modal.style.display = "block";
            } else {
                var dubugMode = false; // This variable is so that we can test with the php echo the results on functions on playcard.php and globalfunctions
                if (dubugMode == true) {
                    $.redirectPost("playCard.php", "selectedCardIDPassed", selectedCardID);
                } else {
                    $.ajax({
                            url: "playCard.php",
                            type: "POST",
                            data: {"selectedCardIDPassed": selectedCardID},
                            success: function(data) {
                                 console.log("data = " + data);
                                if (data.localeCompare("not_your_turn") == 0) {
                                    alert("It's not your turn!! ");
                                } else if (data.localeCompare("you_cant_play_this_card") == 0) {
                                    alert("You can't play this card!");
                                } else {
                                    reloadUI();
                                }
                            }
                        });
                }
            }


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
              var dubugMode = false; // This variable is so that we can test with the php echo the results on functions on playcard.php and globalfunctions
              if (dubugMode == true) {
                  $.redirectPost("didClickPass.php");
              } else {
                $.ajax({
                    url: "didClickPass.php",
                    type: "POST",
                    data: {},
                    success: function(data) {
                         console.log("data = " + data);
                        if (data.localeCompare("not_your_turn") == 0) {
                            alert("It's not your turn!! ");
                        } else if (data.localeCompare("you_must_pickACard_first") == 0) {
                            alert("You must pick a card before you pass");
                        } else {
                            reloadUI();
                        }
                    }
                });
                }
          }

          function didPickColor(color) {
             $.ajax({
                 url: "playCard.php",
                 type: "POST",
                 data: {"selectedCardIDPassed": selectedCardIDForColorCase, "colorForBalader":color},
                 success: function(data) {
                      console.log("data = " + data);
                     if (data.localeCompare("not_your_turn") == 0) {
                         alert("It's not your turn!! ");
                     } else if (data.localeCompare("you_cant_play_this_card") == 0) {
                         alert("You can't play this card!");
                     } else {
                         reloadUI();
                     }
                 }
             });
          }

          function didClickPickACard() {
            var dubugMode = false; // This variable is so that we can test with the php echo the results on functions on playcard.php and globalfunctions
            if (dubugMode == true) {
                $.redirectPost("pickACard.php");
            } else {
                $.ajax({
                    url: "pickACard.php",
                    type: "POST",
                    data: {},
                    success: function(data) {
                         console.log("data = " + data);
                        if (data.localeCompare("not_your_turn") == 0) {
                            alert("It's not your turn!! ");
                        } else if (data.localeCompare("you_cant_play_this_card") == 0) {
                            alert("You can't play this card!");
                        } else if (data.localeCompare("you_have_already_Picked_a_card") == 0) {
                            alert("You have already picked a card");
                        } else {
                            reloadUI();
                        }
                    }
                });
            }


          }




    $(document).ready(function(){
    		var websocket = new WebSocket("ws://localhost:8090/ADISE19_UNO_GAME/unogame/php-socket.php");
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

<div id='myModal' class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <button id='closeID' class='close'>x</button>
      <h2>Pick a color</h2>
    </div>
    <div class="modal-body">
      <img class='currentPlayingColorInBalader' style='background-color:#30911F' onclick='didPickColor("green")'>
      <img class='currentPlayingColorInBalader' style='background-color:#ff0000' onclick='didPickColor("red")'>
      <img class='currentPlayingColorInBalader' style='background-color:#89cff0' onclick='didPickColor("blue")'>
      <img class='currentPlayingColorInBalader' style='background-color:#ffff00' onclick='didPickColor("yellow")'>
    </div>
    <div class="modal-footer">
      <h3></h3>
    </div>
  </div>

</div>

<script>

    $('#closeID').click(function(){
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    });

</script>

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