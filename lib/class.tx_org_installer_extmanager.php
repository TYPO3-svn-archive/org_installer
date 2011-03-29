<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* Class provides methods for the extension manager.
*
* @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
* @package    TYPO3
* @subpackage    org
* @version 1.0.0
* @since 1.0.0
*/


  /**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   49: class tx_org_installer_extmanager
 *   67:     function promptQuickstart()
 *
 * TOTAL FUNCTIONS: 2
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_org_installer_extmanager
{









  /**
 * initialPage(): Displays the quick start message.
 *
 * @return  string    message wrapped in HTML
 * @since 1.0.0
 * @version 1.0.0
 */
  function initialPage()
  {
//.message-notice
//.message-information
//.message-ok
//.message-warning
//.message-error

    $str_prompt         = null;
    $confArr            = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['org_installer']);
    $arr_installerPages = $this->get_installerPages();

    $str_prompt = $str_prompt.'
      <div class="typo3-message message-warning">
        <div class="message-body">
          ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptSaveTwice'). '
        </div>
      </div>
    ';



      /////////////////////////////////////////////////////////
      //
      // RETURN There is one installer page at least

    if(!empty($arr_installerPages))
    {
      $str_installerPages = implode(null, $arr_installerPages);
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-ok">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallPageExist'). '
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallNextSteps'). '
          </div>
        </div>
      ';
      $str_prompt = str_replace('###TITLE_UID###', $str_installerPages, $str_prompt);
      return $str_prompt;
    }
      // RETURN There is one installer page at least



      /////////////////////////////////////////////////////////
      //
      // RETURN There shouldn't install any installer page

    if(strtolower($confArr['installPage']) == 'no')
    {
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-information">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptEnableInstallPage'). '
          </div>
        </div>
      ';
      return $str_prompt;
    }
      // RETURN There shouldn't install any installer page



      /////////////////////////////////////////////////////////
      //
      // Insert page with TypoScript and plugin

    $this->add_installerPage();
    $arr_installerPages = $this->get_installerPages();
    if(!empty($arr_installerPages))
    {
      $str_installerPages = implode(null, $arr_installerPages);
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-ok">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallPageAdded'). '
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallNextSteps'). '
          </div>
        </div>
      ';
      $str_prompt = str_replace('###TITLE_UID###', $str_installerPages, $str_prompt);
      return $str_prompt;
    }

      $str_prompt = $str_prompt.'
        <div class="typo3-message message-ok">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallPageInstall'). '
          </div>
        </div>
      ';
      // Insert page with TypoScript and plugin



    return $str_prompt;
  }









  /**
 * add_installerPage(): Get all pages with module = org_inst AND not deleted
 *
 * @return  array   rows with installer pages
 * @since 1.0.0
 * @version 1.0.0
 */
  function add_installerPage()
  {
    $int_maxUidPages        = $this->get_maxUidPages();
    $int_newUidPages        = $int_maxUidPages++;
    $table                  = 'pages';
    $fields_values['uid']   = $int_newUidPages;
    $fields_values['title'] = 'Organiser Installer';
    $fields_values['modul'] = 'org_inst';
    $GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values,$no_quote_fields=FALSE);
  }









  /**
 * get_installerPages(): Get all pages with module = org_inst AND not deleted
 *
 * @return  array   rows with installer pages
 * @since 1.0.0
 * @version 1.0.0
 */
  function get_installerPages()
  {
    $rows           = null;
    $select_fields  = 'uid, title';
    $from_table     = 'pages';
    $where_clause   = 'deleted = 0 AND module = "org_inst"';
    $groupBy        ='';
    $orderBy        ='';
    $limit          ='';
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit));
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit);
    while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
    {
      $rows[] = '<li>' . $row['title'] . ' [uid: ' . $row['uid'] . ']</li>';
      //$params['items'][] = array($row['itemValue'], $row['itemKey']);
    }
    return $rows;
  }









  /**
 * get_maxUidPages(): Get all pages with module = org_inst AND not deleted
 *
 * @return  array   rows with installer pages
 * @since 1.0.0
 * @version 1.0.0
 */
  function get_maxUidPages()
  {
    $rows           = null;
    $select_fields  = 'max(uid) AS maxUid';
    $from_table     = 'pages';
    $where_clause   = null;
    $groupBy        = null;
    $orderBy        = null;
    $limit          = null;
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit));
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit);
    $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
    return $row['maxUid'];
  }









}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/lib/class.tx_org_installer_extmanager.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/lib/class.tx_org_installer_extmanager.php']);
}

?>