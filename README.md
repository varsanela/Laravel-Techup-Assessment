# Installation

Step 1: Setup this project into your local machine. <br />
Step 2: Install the composer if you don't have it and run the "composer dump-autoload" to install the project dependencies. <br />
Step 3: Copy the .env.example to .env file under the root path and create a database to configure the same in .env file. <br />
Step 4: Run the command "php artisan migrate" to create the tables in the database. <br />
Steo 5: Run the command "php artisan passport:install" to install the client passport tokens. <br />
Step 6: Run the command "php artisan db:seed" to create a demo user detail for login purpose.

# DEMO Login

Email: testuser@gmail.com
Password: testuser@321?!

# REST APIs

Please find the list of APIs used in this project below. <br />

1. <project url with public>/api/login [POST]
2. <project url with public>/api/regsiter [POST]
3. <project url with public>/api/tasks/create [POST]
4. <project url with public>/api/tasks/list [GET]

# Login API

<b>URL:</b> /api/login <br />
<b>METHOD:</b> POST <br />
<b>REQUEST PARAMETERS:</b> <br />

  <p>
  1. email <br />
  2. password
  </p>
  
# Register API
  
  <b>URL:</b> /api/register <br />
  <b>METHOD:</b> POST <br />
  <b>REQUEST PARAMETERS:</b>  <br />
  <p>
  1. name <br />
  2. email <br />
  3. password
  </p>
  
# Create Tasks with Notes API
  
  <b>URL:</b> /api/tasks/create <br />
  <b>METHOD:</b> POST <br />
  <b>HEADER:</b> Authorization: Bearer [token] <br />
  <b>REQUEST PARAMETERS:</b>  <br />
  <p>
  1. subject <br />
  2. description <br />
  3. start_date <br />
  4. due_date <br />
  5. status <br />
  6. priority <br />
  7. notes (multiple array) <br />
      7.1. subject <br />
      7.2. attachments <br />
      7.3. note <br />
  </p>
  
# Retrieve Tasks with Notes API
  
  <b>URL:</b> /api/tasks/list <br />
  <b>METHOD:</b> GET <br />
  <b>HEADER:</b> Authorization: Bearer [token] <br />
  <b>REQUEST PARAMETERS:</b>  <br />
  <p>
  1. filter[status] <br />
  2. filter[due_date] <br />
  3. filter[priority] <br />
  4. filter[notes] (set to 'true') <br />
