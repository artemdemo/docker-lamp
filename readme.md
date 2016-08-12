# Docker environment: LAMP

## Basic: Linux, Apache and PHP

Based on https://medium.com/dev-tricks/apache-and-php-on-docker-44faef716150

Build container:
```
$ docker build -t apache-php .
```

Run it in the background:
```
$ docker run -p 8080:80 -d apache-php
```
Then open http://localhost:8080/

Sometimes you’ll want to debug issues with the container; maybe there are PHP configuration issues or you want to view error logs. To do that you can start the container in interactive mode:
```
$ docker run -i -t -p 8080:80 mysite /bin/bash
```
and then start apache manually:
```
$ apachectl start
```

Using volume folder:
```
$ docker run -p 8080:80 -d -v $(pwd)/www:/var/www/site apache-php
```

## If you need mysql

Based on https://www.sitepoint.com/docker-and-dockerfiles-made-easy/

First mount run mysql container
```
$ docker run -p 3306:3306 --name mysqlserver -e MYSQL_ROOT_PASSWORD=root -d mysql
```
The `-e` option lets you set an environment variable on the container creation. In this case, the `MYSQL_ROOT_PASSWORD` will tell the MySQL installation process to use the password we specified in the command.

Create web server and lnk it to the mysql database
```
$ docker run -tid -p 8080:80 -v $(pwd)/www:/var/www/site --link mysqlserver:mysqldb apache-php
```
Then open http://localhost:8080/

