<?php

include 'process.php';

if ($_POST){    // all possible $_POST actions
    session_start();

    if (!isset($_SESSION['login'])){  // no login attempt
        $_SESSION['login'] = False;
    }
    if (isset($_POST['logout'])){    // logging out
        session_destroy();
        session_start();
    }
    elseif (isset($_POST['username'])){  // check login
        $username = $_POST['username'];
        $passw = $_POST['password'];
        $_SESSION['login'] = validate($username, $passw);
        if ($_SESSION['login'] == True){
            $username = strtolower($username);  // username is not case-sensitive
            $_SESSION['user'] = $username;
        }         
        else{
            $_SESSION['invalidLogin'] = True;
        }
    }
    if (isset($_POST['mytweet'])){    // adding bleat to db
        $mybleat = $_POST['mytweet'];
        $user = $_SESSION['user'];
        makebleat($mybleat, $user);
    }
    if (isset($_POST['search'])){  // if searching for users
        $searchname = $_POST['search'];
        $_SESSION['searchlist'] = usersearch($searchname);
        $_SESSION['search'] = True;
    }
    if (isset($_POST['adduser'])){   // adding a new user
        $newguy = adduser($_POST['adduser'], $_POST['addpassword'], False); // last argument is testing- True or False
        if ($newguy != False){
            $_SESSION['login'] = True;    // logging in
            $_SESSION['user'] = $newguy;
        }
        else{
            $_SESSION['invalidAdd'] = True;
        }
    }
    header("location: " . $_SERVER['REQUEST_URI']);    // redirect to avoid reposting 
    exit();
}

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();



$app->get('/testing', function () use ($app) {    // testing display page
    session_start();
    $_SESSION['view'] = True;
    if (isset($_SESSION['login'])){
        if ($_SESSION['login'] == True && $_SESSION['user'] == 'testing'){  // if logged in, go to testing page
            include 'testing.php';
        }
        else{
            include 'display.php';
        }
    }
    else {
        include 'display.php';
    }
    return '';
});


$app->get('/', function () use ($app) {
    session_start();
    if (!isset($_SESSION)) {
        session_start();
        $_SESSION['login'] = False;
    }

    include 'display.php';
    return '';
});


$app->get('/{name}/', function ($name) use ($app) {    // view a user's bleats
    session_start();
    $_SESSION['view'] = True;
    include 'display.php';
    return '';
});


$app->run();