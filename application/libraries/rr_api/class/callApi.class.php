<?php
/*
 * Call RESTAPI Class Aaron 2012-08-29
 */
class CallApi
{

	private $session_key;

	private $rrObj; // Renren api class
	
	function __construct($session_key, $rrObj)
	{
		$this->session_key = $session_key;
		$this->rrObj = $rrObj;
	}

	function getUserInfo()
	{
		$params = array (
				'fields' => 'uid,name,birthday',
				'session_key' => $this->session_key 
		);
		$res = $this->rrObj->rr_post_curl('users.getInfo', $params);
		return $res;
	}
	
	function getUserBirthday()
	{
		$userinfo = $this->getUserInfo();
		$userBirth = explode('-', $userinfo[0]['birthday']);
		return $userBirth;
	}

	function getFriends()
	{
		$params = array (
				'session_key' => $this->session_key 
		);
		$res = $this->rrObj->rr_post_curl('friends.get', $params);
		return $res;
	}

	function getFriendsInfo($uids)
	{
		$params = array (
				'uids' => $uids,
				'fields' => 'uid,name,sex,birthday,tinyurl,headurl',
				'session_key' => $this->session_key 
		);
		$res = $this->rrObj->rr_post_curl('users.getInfo', $params);
		return $res;
	}

	function postNewMessage($message)
	{
		// $params =
		// array('name'=>"这是name",'description'=>"这是描述",'url'=>"这是url",
		// 'image'=>"http://wiki.dev.renren.com/mediawiki/images/a/a7/Wiki2.png",
		// 'action_name'=>"这是action_name",'action_link'=>"http://www.renren.com",
		// 'message'=>"这是message",'session_key'=>$session_key);//使用session_key调api的情况
		$params = array (
				'status' => $message,
				'session_key' => $this->session_key 
		);
		$res = $this->rrObj->rr_post_curl('status.set', $params); // curl函数发送请求
		return $res;
	}

	function uploadPhoto($img_src)
	{
		$description = "与我生日相同的好友，你也试试 http://apps.renren.com/birthdates";
		preg_match('|\.(\w+)$|', $img_src, $ext); // 转化成小写
		$ext = strtolower($ext[1]);
		$myfile = array (
				'upload' => array (
						'name' => 'your.' . $ext,
						'tmp_name' => $img_src,
						'type' => 'image/' . $ext 
				) 
		);
		$params = array (
				'aid' => "0",
				'caption' => $description,
				'session_key' => $this->session_key 
		);
		$res = $this->rrObj->rr_photo_post_fopen('photos.upload', $params, $myfile);
		return $res;
	}
}