# Παιχνίδι Uno
https://users.iee.ihu.gr/~it154459/ADISE19_UNO_GAME 


## Κανόνες
* Από 2 εως 9 παίκτες.
* Ο host όταν πατήσει start ξεκινάει το παιχνίδι και μοιράζονται 7 κάρτες στον κάθε παίκτη
* Μία τυχαία κάρτα ανοίγει στο board και εφαρμόζονται όλες οι ενέργειες ποη αυτή η κάρτα προκαλεί στον παίκτη που παίζει πρώτος (πχ +2)
* Οι παίκτες παίζουν με τη σειρά και το παιχνίδι τελειώνει όταν ένας από τους παίκτες δεν έχει άλλες κάρτες.
* Όταν ένας παίκτης παίζει κάρτα +2 ή +4 ο επόμενος παίκτης παίρνει τον αντίστοιχο αριθμό καρτών.
* Όταν ένας παίκτης παίξει κάρτα "Χάσε τη σειρά σου" τότε ο επόμενος παίκτης χάνει τη σειρά του
* Όταν ένας παίκτης παίξει κάρτα "Αλλαγή φοράς" τότε αλλάζει η φορά του παιχνιδιού. Στους 2 παίκτες η κάρτα δεν λειτουργεί σαν κάρτα "Χάσε τη σειρά σου"
* Όταν ένας παίκτης παίξει κάρτα μπαλαντέρ ή μπαλαντέρ +4 τότε εμφανίζεται ένα παράθυρο για να διαλέξει το χρώμμα επιλογής του για να διαλέξει το χρώμμα που θέλει.
* Ένας παίκτης δεν μπορεί να παίξει όταν δεν είναι η σειρά του
* Ένας παίκτης δεν μπορεί να πάει πάσο αν δεν έχει τραβήξει πρώτα κάρτα
* Ένας παίκτης δεν μπορεί να τραβήξει στην σειρά του παραπάνω από 1 κάρτες
* Όλες οι κάρτες είναι 108
## Uno Game API
| URI    | METHOD                           | Example        
| :---:        |     :---:                    |    :---:     
| /unogame/loadMainBoard.php      | POST  |   {"isGameStarted":true,"cardSourceUL":"Assets\/cards\/0_blue.png","wasLastCardBalader":false,"baladerColor":""}  |
| /unogame/loadOpponents.php      | POST  |   {name: "username", number_of_cards: "7", isPlaying: false}  |
| /unogame/loadMyCards.php      | POST  |  {"0":{"imageSourceURL":"Assets\/cards\/1_red.png","cardid":"1"},"1":{"imageSourceURL":"Assets\/cards\/3_green.png","cardid":"12"},"2":{"imageSourceURL":"Assets\/cards\/loseOrder_blue.png","cardid":"42"},"3":{"imageSourceURL":"Assets\/cards\/8_yellow.png","cardid":"79"},"4":{"imageSourceURL":"Assets\/cards\/7_green.png","cardid":"28"},"5":{"imageSourceURL":"Assets\/cards\/4_blue.png","cardid":"62"},"6":{"imageSourceURL":"Assets\/cards\/6_green.png","cardid":"72"}}   |
|  /unogame/checkForRefresh.php    | POST  |   {"shouldUpdate":true,"latestVersionNewNumber":"2"}  |


## Bάση uno

### Πίνακες - Script για δημιουργία πίνακα ./initializationScripts

**users** - createDataBaseScript.php

| Μεταβλητή    | Περιγραφή                             | Τύπος        |
| :---:        |     :---:                               |    :---:      |
| id          | ID χρήστη                   | int(11)  |
| username     | Όνομα χρήστη                          | varchar(100)        |
| email     | email χρήστη | varchar(100)        |
| password     | password χρήστη | varchar(100)        |

* Στον πίνακα users αποθηκέυονται όλοι οι χρήστες αφού κάνουν register και μετά μπορούν να κάνουν logout και ξανά login μέσω αυτού του πίνακα. <br>
* Το password του χρήστη αποθηκεύεται στη βάση με md5 κωδικοποίησης ***md5($password_1); στο αρχείο server.php***<br>
<br><br><br><br>
**cards** - createCardsTable.php

| Μεταβλητή    | Περιγραφή                             | Τύπος        |
| :---:        |     :---:                               |    :---:      |
| cardid          | ID κάρτας                   | int(11)  |
| value     | Τιμή κάρτας Αριθμός, αλλαγή φοράς κτλ.                          | varchar(100)        |
| color     | Χρώμα κάρτας | varchar(20)        |

* Ο πίνακας cards λειτουργεί ως μία αποθήκη καρτών και δεν τροποποιείται παρά μόνο όταν τρέξει το script createCardsTable.php <br>
* Όλες οι κάρτεσ που βρίσκονται στο φάκελο Assets/cards έχουν σαν όνομα τη μορφή value_color.png <br>
* Με αυτόν τον τρόπο γίνεται από το id της κάρτας η αντιστοιχία με την εικόνα <br>
<br><br><br><br>
**games** - creategamesTable.php

| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gameid          | ID παιχνιδιού | int(11)  |
| gamename     | Το όνομα του παιχνιδιού | varchar(100)|
| started     | Μεταβλητή για το αν το παιχνίδι έχει αρχίσει | BOOLEAN |
| finished     | Μεταβλητή για το αν το παιχνίδι έχει τελειώσει | BOOLEAN |
| adminid     | To id του χρήστη που έφτιαξε το παιχνίδι | INT|

* Στον πίνακα games αποθηκεύεται κάθε παιχνίδι που δημιουργείται. <br>
* Στην σελίδα <b> ADISE19_UNO_GAME/gameBoard/ </b> φαίνονται μόνο τα παιχνίδια των οποίων το started value είναι false. <br>
* Όταν η τιμή finished γίνει true τότε οι χρήστες στο παιχνίδι δεν μπορούν να συνεχίσουν να παίζουν.<br>
<br><br><br><br>
**gametousersconnection** - gametousersconnection.php
                   
| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| userid     | Τα id του παίχτη | INT(11) |

* Στον πίνακα gametousersconnection εισάγονται οι παίκτες για κάθε παιχνίδι.
<br><br><br><br>
**gametoorder** - gameΤoΟrder.php
                   
| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| userid     | Τα id του παίχτη | INT(11) |
| playerorder | Η τιμή της σειράς του παίχτη στο παιχνίδι | INT(11) |

* Ο πίνακας gametoorder χρησιμοποιείται για να κρατιέται η θέση των χρηστών. <br>
* Η εισαγωγή των παικτών γίνεται όταν ο admin ξεκινήσει το παιχνίδι με βάση τον πίνακα gametousersconnection.<br>
* Ο πίνακας αλλάζει τιμές στην μεταβλητή playerorder μόνο αν παιχτει η κάρτα switch order<br>
<br><br><br><br>
**gametowhoPlays** - gameToWhoPlays.php
                   
| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gamename     | Το όνομα του παιχνιδιού | varchar(100)|
| userid     | Τα id του παίχτη | INT(11) |

* Στον πίνακα gametowhoPlays ορίζεται για κάθε παιχνίδι (gamename) το id του χρήστη ο οποίος παίζει. <br>
* Ο υπολογισμός γίνεται μέσω του πίνακα game to order μέσω της μεθόθου updateWhoPlays που βρίσκεται στο αρχείο unogame/globalFunctions.php<br>
<br><br><br><br>
**gametoVersion** - gameToVersion.php
                   
| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| versionNumber  | Τα version που έχει αυτή τη στιγμή το παιχνίδι του παίχτη | INT(11) |

* Ο πίνακας gametoVersion χρησιμοποιείται για να γίνεται update το board κάθε φορά που παίζει ένας παίχτης.
* Η μεταβλητή versionNumber αυξάνεται κάθε φορά που:
    * κάποιος παίζει μία κάρτα 
    * κάποιος κάνει πάσο
    * ο admin ξεκινάει το παιχνίδι
* Οι παίχτες ελέγχουν αν έχει μεγαλώσει το version number του παιχνιδιού κάθες 3,5 δευτερόλεπτα.
<br><br><br><br>
**createUserIDCards** - createUserIDCards.php
                   
| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| userid     | Τα id των παιχτών | INT(11) |
| cardid     | Τα id των καρτών του παίχτη | INT(11) |

* Στον πίνακα createUserIDCards γίνεται η αντιστοιχία ανάμεσα σε παίκτες και κάρτες. <br>
* Με αυτόν τον τρόπο φορτώνονται οι κάρτες στην οθόνη του χρήστη. <br>
<br><br><br><br>
**game_to_last_card** - createGameToLastCard.php

| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gamename     | Το όνομα του παιχνιδιού | varchar(100)|
| lastCardId     | Το id της κάρτας που παίχτηκε τελευταία στο παιχνίδι | INT |

* Ο πίνακας game_to_last_card χρησιμοποιείται για να αποθηκεύεται το id της κάρτας που παίχτηκαι τελευταία στο board.<br>
* Κάθε φορά που παίζεται μία κάρτα γίνεται update η γραμμή με την τιμή gamename = όνομα του παιχνιδιού που παίχτηκε η κάρτα<br>
<br><br><br><br>
**game_to_not_played_cards** - createGameToNotPlayedCards.php

| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gamename     | Το όνομα του παιχνιδιού | varchar(100)|
| availableCardId     | Τα id των καρτών που είναι δεν έχουν παιχτεί | INT |

* Στον πίνακα game_to_not_played_cards αποθηκεύονται όλες οι κάρτες που δεν έχουν παιχτεί στο παιχνίδι.<br>
* Όταν ξεκινάει το παιχνίδι στον πίνακα προστίθονται 108 γραμμές που είναι και οι κάρτες που έχει μία τράπουλα uno.<br>
* Καθε φορά που ένας παίκτης παίρνει μία κάρτα παίρνει μία από τις υπόλοιπες που υπάρχουν στον πίνακα game_to_not_played_cards και η γραμμή αυτή διαγράφεται.<br>
<br><br><br><br>
**gameToWinner** - createGameToWinner.php

| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| winnerID     | Τα id του παίχτη που κέρδισε το παιχνίδι | INT(11) |

* Στον πίνακα gameToWinner αποθηκεύεται το id του παίχτη που κέρδισε το παιχνίδι.<br>
* Όταν ένα παιχνίδι στον πίνακα games έχει τιμή finished = true τότε οι παίκτες βλέπου το μήνυμα και το όνομα του χρήστη που κέρδισε. <br>
<br><br><br><br>
**userToHasPickedACard** - createBaladerSelectedColors.php
                   
| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| userid     | Τα id του παίχτη | INT(11) |
| hasPickedACard     | Μεταβλητή που ελέγχει το εαν ένας παίκτης έχει τραβήξει κάρτα | Boolean |

* Ο πίνακας userToHasPickedACard χρησιμοποιείται για να ελέγχεται αν ένας παίκτης έχει τραβήξει κάρτα έτσι ώστε να μπορεί να κάνει πάσο.<br>
* Κάθε φορά που τραβάει κάρτα η τιμή hasPickedACard για το gameName που είναι και το userid του παίρνει την τιμή true και <br>
* Kάθε φορά που κάνει πάσο ή παίζει μία κάρτα η τιμή hasPickedACard γίνεται παίρνει την τιμή false <br>
<br><br><br><br>
**baladerSelectedColor** - createGameToNotPlayedCards.php

| Μεταβλητή    | Περιγραφή | Τύπος        |
| :---:        |     :---:     |    :---:      |
| gamename     | Το όνομα του παιχνιδιού | varchar(100)|
| color    |Το χρώμα του balader που επιλέχτηκε| varchar(100) |

* Ο πίνακας  baladerSelectedColor αποθηκεύεται για κάθε game το χρώμα του balader που επιλέχθηκε .<br>

<br>
<br><br><br><br>
