CREATE TABLE `tcp_logs` (`log_id` INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(log_id),`type` varchar(20) NOT NULL DEFAULT 'unknown',`user1` INT NOT NULL DEFAULT 0,`user1_str` varchar(50) NOT NULL default '',`user2` INT,`date` datetime NOT NULL default '0000-00-00 00:00:00',`ip` varchar(20) NOT NULL default '127.0.0.1',`note` varchar(255))engine=myisam;
CREATE TABLE `tcp_pass_res` (`pass_res_id` INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(pass_res_id),`account_id` INT NOT NULL,`code` varchar(20) NOT NULL,`date` DATETIME NOT NULL default '0000-00-00 00:00:00',`ip` varchar(20) NOT NULL default '127.0.0.1')engine=innodb;
UPDATE tcp_dash_li SET dash_li_id=9 WHERE dash_li_id=8;
INSERT INTO tcp_dash_li(`dash_li_id`,`desc`,`url`) VALUE(8,'Logs','dashboard/logs');
ALTER TABLE tcp_set_acc ADD COLUMN `use_md5` BOOL NOT NULL default 0, ADD COLUMN bday_allow_change BOOL NOT NULL default 0;
ALTER TABLE tcp_set_gen ADD COLUMN `tospage` INT NOT NULL DEFAULT 0 AFTER homepage;
ALTER TABLE tcp_set_adm ADD COLUMN `disp_name` varchar(23) NOT NULL default 'coraadmin' AFTER ad_userpw;
UPDATE tcp_post SET author=1;
UPDATE tcp_page SET author=1;