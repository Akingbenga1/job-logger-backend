# ELogBooks Backend Service using Laravel
## What does this solution do?

This solution is a simple logging application that logs jobs done in a property.

At a minimum this solution provides the ability to:

1. Create a Property (name)
2. Create a new Job by specifying a property from a drop down and add ther details (first name, last name, email, job summary, job description).

## Setup & Instruction

1. Clone the repository: `git clone https://github.com/Akingbenga1/job-logger-backend.git`
2. Assuming that the Dependencies listed above are satisfied, you can ```cd``` into the directory called ```job-logger-backend```
3. When inside this repository directory, run ```composer install``` to install the project dependencies. Please, ensure that your system has `php 8.0 and above` installed before running composer.
4. Modify the .env file and set the required database credentials.
5. Run `php artisan migrate` to generate the database tables.
6. To test, make sure you are still in this repository directory and in your terminal, to run the test suite run ```php artisan test``` for the test.
7. To start the laravel application, you can simply run `php artisan serve`. This will serve the laravel application on this url `http://127.0.0.1:8000/.`

## Task specification
There are 4 endpoints in the backend service namely: 

1. `GET: http://127.0.0.1:8000/api/properties` - for listing the properties.
2. `POST: http://127.0.0.1:8000/api/properties` - for creating a new a property. Its takes `name` parameter in the request body.
3. `GET: http://127.0.0.1:8000/api/jobs` - for listing jobs created by any user
4. `POST:http://127.0.0.1:8000/api/jobs` - for creating a new job. Its takes the following parameters in the request body `first name`, `last name`, `email`, `summary`, `description` and `property_id`
5. No need to add any other headers parameter for each api request. 
