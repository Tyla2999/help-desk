USE help_desk;

CREATE TABLE IF NOT EXISTS employee_ideas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(120) NOT NULL,
    description VARCHAR(500) NOT NULL,
    vote_count INT UNSIGNED NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    CONSTRAINT fk_employee_ideas_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
