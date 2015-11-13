<?php
  var_dump($_GET);
  var_dump($_POST);
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>My First HTML Form</title>
	</head>
    	<body>
        
            <h1>User Login</h1>
    		<form method="POST" action="/my_first_form.php">
            <p>
                <label for="username">Username</label>
                <input id="password" name="username" type="text" placeholder value="ryan">
            </p>
            <p>
                <label for="password">Password</label>
                <input name="password" type="password" placeholder value="Floater">
            </p>
            <p>
                <input id="password" type="submit" value="It's about to go down!">
            </p>
        </form>
            <h1>Compose an Email!</h1>
        <form>
            <p>
                <form method="POST" action="my_first_form.php" element spellcheck="true|false">
                <label for="send to:">Send to:</label>
                <input id="send to:" name="send to" type="text">

                <label for="sent from:">Sent from:</label>
                <input name="sent from" name="Sent from" type="text" placeholder value="ryanscottbaker@gmail.com">
            </p>
                <label><input type="checkbox" id="save_to_sent" name="save_to_sent" value="yes" checked>Save copy to sent folder</label>
            <p>    
                <textarea id="email_body" name="email_body" rows="10" cols="70" placeholder="Post something cool!"></textarea>
            </p>
            <p>
               <input id="email_body" type="submit" value="Send your message!">
            </p>
        </form>
        <h1>Multiple Choice Test</h1>
        <form method="POST" action="/my_first_form.php">
            <p>What is the best band in the world?
            </p>    
                <label><input type="radio" name="band" value="thrice">Thrice</label>
            <p>    
                <label><input type="radio" name="band" value="iron_maiden">Iron Maiden</label>
            </p> 
                <label><input type="radio" name="band" value="the_beatles">The Beatles</label>
            <p>    
                <label><input type="radio" name="band" value="fleetwood_mac">Fleetwood Mac</label>
            </p>
            <p>What is the best type of food world?
            </p>    
                <label><input type="radio" name="food" value="italian">Italian</label>
            <p>    
                <label><input type="radio" name="food" value="mexican">Mexican</label>
            </p> 
                <label><input type="radio" name="food" value="indian">Indian</label>
            <p>    
                <label><input type="radio" name="food" value="greek">Greek</label>
            </p>
            What are your favorite cities?
            <p>
                <label><input type="checkbox" name="favorite_places[]" value="salt lake city">Salt Lake City</label>
            </p>    
            <p>
                <label><input type="checkbox" name="favorite_places[]" value="austin">Austin</label>
            </p>     
                <label><input type="checkbox" name="favorite_places[]" value="san antonio">San Antonio</label>
            <p>
                <label><input type="checkbox" name="favorite_places[]" value="phoenix">Phoenix</label>
            </p>       
                <label><input type="checkbox" name="favorite_places[]" value="san diego">San Diego</label>
            <p>    
                <label for="president">Who has your vote for the democratic/republican nomination?</label>   
            </p>    
                <select id="president" name="president[]" multiple>   
                    <option value="Hilary Clinton">Hilary Clinton</option>
                    <option value="Bernie Sanders">Bernie Sanders</option>
                    <option value="Donald Trump">Donald Trump</option>
                    <option value="Ben Carson">Ben Carson</option>    
                </select>
                <!-- Notice if you delete the [] and multiple it will turn multiple list and create a drop down -->
                <p>
                    <!--Notice: input type and button type will give
                    the same info, button is likely best practice as you 
                    do not need a value, you just name it between the tags.  -->
                    <input type="submit" value="Send away!">
                    <button type="submit">Submit!!</button>      
                </p>
        
        </form>
        <form method="POST" action="/my_first_form.php">
            Favorite Sports Teams?
            <p>
            <label><input type="checkbox" name="favorite_teams[]" value="Utah Jazz">Utah Jazz</label>
            <label><input type="checkbox" name="favorite_teams[]" value="San Antonio Spurs">San Antonio Spurs</label>
            <label><input type="checkbox" name="favorite_teams[]" value="Real Salt Lake">Real Salt Lake</label>
            <label><input type="checkbox" name="favorite_teams[]" value="Chicago Bulls">Chicago Bulls</label>
            <button type="submit"><img src="img/Sq_1.png"></button>
            <!-- This is how to make a button submit info!!!! -->
            </p>    
        </form>
        <h1>Select Testing</h1>
        <form>
            <label for="championship"> Will the Spurs win another Championship this year?</label>   
            <select id="championship" name="championship">
                <option value="We are #1">Yes</option>    
                <option value="0, Sorry Spurs, maybe next year!">No</option>   
            </select>
            <input type="submit"  value="Go Spurs, Go!!!">
        </form> 
    </body>
</html>