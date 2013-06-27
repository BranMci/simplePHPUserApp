CREATE TABLE IF NOT EXISTS users (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username varchar(50) NOT NULL,
	password varchar(50) NOT NULL,
	email varchar(50) NOT NULL,
	join_date datetime NOT NULL,
	UNIQUE(username)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;