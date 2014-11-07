<?php

class vodname_controller extends controller
{
	public function index()
	{
		$idvod = $_GET['idvod'];
		$db = Db::init();
		$stk = $db->vod;
		
		$p = array(
			"_id" => new MongoId($idvod)
		);
		
		$data = $stk->findOne($p);
		
		$p = array(
			'data' => $data,
			'idvod' => $idvod
		);
		$content = $this->getView(DOCVIEW.'vodname/index.php', $p);
		
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
		$stk = $db->vodname;
		$data = $stk->find();
		
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
				$stk = $db->vodname;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'], 
					'vod_id' => trim($id) 
				);
				$stk->insert($data);
				header("Location: ".'/vodname/index?idvod='.$id);
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
		
		$link = '/vodname/add?id='.$id;
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'link' => $link,
			'data' => $data,
		);
		
		$content = $this->getView(DOCVIEW.'vodname/add.php', $p);
		
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
		$stk = $db->vod;
		$sdd = $stk->findOne(array('_id' => new MongoId($id)));
		
		
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
				$stk = $db->vod;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'],
					'vod_id' => trim($id)  
				);
				$newdata = array('$set' => $data);
				$stk->update(array("_id" => new MongoId($id)), $newdata);
				
				$sql = MysqlDB::init();
				$data_sql = array(
					'user' => 'vod-'.$name,
					'userid' => $_SESSION['userid'],
					'Password' => $password, //
					'host' => 'www.deboxs.com',
					'Dir' => '/var/www/program/client-data/'.$_SESSION['userid'].'/vod/'.$name,
					'mongoid' => trim($data['_id'])
				);
				$sql->update('users', $data_sql);
				
				header("Location: ".'/vodname/index?idvod='.$id);
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
			
			$name = $sdd['name'];
			$status = $sdd['status'];
			$deskripsi = $sdd['deskripsi'];
			$password = $mabouts['Password'];
		}
		
		$link = '/vodname/edit?id='.$id;
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'password' => $password,
			'link' => $link,
		);
		
		$content = $this->getView(DOCVIEW.'vodname/edit.php', $p);
		
		$a = array(
			'content' => $content
		);
		
		$view = $this->getView(DOCVIEW.'template/template.php', $a);
		echo $view;
	}

	public function delete()
	{
		
		$idvod = $_GET['idvod'];
		$db = Db::init();
		$stk = $db->vod;
		
		$p = array(
			"_id" => new MongoId($idvod)
		);
		
		$data = $stk->findOne($p);
		
		$id = $_GET['id'];
		$curl = new Curl();
		$curl->get('http://www.deboxs.com/api/clientdata/removefolder', array(
		    'userid' => $_SESSION['userid'],
		    'typename' => 'vod',
		    'name' => $data['name']
		));
		//echo 'response : ' .$curl->response;
		header("Location: ".'/vodname/index?idvod='.$id);
	}
}
