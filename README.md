# Web Summer Camp 2017 workshop - Hands-on: HTTP caching with Varnish

This repository is based on eZ Platform Demo release v.1.10.0 (https://github.com/ezsystems/ezplatform-demo) with legacy support 
(using legacy dependencies and configuration provided in https://github.com/emodric/ezplatform-legacy, branch 1.10).

In order to set up and run this project, follow these steps
### 1. run composer install
```bash
composer install
```
*Installation will ask you for database credentials and secret token for Symfony, other settings can stay as default.* 

### 2. Create database
```bash
php app/console doctrine:database:create
```

### 3. run the following commands to install the demo and dump the assets
```bash
php app/console ezplatform:install demo
php app/console assetic:dump --env=prod web
```

### 4. Configure virtual host ( root permissions required )
```bash
./bin/vhost.sh --basedir=/var/www/ezhttpcaching \\
  --template-file=doc/websc/vhost.template \\
  --host-name=ezhttpcaching.websc \\
  --sf-env=prod \\
  --sf-http-cache=0 \\
  | sudo tee /etc/apache2/sites-enabled/ezhttpcaching.websc.conf > /dev/null
``` 
(Restart/reload Apache service after running the script)

### 5. copy the prepared VCL file (doc/websc/varnish.vcl) to /etc/varnish folder (root permissions required ), configure Varnish to use this VCL, and restart Varnish service

### 6. add ezhttpcaching.websc entry in your /etc/hosts file

### 7. ... and to clear all caches and warm up the caches for prod environment, run composer install one more time.


