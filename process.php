<?php

function adduser($newguy, $pass, $test){  // adds user if valid

    $newguy = strtolower($newguy);  // username is not case-sensitive
    if (preg_match('/^[a-z0-9-_]+$/', $newguy)){   // no special characters allowed in username
        $invalid = False;  // no special characters present
    }
    else{
        $invalid = True;    // special characters present
    }
    if ($newguy == "bildad" && $test == False){    // Bildad reserved for testing
        $invalid = True;
    }

    if (strlen($pass) < 5){  // checking for minimum of 5 characters for password
        $invalid = True;
    }

    $pass = crypt($pass);  // salting and hashing the password

    $db = new PDO('sqlite:tweets.db');

    // Check to see if username is unique
    $sqlunique = 'select * from users where username = ?';
    $sqlresult = $db->prepare($sqlunique);
    $sqlresult->execute(array($newguy));
    $uniquelist = array();
    while($name=$sqlresult->fetch()){
        foreach($name as $usern){
            if ($usern = $newguy){
                $invalid = True;
            }
        }
    }

    if ($invalid != True) {    // if username and password are valid, add new user and logging in
        $sql = 'INSERT INTO users (username,password) VALUES(?, ?)';
        $result = $db->prepare($sql);
        $result->execute(array($newguy,$pass));    // inserting newguy into db
    } 
    else {    // if username or password are not valid, return False
        $newguy = False;
    }
    $db->connection = null;
    return $newguy;    // returning username to be passed to $_SESSION['username']

}

function makebleat($mybleat, $user){  // adds a new message if valid
    $mybleat = strip_tags($mybleat);  // protecting against injection
    $datetime = date("m-d-Y H:i:s");

    $len = strlen($mybleat);  // checking for valid length, also checked client side

    if ($len > 0 && $len <= 140){    // validating the length of the tweet
         $db = new PDO("sqlite:tweets.db");
         $sql = "INSERT INTO messages(username, message, datetime) VALUES (?, ?, ?)";
         $result = $db->prepare($sql);
         $result->bindParam(1, $user);
         $result->bindParam(2, $mybleat);
         $result->bindParam(3, $datetime);
         $result->execute();
    }
}

function usersearch($searchname){    // user search for other users
    $searchname = strtolower($searchname);  // usernames are not case-sensitive

    $db = new PDO("sqlite:tweets.db");
    $sql = "select username from users";
    $result = $db->query($sql);

    $searchlist = array();  
    while($names=$result->fetch()){  // checking each existing username
        foreach($names as $usern){
            similar_text($searchname, $usern, $perc); 
            if ($perc >= 50){       // checking for similar names
                $searchlist[$usern] = $perc;
            }
        }
    }
    array_multisort($searchlist, SORT_DESC);    // sorting similar names
    $db->connection = null;
    return $searchlist;  
}

function validate($username, $passw){  // login validation
    $checker = False;  // setting checker to an invalid result
    $username = strtolower($username);  // username is not case-sensitive
    if(!preg_match('/^[a-z0-9-_]+$/', $username)){  
        $login = False;    // checking for special characters
    }
    else{    // if no special characters present, continue with login attempt
        $db = new PDO("sqlite:tweets.db");    
        $sql = 'select password from users where username=?';
        $result = $db->prepare($sql);
        $result->execute(array($username));
        while($verify = $result->fetch(SQLITE3_ASSOC)){
            $checker = $verify['password'];
        }
        if (crypt($passw, $checker) == $checker) {    // login confirmation
            $login = True;
        }
        else {     // login failed
            $login = False;
        }
    }
    $db->connection = null;
    return $login;  // passed to $_SESSION['login']
}

// display functions

function showbleats($name){  // diplays a user's messages
    $name = strtolower($name);  // name is not case-sensitive
    $db = new PDO("sqlite:tweets.db");
    $sql='SELECT * from messages where username = ?';
    $result = $db->prepare($sql);
    $result->execute(array($name));

    $message = array(); 
    $datetime = array();

    while($verify = $result->fetch(SQLITE3_ASSOC)){
        $username = $verify['username'];
        $message[] = $verify['message'];
        $datetime[] = $verify['datetime'];
    }

    $countdown = count($message) - 1;  
    if (!empty($message)){    // message display
        echo "$name's bleats:";
        for($i = $countdown; $i >= 0; $i--){
                $words = $message[$i];
                $bleat = strip_tags($words);
            echo "			
                <div class='tweets';>
                    <h3><font color='#365127'>$datetime[$i]</font></h3>
                    <p><font color='5B5D5A'>$bleat</font></p>
                </div>";
         }
    }
    else{
        echo "\n No tweets availble by $name \n";
    }
    $db->connection = null;
}



