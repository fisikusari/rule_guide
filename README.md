<!-- ABOUT THE PROJECT -->

## About The Project

This is a test project.

### Built With

PHP Symfony

<!-- GETTING STARTED -->

## Getting Started

1. Clone the project from github link -> 'https://github.com/fisikusari/rule_guide.git'
2. Change directory to rule_guide
3. Run docker-compose up -d
4. Change directory to rule_guide/app and run composer install

<!-- USAGE EXAMPLES -->

## Usage

The project is using http://localhost:8080 port.
To test the api use the postman and send request to (http://localhost:8080/rule-engine) route.
Request method is POST and the requeired fields are:

1. email
2. password
3. dependencies (file)
4. repositoryName
5. commitName

Note: to get login access you should have an account on (https://debricked.com/).
