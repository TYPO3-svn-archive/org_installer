<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Organiser Installer',
	'description' => 'The installer installs the TYPO3 Organiser, a template and sample records. Installation is out of the box. It is a one click installation.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '3.3.5',
	'dependencies' => 'css_styled_content,org',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Dirk Wildt (Die Netzmacher)',
	'author_email' => 'http://wildt.at.die-netzmacher.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'css_styled_content' => '',
			'org' => '',
			'typo3' => '4.5.0-6.1.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'tsconf' => '',
		),
	),
	'suggests' => array(
                'tsconf'
	),
);

?>