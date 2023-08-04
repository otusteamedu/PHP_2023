help:
	@echo 'Please use commands vagrant, composer, docker.'

use-vagrant:
	@echo '..use-vagrant!'
	@yes | cp ./www/.env ./www/.env.backup
	@yes | cp ./www/.env.vagrant ./www/.env
	@echo 'Updated .env file for Vagrant using!'
	@echo 'Now you can start work, please use command like `vagrant up`.'

use-docker:
	@echo '..use-docker!'
	@yes | cp ./www/.env ./www/.env.backup
	@yes | cp ./www/.env.docker ./www/.env
	@echo 'Updated .env file for Docker using!'
	@echo 'Now you can start work, please use command like `docker-composer up`.'
