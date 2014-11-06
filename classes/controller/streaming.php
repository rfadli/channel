<?php

class streaming_controller extends controller
{
	public function index()
	{
		$db = Db::init();
		$str = $db->channel;
		
		$p = array(
			"userid" => $_SESSION['userid']
		);
		$data = $str->find($p);
		
		$p = array(
			'data' => $data
		);
		$content = $this->getView(DOCVIEW.'streaming/index.php', $p);
		$p = array(
			'content' => $content
		);
		$view = $this->getView(DOCVIEW.'template/template.php', $p);
		echo $view;
	}	
	
	public function add()
	{
		$db = Db::init();
		$str = $db->channel;
		$data = $str->find();
		
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
				$str = $db->channel;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'],  
				);
				$str->insert($data);
				header("Location: ".'/streaming/index/');
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
		
		$link = '/streaming/add';
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'link' => $link,
			'data' => $data
		);
		
		$content = $this->getView(DOCVIEW.'streaming/add.php', $p);
		
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
		$str = $db->channel;
		$sdk = $str->findOne(array('_id' => new MongoId($id)));
		
				
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
				$str = $db->channel;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'],  
				);
				$newdata = array('$set' => $data);
				$str->update(array("_id" => new MongoId($id)), $newdata);
				header("Location: ".'/streaming/index/');
				return;
			}
			else
			{
				$error = $validator->getErrors();	
			}
		}
		else
		{
			$name = $sdk['name'];
			$status = $sdk['status'];
			$deskripsi = $sdk['deskripsi'];
			$password = $mabouts['password'];
		}
		
		
		$link = '/streaming/edit?id='.$id;
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'password' => $password,
			'link' => $link,
		);
		
		$content = $this->getView(DOCVIEW.'streaming/add.php', $p);
		
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
		$str = $db->channel;
		
		$str->remove(array('_id' => new MongoId($id)));
		header("Location: ".'/streaming/index/');
	}
}
