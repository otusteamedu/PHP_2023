Vagrant.configure("2") do |config|
  # Added OC
  config.vm.box = "ubuntu/focal64"

  # set shell script that install necessery packages
  config.vm.provision :shell, path: "bootstrap.sh"

  # forvarding ports
  config.vm.network :forwarded_port, guest: 80, host: 80

  # config resources for the VM
  config.vm.provider "virtualbox" do |v|
    v.memory = 4048
    v.cpus = 4
  end
end
