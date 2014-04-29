<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2011-2012 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 * ************************************************************* */

/**
 * Class provides methods for the extension manager.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    org
 * @version 4.0.0
 * @since 1.0.0
 */

/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   49: class tx_orginstaller_extmanager
 *   67:     function promptQuickstart()
 *
 * TOTAL FUNCTIONS: 2
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_orginstaller_extmanager
{

  var $int_pageUid = null;
  var $str_llStatic = 'en';

  /**
   * initialPage(): Displays a prompt with the current state.
   *                If the user enabled the adding of the installer page,
   *                the installer page will be added in the database.
   *
   * @return  string    message wrapped in HTML
   * @version 4.0.0
   * @since 1.0.0
   */
  function initialPage()
  {
//.message-notice
//.message-information
//.message-ok
//.message-warning
//.message-error

    // #58340, 131106, dwildt, 1+
    $this->initTypo3version( );

    $str_prompt = null;

      // #58340, 131106, dwildt+
    switch( true )
    {
      case( $this->typo3Version < 6000000 ):
        $confArr = $_POST['data'];
        break;
      default:
        $confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['quickshop_installer']);
        break;
    }

    $llStatic = $confArr['LLstatic'];



    /////////////////////////////////////////////////////////
    //
      // Default prompt
    // 120613, dwildt-
//    $str_prompt = $str_prompt.'
//      <div class="typo3-message message-warning">
//        <div class="message-body">
//          ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptSaveTwice'). '
//        </div>
//      </div>
//    ';
    // 120613, dwildt-
    // Default prompt
    /////////////////////////////////////////////////////////
    //
      // Get installed installer pages

    $arr_installerPages = $this->get_installerPages();
    // Get installed installer pages
    /////////////////////////////////////////////////////////
    //
      // RETURN There is one installer page at least

    if (!empty($arr_installerPages))
    {
      $str_installerPages = implode(null, $arr_installerPages);
      $str_prompt = $str_prompt . '
        <div class="typo3-message message-ok">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallPageExist') . '
          </div>
        </div>
      ';
      $str_prompt = $str_prompt . '
        <div class="typo3-message message-information">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallNextSteps') . '
          </div>
        </div>
      ';
      $str_prompt = $str_prompt . '
        <div class="typo3-message message-information">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptDeleteInstallPage') . '
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

    if (strtolower($confArr['installPage']) == 'no' OR empty($confArr['installPage']))
    {
      $str_prompt = $str_prompt . '
        <div class="typo3-message message-information">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptEnableInstallPage') . '
          </div>
        </div>
      ';
      return $str_prompt;
    }
    // RETURN There shouldn't install any installer page
    /////////////////////////////////////////////////////////
    //
      // Language configuration

    switch ($llStatic)
    {
      case($llStatic == 'German'):
        $this->str_llStatic = 'de';
        break;
      default:
        $this->str_llStatic = 'en';
    }
    // Language configuration
    /////////////////////////////////////////////////////////
    //
      // Insert page, TypoScript and plugin

    $this->add_installerPage();
    $this->add_installerTS();
    $this->add_installerPlugin();
    // Insert page, TypoScript and plugin
    /////////////////////////////////////////////////////////
    //
      // RETURN page was added succesfully

    $arr_installerPages = $this->get_installerPages();
    if (!empty($arr_installerPages))
    {
      $str_installerPages = implode(null, $arr_installerPages);
      $str_prompt = $str_prompt . '
        <div class="typo3-message message-ok">
          <div class="message-body">
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallPageAdded') . '
            ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptInstallNextSteps') . '
          </div>
        </div>
      ';
      $str_prompt = str_replace('###TITLE_UID###', $str_installerPages, $str_prompt);
      return $str_prompt;
    }
    // RETURN page was added succesfully
    /////////////////////////////////////////////////////////
    //
      // RETURN with an error

    $str_prompt = $str_prompt . '
      <div class="typo3-message message-error">
        <div class="message-body">
          ' . $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:promptError') . '
        </div>
      </div>
    ';
    return $str_prompt;
    // RETURN with an error
  }

  /**
   * init_typo3version( ):  Get the current TYPO3 version, move it to an integer
   *                        and set the global $bool_typo3_43
   *                        This method is independent from
   *                        * t3lib_div::int_from_ver (upto 4.7)
   *                        * t3lib_utility_VersionNumber::convertVersionNumberToInteger (from 4.7)
   *
   * @return    void
   * @version 4.0.0
   * @since   4.0.0
   * @internal #58340
   */
  private function initTypo3version()
  {
    // RETURN : typo3Version is set
    if ($this->typo3Version !== null)
    {
      return;
    }
    // RETURN : typo3Version is set
    // Set TYPO3 version as integer (sample: 4.7.7 -> 4007007)
    list( $main, $sub, $bugfix ) = explode('.', TYPO3_version);
    $version = ( (int) $main ) * 1000000;
    $version = $version + ( (int) $sub ) * 1000;
    $version = $version + ( (int) $bugfix ) * 1;
    $this->typo3Version = $version;
    // Set TYPO3 version as integer (sample: 4.7.7 -> 4007007)
//echo __METHOD__ . ' (' . __LINE__ . '): ' . typo3Version . '<br />' . PHP_EOL;

    if ($this->typo3Version < 3000000)
    {
      $prompt = '<h1>ERROR</h1>
        <h2>Unproper TYPO3 version</h2>
        <ul>
          <li>
            TYPO3 version is smaller than 3.0.0
          </li>
          <li>
            constant TYPO3_version: ' . TYPO3_version . '
          </li>
          <li>
            integer $this->typo3Version: ' . (int) $this->typo3Version . '
          </li>
        </ul>
          ';
      die($prompt);
    }
  }

  /**
   * add_installerPage(): Add a page with module 'org_inst' to the root level
   *
   * @return  void
   * @since 1.0.0
   * @version 1.0.0
   */
  private function add_installerPage()
  {
    $table = 'pages';
    $int_maxUid = $this->get_maxUid($table);
    $this->int_pageUid = $int_maxUid + 1;
    $fields_values['uid'] = $this->int_pageUid;
    $fields_values['title'] = $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:installPageTitle');
    $fields_values['module'] = 'org_inst';
    $fields_values['sorting'] = '1000000000';
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->INSERTquery($table,$fields_values,$no_quote_fields=FALSE));
    //exit;
    $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields = FALSE);
  }

  /**
   * add_installerPlugin(): Add the plugin
   *
   * @return  void
   * @since 1.0.0
   * @version 1.0.0
   */
  private function add_installerPlugin()
  {
    $table = 'tt_content';
    $int_maxUid = $this->get_maxUid($table);
    $int_maxUid = $int_maxUid + 1;

    $fields_values['uid'] = $int_maxUid;
    $fields_values['pid'] = $this->int_pageUid;
    $fields_values['CType'] = 'list';
    $fields_values['header'] = $GLOBALS['LANG']->sL('LLL:EXT:org_installer/lib/locallang.xml:installPluginTitle');
    $fields_values['header_layout'] = '100';
    $fields_values['list_type'] = 'org_installer_pi1';
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->INSERTquery($table,$fields_values,$no_quote_fields=FALSE));
    //exit;
    $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields = FALSE);
  }

  /**
   * add_installerTS(): Add the TypoScript
   *
   * @return  void
   * @since 1.0.0
   * @version 1.0.0
   */
  private function add_installerTS()
  {
    $table = 'sys_template';
    $int_maxUid = $this->get_maxUid($table);
    $int_maxUid = $int_maxUid + 1;

    $fields_values['uid'] = $int_maxUid;
    $fields_values['pid'] = $this->int_pageUid;
    $fields_values['title'] = 'page_organiserinstaller_' . sprintf('%03d', $int_maxUid);
    $fields_values['root'] = '1';
    $fields_values['clear'] = '3';
    $fields_values['include_static_file'] = 'EXT:css_styled_content/static/';
    $fields_values['config'] = '
config {
  baseURL            = ' . t3lib_div::getIndpEnv('TYPO3_REQUEST_HOST') . '/
  language           = ' . $this->str_llStatic . '
  htmlTag_langKey    = ' . $this->str_llStatic . '
  metaCharset        = UTF-8
  tx_realurl_enable  = 0
  no_cache           = 1
}
page = PAGE
page {
  typeNum = 0
  10 = COA
  10 {
    10 = TEXT
    10 {
      value (
        <style type="text/css">
        body {
          background-image:url(typo3conf/ext/org_installer/res/images/background.gif);
          background-repeat:no-repeat;
          background-position:center center;
          background-attachment:fixed;
        }
        </style>
)
    }
    20 < styles.content.get
  }
}
';
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->INSERTquery($table,$fields_values,$no_quote_fields=FALSE));
    //exit;
    $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields = FALSE);
  }

  /**
   * get_installerPages(): Get all pages with module = org_inst AND not deleted
   *
   * @return  array   rows with installer pages
   * @since 1.0.0
   * @version 1.0.0
   */
  private function get_installerPages()
  {
    $rows = null;
    $select_fields = 'uid, title';
    $from_table = 'pages';
    $where_clause = 'deleted = 0 AND module = "org_inst"';
    $groupBy = '';
    $orderBy = '';
    $limit = '';
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit));
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit);
    while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
    {
      $rows[] = '<li>' . $row['title'] . ' [uid: ' . $row['uid'] . ']</li>';
      //$params['items'][] = array($row['itemValue'], $row['itemKey']);
    }
    return $rows;
  }

  /**
   * get_maxUid(): Get the max uid of the given table
   *
   * @param    string       $from_table: the table
   * @return  int   max uid
   * @since 1.0.0
   * @version 1.0.0
   */
  private function get_maxUid($from_table)
  {
    $rows = null;
    $select_fields = 'max(uid) AS maxUid';
    $where_clause = null;
    $groupBy = null;
    $orderBy = null;
    $limit = null;
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit));
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit);
    $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
    return $row['maxUid'];
  }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/lib/class.tx_orginstaller_extmanager.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/lib/class.tx_orginstaller_extmanager.php']);
}
?>