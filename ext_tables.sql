#
# Table structure for table 'tx_nsgallery_domain_model_nsalbum'
#
CREATE TABLE tx_nsgallery_domain_model_nsalbum (
    uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	media int(11) unsigned DEFAULT '0' NOT NULL,

   tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY(uid),
	KEY parent(pid),
	KEY t3ver_oid(t3ver_oid,t3ver_wsid),
	KEY language(l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_nsgallery_domain_model_nsmedia'
#
CREATE TABLE tx_nsgallery_domain_model_nsmedia (

    uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	nsalbum int(11) unsigned DEFAULT '0' NOT NULL,

	media int(11) unsigned DEFAULT '0' NOT NULL,
	poster int(11) unsigned DEFAULT '0' NOT NULL,

   tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY(uid),
	KEY parent(pid),
	KEY t3ver_oid(t3ver_oid,t3ver_wsid),
	KEY language(l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_nsgallery_domain_model_nsmedia'
#
CREATE TABLE tx_nsgallery_domain_model_nsmedia (

	nsalbum int(11) unsigned DEFAULT '0' NOT NULL,
   disBig int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_nsgallery_domain_model_nsalbum'
#
CREATE TABLE tx_nsgallery_domain_model_nsalbum (
	categories int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_nsgallery_domain_model_apidata'
#
CREATE TABLE tx_nsgallery_domain_model_apidata (
   id int(11) NOT NULL auto_increment,
   extension_key varchar(255) DEFAULT '',
   right_sidebar_html text,
   premuim_extension_html text,
   support_html text,
   footer_html text,
   last_update date,
   PRIMARY KEY (id)
);
