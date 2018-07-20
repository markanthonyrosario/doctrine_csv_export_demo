# Requirements
* php7
* mysql
* php_pdo extension
* composer

# Installation
```
# clone this repository
git clone github.com/doctrine_csv_export_demo

# Install dependencies
composer install

# set your MySQL credentials at .env
# vi .env
DB_NAME=db_products
DB_USER=mysqluser
DB_PASS=mysqlpassword

```

# Preparing the Database
```
# create the database
mysql -uroot -p -e "create database db_products"

# create the tables based on Doctrine Entities
vendor/bin/doctrine orm:schema-tool:update --force
```

# Generating Test Data
```
# this will generate 400k rows of product/product owner records
php generate_products.php
```

# Testing the results - Memory Usage of Database Operations
```
# list_products_1.php up to list products_5.php are meant to be run in the terminal 
php list_products_1.php # uses up to 646.01 MB
php list_products_2.php # uses up to 627.36 MB
php list_products_3.php # uses up to 87.37 MB
php list_products_4.php # uses up to 8 MB (no product owner name)
php list_products_5.php # uses up to 6 MB
```

# Testing the results - CSV download
```
# download_csv.php and download_csv_streamed.php is meant to be executed on a browser
# download_csv.php and download_csv_streamed.php uses the codes of list_products_5.php

# start the built-in php server for a quick demo
php -S localhost:8000

# you should see 
Listening on http://localhost:8000
Document root is /path/to/doctrine_csv_export_demo
Press Ctrl-C to quit.

# access download_csv.php from a browser
# this uses up to 25.16 MB of memory
# open the file to see the memory usage report per line
localhost:8000/download_csv.php

# access download_csv_streamed.php from a browser
# this now uses only a constant 2 MB
# open the file to see the memory usage report per line 
localhost:8000/download_csv_streamed.php 

``
