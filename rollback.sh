sudo cp conf/nginx.conf /etc/nginx/conf.d/default -f
#sudo cp conf/supervisor.conf /etc/supervisor/conf.d/demo.conf -f
#sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/demo.conf
sudo service nginx restart
sudo service php8.1-fpm restart
#sudo service supervisor restart
