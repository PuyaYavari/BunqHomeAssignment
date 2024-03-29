--
-- File generated with SQLiteStudio v3.2.1 on Sat Nov 14 13:48:55 2020
--
-- Text encoding used: System
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS User;

-- Table: Message
CREATE TABLE Message (ID INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, FROM_USER INTEGER REFERENCES User (ID) ON DELETE NO ACTION ON UPDATE CASCADE, TO_USER INTEGER REFERENCES User (ID) ON DELETE NO ACTION ON UPDATE CASCADE, BODY NVARCHAR (4000), RECEIVED_BY_BACKEND_TIME DATETIME DEFAULT (datetime('now')), RESPONSE_TO_MESSAGE_ID INTEGER DEFAULT NULL REFERENCES Message (ID) ON DELETE SET NULL ON UPDATE CASCADE, RECEIVED BIT DEFAULT 0, VISIBLE BIT DEFAULT 1);
INSERT INTO Message (FROM_USER, TO_USER, BODY, RESPONSE_TO_MESSAGE_ID, RECEIVED_BY_BACKEND_TIME) VALUES (2, 1, 'Hello', NULL, datetime('now', '-15 minutes'));
INSERT INTO Message (FROM_USER, TO_USER, BODY, RESPONSE_TO_MESSAGE_ID, RECEIVED_BY_BACKEND_TIME) VALUES (1, 2, 'Hello Oli', 1, datetime('now', '-14 minutes'));
INSERT INTO Message (FROM_USER, TO_USER, BODY, RESPONSE_TO_MESSAGE_ID, RECEIVED_BY_BACKEND_TIME) VALUES (2, 1, 'You are hired!', NULL, datetime('now', '-10 minutes'));
INSERT INTO Message (FROM_USER, TO_USER, BODY, RESPONSE_TO_MESSAGE_ID, RECEIVED_BY_BACKEND_TIME) VALUES (1, 2, ':)', NULL, datetime('now', '-8 minutes'));
INSERT INTO Message (FROM_USER, TO_USER, BODY, RESPONSE_TO_MESSAGE_ID, RECEIVED_BY_BACKEND_TIME) VALUES (3, 1, 'Hey', NULL, datetime('now', '-7 minutes'));
INSERT INTO Message (FROM_USER, TO_USER, BODY, RESPONSE_TO_MESSAGE_ID, RECEIVED_BY_BACKEND_TIME) VALUES (1, 3, 'Hey Joe', NULL, datetime('now', '-5 minutes'));
INSERT INTO Message (FROM_USER, TO_USER, BODY, RESPONSE_TO_MESSAGE_ID, RECEIVED_BY_BACKEND_TIME) VALUES (3, 1, 'Nice application man.', NULL, datetime('now', '-2 minutes'));
INSERT INTO Message (FROM_USER, TO_USER, BODY, RESPONSE_TO_MESSAGE_ID, RECEIVED_BY_BACKEND_TIME) VALUES (1, 3, 'Thanks', NULL, datetime('now', '-1 minutes'));

-- Table: User
CREATE TABLE User (
    ID            INTEGER           NOT NULL
                                PRIMARY KEY
                                AUTOINCREMENT,
    USERNAME      VARCHAR (64),
    NAME          VARCHAR (64),
    SURNAME       VARCHAR (64),
    TOKEN         VARCHAR (128) NOT NULL
                                UNIQUE,
    CREATION_DATE DATETIME      DEFAULT (datetime('now') ),
    ACTIVE        BIT           DEFAULT 1
);
INSERT INTO User (USERNAME, NAME, SURNAME, TOKEN) VALUES ('puyayavari', 'Pouya', 'Yavari', 'c452116e-deea-4f42-be5d-01646a6f8980');
INSERT INTO User (USERNAME, NAME, SURNAME, TOKEN) VALUES ('oli', 'Oliver', 'Sinclare', '4e77356e-fdc6-45b8-be95-c8fb669cabad');
INSERT INTO User (USERNAME, NAME, SURNAME, TOKEN) VALUES ('joe', 'Joe', 'Biden', 'ecf7ce1b-a4dd-4424-ae99-8df2e4b5bc56');

COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
