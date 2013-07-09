WP Automate Backups
===================

Backup automatization for multiple WordPress instances.

Usage
=====

WordPress
---------

1. Install [WP Complete Backup](http://wordpress.org/plugins/wp-complete-backup/) into your WordPress instance.
2. Allow your **current IP** or **'any'** to access to remote backups.
3. Generate an **API KEY**.

Project (PHP 5+)
----------------

1. Clone the repository into your system.
2. Add as much projects as you want to the **$projects** array.
     
     ```PHP
     $projects = array(
          array(
               'name'     => 'ProjectName',
               'url'      => 'www.project-url.com',
               'api_key'  => 'xxxxxxxxxxxxxxxxxxxxxxxx',
               'method'   => 'both',
               'execute'  => true,
               'auth'     => 'required', // HTTP Basic authentication OPTIONAL
               'username' => 'username', // OPTIONAL
               'password' => 'password' // OPTIONAL
          )
     );
     ```

3. Open terminal and execute: 

     ```sudo php Automate.php```
