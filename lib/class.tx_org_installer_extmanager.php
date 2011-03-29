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
    $arr_installedPages = $this->get_installedPages();

    $str_prompt = $str_prompt.'
      <div class="typo3-message message-warning">
        <div class="message-body">
          ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptSaveTwice'). '
        </div>
      </div>
    ';


      // RETURN There is one installer page at least
    if(!empty($arr_installedPages))
    {
      $str_installedPages = implode(', ', $arr_installedPages);
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-ok">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallPageExist'). '
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallNextSteps'). '
          </div>
        </div>
      ';
      $str_prompt = str_replace('###TITLE_UID###', $str_installedPages, $str_prompt);
      return $str_prompt;
    }
      // RETURN There is one installer page at least



    if(strtolower($confArr['installPage']) == 'no')
    {
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-information">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptEnableInstallPage'). '
          </div>
        </div>
      ';
    }
    if(strtolower($confArr['installPage']) != 'no')
    {
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-ok">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallPageInstall'). '
          </div>
        </div>
      ';
    }


    return $str_prompt;
  }









  /**
 * get_installedPages(): Get all pages with module = org_inst AND not deleted
 *
 * @return  array   rows with installed pages
 * @since 1.0.0
 * @version 1.0.0
 */
  function get_installedPages()
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
      $rows[] = $row['title'] . '[' . $row['uid'] . ']';
      //$params['items'][] = array($row['itemValue'], $row['itemKey']);
    }
    return $rows;
  }









}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/lib/class.tx_org_installer_extmanager.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/lib/class.tx_org_installer_extmanager.php']);
}

?>