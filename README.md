## Logger 

### Set up

```
git clone https://github.com/cornel-b/logger
cd logger
cp .env.example .env
composer install
php artisan serve
```

### Specifications

```
I have added a new AppLog model which is used to save log entries in the app_log table
To only log exceptions to the database, the LOG_LEVEL can be set to `error`.
Index has been added for created_at, since it's used for sorting the records.

visit

http://127.0.0.1:8000/test/division-by-zero
http://127.0.0.1:8000/test/malformed-json
http://127.0.0.1:8000/test/carbon-error
http://127.0.0.1:8000/test/undefined-variable
http://127.0.0.1:8000/test/array-index-error
http://127.0.0.1:8000/test/alternative-database
http://127.0.0.1:8000/test/log-only
```
