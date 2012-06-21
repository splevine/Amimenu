<?php
require('Pusher.php');
$pusher = PusherInstance::get_pusher();
//$pusher->socket_auth('test_channel','my_event');
//$pusher = new Pusher($key, $secret, $app_id);
$array['id'] = $_REQUEST['id'];
$array['mensaje'] = $_REQUEST['mensaje'];
$pusher->trigger('test_channel', 'my_event', $array);
?>