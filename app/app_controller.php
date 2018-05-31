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

	   	// var $components = array('Session', 'RequestHandler');
        var $components = array('Session', 'RequestHandler');
        
	   	function beforeFilter()
        {
            if (env('HTTPS')) {
                Configure::write('Session.save', Configure::read('Session.save') . '_https');
            }
            // tct_auth_blog
            $this->Cookie->path = '/';

            if ( isset( $_SERVER['HTTP_BASE'] ) ) {
                $this->Cookie->domain = $_SERVER['HTTP_BASE'];
            } else {
                $this->Cookie->domain = Configure::read('Session.domain');
            }
            if ( $_SERVER['HTTP_HOST'] == LOCALHOST )
            {    
                $this->Cookie->secure = false; 
            } else {
                $this->Cookie->secure = true; 
            }

            // user sets language 
            // code: eng or deu
            if ( isset( $this->params['named']['code'] ) ) 
            {
                $this->code = $this->params['named']['code'];
                $language = $this->code;
                //echo "DEBUG code language " . $language . "<br />";
            } else {
                // user is logged in
                if ( is_numeric( $this->Session->read('session_userid') ) )
                {
                    $this->loadModel('User');
                    
                    // $this->checkSession();
                    $this->User->id = $this->Session->read('session_userid');
                    $this->UserLanguage = $this->User->read();
                    //echo "DEBUG user language " . $this->UserLanguage . "<br />";
                    
                    if ( isset($this->UserLanguage['User']['yourlanguage'] ) ) {
                        $language = $this->UserLanguage['User']['yourlanguage'];
                    }

                } else {

                    if ( $this->Session->read('Config.language') ) {
                        $language = $this->Session->read('Config.language');

                        //echo "DEBUG session language " . $language . "<br />";
                    } else {
                        /*
                        if ( $_SERVER['HTTP_HOST'] == LOCALHOST )
                            $freegeoipurl = 'http://freegeoip.net/json/81.217.23.232';
                        else
                            $freegeoipurl = 'http://freegeoip.net/json/' . $_SERVER['REMOTE_ADDR'];
                    
                        $yourlocation = @json_decode( implode( '', file( $freegeoipurl ) ) );
            
                        if ( isset( $yourlocation->country_code ) && ( $yourlocation->country_code == 'DE' || $yourlocation->country_code == 'AT' ) )
                        {
                            $language = 'deu';
                        } else {
                            $language = 'eng';
                        }
                        */
                        if ( preg_match('/^de/', $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ) {
                            $language = 'deu';
                        } else {
                            $language = 'eng';
                        }
                        //echo "DEBUG browser language " . $language . "<br />";
                    }
                }
            }
            
            // you have to set this to change the language of the app
            Configure::write('Config.language', $language);
            // write language into session // this is a MUST to set the language
            $this->Session->write('Config.language', $language);
            // deu is for locale folder
            $this->set('language', $language); 
            
            $this->Cookie->write('tct_language', "$language", false, '+1 day');

            if ($language && file_exists(VIEWS . $language . DS . $this->viewPath))
            {
                // e.g. use /app/views/fre/pages/tos.ctp instead of /app/views/pages/tos.ctp
                $this->viewPath = $language . DS . $this->viewPath;
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
                            
                    $sql = "SELECT myrecommendation, firstname, lastname, email FROM " .
                        "users WHERE myrecommendation != '' AND yourlanguage = '" . $language . "'";
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
        
            // set for views
            $this->set('session_userid', $this->Session->read('session_userid'));
            $this->set('session_useremail', $this->Session->read('session_useremail'));
     }

     function checkSession()
     {
            // fill $username with session data
            $session_useremail = $this->Session->read('session_useremail');
            $session_userid    = $this->Session->read('session_userid');

            if ( preg_match( '/@/', $session_useremail ) && is_numeric( $session_userid ) )
            {
                // check to make sure it's correct
                $this->loadModel('User');
                $results = $this->User->findByEmail( $session_useremail );

                // if not correct, send to login page
                if ( ( !$results || $results['User']['id'] != $session_userid ) )
                {
                    $this->Session->delete('session_useremail');
                    $this->Session->delete('session_userid');
                    $this->set('session_userid', null);
                    $this->set('session_useremail', null);

                    $this->Session->write('flash',__('Incorrect session data. Sorry.',true));
                    $this->redirect('/users/login');
                    die();

                } else
                {  
                    // reset session vars
                    $this->Session->write('session_userid', $results['User']['id']);
                    $this->Session->write('session_useremail', $results['User']['email']);
                    
                    $this->set('session_userid', $results['User']['id']);
                    $this->set('session_useremail', $results['User']['email']);

                    $this->Session->write('userobject', $results['User']);
                    $this->Session->write('Config.language', $results['User']['yourlanguage']);
                    $this->set('userobject', $results['User']);

                    // this is for Wordpress to have the same auth
                    $this->Cookie->write('tct_auth_blog', "true", false, '+1 day');
                }
            // session data not correct, kick her/him out
            } else {
                
                // to be sure
                $this->Session->write('previous_url', $_SERVER['REQUEST_URI']);
                $this->Session->delete('session_useremail');
                $this->Session->delete('session_userid');
                $this->set('session_userid', null);
                $this->set('session_useremail', null);

                $this->Session->write('flash',__("Sorry, you're not signed in or your session expired.", true));
                $this->redirect('/users/login');
                die();
            }
        }
}

?>