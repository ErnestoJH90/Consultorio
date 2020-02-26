www.icosaedro.it web application (IWA)
======================================

This directory contains the source code of the "active" part of my web site,
www.icosaedro.it.

Sections:

- Pages comments are the comments visitors may see at the bottom of each page.
  Comments can be read and new comments can be added, both by registered and
  not registered users; not registered users have the "guest" account assigned.

- Issues Tracking System (ITS) allows members of each created project to share
  comments about specific issues, including features, bugs, deployment and
  support. Assigned members of each specific project may open new issues and add
  new comments. A project may be open to visitors for read only. Projects are
  created by site administrators and managed by project administrators.

- Users management, projects management and background jobs management pages are
  reserved to the site administrators only.

Implementation concepts:

- The "icodb" data base contains the registered users and their permissions, and
  the commented web pages. The file icodb.sql contains the schema and creates
  the two initial default users 'admin' and 'guest'.

- The "its" data base contains the ITS projects. The file its.sql contains the
  schema.

- Registered users may have a "site administrator" permission set. This allows
  access all the features of the IWA, including delete any comment, creating
  ITS projects and assigning project administrators.

- Registered users can be member of projects and administrators of project.

- The public_html directory contains the code that implement the public pages.
  It is assumed the real pages are created under the /iwa directory of the
  document root of the web site; their only purpose is to include the respective
  code of the pages in the public_html directory. So for example the login page
  /iwa/login.php should simply include the login.php stub code inside public_html:

		<?php
		require_once __DIR__ . "/../../phplint/stdlib/it/icosaedro/www/public_html/login.php";

  Note that the PHPLint dir should always be outside the document root of the
  web site.

- All the pages are implemented using the bt_ framework when an user session
  is already established, or sticky forms otherwise.
  See http://www.icosaedro.it/phplint/web/index.html for more.

- A direct-access.php page under the public_html directory allows direct access
  to comments and issues from the web.


- Umberto Salsi

