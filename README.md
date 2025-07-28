# Task: Simple Service Booking System
## Project Description:
You are required to build a basic API-based & Admin managed service booking
system using Laravel. The system should allow customers to register, view
services, and make bookings. Admin should be able to manage services and view
bookings. This task will help us evaluate your development skills, along with your
code organization and Git practices.
## Core Requirements:
Your application should include the following features:

1. Authentication (Laravel Sanctum or Passport)
   ● User registration & login API (as Customer)
   ● Admin login API (credentials can be seeded)
   ● JWT or token-based authentication
2. Models & Relationships
   ● User (customer)
   ● Admin (can be just a role flag on users table or a separate model)
   ● Service (id, name, description, price, status)
   ● Booking (id, user_id, service_id, booking_date, status)
3. API Endpoints (Examples)
   Public:
   ● POST /api/register – Customer registration
   ● POST /api/login – Login
   Authenticated (Customer):
   ● GET /api/services – List available services
   ● POST /api/bookings – Book a service

    ● GET /api/bookings – List logged-in user's bookings
    Authenticated (Admin):
    ● POST /api/services – Create a new service
    ● PUT /api/services/{id} – Update service
    ● DELETE /api/services/{id} – Delete service
    ● GET /api/admin/bookings – List all bookings

4. Validation
   ● Proper form request validation for all input.
   ● Prevent booking a service on a past date.
5. Database Seeder
   ● Seed a few services and an admin user.
6. API Documentation
   ● Provide clear and complete API documentation using one of the following:
   ○ Postman Collection with example requests/responses and
   environment variables.
   ○ Swagger/OpenAPI documentation (bonus).
   ○ Include instructions in the README for how to test the APIs.

7. Unit test (optional but bonus)
   ● Provide clear and complete unit test using phpunit/pest
8. Live Link (optional but bonus)
   ● Host you project in any hosting platform and send us the Live Link

## Bonus Points for:
    ● Following Laravel naming conventions and RESTful design.
    ● Using FormRequest classes for validation.
    ● Organized code with service/repository pattern.
    ● Unit or feature tests.
    ● API Resource classes for clean response formatting.