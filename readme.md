# IFMSA CZ - PRET/TNT Website

Simple website presenting two events (PRET, TNT) hosting by IFMSA CZ with registration system.

## Installation

1. Clone the git repository
2. Run `composer install`
3. Create a database and fill in the access information in `app/config/config.local.neon` (for an example, see `app/config/config.local.neon.example`)
4. Setup the database schema by running `php www/index.php orm:schema-tool:update --force`

Do not forget to make directories `temp/` and `log/` writable.

## Web Server Setup

The simplest way to get started is to start the built-in PHP server in the root directory of your project:

	php -S localhost:4000 -t www

Then visit `http://localhost:4000` in your browser to see the welcome page.

## Security Warning

It is CRITICAL that whole `app/`, `log/` and `temp/` directories are not accessible directly via a web browser. See [security warning](https://nette.org/security-warning).


## Requirements

PHP 7.0 or higher.

## License

[MIT License](LICENSE)
