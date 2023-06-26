<?php
// +--------------------------------------------+
// | Name: function.php
// +--------------------------------------------+
// | User: Administrator
// +--------------------------------------------+
// | Author: Nathan <www.nanyinet.com>
// +--------------------------------------------+
// | Date: 2023-06-25 11:49
// +--------------------------------------------+
// | Created: PHPStorm
// +--------------------------------------------+
function GetModel($openai_api_key) {
    if (empty($openai_api_key)) {
        return json_encode(['code' => 0, 'msg' => '密钥为空！请输入密钥！'], 320);
    }
    $Url = 'https://api.nanyinet.com/api/ai/api.php';
    $Data = array(
        'action' => 'Models',
        'key' => $openai_api_key
    );
    $urlWithParams = $Url . '?' . http_build_query($Data);
    $resultdata = curl_request($urlWithParams);
    if (!$resultdata) {
        return json_encode(['code' => 0, 'msg' => '无效的响应'], 320);
    }
    return $resultdata;
}

function Chat($openai_api_key,$question,$history) {
    if (empty($question)) {
        return json_encode(['code' => 0, 'msg' => '问题为空！请输入问题！'], 320);
    }elseif (empty($openai_api_key)) {
        return json_encode(['code' => 0, 'msg' => '密钥为空！请输入密钥！'], 320);
    }
    $Url = 'https://api.nanyinet.com/api/ai/api.php';
    $Data = array(
        'action' => 'Chat',
        'key' => $openai_api_key,
        'question' => $question,
        'history' => $history,
    );
    $urlWithParams = $Url . '?' . http_build_query($Data);
    $resultdata = curl_request($urlWithParams);
    if (!$resultdata) {
        return json_encode(['code' => 0, 'msg' => '无效的响应'], 320);
    }
    $response = json_decode($resultdata, true);
    $fileContent = $_SERVER["REMOTE_ADDR"] . " | " . date("Y-m-d H:i:s") . "\n";
    $fileContent .= "Q:" . $question . "\nA:" . trim($response['data']['answer']) . "\n----------------\n";
    $myFile = fopen("log.txt", "a") or die("Writing file failed.");
    fwrite($myFile, $fileContent);
    fclose($myFile);
    return $resultdata;
}

function SubscriptionInfo($openai_api_key) {
    if (empty($openai_api_key)) {
        return json_encode(['code' => 0, 'msg' => '密钥为空！请输入密钥！'], 320);
    }
    $Url = 'https://api.nanyinet.com/api/ai/api.php';
    $Data = array(
        'action' => 'KeyInfo',
        'key' => $openai_api_key
    );
    $urlWithParams = $Url . '?' . http_build_query($Data);
    $resultdata = curl_request($urlWithParams);
    if (!$resultdata) {
        return json_encode(['code' => 0, 'msg' => '无效的响应'], 320);
    }
    return $resultdata;

}

function curl_request($url, $post = '', $referer = '', $cookie = '', $returnCookie = 0, $ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0') {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $ua);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 60);
    curl_setopt($curl, CURLOPT_REFERER, $referer);

    $httpheader[] = "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
    $httpheader[] = "Accept-Encoding:gzip, deflate";
    $httpheader[] = "Accept-Language:zh-CN,zh;q=0.9";
    $httpheader[] = "Connection:close";
    curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);

    if ($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    if ($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    }
    curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_ENCODING, "gzip");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // 禁用SSL验证
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $data = curl_exec($curl);
    if (curl_errno($curl)) {
        return curl_error($curl);
    }
    curl_close($curl);
    if ($returnCookie) {
        list($header, $body) = explode("\r\n\r\n", $data, 2);
        preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
        $info['cookie'] = substr($matches[1][1], 1);
        $info['content'] = $body;
        return $info;
    } else {
        return $data;
    }
}
