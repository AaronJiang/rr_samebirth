<?php

if (! defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Ajax Request Controller
 * Receive Ajax from main page and call Renren API
 *
 * @author Aaron 2013/02/04
 */
class Ajax extends CI_Controller
{

	/**
	 * @var api call example
	 */
	public $callApi;

	/**
	 * @var api session key
	 */
	public $session_key;

	/**
	 * Set header and include Renren SDK
	 */
	public function __construct()
	{
		parent::__construct();
		header('P3P:CP="CAO PSA OUR"');
		$this->load->library('session');
		
		require_once LIBRARYPATH . 'rr_api/class/RenrenRestApiService.class.php';
		require_once LIBRARYPATH . 'rr_api/class/callApi.class.php';
		$this->rrObj = new RenrenRestApiService();
		$this->rrObj->setEncode("utf-8");
		
		$this->session_key = $this->session->userdata('session_key');
		$this->callApi = new CallApi($this->session_key, $this->rrObj);
	}

	public function index()
	{
		// index action
	}

	/**
	 * Generate photo contains same birthday friends
	 */
	public function generatePhoto()
	{
		$userBirth = $this->callApi->getUserBirthday();
		
		// Get friends info
		$friendsList = $this->callApi->getFriends();
		$uids = implode(',', $friendsList);
		$friendsInfo = $this->callApi->getFriendsInfo($uids);
		
		// Filter same birthday
		$sameBirthList = array ();
		foreach ($friendsInfo as $key => $detail)
		{
			$friendBirth = explode('-', $detail['birthday']);
			if ($friendBirth == $userBirth)
			{
				// Same birthday and birthyear
				$sameBirthList['sameyear'][] = $detail;
			}
			elseif ($friendBirth[1] == $userBirth[1] && $friendBirth[2] == $userBirth[2])
			{
				// Same birthday, diff birthyear
				$sameBirthList['diffyear'][] = $detail;
			}
		}
		
		if (! empty($sameBirthList))
		{
			$bgImage = "/assets/image/bg.jpg";
			// $fontTitle="../font/WCL-03.ttf";
			$font = "/assets/font/font.TTF";
			$bg_image = imagecreatefromjpeg($bgImage);
			$p_image = array ();
			
			// create title
			$title = "与我生日相同的好友";
			$titleColor = imagecolorallocate($bg_image, 0, 0, 0);
			imagettftext($bg_image, 16, 0, 95, 30, $titleColor, $fontTitle, $title);
			
			// prepare image list
			$i = 0;
			if (! empty($sameBirthList['sameyear']))
			{
				foreach ($sameBirthList['sameyear'] as $key => $users)
				{
					$y = 90 + ($i * 60);
					$detail = $users['name'] . " " . $users['birthday'];
					imagettftext($bg_image, 14, 0, 125, $y, $titleColor, $font, $detail);
					$p_image[] = imagecreatefromjpeg($users['tinyurl']);
					$i ++;
				}
			}
			if (! empty($sameBirthList['diffyear']))
			{
				foreach ($sameBirthList['diffyear'] as $key => $users)
				{
					$y = 90 + ($i * 60);
					$detail = $users['name'] . " " . $users['birthday'];
					imagettftext($bg_image, 14, 0, 125, $y, $titleColor, $font, $detail);
					$p_image[] = imagecreatefromjpeg($users['tinyurl']);
					$i ++;
				}
			}
			
			// Create image
			$count = count($p_image);
			// max match result is 4
			if ($count > 4)
			{
				$count = 4;
			}
			for ($i = 0; $i < $count; $i ++)
			{
				$y = 60 + ($i * 60);
				imagecopy($bg_image, $p_image[$i], 65, $y, 0, 0, 50, 50);
				imagedestroy($p_image[$i]);
			}
			
			$filename = md5(mktime() . $this->session_key);
			if (imagejpeg($bg_image, "/upload/" . $filename . ".jpg"))
			{
				echo "<img id='uploadimg' src='/upload/" . $filename . ".jpg'>";
			}
		}
	}

	/**
	 * Upload photo and post status
	 */
	public function uploadPhoto()
	{
		$img_src = $_POST["img_src"];
		$res = $this->callApi->uploadPhoto($img_src);
	}
}
