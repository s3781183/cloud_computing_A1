<?php
# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Storage\StorageClient;

# Your Google Cloud Platform project ID
$projectId = 's3781183-cc2021';

# Instantiates a client
$datastore = new DatastoreClient([
    'projectId' => $projectId
]);

# The kind for the new entity
$kind = 'user';


# The Cloud Datastore key for the new entity
$userKey0 = $datastore->key($kind, 's37811830');

# Prepares the new entity
$user0= $datastore->entity($userKey0, ['username' => 'Ruchelle Balasuriya0','password' => '012345', 'img'=>'https://storage.cloud.google.com/s3781183-cc2021.appspot.com/0.png']);

# Saves the entity
$datastore->upsert($user0);




switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'login.php';
        break;
    case '/register':
        require 'register.php';
        break;
    case '/forum':
        require 'forum.php';
        break;
    case '/user':
        require 'userpage.php';
        break;
    default:
        http_response_code(404);
        exit('Not Found');
}



// $storage = new StorageClient();

// $bucket = $storage->bucket('s3781183-cc2021.appspot.com'); // Put your bucket name here.

// $object = $bucket->upload(file_get_contents($filePath), [
//     'name' => $objectName
// ]);

?>

