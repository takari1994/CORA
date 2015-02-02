ALTER TABLE `tcp_set_acc` DROP `req_capt_log`;
ALTER TABLE `tcp_set_acc` ADD COLUMN `pw_format_error` varchar(255) AFTER `un_allow_char`, ADD COLUMN `un_format_error` varchar(255) AFTER `pw_format_error`, ADD COLUMN `un_allow_change` BOOL NOT NULL default 0;
UPDATE `tcp_set_acc` SET `pw_format_error`='Password must only contain a-z,0-9,_!@#$%^&*()-=+? with a 6-32 character length.', `un_format_error`='Username must be alphanumeric and 6-23 characters in length.';
ALTER TABLE `tcp_set_gen` ADD COLUMN `const_mode` BOOL NOT NULL DEFAULT 0;