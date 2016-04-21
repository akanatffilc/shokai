## install
initial setup
```
#clone repo
$ cd /{desired_repo_location}
$ git clone https://github.com/akanatffilc/shokai.git
$ cd shokai

#add local host url to /etc/hosts
#mac
$ sudo -- sh -c 'echo "192.168.50.11 shokai.localhost.com" >> /etc/hosts'
```

@HOST
```
$ vagrant up
```

@GUEST
```
$ vagrant ssh
$ cd /app
$ curl -s http://getcomposer.org/installer | php
$ php composer.phar install
```
