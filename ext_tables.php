<?php
if (!defined ('TYPO3_MODE'))  die ('Access denied.');



  ///////////////////////////////////////////////////////////
  //
  // Language for labels of static templates and page tsConfig

$llStatic = $confArr['LLstatic'];
switch($llStatic) {
  case($llStatic == 'German'):
    $llStatic = 'de';
    break;
  default:
    $llStatic = 'default';
}
  // Language for labels of static templates and page tsConfig



  ///////////////////////////////////////////////////////////
  //
  // Plugin general configuration
  
  t3lib_div::loadTCA('tt_content');
  // Plugin general configuration



  ///////////////////////////////////////////////////////////
  //
  // Plugin 1 configuration
  
  $TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']  = 
    'layout,select_key,pages,recursive';
  // Remove the default tt_content fields layout, select_key, pages and recursive.
  $TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']      =
    'pi_flexform';
  // Display the field pi_flexform
  t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/pi1/flexform.xml');
  // Register our file with the flexform structure
  t3lib_extMgm::addPlugin(
    array(
      'LLL:EXT:org_installer/pi1/locallang.xml:tt_content.list_type_pi1', 
      $_EXTKEY  .'_pi1',
      'EXT:org_installer/ext_icons/ext_icon_blink.gif'),
      'list_type');
  // Add the Flexform to the Plugin List
  // Plugin 1 configuration

  ////////////////////////////////////////////////////////////////////////////
  // 
  // Add pagetree icons

  // Case $llStatic
switch(true) {
  case($llStatic == 'de'):
      // German
    $TCA['pages']['columns']['module']['config']['items'][] = 
       array('Org: Installer', 'org_inst', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icons/ext_icon_blink.gif');
    break;
  default:
      // English
    $TCA['pages']['columns']['module']['config']['items'][] = 
       array('Org: Installer', 'org_inst', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icons/ext_icon_blink.gif');
}
  // Case $llStatic

$ICON_TYPES['org_inst'] = array('icon' => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icons/ext_icon_blink.gif');

  // Add pagetree icons
?>
