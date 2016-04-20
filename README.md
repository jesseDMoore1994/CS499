# CS499

## Installation Requirements

1. PHP version 5.5.9 or greater
2. The PHP mbstring and intl extensions
3. Apache

## Installation Instructions

1. Identify the path to your apache web server.

   Examples:
     - C:\wamp\www
     - /var/www/
     - /var/htdocs
     
2. Identify the login information to your MySQL server

    - **Server:** This is usually "localhost." Alternatively, it can be
      the IP address or hostname of a machine running MySQL.
    - **Database:** The name of the MySQL database on the
      server to upload data into
    - **Username:** Usually "root" on development machines.
      This is the MySQL user to log in as
    - **Password:** This is the MySQL user's password.
    
3. Download the TicketAngel source. This can be accomplished
   by clicking the "Download ZIP" button on GitHub, or clicking
   the below link:
   
   https://github.com/JesseDarellMoore/CS499/archive/master.zip
   
4. Upload the installer.

    - Find the folder "installer" within the project ZIP 
      file.
    - Copy/upload it to the web server. Example: C:\www\wamp\installer
    - Visit the installer page (Example: http://localhost/installer/)
    - Type in the MySQL credentials mentioned in step 2.
    - Click the submit button.
    
5. Upload the code

    - Find the folder "code" within the project ZIP file.
    - Rename it to "ticketangel" (or similar), and copy it
      to the web server like with the installer in step 4.

6. Edit the configuration file

    - In the newly uploaded site, open config/app.php
    - On line 220, fine the following:
    
          'username' => 'root',  
          'password' => ((strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? "" : "root"),  
          'database' => 'theater_ticket_manager_db',
          
    - Upadte to include the MySQL access information

          'username' => 'root',  
          'password' => 'thepassowrd',  
          'database' => 'ticketangel',
          
7. Access the site

    Visit the site. For example: http://localhost/ticketangel/