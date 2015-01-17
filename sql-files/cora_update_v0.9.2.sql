ALTER TABLE tcp_wid_ss ADD COLUMN player_online BOOL default 1, ADD COLUMN player_peak BOOL default 1;
UPDATE tcp_wid SET page='wid_ss_inline' WHERE wid_id=5; UPDATE tcp_wid SET page='wid_acc_inline' WHERE wid_id=6;
INSERT INTO tcp_wid(`desc`,child_tbl,page) VALUE('Rankings','tcp_wid_rank','wid_rank');
CREATE TABLE IF NOT EXISTS `tcp_wid_rank`(`wid_rank_id` int(11) NOT NULL auto_increment,PRIMARY KEY(wid_rank_id),`wid_used_id` int(11) NOT NULL,`display` enum('b','p','g') NOT NULL default 'b',`pl_rank_sort` enum('k','l','z') NOT NULL default 'k',`gl_rank_sort` enum('l','c') NOT NULL default 'l')engine=innoDB;
INSERT INTO tcp_wid(`desc`,page) VALUE('Search','wid_search');
