// prompt and alert are functions, it is a block statement
// And the syntax looks like this

sayHello(); 
// Everytime sayHello is invoked whatever is in the code will run 

function sayHello (name) {
	// code goes here and can be used a bunch of different times
	// Whatever is in the code will happen every time it is invoke
	console.log ("Hello!!!")
	alert("My Name Is Ryan!")
	alert("Hello");
}

sayHello("Ryan")

function sum(numberOne, NumberTwo) {
	var result = numberOne + NumberTwo;
	return result;
}

console.log(sum(10, 11));

function isEVEN(input) {
	var remainder = input %2;
	if (remainder === 0) {
		return true;
	} else {
		return false;
	}
}

console.log (isEVEN(20));
console.log (isEVEN(31));

// accept parameters accept block and return at will and return values, this is what functions do

function toGoldBars(numberOfUSD){
	return numberOfGoldBars / 500000;
}

function toUSD(numberOfGoldBars) {
	return numberOfGoldBars * 500000;
}

var goldBarCount = prompt("How many gold bars do you have?");
console.log (toUSD(goldBarCount));

prompt("Is this prompting?")



