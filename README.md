# Not intended for public use. Test purposes only
### Start PHP CLI Server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:

```php
	php -S 0.0.0.0:8080 -t public/ public/index.php
```

### Install Composer dependencies

```php
    php composer.phar install
```

### Run Command

From the project root run the following command in terminal

```php
php public/index.php scrape bbc-top-shared
```
