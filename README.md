Basic PHP Project Structure
This repository was based on pds/skeleton, which describes, based on studies, a standard structure for PHP projects and packages.

Changes were made to speed up the process of setting up, testing, and studying new PHP functionalities. Consequently, the structure was modified, and the details of these modifications can be found in this document. For more details, consult the original documentation before starting to use it.

Summary
If the project has a root folder for...	...then the folder will be named:
command line executables	bin/
dockerfiles to set up the application	docker/
configuration files	config/
documentation files	docs/
web server files	public/
other resource files	resources/
PHP source code	src/
test code	tests/
additional packages	vendor/
If the project has a root file for...	...then the file will be named:
a log of changes between versions	CHANGELOG(.*)
guidelines for contributors	CONTRIBUTING(.*)
licensing information	LICENSE(.*)
information about the package or project itself	README(.*)
project's required packages	composer.json
Changes from the Original Project
"docker" Directory
The original project was designed to standardize the development of new PHP packages by the community. The docker folder was created to store files related to Docker and Docker Compose, allowing the complete environment to be set up for tests, studies, or new projects, providing a good starting point.

Inside the directory, there's already a complete and configured localhost environment with Nginx, PHP-FPM, and PHP7.4.

"vendor" Directory and "composer.json" File
The composer.json was added to the project with its configurations, thereby speeding up development with external packages. The vendor directory is automatically created when running the composer install or composer update command.

Files in "public/"
Files were added for constructing the project with a testing base. public/index.php loads the composer's autoload and is already loaded by the web server when starting services with docker-compose up. public/phpinfo.php is for checking all the configurations and modules enabled in the image.

How to Use
There are two ways to use this PHP project template.

The first is by cloning this repository and placing it in the root of your web server/PHP, pointing the public folder to public and running composer to update the packages.

The second is after cloning the repository to a server with Docker and Docker Compose installed, enter the docker folder and run build.sh to start the services.

All files are as simplified and commented as possible, giving you complete freedom to modify them as needed.