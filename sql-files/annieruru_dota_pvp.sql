	create table pvpladder (
		char_id int(11) not null default '0' primary key,
		name varchar(30) not null default '',
		streaks smallint(6) unsigned not null default '0',
		kills smallint(6) unsigned not null default '0',
		deaths smallint(6) unsigned not null default '0',
		streaktime datetime
	) engine = myisam;
	
	create table ownladder (
		guild_id int(11) not null default '0' primary key,
		name varchar(24) not null default '',
		currentown smallint(6) unsigned not null default '0',
		highestown smallint(6) unsigned not null default '0',
		owntime datetime
	) engine = myisam; 
