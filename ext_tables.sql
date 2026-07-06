#
# Table structure for table 'tx_hgondonation_domain_model_project'
#
CREATE TABLE tx_hgondonation_domain_model_project (
	uid int(11) unsigned NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) unsigned DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	t3ver_oid int(11) unsigned DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) unsigned DEFAULT '0' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	slug varchar(255) DEFAULT '' NOT NULL,
	project_code varchar(80) DEFAULT '' NOT NULL,
	short_description text,
	description text,
	button_text varchar(255) DEFAULT '' NOT NULL,
	hosted_button_id varchar(255) DEFAULT '' NOT NULL,
	paypal_business varchar(255) DEFAULT '' NOT NULL,
	paypal_item_name varchar(255) DEFAULT '' NOT NULL,
	paypal_item_number varchar(255) DEFAULT '' NOT NULL,
	suggested_amount decimal(10,2) DEFAULT '0.00' NOT NULL,
	location_title varchar(255) DEFAULT '' NOT NULL,
	location_description text,
	latitude decimal(9,6) DEFAULT '0.000000' NOT NULL,
	longitude decimal(9,6) DEFAULT '0.000000' NOT NULL,
	contact_person int(11) unsigned DEFAULT '0' NOT NULL,
	image int(11) unsigned DEFAULT '0' NOT NULL,
	gallery_images int(11) unsigned DEFAULT '0' NOT NULL,
	downloads int(11) unsigned DEFAULT '0' NOT NULL,
	categories int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid),
	KEY project_code (project_code),
	KEY contact_person (contact_person)
);

CREATE TABLE pages (
	tx_hgondonation_project int(11) unsigned DEFAULT '0' NOT NULL,

	KEY tx_hgondonation_project (tx_hgondonation_project)
);

CREATE TABLE tx_news_domain_model_news (
	tx_hgondonation_project int(11) unsigned DEFAULT '0' NOT NULL,

	KEY tx_hgondonation_project (tx_hgondonation_project)
);

CREATE TABLE tx_hgonspecies_domain_model_species (
	tx_hgondonation_project int(11) unsigned DEFAULT '0' NOT NULL,

	KEY tx_hgondonation_project (tx_hgondonation_project)
);

CREATE TABLE tx_sfeventmgt_domain_model_event (
	tx_hgondonation_project int(11) unsigned DEFAULT '0' NOT NULL,

	KEY tx_hgondonation_project (tx_hgondonation_project)
);
