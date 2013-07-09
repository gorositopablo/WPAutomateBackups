<?php

/**
 * e.x:
 *
 * $projects = array(
 *    array(
 *      'name'     => 'ProjectName',
 *      'url'      => 'www.project-url.com',
 *      'api_key'  => 'xxxxxxxxxxxxxxxxxxxxxxxx',
 *      'method'   => 'both',
 *      'execute'  => true,
 *      'auth'     => 'required',
 *      'username' => 'username',
 *      'password' => 'password'
 *    )
 * );
 * 
 * */

include_once 'AutomateClass.php';

if (isset($projects) && is_array($projects))
{
  foreach ($projects as $project) {
  
    if ($project['execute'])
    {  
        $automate = new Automate($project);
        $automate->execute();
        $response = $automate->getResponse();
      
        echo $project['name'].' --> '.$response['status'].'('.$response['code'].')'."\n";
        if ($response['message'] !== '')
        {
          echo 'Message: '.$response['message']."\n"
        }

    } else {
    
      echo $project['name'].' --> SKIPPED'."\n";
    
    }
  }
}

exit;

?>