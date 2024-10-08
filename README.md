# Email Parser

## Installation

- Clone and run `composer install`
- Create database and update DB variables from `.env`
- Import the **"successful_emails"** first on your DB
- Run `php artisan migrate && php artisan db:seed`
- Run `php artisan serve`

## Command

- To test command for email parsing, run `php artisan app:parse-emails`
    - A schedule has been set to run every hour, checking if the email has been processed or not. If it's not processed then it will be parsed, otherwise, skip.

## Local testing
- Go to `routes/console.php` and just update the duration
```
Schedule::command('app:parse-emails')->hourly();

Example: Schedule::command('app:parse-emails')->everyTenSeconds();
```
- Run `php artisan schedule:run` and just check the database to confirm.
