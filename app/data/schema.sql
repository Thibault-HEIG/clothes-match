USE my_database;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    last_prefered_season INT, -- Entre 5°C et 30°C
    last_color_harmony_importance DOUBLE, -- [0,1]
    last_season_harmony_importance DOUBLE -- [0,1]
);

CREATE TABLE IF NOT EXISTS clothes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    img_url VARCHAR(500) NOT NULL,
    category VARCHAR(20) NOT NULL,
    season INT NOT NULL,
    hue DOUBLE NOT NULL,
    saturation DOUBLE NOT NULL,
    brightness DOUBLE NOT NULL,
    user_rate INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE IF NOT EXISTS results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_top INT NOT NULL,
    id_bottom INT NOT NULL,
    id_shoes INT NOT NULL,
    id_jacket INT,
    id_accessory INT,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    FOREIGN KEY (id_top) REFERENCES clothes (id),
    FOREIGN KEY (id_bottom) REFERENCES clothes (id),
    FOREIGN KEY (id_shoes) REFERENCES clothes (id),
    FOREIGN KEY (id_jacket) REFERENCES clothes (id),
    FOREIGN KEY (id_accessory) REFERENCES clothes (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);
