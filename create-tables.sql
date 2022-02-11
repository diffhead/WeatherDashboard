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
