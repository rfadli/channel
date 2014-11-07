<?php

class othername_controller extends controller
{
	public function index()
	{	
		$idother = $_GET['idother'];
		$db = Db::init();
		$stq = $db->other;
		
		$p = array(
			"_id" => new MongoId($idother)
		);
		$data = $stq->findOne($p);
		
		$p = array(
			'data' => $data,
			'idother' => $idother
		);
		$content = $this->getView(DOCVIEW.'othername/index.php', $p);
		
		$p = array(
			'content' => $content
		);
		$view = $this->getView(DOCVIEW.'template/template.php', $p);
		echo $view;
	}	
	
	public function add()
	{
		$id = $_GET['id'];
		$db = Db::init();
		$stq = $db->othername;
		$data = $stq->find();
		
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
				$stq = $db->othername;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'], 
					'other_id' => trim($id) 
				);
				$stq->insert($data);
				header("Location: ".'/othername/index?idother='.$id);
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
		
		$link = '/othername/add?id='.$id;
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'link' => $link,
			'data' => $data,
		);
		
		$content = $this->getView(DOCVIEW.'othername/add.php', $p);
		
		$p = array(
			'content' => $content
		);
		
		$view = $this->getView(DOCVIEW.'template/template.php', $p);
		echo $view;
	}
	
	public function edit()
	{
		$id = $_GET['id'];
		$db = Db::init();
		$stq = $db->other;
		$sdu = $stq->findOne(array('_id' => new MongoId($id)));
		
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
			
			$password = '';
			if(isset($_POST['password']));
			$password = trim($_POST['password']);	
			
			$validator = new Validator();
			$validator->addRule('name', array('require'));
			
			$validator->setData(array(
				'name' => $name
			));
			
			if($validator->isValid())
			{
				$db = Db::init();
				$stq = $db->othername;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'],
					'other_id' => trim($id)  
				);
				$newdata = array('$set' => $data);
				$stq->update(array("_id" => new MongoId($id)), $newdata);
				
				$sql = MysqlDB::init();
				$data_sql = array(
					'user' => 'vod-'.$name,
					'userid' => $_SESSION['userid'],
					'password' => $password, //
					'host' => 'www.deboxs.com',
					'Dir' => '/var/www/program/client-data/'.$_SESSION['userid'].'/other/'.$name,
					'mongoid' => trim($data['_id'])
				);
				$sql->update('users', $data_sql);
				
				header("Location: ".'/othername/index?idother='.$id);
				return;
			}
			else
			{
				$error = $validator->getErrors();	
			}
		}
		else
		{
			$sql_i = MysqlDB::init();
			$sql_i->where('mongoid', $id);
			$mabouts = $sql_i->getOne('users');
			
			$name = $sdu['name'];
			$status = $sdu['status'];
			$deskripsi = $sdu['deskripsi'];
			$password = $mabouts['Password'];
		}
		
		$link = '/othername/edit?id='.$id;
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'password' => $password,
			'link' => $link,
		);
		
		$content = $this->getView(DOCVIEW.'othername/edit.php', $p);
		
		$a = array(
			'content' => $content
		);
		
		$view = $this->getView(DOCVIEW.'template/template.php', $a);
		echo $view;
	}

	public function delete()
	{
		$id = $_GET['id'];
		$db = Db::init();
		$stq = $db->othername;
		
		$stq->remove(array('_id' => new MongoId($id)));
		header("Location: ".'/other/index/');
	}
}
