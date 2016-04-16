# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = 'centos65'

  config.vm.box_url = 'https://github.com/2creatives/vagrant-centos/releases/download/v6.5.1/centos65-x86_64-20131205.box'

  config.vm.network :private_network, ip: '192.168.50.11'
  config.vm.network :forwarded_port, guest: 443, host: 8443, auto_correct: true

  if ENV['USE_NFS']
    config.vm.synced_folder './', '/app', :nfs => true
  else
    config.vm.synced_folder './', '/app', :owner=> 'vagrant', :group=>'vagrant', :mount_options => ['dmode=777','fmode=777']
  end

  config.vm.provider :virtualbox do |vb|
    unless defined? config.vbguest
      require 'vagrant-vbguest'
      config.vbguest.auto_update = false
    end
    vb.customize ['modifyvm', :id, '--memory', '3072']
  end
 
  config.vm.provision :ansible do |ansible|
    ansible.playbook       = 'ansible/vagrant.yml'
    ansible.inventory_path = 'ansible/vagrant'
    ansible.limit          = 'all'
    ansible.verbose        = true
  end

end
