USE my_database;

CREATE TABLE IF NOT EXISTS my_table (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    column1 TEXT NOT NULL,
    column2 INTEGER NOT NULL
);

INSERT INTO my_table (column1, column2) VALUES ('Example Text 1', 123), ('Example Text 2', 456);
