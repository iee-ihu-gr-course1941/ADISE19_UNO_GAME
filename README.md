# Παιχνίδι Uno
https://users.iee.ihu.gr/~it154459/ADISE19_UNO_GAME 
## Bάση uno

### Πίνακες - Script για δημιουργία πίνακα ./initializationScripts

**users** - createDataBaseScript.php

| Attribute    | Description                             | Values        |
| :---:        |     :---:                               |    :---:      |
| id          | ID χρήστη                   | int(11)  |
| username     | Όνομα χρήστη                          | varchar(100)        |
| email     | email χρήστη | varchar(100)        |
| password     | password χρήστη | varchar(100)        |

* Στον πίνακα users αποθηκέυονται όλοι οι χρήστες αφού κάνουν register και μετά μπορούν να κάνουν logout και ξανά login μέσω αυτού του πίνακα. <br>
* Το password του χρήστη αποθηκεύεται στη βάση με md5 κωδικοποίησης ***md5($password_1); στο αρχείο server.php***<br>

**cards** - createCardsTable.php

| Attribute    | Description                             | Values        |
| :---:        |     :---:                               |    :---:      |
| cardid          | ID κάρτας                   | int(11)  |
| value     | Τιμή κάρτας Αριθμός, αλλαγή φοράς κτλ.                          | varchar(100)        |
| color     | Χρώμα κάρτας | varchar(20)        |

* Ο πίνακας cards λειτουργεί ως μία αποθήκη καρτών και δεν τροποποιείται παρά μόνο όταν τρέξει το script createCardsTable.php <br>
* Όλες οι κάρτεσ που βρίσκονται στο φάκελο Assets/cards έχουν σαν όνομα τη μορφή value_color.png <br>
* Με αυτόν τον τρόπο γίνεται από το id της κάρτας η αντιστοιχία με την εικόνα <br>


**games** - creategamesTable.php

| Attribute    | Description | Values        |
| :---:        |     :---:     |    :---:      |
| gameid          | ID παιχνιδιού | int(11)  |
| gamename     | Το όνομα του παιχνιδιού | varchar(100)|
| started     | Μεταβλητή για το αν το παιχνίδι έχει αρχίσει | BOOLEAN |
| finished     | Μεταβλητή για το αν το παιχνίδι έχει τελειώσει | BOOLEAN |
| adminid     | To id του χρήστη που έφτιαξε το παιχνίδι | INT|

* Στον πίνακα games αποθηκεύεται κάθε παιχνίδι που δημιουργείται. <br>
* Στην σελίδα <b> ADISE19_UNO_GAME/gameBoard/ </b> φαίνονται μόνο τα παιχνίδια των οποίων το started value είναι false. <br>
* Όταν η τιμή finished γίνει true τότε οι χρήστες στο παιχνίδι δεν μπορούν να συνεχίσουν να παίζουν.<br>

**gametousersconnection** - gametousersconnection.php
                   
| Attribute    | Description | Values        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| userid     | Τα id του παίχτη | INT(11) |

* Στον πίνακα gametousersconnection εισάγονται οι παίκτες για κάθε παιχνίδι.

**gametoorder** - gameΤoΟrder.php
                   
| Attribute    | Description | Values        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| userid     | Τα id του παίχτη | INT(11) |
| playerorder | Η τιμή της σειράς του παίχτη στο παιχνίδι | INT(11) |

* Ο πίνακας gametoorder χρησιμοποιείται για να κρατιέται η θέση των χρηστών. <br>
* Η εισαγωγή των παικτών γίνεται όταν ο admin ξεκινήσει το παιχνίδι με βάση τον πίνακα gametousersconnection.<br>
* Ο πίνακας αλλάζει τιμές στην μεταβλητή playerorder μόνο αν παιχτει η κάρτα switch order<br>


**gametowhoPlays** - gameToWhoPlays.php
                   
| Attribute    | Description | Values        |
| :---:        |     :---:     |    :---:      |
| gamename     | Το όνομα του παιχνιδιού | varchar(100)|
| userid     | Τα id του παίχτη | INT(11) |

* Στον πίνακα gametowhoPlays ορίζεται για κάθε παιχνίδι (gamename) το id του χρήστη ο οποίος παίζει. <br>
* Ο υπολογισμός γίνεται μέσω του πίνακα game to order μέσω της μεθόθου switchOrder που βρίσκεται στο αρχείο unogame/globalFunctions.php<br>

**createUserIDCards** - createUserIDCards.php
                   
| Attribute    | Description | Values        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| userid     | Τα id των παιχτών | INT(11) |
| cardid     | Τα id των καρτών του παίχτη | INT(11) |

* Στον πίνακα createUserIDCards γίνεται η αντιστοιχία ανάμεσα σε παίκτες και κάρτες. <br>
* Με αυτόν τον τρόπο φορτώνονται οι κάρτες στην οθόνη του χρήστη. <br>

**game_to_last_card** - createGameToLastCard.php

| Attribute    | Description | Values        |
| :---:        |     :---:     |    :---:      |
| gamename     | Το όνομα του παιχνιδιού | varchar(100)|
| lastCardId     | Το id της κάρτας που παίχτηκε τελευταία στο παιχνίδι | INT |

* Ο πίνακας game_to_last_card χρησιμοποιείται για να αποθηκεύεται το id της κάρτας που παίχτηκαι τελευταία στο board.<br>
* Κάθε φορά που παίζεται μία κάρτα γίνεται update η γραμμή με την τιμή gamename = όνομα του παιχνιδιού που παίχτηκε η κάρτα<br>

**game_to_not_played_cards** - createGameToNotPlayedCards.php

| Attribute    | Description | Values        |
| :---:        |     :---:     |    :---:      |
| gamename     | Το όνομα του παιχνιδιού | varchar(100)|
| availableCardId     | Τα id των καρτών που είναι δεν έχουν παιχτεί | INT |

* Στον πίνακα game_to_not_played_cards αποθηκεύονται όλες οι κάρτες που δεν έχουν παιχτεί στο παιχνίδι.<br>
* Όταν ξεκινάει το παιχνίδι στον πίνακα προστίθονται 108 γραμμές που είναι και οι κάρτες που έχει μία τράπουλα uno.<br>
* Καθε φορά που ένας παίκτης παίρνει μία κάρτα παίρνει μία από τις υπόλοιπες που υπάρχουν στον πίνακα game_to_not_played_cards και η γραμμή αυτή διαγράφεται.<br>

**gameToWinner** - createGameToWinner.php

| Attribute    | Description | Values        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| winnerID     | Τα id του παίχτη που κέρδισε το παιχνίδι | INT(11) |

* Στον πίνακα gameToWinner αποθηκεύεται το id του παίχτη που κέρδισε το παιχνίδι.<br>
* Όταν ένα παιχνίδι στον πίνακα games έχει τιμή finished = true τότε οι παίκτες βλέπου το μήνυμα και το όνομα του χρήστη που κέρδισε. <br>


**userToHasPickedACard** - createUserToHasPickedACard.php
                   
| Attribute    | Description | Values        |
| :---:        |     :---:     |    :---:      |
| gameName     | Το όνομα του παιχνιδιού | varchar(100)|
| userid     | Τα id του παίχτη | INT(11) |
| hasPickedACard     | Μεταβλητή που ελέγχει το εαν ένας παίκτης έχει τραβήξει κάρτα | Boolean |

* Ο πίνακας userToHasPickedACard χρησιμοποιείται για να ελέγχεται αν ένας παίκτης έχει τραβήξει κάρτα έτσι ώστε να μπορεί να κάνει πάσο.<br>
* Κάθε φορά που τραβάει κάρτα η τιμή hasPickedACard για το gameName που είναι και το userid του παίρνει την τιμή true και <br>
* Kάθε φορά που κάνει πάσο ή παίζει μία κάρτα η τιμή hasPickedACard γίνεται παίρνει την τιμή false <br>
