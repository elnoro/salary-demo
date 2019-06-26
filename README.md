##### How to build

`git clone https://github.com/elnoro/salary-demo.git`

`cd salary-demo && composer install`

##### How to run

`employees.csv` is included in the repo and has been generated with Numbers.

Run locally (at least php 7.1 is required):

`bin/console app:calculate-salary employees.csv salaries.csv`

Run with Docker:

`docker run -it --rm --name salary-script -v "$PWD":/usr/src/app -w /usr/src/app php:7.2-cli php bin/console app:calculate-salary employees.csv output.csv`


##### How to test

Run `bin/phpunit --testdox`

Note that only the Accounting module is covered by unit tests. 

IO can be tested using either vfs, Humble Object pattern or actual files, and a functional test could be written for the console command itself.
