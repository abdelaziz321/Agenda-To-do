# Agenda
A simple app to manage your tasks built with Laravel framework 5.5

## Demo video

[Youtube](https://www.youtube.com/watch?v=dv5ykNiLdZM)


## Installation

1- Clone the repository

```
https://github.com/abdelaziz321/Agenda-To-do
```

2- change the directory into Agenda folder

```
cd Agenda
```

3- install the dependencies by running Composer's install command

```
composer install
```

4- create an environment file

```
cp .env.example .env
```

5- edit `.env` file with appropriate credential for your database server - these parameter(`DB_USERNAME`, `DB_PASSWORD`).

6- create a database named `agenda`

7- migrate your database

```
php artisan migrate
```

8- generate the application key.

```
php artisan key:generate
```

9- Run the server

```
php artisan serve
```

10- Now go to `http://localhost:8000` from your browser.

## Screenshots

![View Tasks](/screenshots/tasks.jpg)

![Create Task](/screenshots/task.jpg)

![Create Note](/screenshots/sidebar.jpg)

![View Notes](/screenshots/notes.jpg)

![Edit Profile](/screenshots/edit.jpg)



## Ask a question?

If you have any question, contact me via my email:
> abdelazizmahmoud321@gmail.com
