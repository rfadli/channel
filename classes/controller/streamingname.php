<?php

class streamingname_controller extends controller
{
	public function index()
	{
		$idchanel = $_GET['idchanel'];
		$db = Db::init();
		$str = $db->stream;
		
		$p = array(
			"channel_id" => $idchanel
		);
		$data = $str->find($p);
		
		$p = array(
			'data' => $data,
			'idchanel' => $idchanel
		);
		$content = $this->getView(DOCVIEW.'streamingname/index.php', $p);
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
		$str = $db->stream;
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
				$str = $db->stream;
				$data = array(
					'name' => $name,
					'status' => $status,
					'deskripsi' => $deskripsi,
					'time_created' => time(),
					'userid' => $_SESSION['userid'], 
					'channel_id' => trim($id) 
				);
				$str->insert($data);
				header("Location: ".'/streamingname/index?idchanel='.$id);
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
		
		$link = '/streamingname/add?id='.$id;
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'link' => $link,
			'data' => $data,
		);
		
		$content = $this->getView(DOCVIEW.'streamingname/add.php', $p);
		
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
		$str = $db->stream;
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
					'channel_id' => trim($id)  
				);
				$newdata = array('$set' => $data);
				$str->update(array("_id" => new MongoId($id)), $newdata);
				header("Location: ".'/streamingname/index?idchanel='.$id);
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
		}
		
		$link = $this->getView(DOCVIEW. '/streamingname/edit?id='.$id);
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'link' => $link,
		);
		
		$content = $this->getView(DOCVIEW.'streaming/add.php', $p);
		
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
		$str = $db->stream;
		
		$str->remove(array('_id' => new MongoId($id)));
		header("Location: ".'/streaming/index/');
	}
}
