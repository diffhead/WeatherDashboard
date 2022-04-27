CREATE TABLE weather_city(
    id SERIAL,
    title TEXT NOT NULL DEFAULT 'UnnamedCity',
    latitude FLOAT NOT NULL DEFAULT 0,
    longitude FLOAT NOT NULL DEFAULT 0,
    active INT NOT NULL DEFAULT 1,
    country INT NOT NULL,

    CONSTRAINT wc_country FOREIGN KEY(country) REFERENCES country(id) ON DELETE CASCADE, 

    PRIMARY KEY(id)
);

CREATE TABLE weather(
    id SERIAL,
    city INT NOT NULL,

    weather TEXT NOT NULL,
    weather_icon TEXT NOT NULL DEFAULT '',
    weather_description TEXT NOT NULL DEFAULT '',

    temperature FLOAT NOT NULL,
    temperature_feeling FLOAT NOT NULL,

    visibility INT NOT NULL DEFAULT 0,

    wind_speed FLOAT NOT NULL,
    wind_deg INT NOT NULL,

    date_add TIMESTAMP NOT NULL DEFAULT NOW(),

    CONSTRAINT fk_city FOREIGN KEY(city) REFERENCES weather_city(id) ON DELETE CASCADE, 

    PRIMARY KEY(id)
);
