<?php
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);
$to = $jsonObj->{"result"}[0]->{"content"}->{"from"};

// テキストで返事をする場合
$response_format_text = ['contentType'=>1,"toType"=>1,"text"=>"me too"];
// 画像で返事をする場合
//$response_format_image = ['contentType'=>2,"toType"=>1,'originalContentUrl'=>"画像URL","previewImageUrl"=>"サムネイル画像URL"];
// 他にも色々ある
// ....

// toChannelとeventTypeは固定値なので、変更不要。
$post_data = ["to"=>[$to],"toChannel"=>"1383378250","eventType"=>"138311608800106203","content"=>$response_format_text];

$ch = curl_init("https://trialbot-api.line.me/v1/events");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'X-Line-ChannelID:取得したチャンネルID',
    'X-Line-ChannelSecret:取得したチャンネルシークレット',
    'X-Line-Trusted-User-With-ACL:取得したMID'
    ));
$result = curl_exec($ch);
curl_close($ch);
