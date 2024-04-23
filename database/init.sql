CREATE TABLE addresses_book (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    surname TEXT,
    phone TEXT,
    email TEXT,
    address TEXT
);

INSERT INTO addresses_book (id, name, surname, phone, email, address) VALUES (1, 'Nick', 'Bahdanau', '576-335-296', 'mikalai.bahdanau@gmail.com', 'os. Kaszubskie 19, Wejherowo.');
INSERT INTO addresses_book (id, name, surname, phone, email, address) VALUES (2, 'Programista', '3E', '', '', '');
