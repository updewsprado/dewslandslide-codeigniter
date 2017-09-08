# dewslandslide-codeigniter
Codeigniter Portion of the Website

[HOW TO SETUP - Ubuntu]
1. Pull repository to /var/www/
2. Rename folder to codeigniter
  2.1 sudo mv dewslandslide-codeigniter codeigniter
3. Replace baseurl to localhost (for local machine)
  3.1 cd /var/www/codeigniter/application/config
  3.2 vim config.php
  3.3 replace base url to: $config['base_url']	= 'http://localhost/';
