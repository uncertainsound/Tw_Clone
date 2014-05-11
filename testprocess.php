<?php

include_once 'process.php';

$now = date("m-d-Y H:i:s");

$_SESSION['testResults'] = "Passed";

// testing adduser
  // checking adding new user, should work
$_SESSION['testAdduser'] = "Passed";
$addError = array("Passed");
$testname = "Bildad";    // reserved test name
$password = "P@ssw0rd";
$newguy = adduser($testname, $password, True);
if ($newguy == False){    // if user didn't add
    $addError[] = ", Failed - did not add";
}
  // checking failed attempt, user already exists
$testname = "Bildad";  	 // reserved test name
$password = "P@ssw0rd";
$newguy = adduser($testname, $password, True);
if ($newguy == "bildad"){	       // if user did add
    $addError[] = ", Failed - added when user already exists";
}
  // checking invalid user name, should not add
$testname = "^%*$\\gfd";  	 // only alphanumeric should pass
$password = "P@ssw0rd";
$newguy = adduser($testname, $password, True);
if ($newguy == $testname){	       // if added
    $addError[] = ", Failed - alphanumeric error";
}
  // checking no password, should not add
$testname = "Bildad";  	 // reserved test name
$password = "";
$newguy = adduser($testname, $password, True);
if ($newguy == "bildad"){	       // if added
    $addError[] = ", Failed - blank password added";
}
  // final adduser check
if (count($addError) > 1){
    $_SESSION['testAdduser'] = "Failed";
    $_SESSION['testResults'] = "Failed";

}

// Testing makebleat
  // regular, valid bleat
$_SESSION['makeBleat'] = "Passed";
$makeError = array("Passed");
$bleat = "Hello World";
$testname = "bildad";
makebleat($bleat, $testname);

$db = new PDO("sqlite:tweets.db"); // checking if bleat went through
$sql='SELECT * from messages where username = ?';
$result = $db->prepare($sql);
$result->execute(array($testname));
$message = array();
$datetime = array();
while($verify = $result->fetch(SQLITE3_ASSOC)){
    $username = $verify['username'];
    $message[] = $verify['message'];
    $datetime[] = $verify['datetime'];
}
if (!in_array($bleat, $message)){
    $makeError[] = ", Failed to add valid bleat";
    $_SESSION['makeBleat'] = "Failed";
    $_SESSION['testResults'] = "Failed";
}

  // blank tweet
$bleat = "";
$testname = "bildad";
makebleat($bleat, $testname);

$db = new PDO("sqlite:tweets.db"); // checking if bleat went through
$sql='SELECT * from messages where username = ?';
$result = $db->prepare($sql);
$result->execute(array($testname));
$message = array();
$datetime = array();
while($verify = $result->fetch(SQLITE3_ASSOC)){
    $username = $verify['username'];
    $message[] = $verify['message'];
    $datetime[] = $verify['datetime'];
}
if (in_array($bleat, $message)){
    $makeError[] = ", Failed to add valid bleat";
    $_SESSION['makeBleat'] = "Failed";
    $_SESSION['testResults'] = "Failed";
}


// usersearch
  // valid search
$_SESSION['usersearch'] = "Passed";
$searchError = array("Passed");
$testname = 'bildad';
$searchlist = array(usersearch($testname));
if (!array_key_exists($testname, $searchlist[0])){
    $_SESSION['usersearch'] = "Failed";
    $searchError[] = ", Valid search failed";
    $_SESSION['testResults'] = "Failed";
}

  // blank search
// $_SESSION['usersearch'] = "Passed";
// $searchError = array("Passed");
$testname = '';
$searchlist = array(usersearch($testname));
if (sizeof($searchlist[0]) != 0){
    $_SESSION['usersearch'] = "Failed";
    $searchError[] = ", Empty search went through";
    $_SESSION['testResults'] = "Failed";
}

  // removing symbols
// $_SESSION['usersearch'] = "Passed";
// $searchError = array("Passed");
$testname = 'b&^*%i\\ld^^&*$<a>d';
$realName = 'bildad';
$ssearchlist = array(usersearch($testname));
if (!array_key_exists($realName, $ssearchlist[0])){
    $_SESSION['usersearch'] = "Failed";
    $searchError[] = ", Symbols not removed";
    $_SESSION['testResults'] = "Failed";
}

// login check
  //valid login
$_SESSION['loginValidation'] = "Passed";
$loginError = array("Passed");
$testname = "bildad";
$password = "P@ssw0rd";
$logincheck = validate($testname, $password);
if ($logincheck != True){
    $_SESSION['loginValidation'] = "Failed";
    $loginError[] = ", Valid login failed";
    $_SESSION['testResults'] = "Failed";
}
  //invalid login
$password = "wrongPassword";
$logincheck = validate($testname, $password);
if ($logincheck != False){
    $_SESSION['loginValidation'] = "Failed";
    $loginError[] = ", Invalid login logs in";
    $_SESSION['testResults'] = "Failed";
}

// for bleat display
$name = 'bildad';
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

// cleaning up, removing bildad from users and messages
$testname = 'bildad';
$sql='DELETE FROM messages where username = ?'; // removing bleats
$result = $db->prepare($sql);
$result->execute(array($testname));
$sql='DELETE FROM users where username = ?';  // removing testname
$result = $db->prepare($sql);
$result->execute(array($testname));
