# BE HPAI Test API Documentation

## Project Overview

This project is a Laravel-based REST API that includes user authentication, role-based access control, and user management.

## Features

- User authentication using Laravel Passport.
- Role-based access control (`admin`, `super-admin`, `regular`).
- CRUD operations for users with restricted access.
- Token-based authentication.
- User profile management.
- Password update functionality.

## Installation

### Prerequisites

- PHP 8+
- Composer
- Laravel 11
- MySQL or PostgreSQL database
- Docker

### Setup

#### Deploy with Docker

1. Clone repository

2. No need to run `compose install`

3. Copy the `.env` file and configure database settings:

    ```sh
    cp .env.example .env
    ```

    Change the DB Host into **db**
    You can customize the username and password

4. Run on CLI

    ```sh
    docker compose up -d
    ```

    By default you can access the API on **http://localhost:8012**

    This will create an user with `super-admin` role. You can log in and add other user.
    | email | password |
    | ------------- | -------------- |
    | admin@mail.com | Admin1234! |

    > Customize the port by changing conf on directory nginx/ and customize the docker compose on nginx service

#### Running locally

1. Clone the repository:

2. Install dependencies:

    ```sh
    composer install
    ```

3. Copy the `.env` file and configure database settings:

    ```sh
    cp .env.example .env
    ```

4. Generate application key:

    ```sh
    php artisan key:generate
    ```

5. Run database migrations and seeders:

    ```sh
    php artisan migrate --seed
    ```

    This will create an user with `super-admin` role. You can log in and add other user.
    | email | password |
    | ------------- | -------------- |
    | admin@mail.com | Admin1234! |

6. Install Passport:

    ```sh
    php artisan passport:install
    php artisan passport:client --personal
    ```

7. Start the server:

    ```sh
    php artisan serve
    ```

## API Endpoints

### Authentication

| Method | Endpoint                    | Description                  | Middleware |
| ------ | --------------------------- | ---------------------------- | ---------- |
| POST   | `/api/auth/login`           | Login user and get token     | None       |
| GET    | `/api/auth/me`              | Get authenticated user       | `auth:api` |
| POST   | `/api/auth/logout`          | Logout user and revoke token | `auth:api` |
| POST   | `/api/auth/change-password` | Change user password         | `auth:api` |
| PUT    | `/api/auth/update`          | Update user profile          | `auth:api` |

### User Management (Admin & Super Admin Only)

| Method | Endpoint          | Description       | Middleware                         |
| ------ | ----------------- | ----------------- | ---------------------------------- |
| GET    | `/api/users`      | Get list of users | `auth:api, role:admin,super-admin` |
| GET    | `/api/users/{id}` | Get user details  | `auth:api, role:admin,super-admin` |
| POST   | `/api/users`      | Create a new user | `auth:api, role:admin,super-admin` |
| DELETE | `/api/users/{id}` | Delete user       | `auth:api, role:admin,super-admin` |

## Middleware

- **`auth:api`** → Ensures the request is authenticated via Passport.
- **`role:admin,super-admin`** → Restricts access to users with `admin` or `super-admin` roles.

## Running Tests

Run the feature tests:

Please change to you database name on phpunit.xml
For better testing, create env.testing

```sh
php artisan test
```

## Testing Coverage

- Authentication (Login, Logout, Me, Change Password, Update Profile)
- User Management (CRUD with role-based access)
- Middleware Enforcement

---

🚀 **Happy coding!**
