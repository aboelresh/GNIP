\# Contributing to GNIP



Thank you for your interest in contributing to GNIP!



\## Development Setup



1\. Clone the repository

2\. Copy `.env.example` to `.env` and configure your environment

3\. Run `composer install`

4\. Run `php artisan key:generate`

5\. Run `php artisan migrate`



\## Code Style



This project uses Laravel Pint for code formatting:



```bash

./vendor/bin/pint

```



\## Static Analysis



```bash

./vendor/bin/phpstan analyse --memory-limit=512M

```



\## Running Tests



```bash

php artisan test

```



\## Pull Request Guidelines



\- One feature or fix per PR

\- Write tests for new features

\- Run Pint and PHPStan before submitting

\- Write clear commit messages following Conventional Commits

