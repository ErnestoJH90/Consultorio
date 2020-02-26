-- Icosaedro.it Web Application
-- Schema for the ITS data base.
--
-- Version: $Date: 2019/01/06 21:39:08 $

CREATE DATABASE its DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE its;

-- Uploaded files attached to folders (see 'folders' table)
CREATE TABLE files (
  id serial,
  folder_id int NOT NULL,   -- folders.id
  cardinal int NOT NULL,    -- sort folder's file according to this
  name text COLLATE utf8_bin NOT NULL,  -- displayed name
  type text COLLATE utf8_bin NOT NULL,  -- MIME type
  length int NOT NULL,      -- length (bytes)
  content longblob NOT NULL -- binary content, Base64 encoded, 4GB max
) ENGINE=InnoDB;

-- Folders of uploaded files attached to projects and messages
CREATE TABLE folders (
  id serial,
  created_time int NOT NULL, -- upload timestamp
  finalized boolean NOT NULL -- if this folder is attached to something, either
  -- a project or a comment; non-finalized folders are periodically deleted
) ENGINE=InnoDB;

-- Issues bound to projects
CREATE TABLE issues (
  project_id int NOT NULL,    -- projects.id
  number int NOT NULL,        -- assigned number starting from 1
  created_time int NOT NULL,  -- timestamp of creation
  modified_time int NOT NULL, -- timestamp last added comment or status change
  is_open boolean NOT NULL,   -- if open
  category int NOT NULL DEFAULT '0', -- category code
  tags varchar(200) CHARACTER SET utf8 NOT NULL, -- assigned keyword(s)
  subject varchar(200) CHARACTER SET utf8 NOT NULL,
  assigned_to int DEFAULT NULL -- icodb.users.pk
) ENGINE=InnoDB;

-- Comments bound to issues
CREATE TABLE messages (
  id serial,
  project_id int NOT NULL,    -- projects.id
  issue_number int NOT NULL,  -- issues.number
  created_time int NOT NULL,  -- timestamp
  created_by int NOT NULL,    -- icodb.users.pk
  diff text COLLATE utf8_bin NOT NULL,  -- issue status change summary
  content text CHARACTER SET utf8 NOT NULL, -- text of the comment
  folder_id int DEFAULT NULL  -- folders.id
) ENGINE=InnoDB;

-- Assigned administrators and members of each project
CREATE TABLE permissions (
  project_id int NOT NULL,    -- projects.id
  user_id int NOT NULL,       -- icodb.pk
  is_admin boolean NOT NULL   -- 0=member, 1=member and admin of this project
) ENGINE=InnoDB;

-- Projects
CREATE TABLE projects (
  id serial,
  created_time int NOT NULL,  -- creation timestamp
  name varchar(200) COLLATE utf8_bin NOT NULL,
  description text COLLATE utf8_bin NOT NULL,
  modified_time int NOT NULL, -- timestamp last issue or comment added
  last_number int NOT NULL,   -- number of the latest issue of this project
  folder_id int DEFAULT NULL, -- folders.id
  is_world_readable boolean NOT NULL DEFAULT FALSE, -- if anybody may read
  users_may_subscribe boolean NOT NULL DEFAULT FALSE -- any user may subscribe himself
) ENGINE=InnoDB;

-- Cached projects statistics
CREATE TABLE statistics (
  project_id int NOT NULL,    -- projects.id
  total_issues int NOT NULL,
  open_issues int NOT NULL,
  open_assigned_issues int NOT NULL,
  last_updated_time int NOT NULL -- this record last updated timestamp
) ENGINE=InnoDB;
