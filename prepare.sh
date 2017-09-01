cd /var/www/html/summercamp/ezhttpcaching
cp ezpublish_legacy_default/config.php ezpublish_legacy/.
cp -R ezpublish_legacy_default/settings/siteaccess/admin ezpublish_legacy/settings/siteaccess/.
mkdir ezpublish_legacy/settings/override
cp ezpublish_legacy_default/settings/override/site.ini.append.php ezpublish_legacy/settings/override/.
sudo mv /etc/varnish/default.vcl /etc/varnish/default.vcl.backup
sudo cp doc/websc/varnish.vcl /etc/varnish/default.vcl
sudo service varnish restart
composer install
