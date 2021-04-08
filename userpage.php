<?php
// Start the session
session_start();
?>
<!DOCTYPE html>

<html>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

 </html>
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


$oldPassword = $_POST['oldpassword'];
$newPassword = $_POST['newpassword'];

$username = $_SESSION['username'];
$query = $datastore->query()
->kind('user')
->filter('username', '=', $username);

$result = $datastore->runQuery($query);


if( isset($newPassword) && isset($oldPassword)){
    if(empty($newPassword)||empty($oldPassword)){
       echo "<h3>All fields required</h3>";}
 
    else{
       foreach ($result as $properties => $users) {
 
          if ( $username == $users['username'] ) {
            if($oldPassword == $users['password']){
                echo $users['password'];
                $transaction = $datastore->transaction();
                $key = $datastore->key('user', $users->key()->pathEndIdentifier());
                $task = $transaction->lookup($key);
                $task['password'] = $newPassword;
                $transaction->update($task);
                $transaction->commit();
                echo '<script language=javascript>window.location.href="/"</script>';
                exit();
            }
      }
    }

    echo "<h3>The old password is incorrect</h3>";
 }}
?>
    <form action="" method="post" name="password">
    <div class="form-group">
                              <label for="exampleInputEmail1">Old Password</label>
                              <input type="password" name="oldpassword"  class="form-control" id="oldpassword" aria-describedby="emailHelp" placeholder="Enter new password">
      </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">New Password</label>
                              <input type="password" name="newpassword"  class="form-control" id="newpassword" aria-describedby="emailHelp" placeholder="Enter new password">
      </div>
                        
 

                        <div class="col-md-12 text-center ">
                              <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Change</button>   
                           </div>
                           </form>
</body>
</html>
