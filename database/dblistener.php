
<?php
require_once('event_logger.php');
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');
require_once('register.php.inc');
require_once('data.php');


function doLog($error){
	file_put_contents("hublog.txt", $error, FILE_APPEND);
}


function doLogin($username,$password)
{
    // lookup username in databas
    // check password
    $login = new loginDB();
    return $login->validateLogin($username,$password);
    //return false if not valid
}


function doregister($username,$password,$email)
{
    $login = new registerDB();
    return $login->validateregister($username,$password,$email);
}
function docsgo($platform,$gamertag)
{
    $login = new dataDB();
    return $login->validatecsgo($platform,$gamertag);
}
function doapex($platform,$gamertag)
{
    $login = new dataDB();
    return $login->validateapex($platform,$gamertag);
}
function dosplitgate($platform,$gamertag)
{
    $login = new dataDB();
    return $login->validatesplitgate($platform,$gamertag);
}
function addcsgo($username,$platform,$gamertag)
{
    $login = new dataDB();
    return $login->addidcsgo($username,$platform,$gamertag);
}
function addapex($username,$platform,$gamertag)
{
    $login = new dataDB();
    return $login->addidapex($username,$platform,$gamertag);
}
function addsplitgate($username,$platform,$gamertag)
{
    $login = new dataDB();
    return $login->addidsplitgate($username,$platform,$gamertag);
}

function category()
{
    $login = new dataDB();
    return $login->displaycategory();
}

function topics($id)
{
    $login = new dataDB();
    return $login->displaytopics($id);
}

function topicsinfo($id)
{
    $login = new dataDB();
    return $login->displaytopic($id);
}

function posts($id)
{
    $login = new dataDB();
    return $login->displayposts($id);
}

function create($topic_subject, $topic_cat, $post_content, $username)
{
    $login = new dataDB();
    return $login->createtopic($topic_subject, $topic_cat, $post_content, $username);
}

function create_reply($id, $reply_content, $username)
{
    $login = new dataDB();
    return $login->reply($id, $reply_content, $username);
}

function add_friend($user_id,$friend_id,$friend_name, $username)
{
    $login = new dataDB();
    return $login->addfriend($user_id,$friend_id,$friend_name, $username);
}

function search_Users($friend_name)
{
    $login = new dataDB();
    return $login->searchUser($friend_name);

}

function delete_friend($user_id,$friend_id,$friend_name)
{
    $login = new dataDB();
    return $login->deletefriend($user_id,$friend_id,$friend_name);

}



function display_friends($user_id)
{
    $login = new dataDB();
    return $login->displayfriends($user_id);

}




function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "ERROR: unsupported message type" . "\n";
    log_event($event);
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
    case "register":
      return doRegister($request['username'],$request['password'],$request['email']);
    case "event_log":
      doLog($request['error_message']);
      break;
    case "csgo":
      return docsgo($request['platform'],$request['gamertag']);
    case "apex":
      return doapex($request['platform'],$request['gamertag']);
    case "splitgate":
      return dosplitgate($request['platform'],$request['gamertag']);
    case "csgo_id":
      return addcsgo($request['username'],$request['platform'],$request['gamertag']);
    case "apex_id":
      return addapex($request['username'],$request['platform'],$request['gamertag']);
    case "splitgate_id":
      return addsplitgate($request['username'],$request['platform'],$request['gamertag']);
    case "forums":
    	return category();
    case "topics_display":
        return topics($request['id']);
    case "topics_info":
        return topicsinfo($request['id']);
    case "posts_display":
        return posts($request['id']);
    case "create_topic":
        return create($request['topic_subject'], $request['topic_cat'], $request['post_content'], $request['username']);
    case "reply":
        return create_reply($request['id'], $request['reply-content'], $request['username']);
    case "search_users":
    	return search_Users($request['friend_name']);
    case "add_friend":
    	return add_friend($request['user_id'], $request['friend_id'], $request['friend_name'], $request['username']);
    case "delete_friend":
    	return delete_friend($request['user_id'], $request['friend_id'], $request['friend_name'] );
    case "displayfriends":
    	return display_friends($request['user_id']);
    
    /* default:
      $event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Database --- " . "Server received request but request type does not match" . "\n";
      log_event($event);
      */
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("database.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>


