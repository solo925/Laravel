-- Create databases for each Laravel microservice
-- This runs automatically on postgres container startup

CREATE DATABASE gateway;
CREATE DATABASE identity;
CREATE DATABASE profile;
CREATE DATABASE media;
CREATE DATABASE social_graph;
CREATE DATABASE feed;
CREATE DATABASE search;

-- Create a dedicated role (optional; using default user 'insta' from docker-compose)
-- You can grant privileges here if using separate roles.
-- GRANT ALL PRIVILEGES ON DATABASE identity TO insta;
-- GRANT ALL PRIVILEGES ON DATABASE profile TO insta;
-- GRANT ALL PRIVILEGES ON DATABASE media TO insta;
-- GRANT ALL PRIVILEGES ON DATABASE social_graph TO insta;
-- GRANT ALL PRIVILEGES ON DATABASE feed TO insta;
-- GRANT ALL PRIVILEGES ON DATABASE search TO insta;
-- GRANT ALL PRIVILEGES ON DATABASE gateway TO insta;
