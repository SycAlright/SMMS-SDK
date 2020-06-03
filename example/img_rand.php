<?php
namespace syc;

/**
 * 随机一图
 * 从你的SMMS库中随机抽取一张图片显示
 * Author: Syc <www.php.wf>
 * PHP_Version > 5.5
 */
 
require("smms.class.php");

$sdk = new sdk\smms('Your Authorization');

$upload_history = $sdk->Image_UploadHistory();
$result = json_decode($upload_history);

if(1 == $result->success) {
	$poor_img = array();
	foreach($result->data as $data) {
		array_push($poor_img, $data->url);
	}
	$id = array_rand($poor_img, 1);
	$img = $poor_img[$id];
	header("Location: $img", true, 301);
}else{
	header('Location: https://php.wf/', true, 302);
}
