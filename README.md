## install
initial setup
```
$ cd /{desired_repo_location}
$ git clone https://github.com/akanatffilc/shokai.git
$ cd shokai
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
