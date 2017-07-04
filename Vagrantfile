# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
	config.vm.box = "ubuntu/yakkety64"


	config.vm.define "read_web" do |read_web|
	    read_web.vm.provider :virtualbox do |vb|
            vb.customize ["modifyvm", :id, "--nictype1", "virtio"]
        end

		read_web.vm.network "private_network", ip: "192.168.34.10"
		read_web.vm.provision :shell, path: "setup/bootstrap_webserver.sh"

		read_web.vm.provider "virtualbox" do |vbox|
			vbox.memory = 2048
			vbox.cpus = 2
		end
	end
end
