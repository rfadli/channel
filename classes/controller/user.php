<?php

class user_controller extends controller
{
	public function index()
	{
		$content = $this->getView(DOCVIEW.'user/index.php', array());
		$p = array(
			'content' => $content
		);
		$view = $this->getView(DOCVIEW.'template/template.php', $p);
		echo $view;
	}	
	
	public function add()
	{
		echo 'test 2';
	}
	
	public function login()
	{
		$error = array();
		$username= '';
		$pass= '';
		if(!empty($_POST))
		{
			
			if(isset($_POST['username']));
			$username = trim($_POST['username']);
			
			
			if(isset($_POST['pass']))
			$pass = trim($_POST['pass']);
			
			$validator = new Validator();

			$validator->addRule('username', array('require'));
			$validator->addRule('pass', array('require'));
			
			$validator->setData(array(
				"username" => $username,
				"pass" => $pass,
			));
			
			if($validator->isValid())
			{
				if(($username == 'rian') && ($pass == 'rian'))
				{
					// login berhasil
					$_SESSION['userid'] = $username;
					$db = Db::init();
					$stt = $db->users;
					$data = array(
						'username' => $_SESSION['userid'],
						'pass' => $pass,
					);
					$stt->update($data);
					$this->redirect('/');
					exit;
				}
				else
				{
					alert::add("alert-danger", "Silakan Login Kembali.");
				}
				
			}
			else
			{
				$error = $validator->getErrors();
			}
					
		}
		
		
		$link = '/user/login';
		
		$ab = array(
			'username' => $username,
			'pass' => $pass,
			'link' => $link,
			'error' => $error
		);
		
		$view = $this->getView(DOCVIEW.'login/login.php', $ab);
		echo $view;
	}
	
	public function logout()
	{
		unset($_SESSION['userid']);
		$this->redirect('/');
		exit;
	}
	
}
