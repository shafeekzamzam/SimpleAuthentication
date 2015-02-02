This one is a simple registration and authentication system on zend framework 2
the table specification is given below under database name userdb

CREATE TABLE IF NOT EXISTS user (
id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
name TEXT NOT NULL,
email VARCHAR(255) NOT NULL,
password TEXT NOT NULL,
UNIQUE INDEX idx_email(email)
);
