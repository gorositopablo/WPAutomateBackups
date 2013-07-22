<?php

include_once 'AutomateClass.php';
include_once 'ProjectsList.php';

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
          echo 'Message: '.$response['message']."\n";
        }

    } else {
    
      echo $project['name'].' --> SKIPPED'."\n";
    
    }
  }
}

exit;

?>