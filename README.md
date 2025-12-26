# V Car Rental System

A modern, full-featured car rental management platform built with **Laravel 11**, **Inertia.js**, **Vue 3**, and **Tailwind CSS**.

![V Car Rental Logo](/public/Logo.svg)

## 🚀 Features

### 👤 Customer Frontend
- **Landing Page**: Modern welcome page featuring highlighted vehicles.
- **Car Catalog**: Browse available cars with search functionality and pagination.
- **Car Details**: View detailed specifications (transmission, seats, etc.) and images.
- **Booking System**: 
  - Interactive date selection.
  - Automatic price calculation based on rental duration.
  - Login/Register prompt for unauthenticated users.
- **My Bookings**: Customers can view their booking history and current status.
- **Notifications System**: Real-time updates for booking status changes and confirmations.
- **Responsive Design**: Fully optimized for mobile and desktop devices.
- **Dark Mode**: Seamless support for light and dark themes.

### 🛠 Admin Dashboard
- **Dashboard Overview**: Key metrics and quick links.
- **Fleet Management**: Add, edit, and manage cars (pricing, status, details).
- **Booking Management**: View and update booking statuses (Pending, Confirmed, Completed, Cancelled).
- **Driver Management**: Manage driver records.
- **Reports**:
  - **Payment Details**: Revenue analysis.
  - **Transactions**: Detailed transaction logs.
  - **Car Reports**: Performance and booking frequency per vehicle.
- **Settings**: System configuration.

## 💻 Tech Stack

- **Backend**: Laravel 11 (PHP)
- **Frontend**: Vue.js 3, Inertia.js (SSR)
- **Styling**: Tailwind CSS
- **Database**: MySQL / SQLite
- **Authentication**: Laravel Breeze

## ⚙️ Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/car-rental.git
   cd car-rental
   ```

2. **Install Backend Dependencies**
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Configure your database settings in the `.env` file.*

5. **Database Migration & Seeding**
   ```bash
   php artisan migrate --seed
   ```

6. **Build Assets**
   ```bash
   npm run build
   ```

7. **Run the Application**
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` in your browser.


## 🔐 Default Credentials (Seeder)

If you ran the seeder, you can log in with:
- **Email**: `admin@example.com`
- **Password**: `password`

## 📸 Screenshots

![Dashboard Overview](dashboard%20-%20cover.png)
![Frontend Overview](frontend%20-%20cover.png)

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
