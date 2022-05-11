<?php 
class Email_model extends CI_Model {
 
	public function notify_user($type, $url, $email, $fname, $val=false, $val2=false){
		switch($type){
			case 'contact_us':
				  $result = $this->appinfo->send_email($email, $this->email_setup("sender",$val2), $this->email_content($type, $fname, $url, $val, $val2), $this->email_setup($type,$val2));
			break;
			case 'forgot-pass':
				   $result = $this->appinfo->send_email($email, $this->email_setup("sender",$val2), $this->email_content($type, $fname, $url, $val, $val2), $this->email_setup($type,$val2));
				break;
      case 'login_attempt':
          $result = $this->appinfo->send_email($email, $this->email_setup("sender",$val2), $this->email_content($type, $fname, $url, $val, $val2), $this->email_setup($type,$val2));
      break;
      case 'lyb_verify': 
          $result = $this->appinfo->send_email($email, $this->email_setup("sender",$val2), $this->email_content($type, $fname, $url, $val, $val2), $this->email_setup($type,$val2));
      break;
      case 'verify_email': 
          $result = $this->appinfo->send_email($email, $this->email_setup("sender",$val2), $this->email_content($type, $fname, $url, $val, $val2), $this->email_setup($type,$val2));
      break;
		}
		if($result){
			return true;
		}else{
			return false;
		}
	}
  //EMAIL SET UP     

  private function email_setup($type,$val2){
      switch ($type) {
      case 'sender':
          return $this->appinfo->app_company_acronym().' Support Team<support@miracle-tree.org>';
          break;
  		case 'login_attempt':
  		    return $this->appinfo->app_company_acronym().': Suspicious login attempt!';
  		    break;
      case 'get_code':
          return $this->appinfo->app_company_acronym().': Email Verification PIN';
          break;
      case 'lyb_verify':
          return $this->appinfo->app_company_acronym().' Admin: User BYPASS PIN';
          break;
      case 'verify_email':
          return $this->appinfo->app_company_acronym().': Confirm Account Email';
          break;
      case 'forgot-pass':
          return $this->appinfo->app_company_acronym().': Account Reset Password';
          break;
      case 'pending_cart_email':
          return $this->appinfo->app_company_acronym().': Pending Order - '.$val2['txnid'];
          break;
      case 'pending_cart_email_customer':
          return $this->appinfo->app_company_acronym().': Pending Order - '.$val2['txnid'];
          break;
      case 'approve_cart_email':
          return $this->appinfo->app_company_acronym().': Order Approved - '.$val2['txnid'];
          break;
      case 'approve_cart_email_customer':
          return $this->appinfo->app_company_acronym().': Order Approved - '.$val2['txnid'];
          break;
      case 'sales_email':
          return $this->appinfo->app_company_acronym().': New Pending Order - '.$val2['txnid'];
          break;
      case 'delivered_code_cart_email':
          return $this->appinfo->app_company_acronym().': Code Generated - '.$val2['txnid'];
          break;
      case 'delivered_code_cart_email_customer':
          return $this->appinfo->app_company_acronym().': Code Generated - '.$val2['txnid'];
          break;

      	default:
      		return '';
      		break;
      }
	}
	
	private function email_content($type, $fname, $url, $val){
        switch ($type) {
          case 'get_code':
            return '<div style="background-color:#f2f3f5;padding:20px">
                    <div style="max-width:600px;margin:0 auto"> 
                      <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">    
                        <div style="border-bottom:1px solid #f2f3f5;">        
                          <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">        
                        </div>
                            <div style="padding:0px 30px">        
                          <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">        
                            <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>        
                            <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>Your request has already been processed. The PIN below is only valid for 5 minutes. To proceed in your request please enter this Identification Number (PIN): </p>        
                            <h1 style="text-align:center;letter-spacing: 10px;">'.$url.'</h1>    
                            <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>If you did not request this code, it is possible that someone else is trying to access your account.<b> Do not forward or give this code to anyone</b>. The code will expire in 5 Minutes.</p>             
                            <p style="text-align:center; margin: 0;"><a style="text-decoration:none;color:#000"></a>See you inside!<br /><b>'.$this->appinfo->app_company_acronym().' Support Team</b></p>        
                          </div>
                              <div style="font:11px sans-serif;color:#686f7a">
                          <p style="margin: 0;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>    
                          </div>        
                        </div>  
                      </div>
                    </div>
                  </div>';
            break;
          case 'login_attempt':
            return '<div style="background-color:#f2f3f5;padding:20px">
                  <div style="max-width:600px;margin:0 auto"> 
                      <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">        
                          <div style="border-bottom:1px solid #f2f3f5;">        
                              <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">        
                          </div>
                          <div style="padding:0px 30px">        
                              <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">        
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>        
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>We have detected a suspicious login attempt on your account. Hurry up '.ucfirst($fname).'!, Secure your account!.</p>        
                                  <a href = "'.$url.'" style="background-color:#42B9D3; border:none; color:white; padding:10px 15px; text-align:center; text-decoration:none;font-size:12px;display:block;margin-left:auto;margin-right:auto;max-width:150px;border-radius:5px;" target="_blank">Secure Account</a>       
                                  <p style="text-align:center; margin: 0;"><a style="text-decoration:none;color:#000;"></a>or click the link below.</p>       
                                  <a style="word-wrap:break-word;font-size:12px;word-break: break-all;"  href = "'.$url.'" >'.$url.'</a>          
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>If you are having problems with the button above, copy and paste the link above in your browser.</p>             
                                  <p style="text-align:center; margin: 0;"><a style="text-decoration:none;color:#000"></a><b>'. $this->appinfo->app_company_acronym().' Support Team</b></p>        
                              </div>
                              <div style="font:11px sans-serif;color:#686f7a">
                              <p style="margin: 0;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>        
                              </div>        
                          </div>  
                      </div>
                  </div>
              </div>';
            break;
          case 'lyb_verify':
            return '<div style="background-color:#f2f3f5;padding:20px">
                    <div style="max-width:600px;margin:0 auto"> 
                      <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">    
                        <div style="border-bottom:1px solid #f2f3f5;">        
                          <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">        
                        </div>
                            <div style="padding:0px 30px">        
                          <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">        
                            <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>        
                            <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>Your request has already been processed. The PIN below is only valid for 5 minutes. To proceed in your request please enter this Identification Number (PIN): </p>        
                            <h1 style="text-align:center;letter-spacing: 10px;">'.$url.'</h1>    
                            <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>If you did not request this code, it is possible that someone else is trying to access your account.<b> Do not forward or give this code to anyone</b>. The code will expire in 5 Minutes.</p>             
                            <p style="text-align:center; margin: 0;"><a style="text-decoration:none;color:#000"></a>See you inside!<br /><b>'. $this->appinfo->app_company_acronym().' Support Team</b></p>        
                          </div>
                              <div style="font:11px sans-serif;color:#686f7a">
                          <p style="margin: 0;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>    
                          </div>        
                        </div>  
                      </div>
                    </div>
                  </div>';
            break;
          case 'verify_email':
            return '<div style="background-color:#f2f3f5;padding:20px">
                  <div style="max-width:600px;margin:0 auto"> 
                      <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">        
                          <div style="border-bottom:1px solid #f2f3f5;">        
                              <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">        
                          </div>
                          <div style="padding:0px 30px">        
                              <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">        
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>        
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>Account Created Successfully! You can also confirm your account email by visiting the link below.</p>        
                                  <a href = "'.$url.'" style="background-color:#42B9D3; border:none; color:white; padding:10px 15px; text-align:center; text-decoration:none;font-size:12px;display:block;margin-left:auto;margin-right:auto;max-width:150px;border-radius:5px;" target="_blank">Confirm Account</a>       
                                  <p style="text-align:center; margin: 0;"><a style="text-decoration:none;color:#000;"></a>or click the link below.</p>       
                                  <a style="word-wrap:break-word;font-size:12px;word-break: break-all;"  href = "'.$url.'" >'.$url.'</a>          
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>If you are having problems with the button above, copy and paste the link above in your browser.</p>             
                                  <p style="text-align:center;"><a style="text-decoration:none;color:#000"></a><b>'. $this->appinfo->app_company_acronym().' Support Team</b></p>        
                              </div>
                              <div style="font:11px sans-serif;color:#686f7a">
                              <p style="margin: 0;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>        
                              </div>        
                          </div>  
                      </div>
                  </div>
              </div>';
            break;
           case 'forgot-pass':
            return '<div style="background-color:#f2f3f5;padding:20px">
                  <div style="max-width:600px;margin:0 auto"> 
                      <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #F64E60;margin-bottom:20px">        
                          <div style="border-bottom:1px solid #f2f3f5;">        
                              <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">        
                          </div>
                          <div style="padding:0px 30px">        
                              <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">        
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>        
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>You reset your account password by clicking the button below, The button and link is valid only for 1 hour.</p>        
                                  <a href = "'.$url.'" style="background-color:#F64E60; border:none; color:white; padding:10px 15px; text-align:center; text-decoration:none;font-size:12px;display:block;margin-left:auto;margin-right:auto;max-width:150px;border-radius:5px;" target="_blank">Reset Password</a>       
                                  <p style="text-align:center; margin: 0;"><a style="text-decoration:none;color:#000;"></a>or click the link below.</p>       
                                  <a style="word-wrap:break-word;font-size:12px;word-break: break-all;"  href = "'.$url.'" >'.$url.'</a>          
                                  <p style="margin: 0;"><a style="text-decoration:none;color:#000"></a>If you are having problems with the button above, copy and paste the link above in your browser.</p>             
                                  <p style="text-align:center; margin: 0;"><a style="text-decoration:none;color:#000"></a><b>'. $this->appinfo->app_company_acronym().' Support Team</b></p>        
                              </div>
                              <div style="font:11px sans-serif;color:#686f7a">
                              <p style="margin: 0;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>        
                              </div>        
                          </div>  
                      </div>
                  </div>
              </div>';
            break;
          case 'pending_cart_email':
          return '<div style="background-color:#f2f3f5;padding:20px">
                    <div style="max-width:600px;margin:0 auto"> 
                      <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">        
                        <div style="border-bottom:1px solid #f2f3f5;">
                            <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">
                        </div>
                        <div style="padding:30px 30px 10px">
                          <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">
                            <p><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>    
                            <p><a style="text-decoration:none;color:#000"></a>You have successfully place your order <span style="color:#fe940a;">'.$val2['txnid'].'</span>. Please wait for the approval of your order.</p>
                            <a  href = "'.$url.'" style="background-color:#42B9D3; border:none; color:white; padding:10px 15px; text-align:center; text-decoration:none;font-size:14px;display:block;margin-left:auto;margin-right:auto;max-width:150px;border-radius:5px;" target="_blank">Track Order</a>
                            <p style="text-align:center;"><a style="text-decoration:none;color:#000;"></a>or click this link to track your order <a style=" word-wrap:break-word;font-size:12px;word-break: break-all;"  href = "'.$url.'" >'.$url.'</a></p>
                          </div>

                          <table style="width:100%;border-spacing:0;border-collapse:collapse">
                            <tbody><tr>
                              <td style="">
                                <center>
                                  <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <h3 style="font-weight:normal;font-size:16px">Order summary</h3>
                                      </td>
                                    </tr></tbody>
                                  </table>


                                  <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                          <tbody><tr style="width:100%">
                                            <td>
                                              <table style="border-spacing:0;border-collapse:collapse">
                                                <tbody>
                                                  '.$val.'
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:15px;border-top-width:1px;border-top-color:#e5e5e5;border-top-style:solid">
                                          <tbody><tr>
                                            <td>
                                              <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:20px">
                                                <tbody><tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Subtotal</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;">'.$val2['price'].'</strong>
                                                  </td>
                                                </tr>
                                                <tr>
                                                      <td style="padding:5px 5px; width: 100%;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Shipping</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                        <strong style="font-size:14px;color:#555;">'.$val2['shipping'].'</strong>
                                                      </td>
                                                    </tr>
                                                <tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Discount</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;white-space: nowrap;">'.$val2['discount'].'</strong>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Wallet</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;white-space: nowrap;">'.$val2['wallet'].'</strong>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Taxes</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;">'.$val2['tax'].'</strong>
                                                  </td>
                                                </tr></tbody>
                                              </table>
                                              <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:20px;border-top-width:2px;border-top-color:#e5e5e5;border-top-style:solid">
                                                <tbody><tr>
                                                  <td style="padding:20px 5px 0;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Total</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:20px 5px 0; width: 100%;text-align: right;" >
                                                    <strong style="font-size:24px;color:#555;">'.$val2['total_price'].' PHP</strong>
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:12px">Includes Delivery.</span>
                                                    </p>
                                                  </td>
                                                </tr></tbody>
                                              </table>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                      </td>
                                    </tr></tbody>
                                  </table>
                                </center>
                              </td>
                            </tr></tbody>
                          </table>
                          <table style="width:100%;border-spacing:0;border-collapse:collapse">
                            <tbody><tr>
                              <td style="padding:40px 0">
                                <center>
                                  <table style="width:560px;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <h3 style="font-weight:normal;font-size:16px;margin:0 0 25px">Customer information</h3>
                                      </td>
                                    </tr>
                                  </tbody></table>
                                  <table style="width:560px;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                          <tbody><tr>
                                            <td style="padding-bottom:40px;width:100%">
                                              <h4 style="font-weight:500;font-size:14px;color:#555;margin:0 0 5px">Shipping address</h4>
                                              <p style="color:#777;line-height:150%;font-size:14px;margin:0">
                                              '.$val2['full_name'].'<br>
                                              +63 '.$val2['mobile'].'<br>
                                              '.$val2['email'].'<br>
                                              '.$val2['address'].'<br>
                                              Philippines</p>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                          <tbody><tr>
                                            <td style="width:100%">
                                              <h4 style="font-weight:500;font-size:14px;color:#555;margin:0 0 5px">Payment method</h4>
                                              <p style="color:#777;line-height:150%;font-size:14px;margin:0">
                                                  '.$val2['payment_method'].' —  <strong style="font-size:14px;color:#555">'.$val2['total_price'].'</strong>
                                              </p>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                      </td>
                                    </tr></tbody>
                                  </table>
                                </center>
                              </td>
                            </tr></tbody>
                          </table>
                          <p style="text-align:center;font-size:12px;"><a style="text-decoration:none;color:#000"></a>If you believe this email was sent to you by mistake, please ingnore this email.</p>
                          <p style="text-align:center;border-bottom:1px solid #f2f3f5;padding-bottom: 10px;"><a style="text-decoration:none;color:#000"></a>Thank you!<br /><b>Team '.$this->appinfo->app_company().'</b></p>
                          <div style="font:11px sans-serif;color:#686f7a">
                            <p style="padding: 10px;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>        
                          </div>
                          </div>  
                      </div>  
                  </div>
                </div>';
            break;
          case 'pending_cart_email_customer':
          return '<div style="background-color:#f2f3f5;padding:20px">
                    <div style="max-width:600px;margin:0 auto"> 
                      <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">        
                        <div style="border-bottom:1px solid #f2f3f5;">
                            <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">
                        </div>
                        <div style="padding:30px 30px 10px">
                          <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">
                            <p><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>    
                            <p><a style="text-decoration:none;color:#000"></a>You have successfully place your order <span style="color:#fe940a;">'.$val2['txnid'].'</span>. Please wait for the approval of your order.</p>
                            <!--<a  href = "'.$url.'" style="background-color:#42B9D3; border:none; color:white; padding:10px 15px; text-align:center; text-decoration:none;font-size:14px;display:block;margin-left:auto;margin-right:auto;max-width:150px;border-radius:5px;" target="_blank">Track Order</a>
                            <p style="text-align:center;"><a style="text-decoration:none;color:#000;"></a>or click this link to track your order <a style=" word-wrap:break-word;font-size:12px;word-break: break-all;"  href = "'.$url.'" >'.$url.'</a></p>-->
                          </div>

                          <table style="width:100%;border-spacing:0;border-collapse:collapse">
                            <tbody><tr>
                              <td style="">
                                <center>
                                  <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <h3 style="font-weight:normal;font-size:16px">Order summary</h3>
                                      </td>
                                    </tr></tbody>
                                  </table>


                                  <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                          <tbody><tr style="width:100%">
                                            <td>
                                              <table style="border-spacing:0;border-collapse:collapse">
                                                <tbody>
                                                  '.$val.'
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:15px;border-top-width:1px;border-top-color:#e5e5e5;border-top-style:solid">
                                          <tbody><tr>
                                            <td>
                                              <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:20px">
                                                <tbody><tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Subtotal</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;">'.$val2['price'].'</strong>
                                                  </td>
                                                </tr>
                                                <tr>
                                                      <td style="padding:5px 5px; width: 100%;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Shipping</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                        <strong style="font-size:14px;color:#555;">'.$val2['shipping'].'</strong>
                                                      </td>
                                                    </tr>
                                                <tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Discount</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;">-₱0.00</strong>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Taxes</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;">'.$val2['tax'].'</strong>
                                                  </td>
                                                </tr></tbody>
                                              </table>
                                              <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:20px;border-top-width:2px;border-top-color:#e5e5e5;border-top-style:solid">
                                                <tbody><tr>
                                                  <td style="padding:20px 5px 0;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Total</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:20px 5px 0; width: 100%;text-align: right;" >
                                                    <strong style="font-size:24px;color:#555;">'.$val2['customer_price'].' PHP</strong>
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:12px">Includes Delivery.</span>
                                                    </p>
                                                  </td>
                                                </tr></tbody>
                                              </table>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                      </td>
                                    </tr></tbody>
                                  </table>
                                </center>
                              </td>
                            </tr></tbody>
                          </table>
                          <table style="width:100%;border-spacing:0;border-collapse:collapse">
                            <tbody><tr>
                              <td style="padding:40px 0">
                                <center>
                                  <table style="width:560px;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <h3 style="font-weight:normal;font-size:16px;margin:0 0 25px">Customer information</h3>
                                      </td>
                                    </tr>
                                  </tbody></table>
                                  <table style="width:560px;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                          <tbody><tr>
                                            <td style="padding-bottom:40px;width:100%">
                                              <h4 style="font-weight:500;font-size:14px;color:#555;margin:0 0 5px">Shipping address</h4>
                                              <p style="color:#777;line-height:150%;font-size:14px;margin:0">
                                              '.$val2['full_name'].'<br>
                                              +63 '.$val2['mobile'].'<br>
                                              '.$val2['email'].'<br>
                                              '.$val2['address'].'<br>
                                              Philippines</p>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                          <tbody><tr>
                                            <td style="width:100%">
                                              <h4 style="font-weight:500;font-size:14px;color:#555;margin:0 0 5px">Payment method</h4>
                                              <p style="color:#777;line-height:150%;font-size:14px;margin:0">
                                                  '.$val2['payment_method'].' —  <strong style="font-size:14px;color:#555">'.$val2['customer_price'].'</strong>
                                              </p>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                      </td>
                                    </tr></tbody>
                                  </table>
                                </center>
                              </td>
                            </tr></tbody>
                          </table>
                          <p style="text-align:center;font-size:12px;"><a style="text-decoration:none;color:#000"></a>If you believe this email was sent to you by mistake, please ingnore this email.</p>
                          <p style="text-align:center;border-bottom:1px solid #f2f3f5;padding-bottom: 10px;"><a style="text-decoration:none;color:#000"></a>Thank you!<br /><b>Team '.$this->appinfo->app_company().'</b></p>
                          <div style="font:11px sans-serif;color:#686f7a">
                            <p style="padding: 10px;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>        
                          </div>
                          </div>  
                      </div>  
                  </div>
                </div>';
            break;
          case 'approve_cart_email':
              return '<div style="background-color:#f2f3f5;padding:20px">
                        <div style="max-width:600px;margin:0 auto"> 
                          <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">        
                            <div style="border-bottom:1px solid #f2f3f5;">
                                <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">
                            </div>
                            <div style="padding:30px 30px 10px">
                              <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">
                                <p><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>    
                                <p><a style="text-decoration:none;color:#000"></a>Your order <span style="color:#fe940a;">'.$val2['txnid'].'</span> has been approved. Your order move to shipment/fulfillment.</p>
                                <a  href = "'.$url.'" style="background-color:#42B9D3; border:none; color:white; padding:10px 15px; text-align:center; text-decoration:none;font-size:14px;display:block;margin-left:auto;margin-right:auto;max-width:150px;border-radius:5px;" target="_blank">Track Order</a>
                                <p style="text-align:center;"><a style="text-decoration:none;color:#000;"></a>or click this link to track your order <a style=" word-wrap:break-word;font-size:12px;word-break: break-all;"  href = "'.$url.'" >'.$url.'</a></p>
                              </div>

                              <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                <tbody><tr>
                                  <td style="">
                                    <center>
                                      <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                        <tbody><tr>
                                          <td>
                                            <h3 style="font-weight:normal;font-size:16px;margin:0 0 25px">Items in this shipment</h3>
                                          </td>
                                        </tr></tbody>
                                      </table>
                                      <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto 30px">
                                        <tbody><tr>
                                          <td>
                                            <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                              <tbody><tr style="width:100%">
                                                <td>
                                                  <table style="border-spacing:0;border-collapse:collapse">
                                                    <tbody> 
                                                    '.$val.'
                                                    </tbody>
                                                  </table>
                                                </td>
                                              </tr></tbody>
                                            </table>
                                          </td>
                                        </tr></tbody>
                                      </table>
                                    </center>
                                  </td>
                                </tr></tbody>
                              </table>
                             
                              <p style="text-align:center;font-size:12px;"><a style="text-decoration:none;color:#000"></a>If you believe this email was sent to you by mistake, please ingnore this email.</p>
                              <p style="text-align:center;border-bottom:1px solid #f2f3f5;padding-bottom: 10px;"><a style="text-decoration:none;color:#000"></a>Thank you!<br /><b>Team '.$this->appinfo->app_company().'</b></p>
                              <div style="font:11px sans-serif;color:#686f7a">
                                <p style="padding: 10px;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>        
                              </div>
                              </div>  
                          </div>  
                      </div>
                    </div>';
              break;
            case 'approve_cart_email_customer':
              return '<div style="background-color:#f2f3f5;padding:20px">
                        <div style="max-width:600px;margin:0 auto"> 
                          <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">        
                            <div style="border-bottom:1px solid #f2f3f5;">
                                <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">
                            </div>
                            <div style="padding:30px 30px 10px">
                              <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">
                                <p><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>    
                                <p><a style="text-decoration:none;color:#000"></a>Your order <span style="color:#fe940a;">'.$val2['txnid'].'</span> has been approved. Your order move to shipment/fulfillment.</p>
                              </div>

                              <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                <tbody><tr>
                                  <td style="">
                                    <center>
                                      <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                        <tbody><tr>
                                          <td>
                                            <h3 style="font-weight:normal;font-size:16px;margin:0 0 25px">Items in this shipment</h3>
                                          </td>
                                        </tr></tbody>
                                      </table>
                                      <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto 30px">
                                        <tbody><tr>
                                          <td>
                                            <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                              <tbody><tr style="width:100%">
                                                <td>
                                                  <table style="border-spacing:0;border-collapse:collapse">
                                                    <tbody> 
                                                    '.$val.'
                                                    </tbody>
                                                  </table>
                                                </td>
                                              </tr></tbody>
                                            </table>
                                          </td>
                                        </tr></tbody>
                                      </table>
                                    </center>
                                  </td>
                                </tr></tbody>
                              </table>
                             
                              <p style="text-align:center;font-size:12px;"><a style="text-decoration:none;color:#000"></a>If you believe this email was sent to you by mistake, please ingnore this email.</p>
                              <p style="text-align:center;border-bottom:1px solid #f2f3f5;padding-bottom: 10px;"><a style="text-decoration:none;color:#000"></a>Thank you!<br /><b>Team '.$this->appinfo->app_company().'</b></p>
                              <div style="font:11px sans-serif;color:#686f7a">
                                <p style="padding: 10px;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>        
                              </div>
                              </div>  
                          </div>  
                      </div>
                    </div>';
              break;












          case 'sales_email':
          return '<div style="background-color:#f2f3f5;padding:20px">
                    <div style="max-width:600px;margin:0 auto"> 
                      <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">        
                        <div style="border-bottom:1px solid #f2f3f5;">
                            <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">
                        </div>
                        <div style="padding:30px 30px 10px">
                          <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">
                            <p><a style="text-decoration:none;color:#000"></a>New pending order <span style="color:#fe940a;">'.$val2['txnid'].'</span>.</p>
                          </div>

                          <table style="width:100%;border-spacing:0;border-collapse:collapse">
                            <tbody><tr>
                              <td style="">
                                <center>
                                  <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <h3 style="font-weight:normal;font-size:16px">Order summary</h3>
                                      </td>
                                    </tr></tbody>
                                  </table>


                                  <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                          <tbody><tr style="width:100%">
                                            <td>
                                              <table style="border-spacing:0;border-collapse:collapse">
                                                <tbody>
                                                  '.$val.'
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:15px;border-top-width:1px;border-top-color:#e5e5e5;border-top-style:solid">
                                          <tbody><tr>
                                            <td>
                                              <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:20px">
                                                <tbody><tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Subtotal</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;">'.$val2['price'].'</strong>
                                                  </td>
                                                </tr>
                                                <tr>
                                                      <td style="padding:5px 5px; width: 100%;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Shipping</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                        <strong style="font-size:14px;color:#555;">'.$val2['shipping'].'</strong>
                                                      </td>
                                                    </tr>
                                                <tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Discount</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;white-space: nowrap;">'.$val2['discount'].'</strong>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Wallet</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;white-space: nowrap;">'.$val2['wallet'].'</strong>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td style="padding:5px 5px; width: 100%;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Taxes</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                    <strong style="font-size:14px;color:#555;">'.$val2['tax'].'</strong>
                                                  </td>
                                                </tr></tbody>
                                              </table>
                                              <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:20px;border-top-width:2px;border-top-color:#e5e5e5;border-top-style:solid">
                                                <tbody><tr>
                                                  <td style="padding:20px 5px 0;">
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:14px">Total</span>
                                                    </p>
                                                  </td>
                                                  <td style="padding:20px 5px 0; width: 100%;text-align: right;" >
                                                    <strong style="font-size:24px;color:#555;">'.$val2['total_price'].' PHP</strong>
                                                    <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                      <span style="font-size:12px">Includes Delivery.</span>
                                                    </p>
                                                  </td>
                                                </tr></tbody>
                                              </table>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                      </td>
                                    </tr></tbody>
                                  </table>
                                </center>
                              </td>
                            </tr></tbody>
                          </table>
                          <table style="width:100%;border-spacing:0;border-collapse:collapse">
                            <tbody><tr>
                              <td style="padding:40px 0">
                                <center>
                                  <table style="width:560px;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <h3 style="font-weight:normal;font-size:16px;margin:0 0 25px">Customer information</h3>
                                      </td>
                                    </tr>
                                  </tbody></table>
                                  <table style="width:560px;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                    <tbody><tr>
                                      <td>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                          <tbody><tr>
                                            <td style="padding-bottom:40px;width:100%">
                                              <h4 style="font-weight:500;font-size:14px;color:#555;margin:0 0 5px">Shipping address</h4>
                                              <p style="color:#777;line-height:150%;font-size:14px;margin:0">
                                              '.$val2['full_name'].'<br>
                                              +63 '.$val2['mobile'].'<br>
                                              '.$val2['email'].'<br>
                                              '.$val2['address'].'<br>
                                              Philippines</p>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                        <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                          <tbody><tr>
                                            <td style="width:100%">
                                              <h4 style="font-weight:500;font-size:14px;color:#555;margin:0 0 5px">Payment method</h4>
                                              <p style="color:#777;line-height:150%;font-size:14px;margin:0">
                                                  '.$val2['payment_method'].' —  <strong style="font-size:14px;color:#555">'.$val2['total_price'].'</strong>
                                              </p>
                                            </td>
                                          </tr></tbody>
                                        </table>
                                      </td>
                                    </tr></tbody>
                                  </table>
                                </center>
                              </td>
                            </tr></tbody>
                          </table>
                          <p style="text-align:center;border-bottom:1px solid #f2f3f5;padding-bottom: 10px;"><a style="text-decoration:none;color:#000"></a>See you inside!<br /><b>Team '.$this->appinfo->app_company().'</b></p>
                          <div style="font:11px sans-serif;color:#686f7a">
                            <p style="padding: 10px;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>        
                          </div>
                          </div>  
                      </div>  
                  </div>
                </div>';
            break;


            case 'delivered_code_cart_email':
              return '<div style="background-color:#f2f3f5;padding:20px">
                        <div style="max-width:600px;margin:0 auto"> 
                          <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">        
                            <div style="border-bottom:1px solid #f2f3f5;">
                                <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">
                            </div>
                            <div style="padding:30px 30px 10px">
                              <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">
                                <p><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>    
                                <p><a style="text-decoration:none;color:#000"></a>Your order <span style="color:#fe940a;">'.$val2['txnid'].'</span> has been generated on '.$val2['date_delivered'].'.</p>
                                <a  href = "'.$url.'" style="background-color:#42B9D3; border:none; color:white; padding:10px 15px; text-align:center; text-decoration:none;font-size:14px;display:block;margin-left:auto;margin-right:auto;max-width:150px;border-radius:5px;" target="_blank">View Order</a>
                                <p style="text-align:center;"><a style="text-decoration:none;color:#000;"></a>or click this link to view your order <a style=" word-wrap:break-word;font-size:15px;word-break: break-all;"  href = "'.$url.'" >'.$url.'</a></p>
                              </div>

                              <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                <tbody><tr>
                                  <td style="">
                                    <center>
                                      <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                        <tbody><tr>
                                          <td>
                                            <h3 style="font-weight:normal;font-size:16px">Order summary</h3>
                                          </td>
                                        </tr></tbody>
                                      </table>


                                      <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                        <tbody><tr>
                                          <td>
                                            <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                              <tbody><tr style="width:100%">
                                                <td>
                                                  <table style="border-spacing:0;border-collapse:collapse">
                                                    <tbody>
                                                      '.$val.'
                                                    </tbody>
                                                  </table>
                                                </td>
                                              </tr></tbody>
                                            </table>
                                            <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:15px;border-top-width:1px;border-top-color:#e5e5e5;border-top-style:solid">
                                              <tbody><tr>
                                                <td>
                                                  <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:20px">
                                                    <tbody><tr>
                                                      <td style="padding:5px 5px; width: 100%;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Subtotal</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                        <strong style="font-size:14px;color:#555;">'.$val2['price'].'</strong>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td style="padding:5px 5px; width: 100%;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Discount</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                        <strong style="font-size:14px;color:#555;white-space: nowrap;">'.$val2['discount'].'</strong>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td style="padding:5px 5px; width: 100%;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Wallet</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                        <strong style="font-size:14px;color:#555;white-space: nowrap;">'.$val2['wallet'].'</strong>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td style="padding:5px 5px; width: 100%;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Taxes</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                        <strong style="font-size:14px;color:#555;">'.$val2['tax'].'</strong>
                                                      </td>
                                                    </tr></tbody>
                                                  </table>
                                                  <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:20px;border-top-width:2px;border-top-color:#e5e5e5;border-top-style:solid">
                                                    <tbody><tr>
                                                      <td style="padding:20px 5px 0;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Total</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:20px 5px 0; width: 100%;text-align: right;" >
                                                        <strong style="font-size:24px;color:#555;">'.$val2['total_price'].' PHP</strong>
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0;">
                                                                          <!--<span style="font-size:12px">Includes Delivery.</span>-->
                                                                        </p>
                                                      </td>
                                                    </tr></tbody>
                                                  </table>
                                                </td>
                                              </tr></tbody>
                                            </table>
                                          </td>
                                        </tr></tbody>
                                      </table>
                                    </center>
                                  </td>
                                </tr></tbody>
                              </table>
                              <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                <tbody><tr>
                                  <td style="padding:40px 0">
                                    <center>
                                      <table style="width:560px;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                        <tbody><tr>
                                          <td>
                                            <h3 style="font-weight:normal;font-size:16px;margin:0 0 25px">Customer information</h3>
                                          </td>
                                        </tr>
                                      </tbody></table>
                                      <table style="width:560px;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                        <tbody><tr>
                                          <td>
                                            <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                              <tbody><tr>
                                                <td style="padding-bottom:40px;width:100%">
                                                  <h4 style="font-weight:500;font-size:14px;color:#555;margin:0 0 5px">Shipping address</h4>
                                                  <p style="color:#777;line-height:150%;font-size:14px;margin:0">
                                                  '.$val2['full_name'].'<br>
                                                  +63 '.$val2['mobile'].'<br>
                                                  '.$val2['email'].'<br>
                                                  '.$val2['address'].'<br>
                                                  Philippines</p>
                                                </td>
                                              </tr></tbody>
                                            </table>
                                            <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                              <tbody><tr>
                                                <td style="width:100%">
                                                  <h4 style="font-weight:500;font-size:14px;color:#555;margin:0 0 5px">Payment method</h4>
                                                  <p style="color:#777;line-height:150%;font-size:14px;margin:0">
                                                    '.$val2['payment_method'].' —  <strong style="font-size:14px;color:#555">'.$val2['total_price'].'</strong>
                                                  </p>
                                                </td>
                                              </tr></tbody>
                                            </table>
                                          </td>
                                        </tr></tbody>
                                      </table>
                                    </center>
                                  </td>
                                </tr></tbody>
                              </table>
                              <p style="text-align:center;font-size:12px;"><a style="text-decoration:none;color:#000"></a>If you believe this email was sent to you by mistake, please ingnore this email.</p>
                              <p style="text-align:center;border-bottom:1px solid #f2f3f5;padding-bottom: 10px;"><a style="text-decoration:none;color:#000"></a>Thank you!<br /><b>Team '.$this->appinfo->app_company().'</b></p>
                              <div style="font:11px sans-serif;color:#686f7a">
                                <p style="padding: 10px;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>        
                              </div>
                              </div>  
                          </div>  
                      </div>
                    </div>';
            break;

          case 'delivered_code_cart_email_customer':
              return '<div style="background-color:#f2f3f5;padding:20px">
                        <div style="max-width:600px;margin:0 auto"> 
                          <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #42B9D3;margin-bottom:20px">        
                            <div style="border-bottom:1px solid #f2f3f5;">
                                <img width="200" style="max-width:200px;display:block;margin-left:auto; margin-right:auto; " tabindex="0" src="'.$this->appinfo->email_logo().'">
                            </div>
                            <div style="padding:30px 30px 10px">
                              <div style="font-size:16px;line-height:1.5em;border-bottom:1px solid #f2f3f5;padding-bottom:10px;margin-bottom:20px">
                                <p><a style="text-decoration:none;color:#000"></a> Hi '.ucfirst($fname).',</p>    
                                <p><a style="text-decoration:none;color:#000"></a>Your order <span style="color:#fe940a;">'.$val2['txnid'].'</span> has been generated on '.$val2['date_delivered'].'. You will get your code to your trusted distributor.</p>
                                <!--<a  href = "'.$url.'" style="background-color:#42B9D3; border:none; color:white; padding:10px 15px; text-align:center; text-decoration:none;font-size:14px;display:block;margin-left:auto;margin-right:auto;max-width:150px;border-radius:5px;" target="_blank">View Order</a>
                                <p style="text-align:center;"><a style="text-decoration:none;color:#000;"></a>or click this link to view your order <a style=" word-wrap:break-word;font-size:15px;word-break: break-all;"  href = "'.$url.'" >'.$url.'</a></p>-->
                              </div>

                              <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                <tbody><tr>
                                  <td style="">
                                    <center>
                                      <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                        <tbody><tr>
                                          <td>
                                            <h3 style="font-weight:normal;font-size:16px">Order summary</h3>
                                          </td>
                                        </tr></tbody>
                                      </table>


                                      <table style="width:100%;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                        <tbody><tr>
                                          <td>
                                            <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                              <tbody><tr style="width:100%">
                                                <td>
                                                  <table style="border-spacing:0;border-collapse:collapse">
                                                    <tbody>
                                                      '.$val.'
                                                    </tbody>
                                                  </table>
                                                </td>
                                              </tr></tbody>
                                            </table>
                                            <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:15px;border-top-width:1px;border-top-color:#e5e5e5;border-top-style:solid">
                                              <tbody><tr>
                                                <td>
                                                  <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:20px">
                                                    <tbody><tr>
                                                      <td style="padding:5px 5px; width: 100%;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Subtotal</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                        <strong style="font-size:14px;color:#555;">'.$val2['price'].'</strong>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td style="padding:5px 5px; width: 100%;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Discount</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                        <strong style="font-size:14px;color:#555;">-₱0.00</strong>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td style="padding:5px 5px; width: 100%;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Taxes</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:5px 5px; width: 100%;text-align: right;">
                                                        <strong style="font-size:14px;color:#555;">'.$val2['tax'].'</strong>
                                                      </td>
                                                    </tr></tbody>
                                                  </table>
                                                  <table style="width:100%;border-spacing:0;border-collapse:collapse;margin-top:20px;border-top-width:2px;border-top-color:#e5e5e5;border-top-style:solid">
                                                    <tbody><tr>
                                                      <td style="padding:20px 5px 0;">
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0">
                                                          <span style="font-size:14px">Total</span>
                                                        </p>
                                                      </td>
                                                      <td style="padding:20px 5px 0; width: 100%;text-align: right;" >
                                                        <strong style="font-size:24px;color:#555;">'.$val2['customer_price'].' PHP</strong>
                                                        <p style="color:#777;line-height:1.2em;font-size:14px;margin:0;">
                                                                          <!--<span style="font-size:12px">Includes Delivery.</span>-->
                                                                        </p>
                                                      </td>
                                                    </tr></tbody>
                                                  </table>
                                                </td>
                                              </tr></tbody>
                                            </table>
                                          </td>
                                        </tr></tbody>
                                      </table>
                                    </center>
                                  </td>
                                </tr></tbody>
                              </table>
                              <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                <tbody><tr>
                                  <td style="padding:40px 0">
                                    <center>
                                      <table style="width:560px;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                        <tbody><tr>
                                          <td>
                                            <h3 style="font-weight:normal;font-size:16px;margin:0 0 25px">Customer information</h3>
                                          </td>
                                        </tr>
                                      </tbody></table>
                                      <table style="width:560px;text-align:left;border-spacing:0;border-collapse:collapse;margin:0 auto">
                                        <tbody><tr>
                                          <td>
                                            <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                              <tbody><tr>
                                                <td style="padding-bottom:40px;width:100%">
                                                  <h4 style="font-weight:500;font-size:14px;color:#555;margin:0 0 5px">Shipping address</h4>
                                                  <p style="color:#777;line-height:150%;font-size:14px;margin:0">
                                                  '.$val2['full_name'].'<br>
                                                  +63 '.$val2['mobile'].'<br>
                                                  '.$val2['email'].'<br>
                                                  '.$val2['address'].'<br>
                                                  Philippines</p>
                                                </td>
                                              </tr></tbody>
                                            </table>
                                            <table style="width:100%;border-spacing:0;border-collapse:collapse">
                                              <tbody><tr>
                                                <td style="width:100%">
                                                  <h4 style="font-weight:500;font-size:14px;color:#555;margin:0 0 5px">Payment method</h4>
                                                  <p style="color:#777;line-height:150%;font-size:14px;margin:0">
                                                    '.$val2['payment_method'].' —  <strong style="font-size:14px;color:#555">'.$val2['customer_price'].'</strong>
                                                  </p>
                                                </td>
                                              </tr></tbody>
                                            </table>
                                          </td>
                                        </tr></tbody>
                                      </table>
                                    </center>
                                  </td>
                                </tr></tbody>
                              </table>
                              <p style="text-align:center;font-size:12px;"><a style="text-decoration:none;color:#000"></a>If you believe this email was sent to you by mistake, please ingnore this email.</p>
                              <p style="text-align:center;border-bottom:1px solid #f2f3f5;padding-bottom: 10px;"><a style="text-decoration:none;color:#000"></a>Thank you!<br /><b>Team '.$this->appinfo->app_company().'</b></p>
                              <div style="font:11px sans-serif;color:#686f7a">
                                <p style="padding: 10px;">© '.$this->appinfo->app_year().' '.$this->appinfo->app_company().'</p>        
                              </div>
                              </div>  
                          </div>  
                      </div>
                    </div>';
            break;
          default:
            return '';
            break;
       	 }




	}
 
}
?>