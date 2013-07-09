WPAutomateBackups
=================

Backup automatization for multiple WordPress instances.

Usage
=====

WordPress
---------

1. Install [WP Complete Backup](http://wordpress.org/plugins/wp-complete-backup/) into your WordPress instance.
2. Allow your **current IP** or **'any'** to access to remote backups.
3. Generate an **API KEY**.

Project
-------

1. Clone the repository into your system.
2. Add as much projects as you want to the **$projects** array.
     $projects = array(
       array(
         'name'     => 'ProjectName',
         'url'      => 'www.project-url.com',
         'api_key'  => 'xxxxxxxxxxxxxxxxxxxxxxxx',
         'method'   => 'both',
         'execute'  => true,
         'auth'     => 'required', // HTTP Basic authentication
         'username' => 'username',
         'password' => 'password'
       )
     );
   'auth', 'username' and 'password' are optional. Fill in only if your WordPress instance has HTTP Basic authentication.
3. Open terminal and execute: sudo php **Automate.php**.

Note: You should have php as a part of your .bash(mac) or path(windows) variable.
