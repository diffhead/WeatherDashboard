CREATE TABLE modules(
    id SERIAL,
    name TEXT,
    enable INTEGER,

    PRIMARY KEY(id)
);

CREATE TABLE cache(
    id SERIAL,

    key TEXT,
    value TEXT,

    expiration INTEGER,

    date_add TIMESTAMP NOT NULL DEFAULT NOW(),

    PRIMARY KEY(id)
);

CREATE TABLE config(
    id SERIAL, 
    key TEXT, 
    value TEXT, 

    date_add TIMESTAMP NOT NULL DEFAULT NOW(), 
    date_update TIMESTAMP NOT NULL DEFAULT NOW(), 

    PRIMARY KEY(key)
);

CREATE TABLE users (
    id SERIAL, 

    name TEXT, 
    secondname TEXT NOT NULL DEFAULT '', 
    thirdname TEXT NOT NULL DEFAULT '', 

    email TEXT NOT NULL, 
    phone TEXT NOT NULL DEFAULT '', 

    date_add TIMESTAMP NOT NULL DEFAULT NOW(), 
    date_upd TIMESTAMP NOT NULL DEFAULT NOW(), 

    last_login TIMESTAMP NOT NULL DEFAULT NOW(),

    PRIMARY KEY(id)
);

CREATE TABLE access (
    id SERIAL, 
    title TEXT NOT NULL, 
    description TEXT NOT NULL DEFAULT '',

    PRIMARY KEY(id)
);

CREATE TABLE user_access (
    user_id INTEGER NOT NULL, 
    access INTEGER NOT NULL, 

    CONSTRAINT fk_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE, 
    CONSTRAINT fk_access FOREIGN KEY(access) REFERENCES access(id) ON DELETE CASCADE,

    PRIMARY KEY(user_id)
);
