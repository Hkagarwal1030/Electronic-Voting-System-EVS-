-- run in your MySQL client for database evs_db
CREATE DATABASE IF NOT EXISTS evs_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE evs_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  has_voted TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE candidates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  party VARCHAR(150),
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE votes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  candidate_id INT NOT NULL,
  voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_user (user_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (candidate_id) REFERENCES candidates(id) ON DELETE CASCADE
);

CREATE TABLE settings (
  id TINYINT PRIMARY KEY DEFAULT 1,
  voting_open TINYINT(1) DEFAULT 1
);

CREATE TABLE jobs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200),
  company VARCHAR(200),
  location VARCHAR(150),
  description TEXT,
  posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default setting row
INSERT INTO settings (id, voting_open) VALUES (1,1) ON DUPLICATE KEY UPDATE voting_open=voting_open;

-- Sample candidates
INSERT INTO candidates (name, party, description)
VALUES ('Alice Kumar', 'Party A', 'Experienced community leader'),
       ('Brijesh Singh', 'Party B', 'Focus on education and jobs'),
       ('Celine Rao', 'Independent', 'Youth-oriented candidate');

-- Sample jobs (for dynamic job display)
INSERT INTO jobs (title, company, location, description)
VALUES 
('Junior Web Developer', 'Acme Pvt Ltd', 'Chennai', '2 yrs exp, PHP, JS'),
('Data Analyst Intern', 'DataByte', 'Bengaluru', 'Internship, Excel/SQL'),
('Frontend Developer', 'UIWorks', 'Remote', 'React.js experience preferred');
