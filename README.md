# UM6P Equipment Inventory Management System

A comprehensive web-based system for tracking IT equipment, movements, maintenance records, and status changes at Université Mohammed VI Polytechnique.

![UM6P Logo](public\favicon.ico)

## Overview

The Equipment Inventory Management System is designed to help UM6P's IT Department efficiently manage their technological assets. The system provides tools for tracking equipment details, recording movements, scheduling maintenance, and managing the complete lifecycle of IT assets.

## Features

- **Equipment Management**: Add, view, edit, and delete equipment with detailed information including name, brand, model, serial number, and MAC address.
- **Category Organization**: Group equipment into logical categories for better classification and reporting.
- **Status Tracking**: Define custom equipment statuses with color coding for visual identification.
- **Movement History**: Record and track all equipment movements, including entries, exits, and maintenance transfers.
- **Maintenance Records**: Document maintenance activities, issues, and resolutions for each equipment item.
- **Search and Filter**: Quickly find equipment based on various criteria with advanced search and filtering options.
- **Responsive Design**: Access the system from various devices with a mobile-friendly interface.
- **User Authentication**: Secure login system with different access levels for administrators and staff.

## Technology Stack

- **Backend**: PHP 8.1, Laravel 10.x
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Database**: MySQL 8.0
- **Tools**: Composer, npm, Git

## Installation

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js and npm

### Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/s4nji1/gestion-inventaire-reseau.git
   cd gestion-inventaire-reseau
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Compile assets:
   ```bash
   npm run dev
   ```

5. Create a copy of the .env file:
   ```bash
   cp .env.example .env
   ```

6. Generate application key:
   ```bash
   php artisan key:generate
   ```

7. Configure your database in the .env file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=equipment_inventory
   DB_USERNAME=root
   DB_PASSWORD=
   ```

8. Run database migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

10. Access the application at: `http://localhost:8000`

## Default Login Credentials

- **Administrator**:
  - Email: admin@um6p.ma
  - Password: password

- **Staff**:
  - Email: staff@um6p.ma
  - Password: password

## Database Schema

The system uses the following main tables:

- `equipment`: Stores details about each equipment item
- `categories`: Defines equipment categories
- `statuses`: Defines possible equipment statuses
- `movements`: Records equipment movements
- `maintenance_records`: Documents maintenance activities
- `users`: Stores user information

## System Architecture

The application follows the MVC (Model-View-Controller) architecture provided by Laravel:

- **Models**: Define the data structure and relationships
- **Views**: Blade templates for the user interface
- **Controllers**: Handle business logic and route requests

## Usage Examples

### Adding New Equipment

1. Navigate to Equipment > Add New
2. Fill in the equipment details
3. Select a category and initial status
4. Click "Create Equipment"

### Recording a Movement

1. Navigate to Movements > Record Movement
2. Select the equipment to move
3. Choose the movement type and destination status
4. Add optional notes
5. Click "Save Movement"

### Creating a Maintenance Record

1. Navigate to Maintenance > New Record
2. Select the equipment
3. Enter issue details and maintenance type
4. Set start date and status
5. Click "Create Record"

## Contributing

If you'd like to contribute to this project, please follow these steps:

1. Fork the repository
2. Create a new branch (`git checkout -b feature/your-feature-name`)
3. Make your changes
4. Commit your changes (`git commit -m 'Add some feature'`)
5. Push to the branch (`git push origin feature/your-feature-name`)
6. Open a Pull Request

## License

This project is proprietary and belongs to UM6P. All rights reserved.

## Author

SANJI - Developed during an internship at UM6P's IT Department.

## Acknowledgements

- The IT Department at UM6P for their support and guidance
- Laravel team for the excellent framework
- Bootstrap team for the frontend components