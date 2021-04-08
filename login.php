<?php
// Start the session
session_start();
?>
<!DOCTYPE html>




<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


<html>
<body>

<?php

require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Datastore\DatastoreClient;

# Your Google Cloud Platform project ID
$projectId = 's3781183-cc2021';

# Instantiates a client
$datastore = new DatastoreClient([
    'projectId' => $projectId
]);


$username = $_POST['username'];
$password = $_POST['password'];


$query = $datastore->query()
->kind('user')
->filter('username', '=', $username)
->filter('password', '=', $password);

$result = $datastore->runQuery($query);

if( isset($username) && isset($password)){
   if(empty($username) || empty($password)){
      echo "<h3>All fields required</h3>";}

   else{
      foreach ($result as $properties => $users) {

         if ( $username == $users['username']  &&  $password == $users['password'] ) {
             $_SESSION['username'] = $username;
           if(isset($_SESSION['username']))
              echo '<script language=javascript>window.location.href="/forum"</script>';
              exit();
         }
     }

     echo "<h3>ID or password is invalid</h3>";
   }
}

?>
    <form action="" method="post" name="login">
                           <div class="form-group">
                              <label for="exampleInputEmail1">Id</label>
                              <input type="username" name="username"  class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter email">
      </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Password</label>
                              <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                           </div>
  
                           <div class="col-md-12 text-center ">
                              <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
                              
                           </div>
                        
                           
                           <div class="form-group">
                              <p class="text-center">Don't have account? <a href="/register" id="signup">Sign up here</a></p>
                           </div>
                        </form>
</body>
</html>
