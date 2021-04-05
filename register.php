<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

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
$id= $_POST['id'];
$password = $_POST['password'];

$query1 = $datastore->query()
       ->kind('user');

$result1 = $datastore->runQuery($query1);


$query = $datastore->query()
->kind('user')
->filter('username', '=', $username);


$result = $datastore->runQuery($query);

if (isset($result1)) {
   foreach ($result1 as $entity){
      // get the entity id using pathEndIdentifier()
      if($entity->key()->pathEndIdentifier()==$id){
            echo "<h3>Id already exists</h3>";
      }
  }

      // if ($id!=null ) {
      //    header('Location: /register');
      //    echo "<h3>already exists</h3>";
      //    echo "hell0";
      //     die();
      // }
   }

      if ( isset($username) ){
         foreach ($result as $properties => $users) {

            if ($username == $users['username'] ) {

               echo "<h3> Username already exists </h3>";
            }

         }
      }
      if(!(isset($username)  && isset($password) && isset($id)|!(isset($username) |isset($password) | isset($id)))){
         echo "<h3> Username/Password/id empty</h3>";
      }

      else{
            $kind = 'user';

            # The Cloud Datastore key for the new entity
            $userKey = $datastore->key($kind, $id);

            # Prepares the new entity
            $user= $datastore->entity($userKey, ['username' => $username,'password' => $password]);
            $datastore->upsert($user);

            header('Location: https://s3781183-cc2021.ts.r.appspot.com');
            exit();
      }
   // }




// if( isset($username) && isset($id) && !(array_key_exists('username', $_POST) || array_key_exists('id', $_POST)) ){
//    echo "<h3>ID and Password cannot be empty</h3>";
// }

?>
    <form action="" method="post" ame="registration">
                         <div class="form-group">
                              <label for="exampleInputEmail1">Id</label>
                              <input type="id" name="id"  class="form-control" id="id" aria-describedby="emailHelp" placeholder="Enter id">
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Username</label>
                              <input type="username" name="username"  class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username">
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Password</label>
                              <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                           </div>
  
                           <div class="col-md-12 text-center ">
                              <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Sign Up</button>
                              
                           </div>
                        
                           
                           <div class="col-md-12 ">
                              <div class="form-group">
                                 <p class="text-center"><a href="/" id="signin">Already have an account?</a></p>
                              </div>
                        </form>
</body>
</html>
