-- Icosaedro.it Web Application
-- Schema for the icodb data base, including registered users and comments to
-- the web pages.
-- BEWARE! Set the password for the "admin" user as shown below; the password
-- is saved as the MD5 hash of the longin name joined with the entered password.
--
-- Version: $Date: 2018/12/30 05:16:57 $

CREATE DATABASE icodb DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE icodb;

-- Comments added to the web pages
CREATE TABLE comments (
  pk serial,
  reference int DEFAULT NULL, -- in reply to another comments.pk
  path varchar(100) NOT NULL, -- resource path of the web site
  time int NOT NULL,          -- timestamp of this comment
  name varchar(50) NOT NULL,  -- login name of the user
  current_name varchar(50) NOT NULL, -- displayed name of the user
  subject varchar(100) NOT NULL, -- subject
  body text NOT NULL          -- body of the message
) ENGINE=MyISAM;

CREATE TABLE users (
  pk serial,
  name varchar(50) NOT NULL,  -- login name
  pass_hash text CHARACTER SET utf8 COLLATE utf8_bin, -- md5 of name+pass
  current_name varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL, -- displayed name
  email text CHARACTER SET utf8 COLLATE utf8_bin, -- email
  permissions varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL, -- each char either 0 or 1
  signature text CHARACTER SET utf8 COLLATE utf8_bin, -- preferred signature
  last_login int DEFAULT '0', -- timestamp of last login
  UNIQUE KEY name (name)
) ENGINE=MyISAM;

-- Add the default users. You should set a password for admin.
INSERT INTO users (pk, `name`, pass_hash, current_name, email, permissions, signature, last_login) VALUES
(1, 'admin', md5('adminYOURPASSWORDHERE'), 'Admin', '', '1111', '', 0),
(4, 'guest', '?', 'Guest', '', '0010', '', 0);
