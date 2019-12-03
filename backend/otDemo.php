<?php
require_once "./vendor/autoload.php";
use OpenTok\MediaMode;
use OpenTok\OpenTok;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
http_response_code(200);
$requestMethod = $_SERVER["REQUEST_METHOD"];
if ($requestMethod == 'OPTIONS') {
    exit();
}
$key='128b125f';
$secret='wkC7uHjnrCHg0ZVo';
$from='14155493399';
$tokbox_key='46365762';
$tokbox_secret='549c08355445aba087bcca98a02a82d74a530cee';
$id=1;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$inbound = json_decode(file_get_contents('php://input'), true);

if (end($uri) == 'register') {
    $opentok = new OpenTok($tokbox_key, $tokbox_secret);
    $session = $opentok->createSession(array('mediaMode' => MediaMode::ROUTED));
    $sessionId = $session->getSessionId();
    $token = $opentok->generateToken($sessionId, array(
        'data' => "userid={$id}",
    ));

    error_log("OpenTok Session ID={$sessionId}    token={$token}");
    echo '{"sessionId" : "' . $sessionId . '" ,
        "token" : "' . $token . '"}';

} elseif (end($uri) == 'show') {
    $data = $_GET;
    $id = $data['id'];
    $sessionId = $data['session'];
    $opentok = new OpenTok($tokbox_key, $tokbox_secret);
    $token = $opentok->generateToken($sessionId, array(
        'data' => "userid={$id}",
    ));
    error_log("SHOW function, OpenTok Session ID={$sessionId}    token={$token}");
    header("Content-Type: text/html");
    ?>
<html>
<body>
<script src="https://static.opentok.com/v2/js/opentok.js"></script>
<script>

// connect to session
var session = OT.initSession('<?php echo $tokbox_key ?>','<?php echo $sessionId ?>');

// create publisher
var publisher = OT.initPublisher('publisherElement',{width:'100%',height:'100%'});
session.connect('<?php echo $token ?>', function(err) {
   // publish publisher
session.publish(publisher);
});

// create subscriber
session.on('streamCreated', function(event) {
   session.subscribe(event.stream);
});

</script>
</body>
</html>

    <?php

} elseif (end($uri) == 'send') {
    try {
        error_log("Sending text, key=" . $key . " secret=" . $secret. " to: ".$inbound['to']);
        $client = new Nexmo\Client(new Nexmo\Client\Credentials\Basic($key, $secret));
        $message = $client->message()->send([
            'to' => $inbound['to'],
            'from' => $from,
            'text' => $inbound['message'],
        ]);
        $msg = "Sent SMS message to " . $inbound['to'] . " : " . $inbound['message'];
        error_log($msg);
    } catch (Exception $e) {
        $msg = "Failed sending SMS message to " . $inbound['to'] . " : " . $inbound['message'];
    }
}