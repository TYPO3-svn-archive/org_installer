<?php

########################################################################
# Extension Manager/Repository config file for ext "org_installer".
#
# Auto generated 01-04-2011 21:22
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Organiser Installer',
	'description' => 'The installer installs the TYPO3 Organiser, a template and sample records. Installation is out of the box. It is a one click installation.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.0.0',
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
			'css_styled_content' => '1.0.0-0.0.0',
			'org' => '1.0.0-0.0.0-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'tsconf' => '0.1.2-0.0.0',
		),
	),
	'_md5_values_when_last_written' => 'a:42:{s:9:"ChangeLog";s:4:"32d7";s:21:"ext_conf_template.txt";s:4:"bb55";s:12:"ext_icon.gif";s:4:"ec42";s:17:"ext_localconf.php";s:4:"64d6";s:14:"ext_tables.php";s:4:"5b55";s:16:"locallang_db.xml";s:4:"91d8";s:14:"doc/manual.pdf";s:4:"082e";s:14:"doc/manual.sxw";s:4:"a2cd";s:28:"ext_icons/ext_icon_blink.gif";s:4:"a09e";s:41:"lib/class.tx_org_installer_extmanager.php";s:4:"87ab";s:17:"lib/locallang.xml";s:4:"6425";s:33:"pi1/class.tx_orginstaller_pi1.php";s:4:"9dad";s:16:"pi1/flexform.xml";s:4:"feef";s:26:"pi1/flexform_locallang.php";s:4:"aff1";s:27:"pi1/flexform_sheet_sDEF.xml";s:4:"fc23";s:17:"pi1/locallang.xml";s:4:"2c88";s:45:"res/files/fe_users/barack.obama_timestamp.jpg";s:4:"2815";s:43:"res/files/fe_users/dirk.wildt_timestamp.jpg";s:4:"f220";s:51:"res/files/fe_users/soeren.schaffstein_timestamp.gif";s:4:"1c24";s:65:"res/files/tx_org/BlogExampleWithAnnotation-320px_02_timestamp.png";s:4:"a641";s:47:"res/files/tx_org/campus_sursee_01_timestamp.jpg";s:4:"49fc";s:47:"res/files/tx_org/campus_sursee_04_timestamp.jpg";s:4:"4ef6";s:47:"res/files/tx_org/campus_sursee_05_timestamp.jpg";s:4:"ce87";s:54:"res/files/tx_org/die_netzmacher_600px_01_timestamp.jpg";s:4:"84b6";s:51:"res/files/tx_org/die_netzmacher_600px_timestamp.jpg";s:4:"84b6";s:49:"res/files/tx_org/ext_icon_org_210px_timestamp.png";s:4:"eaf7";s:35:"res/files/tx_org/logo_timestamp.jpg";s:4:"c3d0";s:49:"res/files/tx_org/situationsplan_neu_timestamp.pdf";s:4:"4a36";s:50:"res/files/tx_org/t3dd11_header_front_timestamp.jpg";s:4:"ce40";s:34:"res/files/tx_org/t3n_timestamp.png";s:4:"713c";s:41:"res/files/tx_org/typo3_logo_timestamp.jpg";s:4:"c3d0";s:42:"res/files/tx_org/white_house_timestamp.jpg";s:4:"be26";s:37:"res/images/22x22/application-exit.png";s:4:"8369";s:42:"res/images/22x22/appointment-recurring.png";s:4:"84e7";s:34:"res/images/22x22/dialog-cancel.png";s:4:"9a5c";s:33:"res/images/22x22/dialog-close.png";s:4:"6063";s:33:"res/images/22x22/dialog-error.png";s:4:"4343";s:39:"res/images/22x22/dialog-information.png";s:4:"959e";s:36:"res/images/22x22/dialog-ok-apply.png";s:4:"a6e0";s:35:"res/images/22x22/dialog-warning.png";s:4:"0eab";s:29:"res/images/22x22/download.png";s:4:"1818";s:32:"res/images/22x22/edit-delete.png";s:4:"7dda";}',
	'suggests' => array(
	),
);

?>