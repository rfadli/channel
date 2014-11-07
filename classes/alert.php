<?php
class alert
{
	public static function add($type, $message) {

      // get session messages
      $messages = "";
	  if(isset($_SESSION['notification']))
	  {
	  	$messages = $_SESSION['notification'];
		$_SESSION['notification'] = "";
	  }		
      // initialize if necessary
      if(!is_array($messages)) {
         $messages = array();
      }
      // append to messages
      $messages[$type][] = $message;
      // set messages
      //Base::instance()->set("SESSION.notification", $messages);
	  $_SESSION['notification'] = $messages;
   }

   public static function count() {
   		$msg = "";
		if(isset($_SESSION['notification']))
			$msg = $_SESSION['notification'];
      return count($msg);
   }

   public static function output() {
      $messages = "";
	  if(isset($_SESSION['notification']))
	  {
	  	$messages = $_SESSION['notification'];
		$_SESSION['notification'] = "";
	  }		      
    
      $str = '';
      if(!empty($messages)) {
         foreach($messages as $type => $messages) {
            $str = '<div class="alert'.$type.'alert-dismissible fade in" role="alert">';
			$str .= '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'; 
            $pesan = explode('-', $type);
            $msg = 'Success';
            if($pesan[1] == 'danger')
                $msg = 'Error!';
            $str .= '<strong>'.$msg.'</strong>';
            $str .= '<ul>';
            foreach($messages as $message) {
               $str .= '<li>'.$message.'</li>';
            }
            $str .= '</ul>';
            $str .= '</div>';
         }
      }
      
      return $str;
   }
}
?>