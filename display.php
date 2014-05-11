
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Baa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Twitter Clone">
    <meta name="author" content="Matt Haley">

    <!-- Le styles -->
    <link href="/web/project/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="/web/project/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://getbootstrap.com/2.3.2/assets/js/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

           <div class="nav-collapse collapse">
            <ul class="nav">

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Baa<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="/web/project">Home</a></li>
                  <li><a href="/web/project/about">About</a></li>
                  <?php
                      if (isset($_SESSION['login'])){
                          if ($_SESSION['login'] == True && $_SESSION['user'] == "testing"){
                              echo "<li><a href='/web/project/testing'>Testing</a></li>";
                          }
                      }
                  ?>
                </ul>
              </li>
              <form action="/web/project/" method="post" class="navbar-form pull-right">
                <input type="text" name="search" placeholder="Search User">
                <input class="btn" type="submit" value="Search">
              </form>
            </ul>


<?php
if (isset($_SESSION['login'])){
    if ($_SESSION['login'] == False){   // if not logged in, include sign-in form
        echo "
            <form class='navbar-form pull-right' action='/web/project/' method='post'>
                <input class='span2' type='text' name='username' placeholder='Username'>
                <input class='span2' type='password' name='password' placeholder='Password'>
                <input type='submit' class='btn' value='Sign in'>
            </form>";
    }
    if ($_SESSION['login'] == True){    // if logged in, include log out button
        echo "
            <form class='navbar-form pull-right' action='' method='post'>
                <input class='btn' type='submit' name = 'logout' value='Logout' />
            </form>";
    }

}
if (!isset($_SESSION['login'])){    // if no log-in attempts, include sign-in form
    echo "
        <form class='navbar-form pull-right' action='/web/project/' method='post'>
            <input class='span2' type='text' name='username' placeholder='Username'>
            <input class='span2' type='password' name='password' placeholder='Password'>
            <input type='submit' class='btn' value='Sign in'>
        </form>";
}
?>



          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">
      <div class="hero-unit">
          <h1>Baa</h1>
      <?php 
        if (isset($_SESSION['invalidAdd'])){
            if ($_SESSION['invalidAdd'] == True){  // if failed adduser attempt, display
                echo "Not a valid username or password. 
                      Username alphanumeric only; password minimum 5 characters.</br>";
               unset($_SESSION['invalidAdd']);
            }
        }
        if (isset($_SESSION['login'])){  // if failed login attempt, display
            if (isset($_SESSION['invalidLogin'])){
	        echo "Login Failed.";
                unset($_SESSION['invalidLogin']);
             }
            if ($_SESSION['login'] == True){  // if successful login attempt, display
                $usern = $_SESSION['user'];
                echo "<p>Welcome, $usern.</p>";
                echo "<form action='/web/project/' method='post' class='navbar-form'>
                      <textarea type='text' name='mytweet' maxlength='140' placeholder='Bleat' rows=4 cols=30></textarea>
                      <input type='submit' class='btn'>
                      </form></div>";
            }
            else{    // if not logged in, include adduser form
                echo "
                    Add New User
                    <form action='/web/project/' method='post'>
                        Username: <input type='text' name='adduser'><br>
                        Password: <input type='password' name='addpassword'><br>
                        <input type='submit'>
                    </form></div>";
                unset($_SESSION['login']);
            }
        }
        else{    // if no log-in attempts, include adduser form
            echo "
                Add New User
                <form action='/web/project/' method='post'>
                    Username: <input type='text' name='adduser'><br>
                    Password: <input type='password' name='addpassword'><br>
                    <input type='submit'>
                </form></div>";
        }
        if (isset($_SESSION['searchlist'])){    // displaying search list
            $searchlist = $_SESSION['searchlist'];
            if (sizeof($searchlist) == 0){         // no one gound
                echo "<br>Search Results: No users found.<hr>";
            } 
            else{
                echo "<br>Search Results:<br>";
                foreach(array_keys($searchlist) as $return){    // displaying search results
                    echo "<a href='/web/project/$return'>$return</a><br>";
                }
            echo "<hr>";
            }
            unset($_SESSION['searchlist']);
        }
        if (isset($_SESSION['login']) && !(isset($_SESSION['view']))){
            if ($_SESSION['login'] == True){  // if logged in and not viewing a user
               $name = $_SESSION['user'];
               showbleats($name);    // displaying the bleats 
            }
        }
        if (isset($_SESSION['view'])){   // if viewing a user
            if (isset($return)){
                showbleats($return);    // displaying the bleats 
            }
            if (isset($name)){
                showbleats($name);    // displaying the bleats
            }
            unset($_SESSION['view']);
        }

      ?>
</div>
      </br></br></br>

      <footer>
        <p>&copy; Matt Haley 2014</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/web/project/js/jquery.js"></script>
    <script src="/web/project/js/bootstrap-transition.js"></script>
    <script src="/web/project/js/bootstrap-alert.js"></script>
    <script src="/web/project/js/bootstrap-modal.js"></script>
    <script src="/web/project/js/bootstrap-dropdown.js"></script>
    <script src="/web/project/js/bootstrap-scrollspy"></script>
    <script src="/web/project/js/bootstrap-tab.js"></script>
    <script src="/web/project/js/bootstrap-tooltip.js"></script>
    <script src="/web/project/js/bootstrap-popover.js"></script>
    <script src="/web/project/js/bootstrap-button.js"></script>
    <script src="/web/project/js/bootstrap-collapse.js"></script>
    <script src="/web/project/js/bootstrap-carousel.js"></script>
    <script src="/web/project/js/bootstrap-typeahead.js"></script>


  </body>
</html>


