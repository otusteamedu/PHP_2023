Vagrant.configure("2") do |config|
  # Added OC
  config.vm.box = "ubuntu/focal64"

  # Access to DHCP
  config.vm.network "public_network"

  # set shell script that install necessary packages
  config.vm.provision :shell, path: "bootstrap.sh"

  # forwarding ports
  config.vm.network :forwarded_port, guest: 80, host: 80

  # sync folder with guest machine
  config.vm.synced_folder ".", "/vagrant", type: "rsync"

  # config resources for the VM
  config.vm.provider "virtualbox" do |v|
    v.memory = 4048
    v.cpus = 4
  end
end
