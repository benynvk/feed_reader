# PHP Developer assignment

## Task

Your task is to create a PHP application that is a feeds reader. The app can read feed from multiple feeds and store them to database. Sample feeds http://www.feedforall.com/sample-feeds.htm.

## Requirements
- The application must be developed by using a php framework and follow coding standard of that framework.
- As a developer, I want to run a command which help me to setup database easily with one run.
- As a developer, I want to run a command which accepts the feed urls (separated by comma) as argument to grab items from given urls. Duplicate items are accepted.
- As a developer, I want to see output of the command not only in shell but also in pre-defined log file. The log file should be defined as a parameter of the application.
- As a user, I want to see the list of items which were grabbed by running the command line. I also should see the pagination if there are more than one page. The page size is up to you.
- As a user, I want to filter items by category name on list of items.
- As a user, I want to create new item manually
- As a user, I want to update/delete an item

## How to do
1. Fork this repository
2. Start coding
3. Use gitflow to manage branches on your repository
4. Open a pull request to this repository after done

# Solution
## Requirement
- **Apache:** 2.2 or higher.
- **PHP:** 7.1.17 or higher.
- **MySQL:** 5.5 or higher.
- **Composer:** 1.6.5 or higher.
## Configuration and installation:
1. Install vendor:
    ~~~
    composer install
    ~~~
2. Create .env file:
    ~~~
    cp .env.example .env
    ~~~
3. Edit database configuration in .env file:
- `DB_DATABASE` value can be whatever. You don't need to create a database, my command in **Usage** section will help you.
    ~~~
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=feeds_reader
    DB_USERNAME=root
    DB_PASSWORD=
    ~~~
4. Generate key application:
    ~~~
    php artisan key:generate
    ~~~
## Usage
1. Create database:
    ~~~
    php artisan initializeDatabase
    ~~~
2. Get data from feed URL:
    ~~~
    php artisan feedUrl {URL} {logFile}
    ~~~
- `URL` parameter is the URL you want to get feed data. You can implement with many URLs by separating by comma.

- `logFile` parameter is the log file to write output of this process. 
    - Currently, accepted values for this parameter are `feed_log_1`, `feed_log_2`, `feed_log_3`. These files are located in `storage/logs`.
    - You can edit or create more log options in `config/logging.php`.

- Example command:
    ~~~
    php artisan feedUrl https://www.feedforall.com/sample.xml,https://www.feedforall.com/sample-feed.xml feed_log_1
    ~~~

After running two commands above, your database is completely created.

You also can use web app on: http://domain.name/base-php
- Domain name depends on server you use.

## Reference
This app  is powered by **Laravel v5.8**, **Bootstrap v3.4.0** and **jQuery v3.4.1**
1. https://laravel.com
2. https://getbootstrap.com
3. https://jquery.com

## Author
Khoa Nguyen | benynvk@gmail.com
