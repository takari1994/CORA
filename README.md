# Table of Contents
1. About CORA CMS
2. Features
3. Requirements
4. Install Guide
5. Credits & License

# About CORA CMS
CORA CMS is a stand-alone content management system for Ragnarok Online private servers. Its purpose is to provide server owners a user-friendly website management tool with control panel-like features that requires as less coding as possible.

CORA CMS is compatible with the latest versions of all three major emulators (eAthena / rAthena / Hercules).

# Features
The following features can be found in CORA's administrator panel:
- Ability to add, edit, and delete news and events through a rich-text editor.
- Ability to add, edit, and delete pages through a rich-text editor.
- Ability to ban/Unban/Delete users, charaters, and IP ban list.
- Ability to manage the website's navigation links.
- Ability to add/edit/delete widgets as well as their position in the website.
- Ability to manage the items as well as prices in the website's cash shop.
- Ability to manage vote for points links and donation options.
- Ability to view various logs.
- Ability to configure settings.

# Requirements
- Apache web server with mod_rewrite enabled.
- Ragnarok main database tables (main.sql) -- included in emulator
- Ragnarok item & mob database tables (item_db.sql & mob_db.sql) -- included in emulator
- Ragnarok log database tables (log.sql) -- included in emulator

# Install Guide
1. Open /cora/www/settings.php and change the following:
 - base_url = Your web domain.
 - encrypt_key = A random 30-character alphanumeric string.
 - db_host = Your server's database host/IP.
 - db_pass = Your server's database/host password.
 - db_name = Your ragnarok database name.
 - db_log_name = Your ragnarok's log database name.
 
2. Open your PHPMyAdmin, choose your ragnarok database and import the following sql files:
 - /cora/sql-files/cora.sql
 - /cora/sql-files/annieruru_dota_pvp.sql
 
3. If you have no record in your login table, you may skip this step. Otherwise, import the following file:
 - /cora/sql-files/generate_profiles.sql

# Credits & License
CORA CMS © 2014 by Takaworks.net gives due credits to the following third-party applications:
- Codeigniter: The framework used by CORA CMS.
- jQuery: Javascript library used by CORA CMS.
- Bootstrap: CSS and Javascript framework used by CORA CMS.
- ROChargen: GRF sprite parser created by KeyWorld.

CORA™ by <a href="http://takaworks.net">Takaworks</a> is licensed under a <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License</a>.
