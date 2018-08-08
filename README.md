# Konnektis Technical Task

A simple application to add, remove and manage contacts. Built in Vue.js and Laravel.

## Build Instructions

You'll need:

* Vagrant (https://www.vagrantup.com)
* VirtualBox (https://www.virtualbox.org)
* PHP >= 7.1 (on a Mac, you can upgrade with Homebrew or with the package provided by [Marc Liyanage](http://php-osx.liip.ch))
* Node.js and NPM (https://nodejs.org/en/download)

**Step 1: Composer and NPM dependencies**

```
$ composer install
$ npm install
```

**Step 2: Environment Information**

```
$ cp .env.example .env
$ php artisan key:generate
```

**Step 3: Homestead Configuration**

```
$ php vendor/bin/homestead make
$ vim Homestead.yaml # Modify this file if required
$ vagrant up
```

**Step 4: Compile Assets**

```
$ npm run dev
```

**Step 5: Seed the Database**

```
$ vagrant ssh
$ cd code
$ art db:seed
```

## Licence Information

This project is made available under the terms of the MIT license - see the LICENCE.md file for details.
