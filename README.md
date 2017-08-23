# Web Summer Camp 2017 workshop - Hands-on: HTTP caching with Varnish

This repository is based on eZ Platform Demo release v.1.10.0 (https://github.com/ezsystems/ezplatform-demo) with legacy support 
(using legacy dependencies and configuration provided in https://github.com/emodric/ezplatform-legacy, branch 1.10).

In order to set up and run this project, position yourself to the project root folder and follow these steps:
### 1. Copy default legacy configurations to ezpublish_legacy folder  
```bash
cp -R ezpublish_legacy_default ezpublish_legacy
```

### 2. run composer install
```bash
composer install
```
*Installation will ask you for database credentials and secret token for Symfony, other settings can stay as default.* 

### 3. Create database
```bash
php app/console doctrine:database:create
```

### 4. run the following commands to install the demo and dump the assets
```bash
php app/console ezplatform:install demo
php app/console assetic:dump --env=prod web
```

### 5. Configure virtual host ( root permissions required )
```bash
./bin/vhost.sh --basedir=/var/www/ezhttpcaching \\
  --template-file=doc/websc/vhost.template \\
  --host-name=ezhttpcaching.websc \\
  --sf-env=prod \\
  --sf-http-cache=0 \\
  | sudo tee /etc/apache2/sites-enabled/ezhttpcaching.websc.conf > /dev/null
``` 
(Restart/reload Apache service after running the script)

*If you are working on your local machine, don't forget to add domain to your /etc/hosts file. Also, change the basedir parameter to match the root path of your project*
### 6. Configure Varnish

Copy the prepared VCL file (doc/websc/varnish.vcl) to /etc/varnish folder (root permissions required ), configure Varnish to use this VCL, and restart Varnish service

### 7. Clear all caches and warm up the caches for prod environment:
```bash
SYMFONY_ENV=prod composer install
```


