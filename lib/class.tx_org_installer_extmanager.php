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
* @version 0.3.1
* @since 0.3.1
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
 * @since 0.3.1
 * @version 0.3.1
 */
  function initialPage()
  {
//.message-notice
//.message-information
//.message-ok
//.message-warning
//.message-error

    $str_prompt       = null;
    $confArr          = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['org_installer']);
    $bool_installPage = $this->bool_installPage();

    $str_prompt = $str_prompt.'
      <div class="typo3-message message-warning">
        <div class="message-body">
          ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptSaveTwice'). '
        </div>
      </div>
    ';


      // There is an installer page already
    if($bool_installPage)
    {
      $str_prompt = $str_prompt.'
        <div class="typo3-message message-ok">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallPageOk'). '
          </div>
        </div>
        ';
    }
      // There isn't any installer page
    if(!$bool_installPage)
    {
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
    }


    return $str_prompt;
  }









  /**
 * bool_installPage(): Displays the quick start message.
 *
 * @return  string    message wrapped in HTML
 * @since 0.3.1
 * @version 0.3.1
 */
  function bool_installPage()
  {
    $query = '
      SELECT uid, title
      FROM `pages`
      WHERE deleted =0
      AND module = "org_inst"
    ';
    $select_fields  = 'SELECT uid, title';
    $from_table     = 'pages';
    $where_clause   = 'deleted = 0 AND module = "org_inst"';
    $groupBy        ='';
    $orderBy        ='';
    $limit          ='';
    var_dump($GLOBALS['TYPO3_DB']->SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit)); 
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit); 
    while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
    {
      var_dump($row);
      //$params['items'][] = array($row['itemValue'], $row['itemKey']);
    }
    return true;
  }









}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/lib/class.tx_org_installer_extmanager.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/lib/class.tx_org_installer_extmanager.php']);
}

?>