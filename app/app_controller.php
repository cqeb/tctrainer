<?php
/**
 * Main App Controller File
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @copyright		Copyright 2007-2008, 3HN Deisngs.
 * @author			Baz L
 * @link			http://www.WebDevelopment2.com/
 */

/**
 * Main App Controller Class
 *
 * @author	Baz L
  */
class AppController extends Controller {

	   	var $components = array('Session', 'RequestHandler');

	   	function beforeFilter()
        {
            // user sets language       
            if ( isset( $this->params['named']['code'] ) ) 
            {
                $this->code = $this->params['named']['code'];
                
                $this->Session->write('Config.language', $this->code);
                // you have to set this to change the language of the app
                Configure::write('Config.language',$this->code);
                $this->set('locale', $this->code); 
                $locale = $this->code;
    
            } else {

                $language = $this->Session->read('Config.language');
                // echo "app_controller - session language: " . $language . "<br>";
                if (!isset($language)) {
                    $language = 'eng';
                }

                Configure::write('Config.language', $language);
                $this->set('locale', $language); 
                $locale = $language;

            }
            
            // print_r($this->Session);
            /*
            // if user is from AUT or GER - change language to German
            if ( !isset( $language ) )
			{
      				if ( $_SERVER['HTTP_HOST'] == LOCALHOST )
      					$freegeoipurl = 'http://freegeoip.net/json/81.217.23.232';
      				else
      					$freegeoipurl = 'http://freegeoip.net/json/' . $_SERVER['REMOTE_ADDR'];
					
      				$yourlocation = @json_decode( implode( '', file( $freegeoipurl ) ) );
			
      				if ( isset( $yourlocation->country_code ) && ( $yourlocation->country_code == 'DE' || $yourlocation->country_code == 'AT' ) )
      				{
                          Configure::write('Config.language','deu');
      				} else {
                          Configure::write('Config.language','eng');
                    }
      		} else
            {                
                Configure::write('Config.language',$language);
            }
            */

            if ($locale && file_exists(VIEWS . $locale . DS . $this->viewPath))
            {
                //echo VIEWS . $locale . DS . $this->viewPath;
                // e.g. use /app/views/fre/pages/tos.ctp instead of /app/views/pages/tos.ctp
                $this->viewPath = $locale . DS . $this->viewPath;
            }

            if ($this->RequestHandler->isAjax())
            {
                // set debug level
                Configure::write('debug', 0);
                // TODO (B) do we need to optimize CACHE-settings in header?
                $this->header('Pragma: no-cache');
                $this->header('Cache-control: no-cache');
                $this->header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                $this->disableCache();
            }

            if ($this->RequestHandler->isSSL()) {}
            if ($this->RequestHandler->isXml()) {}
            if ($this->RequestHandler->isRss()) {}
            if ($this->RequestHandler->isAtom()) {}
            if ($this->RequestHandler->isMobile()) {
                $mobile = true;
            }
            if ($this->RequestHandler->isWap()) {}

            /*
            $this-RequestHandler->setContent();
            javascript text/javascript
            js text/javascript
            json application/json
            css text/css
            html text/html,
            text text/plain
            txt text/plain
            csv application/vnd.ms-excel, text/plain
            form application/x-www-form-urlencoded
            file multipart/form-data
            xhtml application/xhtml+xml, application/xhtml, text/xhtml
            xhtml-mobile application/vnd.wap.xhtml+xml
            xml application/xml, text/xml
            rss application/rss+xml
            atom application/atom+xml
            amf application/x-amf
            wap text/vnd.wap.wml, text/vnd.wap.wmlscript, image/vnd.wap.wbmp
            wml text/vnd.wap.wml
            wmlscript text/vnd.wap.wmlscript
            wbmp image/vnd.wap.wbmp
            pdf application/pdf
            zip application/x-zip
            tar application/x-tar
            */

            if ( !$this->Session->read('recommendations') )
			{
                    $this->loadModel('User');
                            
                    $sql = "SELECT myrecommendation, firstname, lastname, email FROM users WHERE myrecommendation != '' AND yourlanguage = '" . $locale . "'";
                    $user_recommendations = $this->User->query( $sql );
                            
                    $this->Session->write( 'recommendations', serialize($user_recommendations) );
            } else
            {
                    $user_recommendations = unserialize( $this->Session->read('recommendations'));
            }
			
	       	if ( isset( $user_recommendations ) ) 
            { 
					$this->set('recommendations', $user_recommendations);
			}

            $this->set('locale', $locale);
            $this->Session->write('Config.language', $locale);
            $this->set('session_userid', $this->Session->read('session_userid'));
            $this->set('session_useremail', $this->Session->read('session_useremail'));
     }

     function checkSession()
     {
                // fill $username with session data
                $session_useremail = $this->Session->read('session_useremail');
                $session_userid    = $this->Session->read('session_userid');

                // googlebot must enter our service to index our pages
                if ( strstr( $_SERVER['HTTP_USER_AGENT'], 'Mediapartners' ) )
                {
                        $session_useremail = 'googlebot@schremser.com';
                        $session_userid = 47;
                }
			
                // if not in session - read cookie
                $cookie = $this->Cookie->read('tct_auth');

                // no information about user in session
                if ( !$session_useremail || !$session_userid )
                {
                      if ( ( !$cookie['email'] || !$cookie['userid'] ) )
                      {
                           // to be sure
                           $this->Cookie->delete('tct_auth');
                           $this->Cookie->delete('tct_auth_blog');
						   
                           $this->Session->write('flash',__("Sorry, your session has expired or you're not logged in.", true));
                           $this->redirect('/users/login');
		                       exit();
                      } else
                      {
                           $session_useremail = $cookie['email'];
                           $session_userid    = $cookie['userid'];
                      }
                } else
                {
                       // if cookie data are not the as session data, delete cookie
                       if ( ( isset( $cookie['email'] ) && isset( $cookie['userid'] ) ) )
                       {
                          if ( ( $cookie['email'] != $session_useremail ) || ( $cookie['userid']  != $session_userid ) )
                          {
                             $this->Cookie->delete('tct_auth');
                             $this->Cookie->delete('tct_auth_blog');
                          }
                       }
                }

                if ( $session_useremail && $session_userid )
                {
            		    // if $username is not empty,
            		    // check to make sure it's correct
            		    $this->loadModel('User');
            		    $results = $this->User->findByEmail( $session_useremail );

            		    // if not correct, send to login page
                        if ( ( !$results || $results['User']['id'] != $session_userid ) )
                        {
                                $this->Session->delete('session_useremail');
                                $this->Session->delete('session_userid');
                             	$this->Cookie->delete('tct_auth');
                             	$this->Cookie->delete('tct_auth_blog');
                                $this->Session->write('flash',__('Incorrect session data. Sorry.',true));
                                $this->redirect('/users/login');
                                exit();
                        } else
                        {  
                                $this->Session->write('session_userid', $results['User']['id']);
                                $this->Session->write('session_useremail', $results['User']['email']);
                                $this->Session->write('userobject', $results['User']);
                                $this->Session->write('Config.language', $results['User']['yourlanguage']);
                                $this->set('userobject', $results['User']);
                                $this->Cookie->write('tct_auth_blog', "true", $encrypt = false, $expires = null);
                        }
	               }
                 $this->set('session_userid', $session_userid);
	     }
}

?>