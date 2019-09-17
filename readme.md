About
============

It is a simple cms by creating with php language, the base functions as follows,

	admin module	- record management, category, tag, upload file, user system
	front module	- the base front-end page for normal user
	lib module		- database scheme, function, config, access file
	view module		- all of module templates, css, js file
	others module	- upload files, custom files, all of backup files will be stored here.



Setup
============

copy from github

	# git clone https://github.com/simrb/cms3.git

firstly, make sure your server environment, ip, port are fine.

	# su
	# cd cms3
	# sh .myt -e

	# service httpd status
	# service mysqld status

and test with  `http://your_ip_address` in web browser, they are good when you can open the page link.


1. let`s install the web application,

copy to your web root directory before installing

	# cp -R cms3/. /var/www/html/
	# cd /var/www/html/

initial by default database, username, userpawd

	# sh .myt -ed

or, set yourself by options `-h, -n, -u, -p`

	# sh .myt -ed -n db_name -u username -p password

if you have an existed database, just configure the file `cfg.php` for connecting

btw, you better to reboot server again.

and then create an administrator account like under command, the default username and password both of called admin.

	# sh .myt -a


2, start the back-end task with `crontab`, 

	# cp .myt .myti
	# vi .myti

and modify the path `my_bk_dir`, `my_cfg_dir` as you want, maybe like the following,

	my_bk_dir=/home/db
	my_cfg_dir=/var/www/html/others/cfg.php

then edit crontab text,

	# crontab -e

add command like the following,
	
	SHELL=/bin/bash
	PATH=/sbin:/bin:/usr/sbin:/usr/bin
	MAILTO=""HOME=/

	10 2 */3 * * /var/www/html/.myti -b
	10 2 15 * * php /var/www/html/index.php _m=admin _f=main _a=task



Backup
============

1, backup your db, output data with the `first command`, and then, 
copy your data file to your new path like `/others` , and execute the `second command`

	# mysqldump -uroot -p cms_db > others/db.xxx

	# mysql -ucms_uxxx -pcms_pxxx cms_dbname < others/db.xxx

1.1, backup the database with `.myt` file

enter your project root dir and typing the under command, that will be created a file called like `others/db.xxxxxx`

	# sh .myt -b

2, backup upload file, such as

	# tar -cvf others.tar others/

untar

	# tar -xvf others.tar

Notice, all of files of the system created that will be stored in directory `others`
such as the `others/upload/*`, `cfg.php`, `access.php`. e.g.
just backup the others dir is enough.

if you want to clear the backup in admin-end, you need to set the `others` dir with `chmod -R 777 others`



License
============

[MIT](https://opensource.org/licenses/MIT)




