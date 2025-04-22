-- Uppdatera social_posts-tabellen med rätt kolumner
ALTER TABLE social_posts 
ADD COLUMN user_id INT NOT NULL AFTER post_id,
ADD COLUMN content TEXT NOT NULL AFTER user_id,
ADD FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE;

-- Kontrollera om comments-tabellen har rätt struktur
CREATE TABLE IF NOT EXISTS comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES social_posts(post_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Kontrollera om kudos-tabellen har rätt struktur
CREATE TABLE IF NOT EXISTS kudos (
    kudos_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES social_posts(post_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    UNIQUE KEY unique_kudos (post_id, user_id)
); 