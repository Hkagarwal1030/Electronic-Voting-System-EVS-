# Electronic-Voting-System-EVS
🗳️ Electronic Voting System (EVS) – PHP + MySQL
















A secure and user-friendly Online Voting System (EVS) developed using PHP and MySQL.
The system allows registered users to log in, vote once, view election results, and browse candidates.
It includes an Admin Panel, dynamic candidate list, and job display (as defined in your database schema).

✨ Features
👥 User Features

User Registration (Name, Email, Password)

Login using secure hashed passwords

Single-vote protection (has_voted flag)

View all candidates

Cast vote securely (prevents multiple votes)

View live election results

Logout with session handling

🗳️ Voting System Features

One person can vote only once

Votes linked to user ID (foreign key)

Candidates stored in dedicated table

Voting enabled/disabled via settings table

Vote timestamp stored for audit purposes

👨‍💼 Admin Features

Manage candidates

View total votes

Manage election status (voting_open)

View jobs (dynamic job listings)

🛠 Database-Driven System

Your schema file init.sql defines:
✔ users table
✔ candidates table
✔ votes table
✔ settings table
✔ jobs table
✔ Sample candidates
✔ Sample job listings


init

📂 Project Structure
/online-voting-system
│── index.php           → Homepage / Login interface
│── register.php        → User registration
│── login.php           → Authentication logic
│── logout.php          → End user session
│── vote_process.php    → Voting logic (one vote per user)
│── candidates.php      → Show candidate list
│── results.php         → Display election results
│── admin.php           → Admin dashboard
│── db.php              → Database configuration
│── init.sql            → Database schema & sample data
│── README.md

🗄️ Database Setup

Run the SQL script inside init.sql:


init

CREATE DATABASE evs_db;
USE evs_db;

-- Tables: users, candidates, votes, settings, jobs
-- Inserts sample candidates & jobs


This file contains all required tables and demo content.

⚙️ Configuration

In db.php, configure database credentials:

$conn = new mysqli("localhost", "root", "", "evs_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

🚀 How to Run

1️⃣ Place project inside your server directory

For XAMPP:

htdocs/online-voting-system/

2️⃣ Start Apache & MySQL

3️⃣ Import the database

Open phpMyAdmin → Import → choose init.sql.

4️⃣ Launch the system

Visit:

http://localhost/online-voting-system/

5️⃣ Register → Login → View Candidates → Cast Vote → View Results
🔐 Security & Logic Highlights

✔ Passwords hashed (password_hash)
✔ One-vote-per-user enforced via:

has_voted flag in users table

Unique constraint in votes table on user_id
✔ SQL constraints ensure data integrity
✔ Voting disabled via settings table
✔ Admin-only sections possible (login gates recommended)

📌 Future Enhancements

Admin login security

Add/update/delete candidates

Role-based access control

Chart-based visual results

Full mobile-responsive UI

Email confirmation for registration

OTP login for verification

Blockchain-inspired vote hashing (advanced)

🤝 Contributing

Contributions are welcome!

Fork the repository

Create a new branch

Commit enhancements

Open a Pull Request

📄 License

This project is licensed under the MIT License.
