// ignore these lines for now
// just know that the variable 'color' will end up with a random value from the colors array
"use strict";
var colors = ['red', 'orange', 'yellow', 'green', 'blue', 'indigo', 'violet'];
var color = colors[Math.floor(Math.random()*colors.length)];

var favorite = 'blue'; // TODO: change this to your favorite color from the list

if(color==="red"){
	console.log ("This is page is hot Lava!")
	document.body.style.background = "red";
}else if(color==="orange"){
	console.log ("This is as orange as a Cheeto")
	document.body.style.background = "orange";
}else if(color==="yellow"){
	console.log ("This is the color of Mellow Yellow")
	document.body.style.background = "yellow";
} else if(color==="green"){
	console.log ("Split Pea Soup Green")
	document.body.style.background = "green";
} else if(color==="blue"){
	console.log ("The color of the Blue Man Group")
	document.body.style.background = "blue";
} else{
	console.log ("I do not know anything about this color")
	document.body.style.background = "indigo";
}

var message = (color==favorite)? alert("Yay! My favorite color!"):alert("Oops, not my favorite");

// TODO: Create a block of if/else statements to check for every color except indigo and violet.
// TODO: When a color is encountered log a message that tells the color, and an object of that color.
//       Example: Blue is the color of the sky.

// TODO: Have a final else that will catch indigo and violet.
// TODO: In the else, log: I do not know anything by that color.

// TODO: Using the ternary operator, conditionally log a statement that
//       says whether the random color matches your favorite color.
