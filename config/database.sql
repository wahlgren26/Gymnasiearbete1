-- Skapa databas
CREATE DATABASE IF NOT EXISTS gymlog CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci;

-- Använd databasen
USE gymlog;

-- Skapa användartabell
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    join_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    profile_image VARCHAR(255) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    age INT DEFAULT NULL,
    height INT DEFAULT NULL,
    weight DECIMAL(5,2) DEFAULT NULL
);

-- Skapa tabell för träningsmål
CREATE TABLE IF NOT EXISTS goals (
    goal_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    goal_name VARCHAR(100) NOT NULL,
    description TEXT,
    target_value DECIMAL(10,2),
    current_value DECIMAL(10,2) DEFAULT 0,
    goal_type ENUM('strength', 'weight', 'reps', 'distance', 'time', 'other') NOT NULL,
    start_date DATE NOT NULL,
    target_date DATE,
    completed BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Skapa tabell för träningspass
CREATE TABLE IF NOT EXISTS workout_sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_date DATE NOT NULL,
    session_name VARCHAR(100) NOT NULL,
    duration INT DEFAULT NULL,
    notes TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Skapa tabell för övningar
CREATE TABLE IF NOT EXISTS exercises (
    exercise_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    muscle_group VARCHAR(50),
    equipment VARCHAR(50),
    difficulty_level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'intermediate'
);

-- Skapa tabell för träningspassets övningar
CREATE TABLE IF NOT EXISTS workout_exercises (
    workout_exercise_id INT AUTO_INCREMENT PRIMARY KEY,
    session_id INT NOT NULL,
    exercise_id INT NOT NULL,
    sets INT NOT NULL DEFAULT 1,
    reps INT,
    weight DECIMAL(6,2),
    duration INT,
    distance DECIMAL(6,2),
    notes TEXT,
    FOREIGN KEY (session_id) REFERENCES workout_sessions(session_id) ON DELETE CASCADE,
    FOREIGN KEY (exercise_id) REFERENCES exercises(exercise_id)
);

-- Skapa tabell för viktloggar
CREATE TABLE IF NOT EXISTS weight_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    log_date DATE NOT NULL,
    notes TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Skapa tabell för personliga rekord
CREATE TABLE IF NOT EXISTS personal_bests (
    pb_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    exercise_id INT NOT NULL,
    value DECIMAL(6,2) NOT NULL,
    achieved_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (exercise_id) REFERENCES exercises(exercise_id),
    UNIQUE KEY unique_pb (user_id, exercise_id)
);

-- Skapa tabell för framstegsdiagram
CREATE TABLE IF NOT EXISTS progress_tracking (
    progress_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    exercise_name VARCHAR(100) NOT NULL,
    progress_value INT NOT NULL DEFAULT 0,
    color_class VARCHAR(50) DEFAULT '',
    display_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Create table for social posts
CREATE TABLE IF NOT EXISTS social_posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    post_type ENUM('workout', 'achievement', 'update') NOT NULL DEFAULT 'workout',
    workout_id INT DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Create table for kudos (likes)
CREATE TABLE IF NOT EXISTS kudos (
    kudos_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES social_posts(post_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    UNIQUE (post_id, user_id)
);

-- Create table for comments
CREATE TABLE IF NOT EXISTS comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES social_posts(post_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Lägg till några grundläggande övningar i övningstabellen
INSERT INTO exercises (name, muscle_group, equipment, difficulty_level) VALUES
('Bänkpress', 'Bröst', 'Skivstång', 'intermediate'),
('Marklyft', 'Rygg', 'Skivstång', 'intermediate'),
('Knäböj', 'Ben', 'Skivstång', 'intermediate'),
('Pull-ups', 'Rygg', 'Räcke', 'intermediate'),
('Pushups', 'Bröst', 'Kroppsvikt', 'beginner'),
('Biceps Curl', 'Armar', 'Hantlar', 'beginner'),
('Triceps Extension', 'Armar', 'Kabel', 'beginner'),
('Axelpress', 'Axlar', 'Hantlar', 'intermediate'),
('Utfall', 'Ben', 'Kroppsvikt', 'beginner'),
('Plankan', 'Core', 'Kroppsvikt', 'beginner');