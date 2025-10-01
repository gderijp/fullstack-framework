# Recipe app // fullstack framework
CRUD Browser application where the user can manage their recipes and filter by specifying which kitchen it originates from

Built using self-built MVC fullstack framework, using Twig Templates and RedBeanPHP ORM

## Features
- __User Authentication__
  - User registration and login

- __Recipe Management__
  - View all recipes
  - Create new recipes
  - Edit existing recipes

- __Kitchen Management__
  - View all available kitchens
  - Add new kitchen types with descriptions
  - Edit kitchen information
  - View recipes associated with each kitchen

## Tech Stack
- __Backend Framework__: Custom PHP MVC Framework
- __Template Engine__: Twig
- __Database ORM__: RedBeanPHP
- __Database__: MySQL

## Installation
1. Clone this repository
2. Configure your web server (Apache) to point to the `public` directory
3. Install dependencies:
   ```
   composer install
   ```
4. Set up your MySQL database:
   - Create a database named 'fullstack_framework'
   - Configure database credentials in `BaseController.php`:
     ```php
     R::setup('mysql:host=localhost;dbname=fullstack_framework', 'bit_academy', 'bit_academy');
     ```
5. Seed the database:
    ```
    php seeder.php
    ```

## Development Setup
1. Configure your virtual host to point to the `public` directory
2. The `.htaccess` file in the public directory handles URL rewriting

## Usage
1. Start your web server (like apache)
2. Access the application through your configured domain
3. Default test user credentials:
    - Username: test
    - Password: test


## Contributing
Feel free to submit issues and pull requests.