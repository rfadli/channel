<?php

class other_controller extends controller
{
	public function index()
	{
		$db = Db::init();
		$stg = $db->other;
		
		$p = array(
			"userid" => $_SESSION['userid']
		);
		$data = $stg->find($p);
		
		$p = array(
			'data' => $data
		);	
		
		$content = $this->getView(DOCVIEW.'other/index.php', $p);
		$p = array(
			'content' => $content
		);
		$view = $this->getView(DOCVIEW.'template/template.php', $p);
		echo $view;
	}	
	
	public function add()
	{
		$db = Db::init();
		$stg = $db->other;
		$data = $stg->find();
		
		if(!empty($_POST))
		{
			$name = '';
			if(isset($_POST['name']));
			$name = trim($_POST['name']);
			
			$status="disable";
			if(isset($_POST['status']))
				$status="enable";
			
			$deskripsi = '';
			if(isset($_POST['deskripsi']));
			$deskripsi = trim($_POST['deskripsi']);
			
			$validator = new Validator();
			
			$validator->addRule('name', array('require'));
			
			$validator->setData(array(
				"name" => $name,
			));
			
			if($validator->isValid())
			{
				$db = Db::init();
				$stg = $db->other;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'],  
				);
				$stg->insert($data);
				
				$sql = MysqlDB::init();
				$data_sql = array(
					'user' => 'other-'.$name,
					'userid' => $_SESSION['userid'],
					'password' => md5('123456789'), //
					'host' => 'main.deboxs.com',
					'Dir' => '/var/www/program/client-data/'.$_SESSION['userid'].'/other/'.$name,
					'mongoid' => trim($data['_id'])
				);
				$sql->insert('users', $data_sql);
				
				$curl = new Curl();
				$curl->get('http://www.deboxs.com/api/clientdata/createfolder', array(
				    'userid' => $_SESSION['userid'],
				    'typename' => 'other',
				    'name' => $name
				));
				
				header("Location: ".'/other/index/');
				return;
			}
			else
			{
				$error = $validator->getErrors();
			}
		}
		else
		{
			$name = '';
			$status = '';
			$deskripsi = '';
		}
		
		$link = '/other/add';
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'link' => $link,
			'data' => $data
		);
		
		$content = $this->getView(DOCVIEW.'other/add.php', $p);
		
		$p = array(
			'content' => $content
		);
		
		$view = $this->getView(DOCVIEW.'template/template.php', $p);
		echo $view;
	}

	public function edit ()
	{
		$id = $_GET['id'];
		$db = Db::init();
		$stg = $db->other;
		$sde = $stg->findOne(array('_id' => new MongoId($id)));
		
		if(!empty($_POST))
		{
			$name = '';
			if(isset($_POST['name']));
			$name = trim($_POST['name']);
			
			$status="disable";
			if(isset($_POST['status']))
				$status="enable";
			
			$deskripsi = '';
			if(isset($_POST['deskripsi']));
			$deskripsi = trim($_POST['deskripsi']);
			
			$validator = new Validator();
			$validator->addRule('name', array('require'));
			
			$validator->setData(array(
				'name' => $name
			));
			
			if($validator->isValid())
			{
				$db = Db::init();
				$stg = $db->other;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'],  
				);
				$newdata = array('$set' => $data);
				$stg->update(array("_id" => new MongoId($id)), $newdata);
				header("Location: ".'/other/index/');
				return;
			}
			else
			{
				$error = $validator->getErrors();	
			}
		}
		else
		{
			$name = $sde['name'];
			$status = $sde['status'];
			$deskripsi = $sde['deskripsi'];
		}
		
		$link = '/other/edit?id='.$id;
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'link' => $link,
		);
		
		$content = $this->getView(DOCVIEW.'other/add.php', $p);
		
		$p = array(
			'content' => $content
		);
		
		$view = $this->getView(DOCVIEW.'template/template.php', $p);
		echo $view;
		
	}

	public function delete()
	{
		$id = $_GET['id'];
		$db = Db::init();
		$stg = $db->other;
		
		$stg->remove(array('_id' => new MongoId($id)));
		header("Location: ".'/other/index/');
	}
}
