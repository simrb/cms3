About
============

It is a simple cms by creating with php language, the base functions as follows,

	admin module	- record management, category, tag, upload file, user system
	front module	- the base front-end page for normal user
	common module	- database scheme, function library, config, access file
	theme module	- all of module templates, css, js file
	others module	- upload files, custom files, all of backup files will be stored here.



Setup
============

initialing the project environment and database by default database, username, userpawd

	# su
	# sh .myt -ed

or, set your custom by options `-h, -n, -u, -p`

	# sh .myt -ed -n db_name -u username -p password

if you have an existed database, just configure the file `cfg.php` for connecting

btw, you better to reboot server agint.



Backup
============

1 backup your db, output data with the `first command`, and then, 
copy your data file to your new path like `/others` , and execute the `second command`

	# mysqldump -uroot -p cms_db > others/db.xxx

	# mysql -ucms_uxxx -pcms_pxxx cms_dbname < others/db.xxx

2 backup upload file, such as

	# tar -cvf others.tar others/

untar

	# tar -xvf others.tar

3 backup the database with `.myt` file

enter your project root dir and typing the under command, that will be created a file called like `others/db.xxxxxx`

	sh .myt -b

or use the `crontab`,

	crontab -e

and add command like the last line,
	
	SHELL=/bin/bash
	PATH=/sbin:/bin:/usr/sbin:/usr/bin
	MAILTO=""HOME=/

	10 2 * * * /var/www/html/.myt -b

Notice, all of files of the system created that will be stored in directory `others`
such as the `others/upload/*`, `cfg.php`, `access.php`. e.g.
just backup the others dir is enough.



License
============

[MIT](https://opensource.org/licenses/MIT)




