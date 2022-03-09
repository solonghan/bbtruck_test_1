<?php defined('BASEPATH') or exit('No direct script access allowed');
require 'vendors/autoload.php';
class Login_model extends CI_Model
{
	//private $fb_app_id = '703984480500954';
	private $fb_app_id = '1143643603107224';

	private $fb_app_secret = '4bf82dfb5ef615211da24b30f13283bc';
	
	private $fb_version = 'v6.0';
	private $fb_callback = 'home/fb_callback/tw';

	private $g_CLIENT_ID = '487744722232-ma60hla9nfif0gstblo8krbmto0d8qrb.apps.googleusercontent.com';
	private $g_CLIENT_SECRET = 'Hj8UagkGxFwIKeM7lCaEq3XB';
	private $g_CLIENT_REDIRECT_URL = 'home/g_callback/tw';

	private $loginpage = 'home/login/tw';

	private $member_table = 'user';

	function __construct()
	{
		parent::__construct();

		$this->g_CLIENT_REDIRECT_URL = base_url() . $this->g_CLIENT_REDIRECT_URL;
	}

	public function login($data)
	{
		$data["isLogin"] = $this->encryption->encrypt(md5("uLogIn"));

		$this->session->set_userdata($data);
	}

	public function is_login()
	{

		if (!($this->session->isLogin && $this->encryption->decrypt($this->session->isLogin) == md5("uLogIn")) && $this->session->user_id) {

			header("Location: " . base_url() . "home/login/tw");
		}
	}

	public function register($data, $is_exist = FALSE)
	{
		if ($is_exist) {
			$this->db->where(array("email" => $data['email']));
			return $this->db->update($this->member_table, $data);
		} else {



			return $this->db->insert($this->member_table, $data);
		}
	}

	/*
	GOOGLE LOGIN
	 */

	public function g_login()
	{
		$login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode($this->g_CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . $this->g_CLIENT_ID . '&access_type=online';

		header("Location: " . $login_url);
	}

	public function g_callback()
	{
		if ($this->input->get("code")) {
			try {
				// Get the access token 
				$data = $this->g_GetAccessToken($this->g_CLIENT_ID, $this->g_CLIENT_REDIRECT_URL, $this->g_CLIENT_SECRET, $this->input->get("code"));
				// print_r($data);
				// exit;
				$user_info = $this->g_GetUserProfileInfo($data['access_token']);
				// print_r($user_info);
				// exit;
				return array(
					"name"	=>	$user_info['name'],
					"id"	=>	$user_info['sub'],
					"email"	=>	$user_info['email'],
					"pic"	=>	$user_info['picture']
				);
			} catch (Exception $e) {
				echo $e->getMessage();
				exit();
			}
		}
	}

	private function g_GetAccessToken($client_id, $redirect_uri, $client_secret, $code)
	{
		$url = 'https://accounts.google.com/o/oauth2/token';

		$curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code=' . $code . '&grant_type=authorization_code';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$data = json_decode(curl_exec($ch), true);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($http_code != 200)
			throw new Exception('Error : Failed to receieve access token');

		return $data;
	}

	private function g_GetUserProfileInfo($access_token)
	{
		//取得api_url
		$url = "https://www.googleapis.com/oauth2/v3/userinfo";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
		$data = json_decode(curl_exec($ch), true);

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($http_code != 200)
			throw new Exception('Error : Failed to get user information');

		return $data;
	}

	/*
	FB LOGIN
	 */

	public function fb_login()
	{
		if (!session_id()) {
			session_start();
		}
		$fb = new Facebook\Facebook([
			'app_id' => $this->fb_app_id,
			'app_secret' => $this->fb_app_secret,
			'default_graph_version' => $this->fb_version,
		]);

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['public_profile', 'email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl(base_url() . $this->fb_callback, $permissions);
		//var_dump($permissions);
		//exit;		
		header("Location: " . $loginUrl);
	}

	public function fb_callback()
	{

		$fb = new Facebook\Facebook([
			'app_id' => $this->fb_app_id,
			'app_secret' => $this->fb_app_secret,
			'default_graph_version' => $this->fb_version,
		]);

		$helper = $fb->getRedirectLoginHelper();

		//var_dump($helper);	

		try {
			//嚴格模式下，要代入callback的url


			$accessToken = $helper->getAccessToken(base_url() . $this->fb_callback);
			//$accessToken = $helper->getAccessToken();
			//  var_dump($accessToken);
			//  exit;

		} catch (Facebook\Exceptions\FacebookResponseException $e) {
			echo 'Graph returned an error: ' . $e->getMessage();
			$date = date("Y-m-d H:i:s");
			$fp = fopen('logForTestLogIn.txt', 'a'); //opens file in append mode  
			fwrite($fp,'Graph returned an error: ' . $e->getMessage() .' ');
			fwrite($fp, 'date : ' . $date . PHP_EOL);
			fclose($fp);
			header("Location: " . base_url() . $this->loginpage);
			exit;
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			$date = date("Y-m-d H:i:s");
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			$fp = fopen('logForTestLogIn.txt', 'a'); //opens file in append mode  
			fwrite($fp, 'Facebook SDK returned an error: ' . $e->getMessage() .' ');
			fwrite($fp, 'date : ' . $date . PHP_EOL);
			fclose($fp);
			header("Location: " . base_url() . $this->loginpage);
			exit;
		} 

		if (!isset($accessToken)) {
			if ($helper->getError()) {
				header('HTTP/1.0 401 Unauthorized');
				echo "Error: " . $helper->getError() . "\n";
				echo "Error Code: " . $helper->getErrorCode() . "\n";
				echo "Error Reason: " . $helper->getErrorReason() . "\n";
				echo "Error Description: " . $helper->getErrorDescription() . "\n";
				header("Location: " . base_url() . $this->loginpage);
			} else {
				header('HTTP/1.0 400 Bad Request');
				echo 'Bad request';
			}
			exit;
		}

		$response = $fb->get('/me?fields=id,name,email,picture.type(large)', $accessToken->getValue());
		$user = $response->getGraphUser();

		return $user;
		// $user['name'];
		// $user['id'];
		// $user['email'];
	}
}
