docker-zf2
==============

Docker multi-container application to have a complete stack for running market and price projects into Docker containers using docker-compose tool.

# Installation

First, clone this repository:

```bash
$ git@gitlab.itftc.com:svitstore_developers/toptopmarket_docker.git

```

Then, run:

```bash
$ sudo docker-compose up -d
```

You are done, you can visite your market application on the following URL: `http://toptopmarket.local.com` and price on `http://price.local.com`

Optionally, you can build your Docker images separately by running:

```bash
$ docker build -t zf2/application application
$ docker build -t zf2/php-fpm php-fpm
$ docker build -t zf2/nginx nginx
$ docker pull centurylink/mysql
```

# How it works?

Here are the `docker-compose` built images:

* `application`: This is the ZF2 application code container,
* `db`: This is the MySQL database container (can be changed to postgresql or whatever in `docker-compose.yml` file),
* `php`: This is the PHP-FPM container in which the application volume is mounted,
* `nginx`: This is the Nginx webserver container in which application volume is mounted too

This results in the following running containers:

```bash
$ docker-compose ps

CONTAINER ID        IMAGE                   COMMAND                  CREATED             STATUS              PORTS                      NAMES
579c584a4a2d        dockerzf2_nginx         "/sbin/my_init"          About an hour ago   Up About an hour    0.0.0.0:80->80/tcp         dockerzf2_nginx_1
03022233f673        dockerzf2_php1          "/sbin/my_init"          About an hour ago   Up About an hour    0.0.0.0:9002->9002/tcp     dockerzf2_php1_1
ff59189e0ff3        dockerzf2_php           "/sbin/my_init"          About an hour ago   Up About an hour    0.0.0.0:9000->9000/tcp     dockerzf2_php_1
73c5f6535877        centurylink/mysql       "/usr/local/bin/run"     3 hours ago         Up About an hour    0.0.0.0:3306->3306/tcp     dockerzf2_db_1
8e3228973f5c        dockerzf2_application   "/sbin/my_init"          3 hours ago         Up 3 hours                                     dockerzf2_application_1
89c94e820a4b        memcached               "/entrypoint.sh memca"   2 days ago          Up 4 hours          0.0.0.0:11211->11211/tcp   dockerzf2_memcached_1
9c362da28e5f        redis                   "/entrypoint.sh redis"   3 days ago          Up 4 hours          0.0.0.0:6379->6379/tcp     dockerzf2_redis_1

```

# Read logs

You can access Nginx logs in the following directories into your host machine: `nginx/log`
# credits_env
