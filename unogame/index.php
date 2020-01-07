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

        function checkForErrors(data) {
            if (data.localeCompare("not_your_turn") == 0) {
                alert("It's not your turn!! ");
            } else if (data.localeCompare("you_cant_play_this_card") == 0) {
                alert("You can't play this card!");
            } else if (data.localeCompare("you_must_pickACard_first") == 0) {
              alert("You must pick a card before you pass");
            } else if (data.localeCompare("you_have_already_Picked_a_card") == 0) {
              alert("You have already picked a card");
            } else  if (data.localeCompare("game_has_finished") == 0) {
                 var modal = document.getElementById("winnerModal");
                 modal.style.display = "block";
                 //$.redirectPost("getWinnerDetails.php");
                $("winnerBody").load("getWinnerDetails.php", {

                 })

                 $.ajax({
                      url: "getWinnerDetails.php",
                      type: "POST",
                      data: {},
                      success: function(data) {
                            document.getElementById("winnerBody").innerHTML = data;
                      }
                  });

            }
        }

    </script>


    <script>
        var selectedCardIDForColorCase;


        function drawOpponent(name, numberOfCards, cardType) {
          var parentDiv = document.createElement('div');
          var aParent = document.createElement('div');
          var cardTypeDiv = document.createElement('div');
          var profileImage = document.createElement('img');
          var h3 = document.createElement('h3');
          var testContainerDiv = document.createElement('div');
          var containerDiv = document.createElement('div');
          var unoCardsImage = document.createElement('img');
          var unoPlaceHolderDiv = document.createElement('div');
          var h1 = document.createElement('h1');
          h1.className = 'numberOfCards_h1';
          var numberOfCardsDiv = document.createElement('div');


            parentDiv.className  = 'parentsParent';
            aParent.className  = 'aParent';
            cardTypeDiv.className  = cardType;
            profileImage.src = "Assets/user.png";
            profileImage.className  = 'profileImage';
            h3.innerHTML = name;
            containerDiv.className = 'container';

            unoCardsImage.src = "Assets/uno_placeholder.png";
            unoCardsImage.className  = 'unoImage';



            testContainerDiv.className  = 'testContainer';
            h1.innerHTML = numberOfCards;
            numberOfCardsDiv.appendChild(h1);
            unoPlaceHolderDiv.appendChild(profileImage);

            testContainerDiv.appendChild(unoPlaceHolderDiv);
            testContainerDiv.appendChild(unoCardsImage);
            containerDiv.appendChild(testContainerDiv);
            containerDiv.appendChild(numberOfCardsDiv);

             cardTypeDiv.appendChild(profileImage);
             cardTypeDiv.appendChild(h3);
             cardTypeDiv.appendChild(containerDiv);
             aParent.appendChild(cardTypeDiv);
             parentDiv.appendChild(aParent);
             document.getElementById("opponents").appendChild(parentDiv);
        }


        function loadOpponents() {
            $.ajax({
                  url: "loadOpponents.php",
                  type: "POST",
                  data: {},
                  success: function(data) {
                     var parsedJSON = JSON.parse(data); // data is the json from loadOpponents.php
                      document.getElementById("opponents").innerHTML = ""; // we clear the div with id opponents so that we do not redraw the same opponents
                     for (var key in parsedJSON) {
                          var name = parsedJSON[key]["name"]; // for each opponent we map the data and we pass the to the drawOpponent so that the items can be drawn in the opponent div
                          var numberOfCards = parsedJSON[key]["number_of_cards"];
                          var isPlaying = parsedJSON[key]["isPlaying"];

                          var cardType = 'card';
                          if (isPlaying == true) {
                            cardType = "currentPlayerCard";
                          }
                          drawOpponent(name, numberOfCards,cardType);
                       }
                  }
              });
        }


        function loadMainBoard() {
             $.ajax({
                  url: "loadMainBoard.php",
                  type: "POST",
                  data: {},
                  success: function(data) {
                    document.getElementById("main_board_div").innerHTML = "";
                     var parsedJSON = JSON.parse(data); // data is the json from loadOpponents.php
                     var gameStarted = parsedJSON["isGameStarted"];
                     if (gameStarted == true) {
                        var cardSourceUL = parsedJSON["cardSourceUL"];
                        var wasLastCardBalader = parsedJSON["wasLastCardBalader"];

                        //<img width='120px' onclick='didClickPickACard()' src='Assets/uno_placeholder.png' alt='Pick a card'>
                        var pickACardImage = document.createElement('img');
                        pickACardImage.src = 'Assets/uno_placeholder.png';
                        pickACardImage.width = '120px';
                        pickACardImage.onclick = function() {
                                                    didClickPickACard();
                                                };
                        pickACardImage.alt = 'Pick a card';
                        pickACardImage.className = 'currentCardImage';
                        document.getElementById("main_board_div").appendChild(pickACardImage);
                        var lastCardPlayed = document.createElement('img');
                        lastCardPlayed.src = cardSourceUL;
                        lastCardPlayed.width = '120px';
                        lastCardPlayed.alt = 'Pick a card';
                        lastCardPlayed.className = 'oppositCurrentCardImage';
                        document.getElementById("main_board_div").appendChild(lastCardPlayed);
                        if (wasLastCardBalader == true) {
                            var baladerColor = parsedJSON["baladerColor"];
                             var baladerColorImage = document.createElement('img');
                             var str = 'background-color:';
                            baladerColorImage.style = str.concat(baladerColor);
                            baladerColorImage.className = 'currentPlayingColorInBalader';
                            document.getElementById("main_board_div").appendChild(baladerColorImage);
                        }


                        var passDiv = document.createElement('div');

                        var passButton = document.createElement('button');
                        passButton.onclick = function() {
                                                 didClickPass();
                                             };
                        passButton.innerHTML = 'PASS';
                        passButton.className = 'btn-grad';
                        passDiv.appendChild(passButton)
                        document.getElementById("main_board_div").appendChild(passDiv);
                     }

                  }
          });


        }


        function loadBoardCards() {
            $.ajax({
                  url: "loadMyCards.php",
                  type: "POST",
                  data: {},
                  success: function(data) {
                     var parsedJSON = JSON.parse(data); // data is the json from loadOpponents.php
                      document.getElementById("id_myCards_div").innerHTML = ""; // we clear the div with id opponents so that we do not redraw the same opponents
                     for (var key in parsedJSON) {
    //<img class='currentCardImage' onclick='didSelectImage($tmp_cardID)' width='120px' src='$cardResourceURL' alt='last played card'>
                        var id = parsedJSON[key]["cardid"];
                        var imageSRC = parsedJSON[key]["imageSourceURL"];
                        var imageToPlay = document.createElement('img');
                        imageToPlay.className = 'currentCardImage';
                        imageToPlay.src = imageSRC;
                        imageToPlay.onclick = function() {
                                              didSelectImage(id);
                                          };
                        imageToPlay.width = '120px';
                        document.getElementById("id_myCards_div").appendChild(imageToPlay);
                       }
                  }
              });


        }



        function showMessage(messageHTML) {
            loadOpponents();
            loadMainBoard();
            loadBoardCards();

            $.ajax({
                 url: "checkIfGameFinished.php",
                 type: "POST",
                 data: {},
                 success: function(data) {
                      console.log("data = " + data);
                      checkForErrors(data);
                 }
             });


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
                                 checkForErrors(data);
                                 reloadUI();
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
                        checkForErrors(data);
                        reloadUI();
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
                      checkForErrors(data);
                      reloadUI();
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
                         checkForErrors(data);
                         reloadUI();
                    }
                });
            }


          }




    $(document).ready(function(){
    		var websocket = new WebSocket("./php-socket.php");
    		websocket.onopen = function(event) {
    			showMessage("Connection is established!");
    		}
    		websocket.onmessage = function(event) {
    		    updateSubtitleStatus()
    			var Data = JSON.parse(event.data);
    			showMessage("message="+Data.message_type+" "+Data.message+"");
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
                loadOpponents();
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
    <h4 id="id_subtitle">waiting for host... </h4>
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
      <h3>      </h3>
    </div>
  </div>
</div>


<div id='winnerModal' class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <button id='winnerModalcloseID' class='close'>x</button>
      <h2>Game finished!!!</h2>
    </div>
    <div class="modal-body">
        <h1 id="winnerBody"></h1>
    </div>
    <div class="modal-footer">
      <h3>Congratulatyions!!!!</h3>
    </div>
  </div>
</div>


<script>

    $('#closeID').click(function(){
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    });

    $('#winnerModalcloseID').click(function(){
        var winnerModal = document.getElementById("winnerModal");
        winnerModal.style.display = "none";
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