<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = 'HspCUc6oAStzfcVTfpNN7JM4FmUZtEY0Nosd0B+uFtWxJ785gx6lTjNf2zlQKxnCuB9MxEqFt8oTuHWWJkoOPko7g1lYQOXn8jb1V9ksnEetrXiMGpsioGZZ5b3mpPM2qCVyBzkgEcJtqDlr7LGkGAdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');

// Parse JSON
$events = json_decode($content, true);

// Validate parsed JSON data
if (!is_null($events['events'])) {

	// Loop through each event
	foreach ($events['events'] as $event) {

		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {

			// Get text sent
			// $text = $event['source']['userId'];
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			$TextInput = $event['message']['text'];

			if($TextInput == 'รู้จักกับเรา') {
				$text = '';
				break;
			} else if($TextInput == 'A') {
				$text = 'URL A';
			}

			// Build message to reply back
			$messages = array();

			array_push($messages, array(
				'type' => 'text',
				'text' => $text
			));
			array_push($messages, array(
				'type' 				 => 'image',
				'originalContentUrl' => 'https://images.pexels.com/photos/160107/pexels-photo-160107.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260',
				'previewImageUrl'    => 'https://images.pexels.com/photos/160107/pexels-photo-160107.jpeg?auto=compress&cs=tinysrgb&h=75&w=126'
			));

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => $messages,
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}

echo "OKKK";
