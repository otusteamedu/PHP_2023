sudo cp nginx.conf /etc/nginx/conf.d/otus_php_prof_hw21.conf -f
sudo cp supervisor.conf /etc/supervisor/conf.d/otus_php_prof_hw21.conf -f
sudo sed -i -- "s|%DOMAIN_NAME%|$1|g" /etc/nginx/conf.d/otus_php_prof_hw21.conf

sudo service nginx restart
sudo service php8.3-fpm restart

sudo -u www-data php bin/console cache:clear

sudo service supervisor restart
