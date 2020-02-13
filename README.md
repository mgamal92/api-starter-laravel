# Barista API

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com)
[![Only 32 Kb](https://badge-size.herokuapp.com/Naereen/StrapDown.js/master/strapdown.min.js)](https://github.com/Naereen/StrapDown.js/blob/master/strapdown.min.js)

Create your API with few touches to use it in your next project wether it is a frontend app or mobile app without anymore headache of development life cycle of API developement. Also there is **no** fighting between the backend developer and the mobile app developer .

## Features

- Easy Dashboard UI to generate your API endpoints
- Create basic API endpoints with field validation
    1. Insert **model name** with its fields and type with validation
    2. Endpoints for ```create```, ```retrieve```, ```update```, ```delete``` and ```show``` or any other methods in controller
- ```/search``` endpoint by **specific fields**
- ```/sort``` endpoint by **specific fields**
- Localization with Google Translate or any translator service
- Select actions within any API endpoint, like
  - Send Email/Notification **after** creation the model
- Fully Authentication System with token
- There are some projects with some common controllers, models, etc.. so we will build **all** of them for you with one second
  - _For Example_ if you are building **blog** you will need ..
    - Models like ```Post```, ```Comment```, ```Auth```, etc... ..
    - Controller ```PostController```, ```CommentController```, ```AuthController```, etc...
    - Database Tables like ```posts```, ```comments```, ```author```

    and we will offer a lot of project templates to cover your needs

- Export API endpoints as JSON/Yaml file

## How Barista prepare your API

- There are two ways to generate your code base

- **Way #1**

    1. You should write your model name
        - _For example_ : Post
    2. Fill the fields name with its type
        - _For example_ : title with string type, etc..
    3. Finally, you should specify the validation rule for each field
       - _For example_: title will be required, unique and minimum length for it 10 letters

- **Way #2**

  - You can choose from project templates to generate some common models, controllers, tables, etc.. for you.

**Barista**, behind the scene, will cook and prepare your API endpoints, then you can list/export them and use them in your awesome project

## Installation

Run the following command

```composer require mgamal/barista```

Laravel >= 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

## Usage

Just login to the dashboard and start building your API through user interface easily.

## Development Stack

### Backend

- Laravel 6
- MySQL

### Frontend

- HTML/CSS
- JavaScript Framework (Vue.js)

## Contribution Guides

- ### Pull Requests

  - Fork the Framework repository
  - Create a new branch for your awesome work
  - Send a pull request

- ### Style Guide

  - All pull requests must adhere to the [PSR-12](https://www.php-fig.org/psr/psr-12/) standard.

- ### Unit Testing

  - All pull requests must be accompanied by passing unit tests.We are using PHPUnit for testing.

## License

- The EspressoPHP Framework is licensed under the MIT license.

### Credits

- [Blueprint Package](https://github.com/laravel-shift/blueprint)
- [Laravel Swagger Package](https://github.com/mtrajano/laravel-swagger)
