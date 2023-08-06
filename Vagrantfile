# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.define "web" do |web|
    web.vm.box = "ubuntu/focal64"
    web.vm.box_check_update = false

    web.ssh.username = "vagrant"
    web.ssh.insert_key = true

    web.vm.network "private_network", ip: "192.168.56.22"
    web.vm.hostname = "application.local"

    web.vm.network "forwarded_port", guest:
      80, host:
      80, host_ip: "127.0.0.1"

    web.vm.synced_folder ".", "/vagrant", disabled: true

    web.vm.provider "virtualbox" do |vb|
      vb.name = "web"
      vb.memory = "512"
      vb.cpus = "1"
    end
    web.vm.synced_folder ".", "/home/learning/hw1"
  end

end
