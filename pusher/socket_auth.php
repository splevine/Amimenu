<?php

	require_once('Pusher.php');

	class PusherPushTest extends PHPUnit_Framework_TestCase
	{

		protected function setUp()
		{
			$this->pusher = new Pusher('thisisaauthkey', 'thisisasecret', 1, true); 
		}

		public function testObjectConstruct()
		{
			$this->assertNotNull($this->pusher, 'Created new Pusher object');
		}

		public function testSocketAuthKey()
		{
			$socket_auth = $this->pusher->socket_auth('testing_pusher-php', 'testing_socket_auth');
			$this->assertEquals($socket_auth, 
				'{"auth":"thisisaauthkey:XXXXXXXXXXXXXXXXXXX"}',
				'Socket auth key valid');
		}

	}

?>