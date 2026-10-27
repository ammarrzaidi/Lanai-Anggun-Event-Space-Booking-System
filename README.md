# Lanai Anggun Event Space Booking System

A comprehensive, web-based event space booking and management system built with **PHP** and **MySQL**. This project was developed as my **Bachelor's Degree Final Year Project**, designed to streamline the entire reservation lifecycle—from user registration and hall catalog browsing to secure payment processing and administrative management.

---

## Features

### User Features
* **User Authentication:** Secure user registration, login, logout, password recovery, and profile management (`signup.php`, `login.php`, `forgot-password.php`, `profile.php`).
* **Catalog & Hall Layout:** Browse available event spaces/halls with detailed views (`catalog.php`, `hall-layout.php`).
* **Booking System:** Interactive event booking workflow allowing users to select dates, times, and space requirements (`book-event.php`, `process-book.php`).
* **Booking Management:** View past and upcoming bookings (`myBooking.php`).
* **Payment Integration:** Secure checkout and payment confirmation workflows (`payment.php`, `process_payment.php`, `payment_success.php`).
* **Reviews & Messaging:** Submit reviews for spaces and contact support or administrators (`review.php`, `message-us.php`).

### Administrative Features
* **Admin Authentication:** Secure admin login portal (`adminlogin.php`).
* **Management Dashboard:** Manage bookings, user accounts, system catalogs, and view system analytics.

---

## Project Structure

```text
Lanai-Anggun-Event-Space-Booking-System/
│
├── admin/                  # Administrative backend panels and scripts
├── backend/                # Core backend processing scripts and logic
├── css/                    # Stylesheets for frontend styling
├── fonts/                  # Custom typography and font assets
├── images/ & img/          # UI graphics, hall photos, and static media
│
├── adminlogin.php          # Administrator login portal
├── book-event.php          # Event booking interface
├── catalog.php             # Event space catalog
├── change-password.php     # Password update utility
├── confirmation.php        # Booking confirmation page
├── hall-layout.php         # Hall layout & seating configurations
├── index.php               # Landing page / home screen
├── login.php               # User login page
├── myBooking.php           # User booking history dashboard
├── obbs.sql                # Database schema and initial data dump
├── payment.php             # Checkout and payment gateway interface
├── process-book.php        # Backend handler for booking requests
├── profile.php             # User profile management
├── review.php              # User review and rating submission
└── signup.php              # New user registration page
```

## Tech Stack
- Frontend: HTML5, CSS3, JavaScript, PHP
- Backend: PHP
- Database: MySQL / MariaDB (obbs.sql)
- Server Environment: Apache / Nginx (XAMPP, WMPP, or LAMP stack recommended)

## Installation & Setup
1. Clone the Repository:  
`git clone https://github.com/ammarrzaidi/Lanai-Anggun-Event-Space-Booking-System.git`
2. Move to Server Directory
3. Place the project folder inside your local server directory (e.g., htdocs for XAMPP).

## Configure the Database:
1. Open your database manager (e.g., phpMyAdmin).
2. Create a new database named (e.g., obbs_db).
3. Import the obbs.sql file provided in the root directory to set up the necessary tables and structure.
4. Update Database Connection:
5. Locate the database configuration file (typically inside the backend/ directory or connection scripts).
6. Update your database credentials (host, username, password, dbname) to match your local environment.

## Run the Application:
1. Start your Apache and MySQL services via XAMPP/WAMP.
2. Open your browser and navigate to:  
http://localhost/Lanai-Anggun-Event-Space-Booking-System/

## License
This project is open-source and available for educational and portfolio purposes.

## Acknowledgments

I would like to express my sincere gratitude to **[Lanai Anggun Event Space](https://www.instagram.com/lanaianggunecosky)** for giving me the opportunity and trust to develop this project as part of my Bachelor's Degree Final Year Project. Their cooperation and real-world insights were instrumental in shaping the features and functionality of this booking system.


