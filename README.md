# Tobazone v6.3.2021

Tobazone v6.3.2021 is a duplication project of [Tobazone](https://github.com/chandrasitinjak/tobazone). The purpose of this project is just to complete final project about software testing.

## Prerequisite

-   PHP 7.4.1
-   Node JS 8.10.0
-   NPM 3.5.2
-   Composer 1.6.3
-   Maria DB 5.7.24

## Installation

-   Clone this project, run `git clone https://github.com/chandrasitinjak/tobazone.git`
-   Run `composer install` to download all PHP dependencies
-   Run `npm install` to download all the Node JS dependencies
-   Copy `.env.example` to `.env`, if you using Unix terminal just run `cp .env.example .env`
-   Run `php artisan key:generate` to generate `APP_KEY` in `.env` file

## Migration

-   Run `php artisan migrate --seed` to generate the database schema and run the database seeder

## Run

-   Run `php artisan serve` to start the PHP server
-   Run `npm run watch` to start the Node JS server to compile the Vue JS components

## Create branch

-   Run `git branch nama-branch`
-   Run `git checkout nama-branch`

## Push to Github

-   Run `git status`
-   Run `git add .`
-   Run `git commit -m "comment perubahan"`
-   Run `git push origin nama-branch`
