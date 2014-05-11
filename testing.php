
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Testing</title>

    <!-- Bootstrap core CSS -->
    <link href="/web/project/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="web/project/css/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

<?php 
    include 'testprocess.php';
?>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/web/project/testing">Baa Admin</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><form class='navbar-form pull-right' action='' method='post'>
                    <input class='btn' type='submit' name = 'logout' value='Logout'/>
                 </form></li>
          </ul>
        </div>
      </div>
    </div>
<div id="fix-for-navbar-fixed-top-spacing" style="height: 42px;">&nbsp;</div>

          <div class="table-responsive">
            <h2 class="sub-header"><u>Test Results</u></h2>
            <?php
                $datetime = date("m-d-Y H:i:s");
                $passFail = $_SESSION['testResults'];
                echo "<h3 class='sub-header'>$datetime: $passFail</h3>";
            ?>

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Checking</th>
                  <th>Pass/Fail</th>
                  <th>Error Message</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Add User</td>
                  <td><?php 
                         echo $_SESSION['testAdduser'];   // result from test of add user function
                       ?></td>
                  <td><?php 
                          foreach($addError as $error){  // individual errors in test
                              echo "$error";
                          }
                        ?>
                 </td>
                </tr>
                 <td>Make Bleat</td>
                  <td><?php
                         echo $_SESSION['makeBleat'];  // result from test of makebleat function
                       ?></td>
                  <td><?php
                          foreach($makeError as $error){  // individual errors in test
			       echo "$error";
                          }
			 ?>
                </tr>
                <tr>
                  <td>Search User</td>
                  <td><?php
                         echo $_SESSION['usersearch'];  // result from test of usersearch function
                       ?></td>
                  <td><?php
                          foreach($searchError as $error){  // individual errors in test
                              echo "$error";
                          }
			 ?>
                 </td>
                <tr>
                  <td>Login</td>
                  <td><?php
                         echo $_SESSION['loginValidation'];  // result from test of login validation function
                       ?></td>
                  <td><?php
                          foreach($loginError as $error){
                              echo "$error";
                          }
			 ?>
                 </td>
                </tr>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

<div style='position:relative; bottom:0;;'><u>Bleat Display Test</u><br>bildad's should only bleat should be: Hello World<br>
<?php
    $name = "bildad";   // displays the message created during testing
    $countdown = count($message) - 1;
    if (!empty($message)){
        echo "$name's bleats:";
        for($i = $countdown; $i >= 0; $i--){
                $words = $message[$i];
                $bleat = strip_tags($words);
            echo "
                <div class='tweets';>
                    <p><font color='5B5D5A'>$bleat</font></p>
                </div>";
         }
    }
    else{
        echo "\n No tweets availble by $name \n";
    }
?>
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="web/project/js/bootstrap.min.js"></script>
    <script src="web/project/js/docs.min.js"></script>

  </body>
</html>
