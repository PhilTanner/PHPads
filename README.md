# PHPads
Simple PHP banner ad script ~~that requires no MySQL~~

I know this project description specifically says it requires no MySQL, so creating a MySQL Version branch seems odd, but I found that when dealing with 125,000+ impressions a day, the ads.dat config file would get corrupted due to simultaneous read/write cycles only retrieving half the file as it was being written. This was not prevented by flock(), and caused behaviour such as being locked out of the admin tool, due to admin username / password missing, and other settings "disappearing".

Recommended minimum Apache configuration: 

    # Stop people viewing the directory contents
    <Directory "<Insert your root install path here>">
      Options -Indexes
    </Directory>
    # Stop people viewing your config file (accessing password to admin etc)
    <FilesMatch "^ads.dat$">
      Require all denied
    </FilesMatch>
    # Stop people other than you accessing your admin tool
    <FilesMatch "admin.php">
      Order deny,allow
      Deny from all
      Allow from <Insert your IP address here>
    </FilesMatch>
    # Stop people re-installing the application
    <FilesMatch "install.php">
      Require all denied
    </FilesMatch>
    # Stop people viewing the .git history
    <DirectoryMatch "\.git">
      Require all denied
    </DirectoryMatch>
    # Stop people browsing through your old upload files
    <DirectoryMatch "uploads">
      Options -Indexes
    </DirectoryMatch>

