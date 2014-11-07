<?php

class vod_controller extends controller
{
	public function index()
	{
		$db = Db::init();
		$stt = $db->vod;
		
		$p = array(
			"userid" => $_SESSION['userid']
		);
		$data = $stt->find($p);
		
		$p = array(
			'data' => $data
		);
		
		$content = $this->getView(DOCVIEW.'vod/index.php', $p);
		$p = array(
			'content' => $content
		);
		$view = $this->getView(DOCVIEW.'template/template.php', $p);
		echo $view;
		
		
	}	
	
	public function add()
	{
		$db = Db::init();
		$stt = $db->vod;
		$data = $stt->find();
		
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
				$stt = $db->vod;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'],  
				);
				
				$stt->insert($data);
				
				$sql = MysqlDB::init();
				$data_sql = array(
					'user' => 'vod-'.$name,
					'userid' => $_SESSION['userid'],
					'password' => md5('123456789'), //
					'host' => 'www.deboxs.com',
					'Dir' => '/var/www/program/client-data/'.$_SESSION['userid'].'/vod/'.$name,
					'mongoid' => trim($data['_id'])
				);
				$sql->insert('users', $data_sql);
				
				/*$curl = new Curl();
				$curl->get('http://www.deboxs.com/api/clientdata/createfolder', array(
				    'userid' => $_SESSION['userid'],
				    'typename' => 'vod',
				    'name' => $name
				));*/
				
				
				header("Location: ".'/vod/index/');
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
		
		$link = '/vod/add';
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'link' => $link,
			'data' => $data
		);
		
		$content = $this->getView(DOCVIEW.'vod/add.php', $p);
		
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
		$stt = $db->vod;
		$sdb = $stt->findOne(array('_id' => new MongoId($id)));
		
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
				$stt = $db->vod;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'],  
				);
				$newdata = array('$set' => $data);
				$stt->update(array("_id" => new MongoId($id)), $newdata);
				header("Location: ".'/vod/index/');
				return;
			}
			else
			{
				$error = $validator->getErrors();	
			}
		}
		else
		{
			$name = $sdb['name'];
			$status = $sdb['status'];
			$deskripsi = $sdb['deskripsi'];
		}
		
		$link = '/vod/edit?id='.$id;
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'link' => $link,
		);
		
		$content = $this->getView(DOCVIEW.'vod/add.php', $p);
		
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
		$stt = $db->vod;
		
		$stt->remove(array('_id' => new MongoId($id)));
		header("Location: ".'/vod/index/');
	}
}
