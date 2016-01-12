// Your assignment is to create a simple text adventure game to reinforce what you’ve learned so far about javascript.


"use strict"

var currentLocation = "forest";
var winDestination = "insideHouse";
var response;

//LOCATION MESSAGES - keep these or write your own.
var forestMessage = "Ryan is in a forest.  The smell of wet leaves and maple syrup reminds Ryan of late saturday morning breakfasts at his grandma\'s house.  Ryan can\'t go north or east because the trees get too dense.  To his west, Ryan can see a house.  There's a clearing to his south.";
var clearingMessage = "This clearing is... surprisingly clear.  There\'s nothing here at all and after a moment Ryan starts to question his motives for coming here.  Why did he come this way?  Should he leave?  More importantly, can Ryan even make these choices or is he under the command of unseen forces.  Is some stranger at a keyboard somehwere controlling every move.  In any case, it would take far too long to walk south or east across the clearing.  There's a forest to his north and a pond to his west.";

var pondMessage = "Ryan comes to a pond and nearly stumbles in. The water looks cool and refreshing and Ryan is thirsty.  Ryan sure would like a drink.  It\'s a big pond, extending far to the south and west.  To his north, Ryan can see a house.  To his east, there\'s a large clearing.";

var houseMessage = "Ryan finally reaches a house.  Is it his house?  His memory has been hazy since the accident.  The house is fenced in to the north and west.  He can see a forest to his east and a pond to his south.";

var winMessage = "Ryan collapses on the couch inside the door.  He\'s still not sure this is his house but he feels a sense of accomplishment.  If life were a game, he\'d surely be winning."

var notLocation = "You cannot do this, try again!"



//TODO: Use a while loop to determine if the player is at the win (winning) destination.  

//TODO: Use a switch to check the current location of the player.

//TODO: For each possible location, display the message about it (defined above or create your own) and then prompt for the user's next move.

//TODO: When the user is at the house and they type "Enter the house" display the winMessage.

//TODO: When the user is at the water and they type "Drink the water" end the game.



while(currentLocation!=winDestination){
	switch(currentLocation){
		case "forest":
			alert(forestMessage);
			response = prompt("Where would you like to go next?");
			if(response=="go west"){
				currentLocation = "house";
			}else if(response=="go south"){
				currentLocation = "clearing";
			}else {alert(notLocation);}
		break;

		case "house":
			alert(houseMessage);
			response = prompt("Where would you like to go from here?");
			if(response=="go east"){
				currentLocation = "forest";
			}
			else if(response=="go south"){
				currentLocation = "pond";
			}
			else {
				alert(notLocation);
			}
		break;
		


		// case "house":
  //           alert(houseMessage);
  //           response = prompt("Where would you like to go next?");
  //           if(response=="go east"){
  //               currentLocation = "forest";
  //           }else if(response=="go south"){
  //               currentLocation = "pond";
  //           }else if(response=="enter the house"){
  //               currentLocation = "insideHouse";
  //               alert(winMessage);
  //           }else {alert(notLocation);}
  //       break; 
	
		case "clearing":
			alert(clearingMessage);
			response = prompt("Where would you like to go from here?");
			if(response=="go west"){
				currentLocation = "pond";
			}
			else if(response=="go north"){
				currentLocation = "forest";
			}
			else {
				alert(notLocation);
			}
		break;

		case "pond":
			alert(pondMessage);
			response = prompt("Where would you like to go from here?")
			if(response=="go north"){
				currentLocation = "house";
			alert(houseMessage)
			}
			else if(response=="go east"){
				currentLocation = "clearing";
			alert(clearingMessage);
			}
			else {alert(notLocation);}
		break;

		
	}
}


