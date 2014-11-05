<?php

class othername_controller extends controller
{
	public function index()
	{
		$idother = $_GET['idother'];
		$db = Db::init();
		$stq = $db->othername;
		
		$p = array(
			"other_id" => $idother
		);
		$data = $stq->find($p);
		
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
		$stq = $db->othername;
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
			$name = $sdu['name'];
			$status = $sdu['status'];
			$deskripsi = $sdu['deskripsi'];
		}
		
		$link = '/othername/edit?id='.$id;
		
		$p = array(
			'name' => $name,
			'status' => $status,
			'deskripsi' => $deskripsi,
			'link' => $link,
		);
		
		$content = $this->getView(DOCVIEW.'othername/add.php', $p);
		
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
