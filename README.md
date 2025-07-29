# Service Booking System API

A Laravel-based RESTful API for managing service bookings with user authentication and role-based access control.

## Features

- **User Authentication**
  - User registration and login with token-based authentication (Laravel Sanctum)
  - Role-based access control (Customer and Admin roles)
  - Secure password hashing and token management

- **Service Management** (Admin only)
  - Create, read, update, and delete services
  - View all services with details

- **Booking Management**
  - Customers can book available services
  - View personal booking history
  - Admin can view all bookings
  - Validation to prevent past date bookings

## API Endpoints

### Authentication
- `POST /api/register` - Register a new user
- `POST /api/login` - Login and get access token
- `POST /api/logout` - Invalidate the current token
- `GET /api/user` - Get authenticated user details

### Services (Public)
- `GET /api/services` - List all available services
- `GET /api/services/{id}` - Get service details

### Bookings (Authenticated Users)
- `GET /api/bookings` - List user's bookings
- `GET /api/bookings/{id}` - Get booking details
- `POST /api/bookings` - Create a new booking

### Admin Endpoints
- `POST /api/services` - Create a new service (Admin only)
- `PUT /api/services/{id}` - Update a service (Admin only)
- `DELETE /api/services/{id}` - Delete a service (Admin only)
- `GET /api/admin/bookings` - List all bookings (Admin only)
- `GET /api/users` - List all users (Admin only)

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL/SQLite
- Laravel 10.x

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/hannanmiah/service-booking.git
   cd service-booking
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Configure your database in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=service_booking
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```
   This will create an admin user with the following credentials:
   - Email: admin@admin.com
   - Password: password

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Testing

Run the test suite to ensure everything is working correctly:

```bash
php artisan test
```

## API Documentation

For detailed API documentation, please refer to the Postman collection or import the following cURL commands:

### Register a new user
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","email":"test@example.com","password":"password","password_confirmation":"password"}'
```

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'
```

### Get available services
```bash
curl -X GET http://localhost:8000/api/services \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN"
```
### Get all bookings as admin
```bash
curl -X GET http://localhost:8000/api/admin/bookings \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN"
```

## Security

- All sensitive data is encrypted
- Password hashing using bcrypt
- CSRF protection
- Rate limiting on authentication endpoints
- Input validation on all endpoints

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-source and available under the [MIT License](LICENSE).

## Acknowledgments

- Built with [Laravel](https://laravel.com/)
- Authentication powered by [Laravel Sanctum](https://laravel.com/docs/sanctum)

## Frontend
It is recommended to use Nuxt for the frontend.
My frontend repo is [here](https://github.com/hannanmiah/service-booking-frontend)

## Testing

Run the test suite to ensure everything is working correctly:

```bash
php artisan test
```