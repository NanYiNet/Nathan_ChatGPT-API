<?php
// +--------------------------------------------+
// | Name: api.php
// +--------------------------------------------+
// | User: Administrator
// +--------------------------------------------+
// | Author: Nathan <www.nanyinet.com>
// +--------------------------------------------+
// | Date: 2023-06-25 11:49
// +--------------------------------------------+
// | Created: PHPStorm
// +--------------------------------------------+
require_once('function.php');
$config = require_once('config.php');
$act = isset($_GET['action']) ? $_GET['action'] : null;
if(empty($_GET['key'])){
    $openai_api_key = $config['OPENAI_API_KEY'];
}else{
    $openai_api_key = $_GET['key'];
}
if ($config['OPENAI_API_KEY'] == '') {
    $data = array('code' => 0, 'msg' => '请先在config.php中配置OPENAI_API_KEY');
    exit(json_encode($data,320));
}
switch ($act) {
    case 'Models':
        $response = GetModel($openai_api_key);
        exit($response);
        break;
    case 'Chat':
        $question = $_GET['question'];
        $history = $_GET['history'];
        $response = Chat($openai_api_key,$question,$history);
        exit($response);
        break;
    case 'KeyInfo':
        $response = SubscriptionInfo($openai_api_key);
        exit($response);
        break;
    default:
        $data = array('code' => 0, 'msg' => '非法请求');
        exit(json_encode($data,320));
        break;
}