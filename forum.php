<?php
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



<?php
date_default_timezone_set('Australia/Melbourne');
require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Datastore\DatastoreClient;

# Your Google Cloud Platform project ID
$projectId = 's3781183-cc2021';

# Instantiates a client
$datastore = new DatastoreClient([
    'projectId' => $projectId
]);


$username = $_SESSION['username'];
$subject= $_POST['subject'];
$content = $_POST['content'];



$query = $datastore->query()
       ->kind('message')
       ->filter('username', '=', $username)
       ->order('created', Query::ORDER_DESCENDING);
$result = $datastore->runQuery($query);
?>
<!DOCTYPE html>
<html>

<form action="" method="post" ame="registration">
<div class="form-group">
     <label for="exampleInputEmail1">Subject</label>
     <input type="subject" name="subject"  class="form-control" id="id" aria-describedby="emailHelp" >
  </div>

  <label for="exampleInputEmail">Content</label>
<div><textarea name="content" rows="3" cols="60"></textarea></div>
 
  <div class="col-md-12 text-center ">
     <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Submit</button>
     
  </div>

</form>
</body>
</html>


<?php

if(isset($content)){
   if(empty($content)){
      echo "<h3>Content empty</h3>";}

   else{

         $kind = 'message';
         
         # The Cloud Datastore key for the new entity
         $messageKey = $datastore->key($kind);

         # Prepares the new entity
         $message= $datastore->entity($messageKey, ['username' => $username,'subject' => $subject,'content' => $content,'timestamp' => date("Y-m-d h:i:sa")]);
         $datastore->upsert($message);
         echo "done";
   }
}


if(!(empty($result))){
  foreach ($result as $properties => $messages) {
       echo $messages['subject'], " ", $messages['subject'], " ", $messages['timestamp']."<br>";
    
}
}



?>


