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

## Adding mysql

Based on https://www.sitepoint.com/docker-and-dockerfiles-made-easy/

First mount and run mysql container:
```
$ docker run -p 3306:3306 --name mysqlserver -e MYSQL_ROOT_PASSWORD=root -d -v $(pwd)/db:/tmp/db mysql
```
The `-e` option lets you set an environment variable on the container creation. In this case, the `MYSQL_ROOT_PASSWORD` will tell the MySQL installation process to use the password we specified in the command.

Create web server and link it to the mysql database
```
$ docker run -tid -p 8080:80 -v $(pwd)/www:/var/www/site --link mysqlserver:mysqldb apache-php
```
Then open http://localhost:8080/

### Connecting to MySQL

In general what you need is:
```php
    $dbuser = 'root';
    $dbpass = 'root';
    $dbhost = 'mysqlserver';

    $connect = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");

    echo "Connected to DB!";
```

## Add mysql and dump db

Well, here is the first recepie:

1. Add `wordpress.sql` to `db` directory

2. Then you can run container
    ```
    $ docker run -p 3306:3306 --name mysqlserver -e MYSQL_ROOT_PASSWORD=root -d -v $(pwd)/db:/tmp/db mysql
    ```
    mysql container will share `/tmp/db` with local `/db` folder.

4. Open console to the running `mysql-lamp` container
    ```
    $ docker exec -it [container-id] bash
    ```

5. And run
    ```
    $ /tmp/db/init_wordpress.sh
    ```

    It will create `wordpress` DB and dump `wordpress.sql` in it.

6. Now you can start your php server
    ```
    $ docker run -tid -p 8080:80 -v $(pwd)/www:/var/www/site --link mysqlserver:mysqldb apache-php
    ```

Yeah, I know should be more automation, it will be next step.
