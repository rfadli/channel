<?php

class controller
{
	var $css;
	var $js;
	var $dta;
	
	public function __construct()
	{
		$this->css = array();
		$this->js = array();
		
		
		if(!isset($_SESSION['userid']))
		{
			// gakada
			$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			if ($path != '/user/login')
			{
				$this->redirect('/user/login');
				exit;	
			}
		}
		else {
			if(strlen(trim($_SESSION['userid'])) == 0)
			{
				$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
				if ($path != '/user/login')
				{
					$this->redirect('/user/login');
					exit;	
				}
			}
		}
	}
	
	protected function before()
	{
		
	}
	
	protected function getView($filename, $variable)
	{
		extract($variable);
		ob_start();
		(include $filename);
		$content = ob_get_contents();
		ob_end_clean ();
		return $content;
	}

	protected function getPage()
	{
	    $page = 1;
		if(isset($_GET['page']))
			$page = $_GET['page'];
		
		if(strlen(trim($page)) > 0)
		{
		    $page = intval($page);
		}
		else {
		    $page = 1;
		}
		return $page;
	}
            
    protected function getListDevice($page=1,$limit=20,$url='')
	{
		$db = Db::init();
		$devTbl = $db->devices;

        	$skip = (int)($limit * ($page - 1));
		
		$count = $devTbl->count();

		$devList = $devTbl->find()->limit($limit)->skip($skip);
		$pg = new Pagination();
		$pg->pag_url = $url;
		$pg->calculate_pages($count, $limit, $page);
		$var = array(
			'deviceList' => $devList,
			'pagination' => $pg->Show()
		);
		return $var;
	}
	
	protected function redirect($page)
	{
		header( 'Location: '.$page ) ;
	}
	
	protected function getcart()
	{
		$id = session_id();
		$db = Db::init();
		$d = $db->carts;
		$c = $d->find(array('session_id' => $id));
		$item = 0;
		$total = 0;
		foreach($c as $cc)
		{
			$db = Db::init();
			$p = $db->products;
			$pp = $p->findone(array('_id' => new MongoId($cc['book_id'])));
				
			$total += $pp['price']-($pp['price']*($pp['diskon']/100));;
			$item++;
		}
		$var = array(
			'item' => $item,
			'total' => $total,
			'dat' => $c
		);
		return $this->getView(DOCVIEW."template/cart2.php", $var);
	}
	
	protected function getLinkGoogle()
	{
		$data = array(
			'method' => 'getLinkGoogle',
			'id' => 212,
			'params' => array(array(
				'appid' => APP_ID,
				'redirect' => BASE_URL.'/account/loginGoogle'
			))
		);
		
		$json = json_encode($data);
		
		$url = SSO_URL;
		
		$curl = new Curl();
		$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$curl->post($url.'login/getlinkgoogle', $json);
		
		$h = json_decode($curl->response, true);
		
		$hh = $h['result'][0];
		$link = $hh['google_url'];
		
		return $link;
	}
	
	protected function getLinkFB()
	{
		$data = array(
			'method' => 'getLinkFacebook',
			'id' => 212,
			'params' => array(array(
				'appid' => APP_ID,
				'redirect' => BASE_URL.'/account/loginFb'
			))
		);
		
		$json = json_encode($data);
		
		$url = SSO_URL;
		
		$curl = new Curl();
		$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$curl->post($url.'login/getlinkfacebook', $json);
		
		$h = json_decode($curl->response, true);
		
		$hh = $h['result'][0];
		$link = $hh['facebook_url'];
		
		return $link;
	}
	
	protected function getLinkTwitter()
	{
		$data = array(
			'method' => 'getLinkTwitter',
			'id' => 212,
			'params' => array(array(
				'appid' => APP_ID,
				'redirect' => BASE_URL.'/account/loginTwitter'
			))
		);
		
		$json = json_encode($data);
		
		$url = SSO_URL;
		
		$curl = new Curl();
		$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$curl->post($url.'login/getlinktwitter', $json);
		
		$h = json_decode($curl->response, true);
		
		$hh = $h['result'][0];
		$link = $hh['twitter_url'];
		
		return $link;
	}
	
	protected function render($group, $view, $var)
	{
		$css[] = "/public/media/assets/css/bootstrap.min.css";
		$css[] = "/public/media/assets/css/main.css";
		$css[] = "/public/media/assets/css/purple.css";
		//$css[] = "/public/media/assets/css/orange.css";
		$css[] = "/public/media/assets/css/owl.carousel.css";
		$css[] = "/public/media/assets/css/owl.transitions.css";
		$css[] = "/public/media/assets/css/animate.min.css";
		//$css[] = "/public/media/assets/css/config.css";
		//$css[] = "/public/media/assets/css/green.css";
		$css[] = "http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800";
		$css[] = "/public/media/assets/css/font-awesome.min.css";
		$css[] = "/public/global/toastr/toastr.min.css";
		
		//book-store
		$css[] = "/public/book-store/css/style.css";
		//$css[] = "/public/book-store/css/bs.css";
		//<!-- All css -->

  		$js[] = "/public/media/assets/js/jquery-1.10.2.min.js"; 
  		$js[] = "/public/media/assets/js/jquery-migrate-1.2.1.js"; 
		$js[] = "/public/media/assets/js/bootstrap.min.js"; 
		//$js[] = "http://maps.google.com/maps/api/js?sensor=false&amp;language=en"; 
		//$js[] = "/public/media/assets/js/gmap3.min.js"; 
		$js[] = "/public/media/assets/js/bootstrap-hover-dropdown.min.js"; 
		$js[] = "/public/media/assets/js/owl.carousel.min.js"; 
		$js[] = "/public/media/assets/js/css_browser_selector.min.js"; 
		$js[] = "/public/media/assets/js/echo.min.js"; 
		$js[] = "/public/media/assets/js/jquery.easing-1.3.min.js"; 
		$js[] = "/public/media/assets/js/bootstrap-slider.min.js"; 
		$js[] = "/public/media/assets/js/jquery.raty.min.js"; 
		$js[] = "/public/media/assets/js/jquery.prettyPhoto.min.js"; 
		$js[] = "/public/media/assets/js/jquery.customSelect.min.js"; 
		$js[] = "/public/media/assets/js/wow.min.js"; 
		$js[] = "/public/media/assets/js/scripts.js"; 
		//$js[] = "http://w.sharethis.com/button/buttons.js"; 
	
		$js[] = "/public/global/toastr/toastr.min.js";
		$js[] = "/public/global/plugins/bootbox/bootbox.min.js";
		$js[] = "/public/controller/glob.js";
		
		//$js[] = "/public/book-store/js/bxslider.js";
		
		
		
		if(!isset($_SESSION['linkgoogle']))
		{
			$g = $this->getLinkGoogle();
			$_SESSION['linkgoogle'] = $g;
		}
		
		if(!isset($_SESSION['linkfb']))
		{
			$f = $this->getLinkFB();
			$_SESSION['linkfb'] = $f;
		}
		
		if(!isset($_SESSION['linktwitter']))
		{
			$t = $this->getLinkTwitter();
			$_SESSION['linktwitter'] = $t;
		}

		$leftmenu = $this->getView(DOCVIEW."template/leftmenu.php", array('controller' => $group));
		$cart = $this->getcart();
		
		$var = array_merge($var, array());
		//$var = array_merge($var, $this->dta);		
		$controller = $group;
		$content = $this->getView(DOCVIEW.$view, $var);		
		
		$meta_description = "";
		if(isset($var['meta_description']))	
			$meta_description = $var['meta_description'];
		$meta_keywords = "";	
		if(isset($var['meta_keywords']))
			$meta_keywords = $var['meta_keywords'];	
		$ogtitle = "";
		if(isset($var['ogtitle']))
			$ogtitle = $var['ogtitle'];
		$ogimage = "";
		if(isset($var['ogimage']))
			$ogimage = $var['ogimage'];
		$ogdescription = "";
		if(isset($var['ogdescription']))
			$ogdescription = $var['ogdescription'];
		$addscope ="";
		if(isset($var['addscope']))
			$addscope = $var['addscope'];
		
		$css = array_merge($css, $this->css);
		$js = array_merge($js, $this->js);
		include(DOCVIEW."template/template3.php");
	}
}
?>