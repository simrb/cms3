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

1 backup your db, such as

	# output data
	# mysqldump --database cms_db > others/db_xx.sql

	# input data later in somewhere
	# mysql -uname -ppawd -Ddbname < db_xx.sql

2 backup the dir, such as

	# tar -cvf others.tar others/

untar

	# tar -xvf others.tar

Notice, all of files of the system created that will be stored in directory `others`
such as the `others/upload/*`, `cfg.php`, `access.php`. e.g.
just backup the others dir is enough.



License
============

[MIT](https://opensource.org/licenses/MIT)




