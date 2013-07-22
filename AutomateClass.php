<?php 

/**
* Automate WordPress BackUps.
* This code has a plugin dependency. WP Complete BackUp plugin should be 
* installed in the WordPress instance you want to do the backup.
* 
* USAGE:
* 1. Install WP Complete Backup plugin in your WordPress instance
* 2. Allow your IP or 'any' to access to remote backup into the installed 
*    plugin.
* 3. Generate an API KEY in WP Complete Backup
* 4. Add a project to start doing this backups
* 5. Open the command line and execute: 
*         'sudo php automate.php'
*/
class Automate
{
  
  private $_name = '';
  private $_url = '';
  private $_api_key = '';
  private $_method = 'both';
  private $_auth = '';
  private $_username = '';
  private $_password = '';
  private $_response = array(
                         'status'  => '',
                         'message' => '',
                         'code'    => -1
                       );
  
  public function setName($value = '')
  {
    $this->_name = ucwords($value);
    return $this;
  }
  
  public function setUrl($value = '')
  {
    $this->_url = $value;
    return $this;
  }
  
  public function setApiKey($value = '')
  {
    $this->_api_key = $value;
    return $this;
  }
  
  public function setMethod($value = '')
  {
    $valid_methods = array('both', 'filesystem', 'database');
    if (in_array($value, $valid_methods))
    {
      $this->_method = $value;
    }
    return $this;
  }
  
  public function setAuth($value = '')
  {
    if ($value !== '')
    {
      $this->_auth = 'required';
    }
    return $this;
  }
  
  public function setUsername($value = '')
  {
    $this->_username = $value;
    return $this;
  }
  
  public function setPassword($value = '')
  {
    $this->_password = $value;
    return $this;
  }
  
  public function setResponse($status, $message, $code)
  {
    $this->_response = array(
      'status'  => $status,
      'message' => $message,
      'code'    => $code
    );
    return $this;
  }
  
  public function getResponse()
  {
    return $this->_response;
  }
  
  public function __construct($project = FALSE)
  {
    if (isset($project['name'])) $this->setName($project['name']);
    if (isset($project['url'])) $this->setUrl($project['url']);
    if (isset($project['api_key'])) $this->setApiKey($project['api_key']);
    if (isset($project['method'])) $this->setMethod($project['method']);
    if (isset($project['auth'])) $this->setAuth($project['auth']);
    if (isset($project['username'])) $this->setUsername($project['username']);
    if (isset($project['password'])) $this->setPassword($project['password']);
  }
  
  public function execute()
  {    
    // auth required
    if ( ! function_exists('curl_init'))
    {
      $this->setResponse('ERROR', 
                         'cUrl library is not in this PHP instance.('.$this->_name.')', 
                         1000);
    }
    else
    {
      // create a new cURL resource
      $ch = curl_init();
  
      // set URL and other appropriate options
      curl_setopt($ch, CURLOPT_URL, $this->_get_url());
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
      if ($this->_auth === 'required')
      {    
        // we need this params to authenticate
        if ($this->_username !== '' && $this->_password !== '')
        {
          curl_setopt($ch, CURLOPT_USERPWD, $this->_username.':'.$this->_password);
        }
        else
        {
          $this->setResponse('ERROR', 
                             'If auth is required, username and password should be filled in.('.$this->_name.')',
                             1001);
        }
      }
    
      $output = $this->_get_output(curl_exec($ch));
    
      $this->setResponse($output['status'], 
                         '',
                         $output['code']);
    }

    return true;
  }

  private function _get_output($response)
  {
    switch ($response) {
      case '<response>0</response>':
        $output = array(
          'status' => 'SUCCESS',
          'code' => 0
        );
        break;

      case '<response>1</response>':
        $output = array(
          'status' => 'BAD TYPE',
          'code' => 1
        );
        break;

      case '<response>2</response>':
        $output = array(
          'status' => 'BAD API',
          'code' => 2
        );
        break;

      case '<response>3</response>':
        $output = array(
          'status' => 'IP RESTRICTION',
          'code' => 3
        );
        break;
  
      default:
        $output = array(
          'status' => 'INTERNAL ERROR',
          'code' => 4
        );
        break;
    }
    return $output;
  }

  private function _get_url()
  {
    if ($this->_url === '' || $this->_api_key === '' || $this->_method === '')
    {
      throw new exception('Not enough params');
    }
    return 'http://'.$this->_url.'/wp-complete-backup/api-'.$this->_api_key.'/type-'.$this->_method;
  }

}

?>