<?php 
class Email_model extends CI_Model {
	private function email_sender($sender,$receiver,$subject,$message){
		$config = Array('protocol'  => $this->appinfo->protocol,'smtp_host' => $this->appinfo->smtp_host,'smtp_port' => $this->appinfo->smtp_port,'smtp_user' => $this->appinfo->smtp_user, 'smtp_pass' => $this->appinfo->smtp_pass,'mailtype'  => $this->appinfo->mailtype,'charset'   => $this->appinfo->charset);

		  $result = $this->email->initialize($config)
		  ->set_newline("\r\n")
		  ->from($sender)
		  ->to($receiver)
		  ->subject($subject)
		  ->message($message);
	      if($result->send()) {
	        return true; 
	      }else{
	        return false; 
	      }
	}
	function email_setup($type,$receiver,$subject,$message,$name,$val){
		switch($type){
			case 'contact_us':{
				$result = $this->email_sender($receiver,$this->appinfo->web_email(),$subject,$this->email_template($type,$receiver,$subject,$message,$name,$val));
				break;
			}
			case 'forgot_pass':{
				$result = $this->email_sender($this->appinfo->web_email(),$receiver,$subject,$this->email_template($type,$receiver,$subject,$message,$name,$val));
				break;
			}
		}


		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	private function email_template($type,$receiver,$subject,$message,$name,$val){
		switch($type){
			case 'contact_us':{
				return '<div style="background-color:#f2f3f5;padding:20px">
                  <div style="max-width:600px;margin:0 auto"> 
                      <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #F64E60;margin-bottom:20px">        
                          <div style="border-bottom:1px solid #f2f3f5;">
                              <img width="100" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">
                          </div>    
                          <div style="padding:0px 30px">
                              <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a> From '.$name.',</p>
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a> Email '.$receiver.',</p>
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a> Mobile : '.$val.',</p>
                                  <p style="margin: 0;">Message : '.$message.'</p>
                                  <p style="text-align:center;"><a style="text-decoration:none;color:#000"></a><b>'.$this->appinfo->app_company().'</b></p>
                              </div>      
                              <div style="font:11px sans-serif;color:#686f7a">
                              <p style="margin:0;">©'.$this->appinfo->app_year().'. '.$this->appinfo->app_company().'</p>        
                              </div>
                          </div>  
                      </div>
                  </div>
              </div>';
				break;
			}
			case 'forgot_pass':{
				return '<div style="background-color:#f2f3f5;padding:20px">
                  <div style="max-width:600px;margin:0 auto"> 
                      <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #F64E60;margin-bottom:20px">        
                          <div style="border-bottom:1px solid #f2f3f5;">        
                              <img width="100" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">        
                          </div>            
                          <div style="padding:0px 30px">        
                              <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">        
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($val).',</p>        
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>You reset your account password by clicking the button below, The button and link is valid only for 10 minutes.</p>        
                                  <a href = "'.$this->appinfo->web_url_forgotpassword().'" style="background-color:#F64E60; border:none; color:white; padding:10px 15px; text-align:center; text-decoration:none;font-size:12px;display:block;margin-left:auto;margin-right:auto;max-width:150px;border-radius:5px;" target="_blank">Reset Password</a>       
                                  <p style="text-align:center; margin: 0;"><a style="text-decoration:none;color:#000;"></a>or click the link below.</p>       
                                  <a style="word-wrap:break-word;font-size:12px;word-break: break-all;"  href = "'.$this->appinfo->web_url_forgotpassword().'" >'.$this->appinfo->web_url_forgotpassword().'</a>          
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>If you are having problems with the button above, copy and paste the link above in your browser.</p>             
                                  <p style="text-align:center;"><a style="text-decoration:none;color:#000"></a><b>'.$this->appinfo->app_company().' Support Team</b></p>        
                              </div>                
                              <div style="font:11px sans-serif;color:#686f7a">
                              <p style="margin: 0;">©'.$this->appinfo->app_year().'. '.$this->appinfo->app_company().'</p>        
                              </div>        
                          </div>  
                      </div>
                  </div>
              </div>';
				break;
			}
		}



	}
 
}
?>