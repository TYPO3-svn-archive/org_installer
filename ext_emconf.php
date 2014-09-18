<?php

$EM_CONF[$_EXTKEY] = array(
  'title' => 'Organiser Installer',
  'description' => 'This is the installer for the Organiser, TYPO3 for the lobby and the organisers. '
  . 'The Organiser provides a lot of features for handle news, events, staff, headquarters, '
  . 'locations and a calendar. Sell your tickets with the integrated shop. '
  . 'The installer enables you to install the Organiser with one mouse click! Sample data is included.'
  . 'See: http://typo3-organiser.de/'
  ,
  'category' => 'plugin',
  'shy' => 0,
  'version' => '6.0.0',
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
      'typo3' => '4.5.0-6.2.99',
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