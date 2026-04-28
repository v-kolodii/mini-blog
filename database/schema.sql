DROP TABLE IF EXISTS post_category;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    description TEXT NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE posts (
                  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  title VARCHAR(255) NOT NULL,
                  description TEXT NOT NULL,
                  content LONGTEXT NOT NULL,
                  image VARCHAR(255) NULL,
                  views_count INT UNSIGNED NOT NULL DEFAULT 0,
                  published_at DATETIME NOT NULL,
                  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  INDEX idx_published_at (published_at DESC),
                  INDEX idx_views_count (views_count DESC)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE post_category (
                  post_id INT UNSIGNED NOT NULL,
                  category_id INT UNSIGNED NOT NULL,
                  PRIMARY KEY (post_id, category_id),
                  INDEX idx_category_id (category_id),
                  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
                  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;