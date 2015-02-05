<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2015 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   96: class tx_orginstaller_pi1 extends tslib_pibase
 *
 *              SECTION: Main
 *  172:     public function main( $content, $conf)
 *
 *              SECTION: Confirmation
 *  252:     private function confirmation()
 *
 *              SECTION: Create
 *  327:     private function create( )
 *  353:     private function createBeGroup()
 *  462:     private function createContent( )
 *  476:     private function createFiles()
 *  533:     private function createPages( )
 *  550:     private function createPlugins( )
 *
 *              SECTION: Create records
 *  575:     private function createRecordsOrg( )
 *  592:     private function createRecordsPowermail( )
 *  608:     private function createRecordsPowermailPageOrgCaddy( )
 *  625:     private function createRecordsPowermailPageOrgDocumentsCaddy( )
 *  642:     private function createTyposcript( )
 *
 *              SECTION: Consolidate
 *  667:     private function consolidate( )
 *
 *              SECTION: Extensions
 *  693:     private function extensionCheck( )
 *  786:     private function extensionCheckCaseBaseTemplate( )
 *  825:     private function extensionCheckExtension( $key, $title )
 *
 *              SECTION: Html
 *  866:     private function htmlReport( )
 *
 *              SECTION: Init
 *  923:     private function initBoolTopLevel( )
 *  952:     private function initPowermailVersion( )
 *  977:     private function install( )
 * 1016:     private function installNothing( )
 *
 *              SECTION: Prompt
 * 1045:     private function promptCleanUp( )
 *
 *              SECTION: ZZ
 * 1086:     private function zz_getCHash($str_params)
 * 1100:     public function zz_getMaxDbUid( $table )
 * 1127:     private function zz_getPathToIcons()
 * 1148:     private function zz_getExtensionVersion( $_EXTKEY )
 * 1180:     private function zz_getFlexValues()
 *
 * TOTAL FUNCTIONS: 28
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
// #61624, 140916, dwildt, 1-
//require_once(PATH_tslib . 'class.tslib_pibase.php');
// #61624, 140916, dwildt, +
list( $main, $sub, $bugfix ) = explode( '.', TYPO3_version );
$version = ( ( int ) $main ) * 1000000;
$version = $version + ( ( int ) $sub ) * 1000;
$version = $version + ( ( int ) $bugfix ) * 1;
// Set TYPO3 version as integer (sample: 4.7.7 -> 4007007)
if ( $version < 6002000 )
{
  require_once(PATH_tslib . 'class.tslib_pibase.php');
}
// #61624, 140916, dwildt, +

/**
 * Plugin 'Organiser Installer' for the 'org_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_orginstaller
 * @version 6.0.0
 * @since 1.0.0
 */
class tx_orginstaller_pi1 extends tslib_pibase
{

  public $prefixId = 'tx_orginstaller_pi1';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_orginstaller_pi1.php';  // Path to this script relative to the extension dir.
  public $extKey = 'org_installer';                      // The extension key.
  public $pi_checkCHash = true;
  // [array] The TypoScript configuration array
  public $conf = false;
  // [boolean] true, if ther is any installation error.
  private $bool_error = false;
  // [boolean]
  public $bool_topLevel = null;
  // [array] The flexform array
  private $arr_piFlexform = false;
  // [array] Array with the report items
  public $arrReport = false;
  // [array] Array with images, wrapped as HTML <img ...>
  public $arr_icons = false;
  // [array] Array with variables like group id, page ids ...
  public $markerArray = false;
  // [array] Uids of the current and the generated pages records. Titles are the keys.
  public $arr_pageUids = false;
  // [array] Titles of the current and the generated pages records. Uids are the keys.
  public $arr_pageTitles = false;
  // [array] Uids of the generated sys_templates records. Titles are the keys.
  public $arr_tsUids = false;
  // [array] Uids of the generated sys_templates records. Uids are the keys.
  public $arr_tsTitles = false;
  // [string] Title of the root TypoScript
  public $str_tsRoot = false;
  // [array] Uids of the generated tt_content records - here: plugins only
  public $arr_pluginUids = false;
  // [array] Uids of the generated records for different tables.
  public $arr_recordUids = false;
  // [array] Uids of the generated files with an timestamp
  public $arr_fileUids = false;
  // [array] Uids of the generated tt_content records - here: page content only
  public $arr_contentUids = false;
  // [object]
  public $consolidate = null;
  // [object]
  public $content = null;
  // [object]
  public $org = null;
  // [object]
  public $pages = null;
  // [object]
  public $plugins = null;
  // [object]
  public $powermail = null;
  // [object]
  public $typoscript = null;
  public $powermailVersionInt = null;
  public $powermailVersionStr = null;
  private $LLstatic = 'English';
  private $typo3Version = null;

  /*   * *********************************************
   *
   * Main
   *
   * ******************************************** */

  /**
   * The main method of the PlugIn
   *
   * @param	string		$content: The PlugIn content
   * @param	array		$conf: The TypoScript configuration array
   * @return	The		content that is displayed on the website
   *
   * @version 4.0.0
   * @since 1.0.0
   */
  public function main( $content, $conf )
  {
    unset( $content );

    $this->conf = $conf;

    $this->pi_loadLL();

    //#58340, 140429, dwildt, 1+
    $this->initTypo3version();

    // Get values from the flexform
    $this->zz_getFlexValues();

    // Set the path to icons
    $this->zz_getPathToIcons();



    // SWITCH : What should installed?
    switch ( $this->markerArray[ '###INSTALL_CASE###' ] )
    {
      case( null ):
      case( 'disabled' ):
        if ( !$this->installNothing() )
        {
          $this->bool_error = true;
        }
        break;
      case( 'install_org' ):
      case( 'install_all' ):
        if ( !$this->install() )
        {
          $this->bool_error = true;
        }
        break;
      default:
        $this->arrReport[] = '
          <p>
            switch in tx_orginstaller_pi1::main has an undefined value: ' .
                $this->markerArray[ '###INSTALL_CASE###' ] . '
          </p>';
        $this->bool_error = true;
    }
    // SWITCH : What should installed?
    // SWITCH : error case
    switch ( $this->bool_error )
    {
      case( true ):
        $str_result = '
          <div style="border:4px solid red;padding:2em;">
            <h1>
            ' . $this->pi_getLL( 'error_all_h1' ) . '
            </h1>
            ' . $this->htmlReport() . '
          </div>';
        break;
      case( false ):
      default:
        $str_result = $this->htmlReport();
        break;
    }
    // SWITCH : error case

    return $this->pi_wrapInBaseClass( $str_result );
  }

  /*   * *********************************************
   *
   * Confirmation
   *
   * ******************************************** */

  /**
   * Shop will be installed - with or without template
   *
   * @param	string		$str_installCase: install_all or install_org
   * @return	The		content that is displayed on the website
   */
  private function confirmation()
  {
    $boolConfirmation = false;

    // RETURN  if form is confirmed
    if ( $this->piVars[ 'confirm' ] )
    {
      $boolConfirmation = true;
      return $boolConfirmation;
    }

    // Get the cHash. Important in case of realUrl and no_cache=0
    $cHash_calc = $this->zz_getCHash( '&tx_orginstaller_pi1[confirm]=1&submit= ' . $this->pi_getLL( 'confirm_button' ) . ' ' );

    // Confirmation form
    $this->arrReport[] = '
      <h2>
       ' . $this->pi_getLL( 'confirm_header' ) . '
      </h2>
      <p>
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'confirm_prompt_createBeGroup' ) . '<br />
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'confirm_prompt_createPages' ) . '<br />
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'confirm_prompt_createPlugins' ) . '<br />
      ';
    if ( $this->markerArray[ '###INSTALL_CASE###' ] == 'install_all' )
    {
      $this->arrReport[] = '
          ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'confirm_prompt_createContent' ) . '<br />
        ';
    }
    $this->arrReport[] = '
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'confirm_prompt_createTs' ) . '<br />
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'confirm_prompt_createPowermail' ) . '<br />
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'confirm_prompt_createRecords' ) . '<br />
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'confirm_prompt_createFiles' ) . '<br />
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'confirm_prompt_createContent' ) . '<br />
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'confirm_prompt_consolidate' ) . '<br />
      </p>
      <div style="text-align:right">
        <form name="form_confirm" method="POST">
          <fieldset id="fieldset_confirm" style="border:1px solid #F66800;padding:1em;">
            <legend style="color:#F66800;font-weight:bold;padding:0 1em;">
              ' . $this->pi_getLL( 'confirm_header' ) . '
            </legend>
            <input type="hidden" name="tx_orginstaller_pi1[confirm]"  value="1" />
            <input type="hidden" name="no_cache"                      value="1" />
            <input type="hidden" name="cHash"                         value="' . $cHash_calc . '" />
            <input type="submit" name="submit" value=" ' . $this->pi_getLL( 'confirm_button' ) . ' " />
          </fieldset>
        </form>
      </div>';
    // Confirmation form

    $boolConfirmation = false;
    return $boolConfirmation;
  }

  /*   * *********************************************
   *
   * Create
   *
   * ******************************************** */

  /**
   * create( ) :
   *
   * @return	void
   * @access private
   * @version    3.0.0
   * @since      3.0.0
   */
  private function create()
  {
    $this->createBeGroup();
    $this->createPages();
    $this->createTyposcript();
    $this->createPlugins();

    $this->arrReport[] = '
      <h2>
       ' . $this->pi_getLL( 'record_create_header' ) . '
      </h2>';

    $this->createRecordsPowermail();
    $this->createRecordsOrg();
    $this->createContent();
    $this->createFiles();
  }

  /**
   * Shop will be installed - with or without template
   *
   * @param	string		$str_installCase: install_all or install_org
   * @return	The		content that is displayed on the website
   */
  private function createBeGroup()
  {

    $this->markerArray[ '###GROUP_TITLE###' ] = 'organiser';

    //////////////////////////////////////////////////////////////////////
    //
    // There is a group available

    $select_fields = '`uid`, `title`';
    $from_table = '`be_groups`';
    $where_clause = '`hidden` = 0 AND `deleted` = 0 AND `title` = "organiser"';
    $groupBy = '';
    $orderBy = '';
    $limit = '0,1';
    $uidIndexField = '';

    $rows = $GLOBALS[ 'TYPO3_DB' ]->exec_SELECTgetRows( $select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField );
    if ( is_array( $rows ) && count( $rows ) > 0 )
    {
      $group_uid = $rows[ 0 ][ 'uid' ];
      $group_title = $rows[ 0 ][ 'title' ];
    }

    if ( $group_uid )
    {
      $this->markerArray[ '###GROUP_TITLE###' ] = $group_title;
      $this->markerArray[ '###GROUP_UID###' ] = $group_uid;

      $str_grp_prompt = '
        <h2>
         ' . $this->pi_getLL( 'grp_ok_header' ) . '
        </h2>
        <p>
          ' . $this->arr_icons[ 'ok' ] . ' ' . $this->pi_getLL( 'grp_ok_prompt' ) . '
        </p>';
      $str_grp_prompt = $this->cObj->substituteMarkerArray( $str_grp_prompt, $this->markerArray );
      $this->arrReport[] = $str_grp_prompt;
      return false;
    }
    // There is a group available
    //////////////////////////////////////////////////////////////////////
    //
    // There isn't any group available

    $timestamp = time();

    $table = '`be_groups`';
    $fields_values = array();
    $fields_values[ 'uid' ] = null;
    $fields_values[ 'pid' ] = 0;
    $fields_values[ 'tstamp' ] = $timestamp;
    $fields_values[ 'title' ] = 'organiser';
    $fields_values[ 'crdate' ] = $timestamp;
    $no_quote_fields = false;
    $GLOBALS[ 'TYPO3_DB' ]->exec_INSERTquery( $table, $fields_values, $no_quote_fields );
    // There isn't any group available

    $where_clause = '`hidden` = 0 AND `deleted` = 0 AND `title` = "organiser" AND `crdate` = ' . $timestamp . ' AND `tstamp` = ' . $timestamp;

    $rows = $GLOBALS[ 'TYPO3_DB' ]->exec_SELECTgetRows( $select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField );
    if ( is_array( $rows ) && count( $rows ) > 0 )
    {
      $group_title = $rows[ 0 ][ 'title' ];
      $group_uid = $rows[ 0 ][ 'uid' ];
    }

    if ( $group_uid )
    {
      $this->markerArray[ '###GROUP_TITLE###' ] = $group_title;
      $this->markerArray[ '###GROUP_UID###' ] = $group_uid;

      $str_grp_prompt = '
        <h2>
         ' . $this->pi_getLL( 'grp_create_header' ) . '
        </h2>
        <p>
          ' . $this->arr_icons[ 'ok' ] . ' ' . $this->pi_getLL( 'grp_create_prompt' ) . '
        </p>';
      $str_grp_prompt = $this->cObj->substituteMarkerArray( $str_grp_prompt, $this->markerArray );
      $this->arrReport[] = $str_grp_prompt;
      return false;
    }

    $this->markerArray[ '###GROUP_UID###' ] = false;

    $str_grp_prompt = '
      <h2>
       ' . $this->pi_getLL( 'grp_warn_header' ) . '
      </h2>
      <p>
        ' . $this->arr_icons[ 'warn' ] . ' ' . $this->pi_getLL( 'grp_warn_prompt' ) . '
      </p>';
    $str_grp_prompt = $this->cObj->substituteMarkerArray( $str_grp_prompt, $this->markerArray );
    $this->arrReport[] = $str_grp_prompt;
    return false;
  }

  /**
   * createContent( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createContent()
  {
    require_once( 'class.tx_orginstaller_pi1_content.php' );
    $this->content = t3lib_div::makeInstance( 'tx_orginstaller_pi1_content' );
    $this->content->pObj = $this;

    $this->content->main();
  }

  /**
   * createFiles( ) :
   *
   * @return	The		content that is displayed on the website
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createFiles()
  {
    $this->arrReport[] = '
      <h2>
       ' . $this->pi_getLL( 'files_create_header' ) . '
      </h2>';

    $this->createFilesDownloads();
    $this->createFilesLibraryHeaderLogo();
    $this->createFilesLibraryHeaderSlider();
    $this->createFilesLibraryMenubelow();
    $this->createFilesOrg();
  }

  /**
   * createFilesDownloads( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createFilesDownloads()
  {
    $this->zz_copyFiles( 'res/files/tx_org_downloads/' );
  }

  /**
   * createFilesLibraryHeaderLogo( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createFilesLibraryHeaderLogo()
  {
    $this->zz_copyFiles( 'res/files/headerLogo/', 'uploads/pics/' );
  }

  /**
   * createFilesLibraryHeaderSlider( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createFilesLibraryHeaderSlider()
  {
    $this->zz_copyFiles( 'res/files/headerSlider/', 'uploads/pics/' );
  }

  /**
   * createFilesLibraryHeaderMenubelow( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createFilesLibraryMenubelow()
  {
    $this->zz_copyFiles( 'res/files/menubelow/', 'uploads/pics/' );
  }

  /**
   * createFilesOrg( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createFilesOrg()
  {
    $this->zz_copyFiles( 'res/files/tx_org/' );
  }

  /**
   * createPages( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createPages()
  {
    require_once( 'class.tx_orginstaller_pi1_pages.php' );
    $this->pages = t3lib_div::makeInstance( 'tx_orginstaller_pi1_pages' );
    $this->pages->pObj = $this;

    $this->pages->main();
  }

  /**
   * createPlugins( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createPlugins()
  {
    require_once( 'class.tx_orginstaller_pi1_plugins.php' );
    $this->plugins = t3lib_div::makeInstance( 'tx_orginstaller_pi1_plugins' );
    $this->plugins->pObj = $this;

    $this->plugins->main();
  }

  /*   * *********************************************
   *
   * Create records
   *
   * ******************************************** */

  /**
   * createRecordsOrg( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createRecordsOrg()
  {
    require_once( 'class.tx_orginstaller_pi1_org.php' );
    $this->org = t3lib_div::makeInstance( 'tx_orginstaller_pi1_org' );
    $this->org->pObj = $this;

    $this->org->main();
  }

  /**
   * createRecordsPowermail( ) :
   *
   * @return	void
   * @access private
   * @version 6.0.0
   * @since 1.0.0
   */
  private function createRecordsPowermail()
  {
    require_once( 'class.tx_orginstaller_pi1_powermail.php' );

    $this->createRecordsPowermailPageOrgCaddy();
    $this->createRecordsPowermailPageOrgDocumentsCaddy();
    // #61779, 140921, dwildt, 1+
    $this->createRecordsPowermailPageOrgJobsJobsApply();
  }

  /**
   * createRecordsPowermailPageOrgCaddy( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createRecordsPowermailPageOrgCaddy()
  {
    $this->powermailPageOrgCaddy = t3lib_div::makeInstance( 'tx_orginstaller_pi1_powermail' );
    $this->powermailPageOrgCaddy->pObj = $this;

    $pid = $this->arr_pageUids[ 'pageOrgCalCaddy_title' ];
    $this->powermailPageOrgCaddy->main( $pid, 'pageOrgCalCaddy_title' );
  }

  /**
   * createRecordsPowermailPageOrgDocumentsCaddy( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function createRecordsPowermailPageOrgDocumentsCaddy()
  {
    $this->powermailPageOrgDocumentsCaddy = t3lib_div::makeInstance( 'tx_orginstaller_pi1_powermail' );
    $this->powermailPageOrgDocumentsCaddy->pObj = $this;

    $pid = $this->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ];
    $this->powermailPageOrgDocumentsCaddy->main( $pid, 'pageOrgDocumentsCaddy_title' );
  }

  /**
   * createRecordsPowermailPageOrgJobsJobsApply( ) :
   *
   * @return	void
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function createRecordsPowermailPageOrgJobsJobsApply()
  {
    return;
    $this->powermailPageOrgJobsJobsApply = t3lib_div::makeInstance( 'tx_orginstaller_pi1_powermail' );
    $this->powermailPageOrgJobsJobsApply->pObj = $this;

    $pid = $this->arr_pageUids[ 'pageOrgJobsJobsApply_title' ];
    $this->powermailPageOrgJobsJobsApply->main( $pid, 'pageOrgJobsJobsApply_title' );
  }

  /**
   * createTyposcript( )
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function createTyposcript()
  {
    require_once( 'class.tx_orginstaller_pi1_typoscript.php' );
    $this->typoscript = t3lib_div::makeInstance( 'tx_orginstaller_pi1_typoscript' );
    $this->typoscript->pObj = $this;

    $this->typoscript->main();
  }

  /*   * *********************************************
   *
   * Consolidate
   *
   * ******************************************** */

  /**
   * consolidate( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function consolidate()
  {
    require_once( 'class.tx_orginstaller_pi1_consolidate.php' );
    $this->consolidate = t3lib_div::makeInstance( 'tx_orginstaller_pi1_consolidate' );
    $this->consolidate->pObj = $this;

    $this->consolidate->main();
  }

  /*   * *********************************************
   *
   * Extensions
   *
   * ******************************************** */

  /**
   * extensionCheck( ) :  Checks whether needed extensions are installed.
   *                      Result will stored in the global $arrReport.
   *
   * @return	void
   * @access private
   * @version   3.0.0
   * @since     1.0.0
   */
  private function extensionCheck()
  {
    $success = true;

    // RETURN  if form is confirmed
    if ( $this->piVars[ 'confirm' ] )
    {
      return $success;
    }
    // RETURN  if form is confirmed
    // Header
    $this->arrReport[] = '
      <h2>
       ' . $this->pi_getLL( 'ext_header' ) . '
      </h2>
      ';
    // Header

    if ( !$this->extensionCheckCaseBaseTemplate() )
    {
      $success = false;
    }

    $key = 'browser';
    $title = 'Browser - TYPO3 without PHP';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key = 'caddy';
    $title = 'Caddy - TYPO3 shopping cart';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key = 'cps_tcatree';
    $title = 'Record tree for TCA';
    // #58340, 140429, dwildt, 1-
    //if (!$this->extensionCheckExtension($key, $title))
    #58340, 140429, dwildt, 2+
    $url = 'http://typo3-organiser.de/cps_tcatree_0.4.2_fix6x.zip';
    if ( !$this->extensionCheckExtension( $key, $title, $url ) )
    {
      $success = false;
    }

    // #58340, 140429, dwildt, 6+
    $key = 'cps_devlib';
    $title = 'Developer Library';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key = 'flipit';
    $title = 'Flip it! TYPO3 for real magazines';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key = 'linkhandlerconf';
    $title = '+AOE linkhandler configurator';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key = 'org';
    $title = 'Organiser - TYPO3 for lobby and organisers';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key = 'powermail';
    $title = 'Powermail';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    // #i0020, 141506, dwildt, +
    $key = 'radialsearch';
    $title = 'Radial Search (German: Umkreissuche)';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    // #i0006, 130911, dwildt, +
    $key = 'seo_dynamic_tag';
    $title = 'SEO Dynamic Tag';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

// See Organiser 3.2.0, #i0001
//    $key    = 'static_info_tables';
//    $title  = 'Static Info Tables (static_info_tables)';
//    if( ! $this->extensionCheckExtension( $key, $title ) )
//    {
//      $success = false;
//    }

    return $success;
  }

  /**
   * extensionCheckCaseBaseTemplate( ) :  Checks whether needed extensions are installed.
   *                      Result will stored in the global $arrReport.
   *
   * @return	void
   * @access private
   * @version   3.0.0
   * @since     1.0.0
   */
  private function extensionCheckCaseBaseTemplate()
  {
    $success = true;
    // RETURN : base template should not installed
    if ( $this->markerArray[ '###INSTALL_CASE###' ] != 'install_all' )
    {
      return $success;
    }
    // RETURN : base template should not installed

    $key = 'automaketemplate';
    $title = 'Template Auto-parser';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    $key = 'baseorg';
    $title = 'Organiser - Template';
    if ( !$this->extensionCheckExtension( $key, $title ) )
    {
      $success = false;
    }

    return $success;
  }

  /**
   * extensionCheckExtension( )  : Checks wether an extension ist installed or not.
   *                                Returns true in case of installtion.
   *                                Writes result in the global $arrReport.
   *
   * @param	string		$key    : extension key
   * @param	string		$title  : extension title
   * @param	string		$url    : url for download
   * @return	boolean
   * @access private
   * @internal  #i0013
   * @version   4.0.1
   * @since     1.0.0
   */
  private function extensionCheckExtension( $key, $title, $url = null )
  {
    $boolInstalled = null;
    $titleWiKey = $key . ': "' . $title . '"';

    // RETURN : extension is installed
    if ( t3lib_extMgm::isLoaded( $key ) )
    {
      $prompt = '
        <p>
          ' . $this->arr_icons[ 'ok' ] . ' ' . $titleWiKey . ' ' . $this->pi_getLL( 'ext_ok' ) . '
        </p>';
      $prompt = str_replace( '%url%', $url, $prompt );
      $this->arrReport[] = $prompt;
      $boolInstalled = true;
      return $boolInstalled;
    }
    // RETURN : extension is installed
    // RETURN : extension isn't installed
    $prompt = '
      <p>
        ' . $this->arr_icons[ 'error' ] . $this->pi_getLL( 'ext_error' ) . '<br />
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'ext_help' ) . ' ' . $titleWiKey . '
        %url%
      </p>';

    if ( $url )
    {
      $url = '<a href="' . $url . '">' . $url . '</a>';
      $url = '<br />' . PHP_EOL . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'ext_help' ) . $url;
    }

    $prompt = str_replace( '%url%', $url, $prompt );
    $this->arrReport[] = $prompt;
    $boolInstalled = false;
    return $boolInstalled;
    // RETURN : extension isn't installed
  }

  /*   * *********************************************
   *
   * Get
   *
   * ******************************************** */

  /**
   * get_Llstatic( )
   *
   * @return	string
   * @access public
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  public function get_Llstatic()
  {
    return $this->LLstatic;
  }

  /**
   * get_typo3Version( ):
   *
   * @return  void
   *
   * @access  private
   * @version 3.1.0
   * @since 3.1.0
   */
  public function get_typo3Version()
  {
    if ( $this->typo3Version !== null )
    {
      return $this->typo3Version;
    }
    // RETURN : typo3Version is set
    // Set TYPO3 version as integer (sample: 4.7.7 -> 4007007)
    list( $main, $sub, $bugfix ) = explode( '.', TYPO3_version );
    $version = ( ( int ) $main ) * 1000000;
    $version = $version + ( ( int ) $sub ) * 1000;
    $version = $version + ( ( int ) $bugfix ) * 1;
    $this->typo3Version = $version;
    // Set TYPO3 version as integer (sample: 4.7.7 -> 4007007)

    if ( $this->typo3Version < 4005000 )
    {
      $prompt = '<h1>ERROR</h1>
        <h2>Unproper TYPO3 version</h2>
        <ul>
          <li>
            TYPO3 version is smaller than 4.5.0
          </li>
          <li>
            constant TYPO3_version: ' . TYPO3_version . '
          </li>
          <li>
            integer $this->typo3Version: ' . ( int ) $this->typo3Version . '
          </li>
        </ul>
          ';
      die( $prompt );
    }

    return $this->typo3Version;
  }

  /*   * *********************************************
   *
   * Html
   *
   * ******************************************** */

  /**
   * htmlReport( )
   *
   * @return	string
   */
  private function htmlReport()
  {
    // RETURN : error, there isn't any report
    if ( !is_array( $this->arrReport ) )
    {
      $prompt = '
        <h1>
          No Report
        </h1>
        <p>
          This is a mistake!
        </p>';
      return $prompt;
    }
    // RETURN : error, there isn't any report

    $arrPrompt = array();
    if ( !$this->bool_error )
    {
      if ( !$this->piVars[ 'confirm' ] )
      {
        $arrPrompt[] = '
          <h1>
            ' . $this->pi_getLL( 'begin_h1' ) . '
          </h1>';
      }
      if ( $this->piVars[ 'confirm' ] )
      {
        $arrPrompt[] = '
          <h1>
            ' . $this->pi_getLL( 'end_h1' ) . '
          </h1>';
      }
    }
    $arrPrompt = array_merge( $arrPrompt, $this->arrReport );
    $prompt = implode( null, $arrPrompt );

    return $prompt;
  }

  /*   * *********************************************
   *
   * Init
   *
   * ******************************************** */

  /**
   * initBoolTopLevel(): If current page is on the top level, $this->bool_topLevel will become true.
   *                      If not, false.
   *
   * @return	void
   * @access private
   * @version 6.0.0
   * @since 2.1.1
   */
  private function init()
  {
    $this->initBoolTopLevel();
    $this->initLlstatic();
    $this->initPowermailVersion();
  }

  /**
   * initBoolTopLevel(): If current page is on the top level, $this->bool_topLevel will become true.
   *                      If not, false.
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 2.1.1
   */
  private function initBoolTopLevel()
  {
    $select_fields = 'pid';
    $from_table = 'pages';
    $where_clause = 'uid = ' . $GLOBALS[ 'TSFE' ]->id;
    $groupBy = null;
    $orderBy = null;
    $limit = null;
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit));
    $res = $GLOBALS[ 'TYPO3_DB' ]->exec_SELECTquery( $select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit );
    $row = $GLOBALS[ 'TYPO3_DB' ]->sql_fetch_assoc( $res );

    if ( $row[ 'pid' ] < 1 )
    {
      $this->bool_topLevel = true;
    }
    if ( $row[ 'pid' ] >= 1 )
    {
      $this->bool_topLevel = false;
    }
  }

  /**
   * initLlstatic( )
   *
   * @return	void
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function initLlstatic()
  {
    $confArr = unserialize( $GLOBALS[ 'TYPO3_CONF_VARS' ][ 'EXT' ][ 'extConf' ][ 'org_installer' ] );
    $this->LLstatic = $confArr[ 'LLstatic' ];
  }

  /**
   * initPowermailVersion( ) :
   *
   * @return	void
   * @access private
   * @version    3.0.0
   * @since      3.0.0
   */
  private function initPowermailVersion()
  {
    $arrResult = $this->zz_getExtensionVersion( 'powermail' );
    $this->powermailVersionInt = $arrResult[ 'int' ];
    $this->powermailVersionStr = $arrResult[ 'str' ];
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
    if ( $this->typo3Version !== null )
    {
      return;
    }
    // RETURN : typo3Version is set
    // Set TYPO3 version as integer (sample: 4.7.7 -> 4007007)
    list( $main, $sub, $bugfix ) = explode( '.', TYPO3_version );
    $version = ( ( int ) $main ) * 1000000;
    $version = $version + ( ( int ) $sub ) * 1000;
    $version = $version + ( ( int ) $bugfix ) * 1;
    $this->typo3Version = $version;
    // Set TYPO3 version as integer (sample: 4.7.7 -> 4007007)
//echo __METHOD__ . ' (' . __LINE__ . '): ' . typo3Version . '<br />' . PHP_EOL;

    if ( $this->typo3Version < 3000000 )
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
            integer $this->typo3Version: ' . ( int ) $this->typo3Version . '
          </li>
        </ul>
          ';
      die( $prompt );
    }
  }

  /*   * *********************************************
   *
   * Install
   *
   * ******************************************** */

  /**
   * install( ) :
   *
   * @return	boolean     $success  : true
   * @access     private
   * @version    3.0.0
   * @since      1.0.0
   */
  //http://forge.typo3.org/issues/9632
  //private function install($str_installCase)
  private function install()
  {
    $success = true;

    // #57390, 140327, dwildt, 7+
    // RETURN if there is any problem with dependencies
    if ( !$this->typo3ConfigVarsCheck() )
    {
      $success = false;
      return $success;
    }

    // RETURN if there is any problem with dependencies
    if ( !$this->extensionCheck() )
    {
      $success = false;
      return $success;
    }
    // RETURN if there is any problem with dependencies

    $bool_confirm = $this->confirmation();
    if ( !$bool_confirm )
    {
      $success = true;
      return $success;
    }

    $this->init();
    $this->create();
    $this->consolidate();

    $this->promptCleanUp();

    return $success;
  }

  /**
   * installNothing( ) : Write a prompt to the global $arrReport
   *
   * @return	boolean		$success  : true
   * @access private
   * @version    3.0.0
   * @since      1.0.0
   */
  private function installNothing()
  {
    $success = false;

    $this->arrReport[] = '
      <p>
        ' . $this->arr_icons[ 'warn' ] . $this->pi_getLL( 'plugin_warn' ) . '<br />
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'plugin_help' ) . '
      </p>';

    return $success;
  }

  /*   * *********************************************
   *
   * Prompt
   *
   * ******************************************** */

  /**
   * promptCleanUp( ) :
   *
   * @return	void
   * @access private
   * @version    3.0.0
   * @since      1.0.0
   */
  private function promptCleanUp()
  {
    // Get the cHash. Important in case of realUrl and no_cache=0
    $cHash_calc = $this->zz_getCHash( false );

    $this->arrReport[] = '
      <h2>
       ' . $this->pi_getLL( 'end_header' ) . '
      </h2>
      <p>
       ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'end_reloadBe_prompt' ) . '<br />
       ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'end_deletePlugin_prompt' ) . '
      </p>
      <div style="text-align:right;">
        <form name="form_confirm" method="POST">
          <fieldset id="fieldset_confirm" style="border:1px solid #F66800;padding:1em;">
            <legend style="color:#F66800;font-weight:bold;padding:0 1em;">
              ' . $this->pi_getLL( 'end_header' ) . '
            </legend>
            <input type="hidden" name="cHash"  value="' . $cHash_calc . '" />
            <input type="submit" name="submit" value=" ' . $this->pi_getLL( 'end_button' ) . ' " />
          </fieldset>
        </form>
      </div>
      ';
  }

  /*   * *********************************************
   *
   * TYPO3 configa vars (global configuration
   *
   * ******************************************** */

  /**
   * typo3ConfigVarsCheck( ) :  Checks whether needed ...
   *
   * @return	boolean
   * @access private
   * @version   6.0.0
   * @since     4.0.3
   */
  private function typo3ConfigVarsCheck()
  {
    $success = true;

    // RETURN  if form is confirmed
    if ( $this->piVars[ 'confirm' ] )
    {
      return $success;
    }

//    // #61663, 140916, dwildt, 1+
//    return true;
//    // #61663, 140916, dwildt, -
    // Header
    $this->arrReport[] = '
      <h2>
       ' . $this->pi_getLL( 'typo3ConfigVars_header' ) . '
      </h2>
      ';


    if ( !$this->typo3ConfigVarsCheckFePageNotFoundOnCHashError() )
    {
      $success = false;
    }

    return $success;
  }

  /**
   * typo3ConfigVarsCheckFePageNotFoundOnCHashError( ) :  Checks whether needed ...
   *
   * @return	boolean
   * @access private
   * @version   4.0.3
   * @since     4.0.3
   */
  private function typo3ConfigVarsCheckFePageNotFoundOnCHashError()
  {
//    // #61663, 140916, dwildt, 1+
//    return true;
//    // #61663, 140916, dwildt, -
    global $TYPO3_CONF_VARS;

    $configIsOk = false;
    $pageNotFoundOnCHashError = $TYPO3_CONF_VARS[ 'FE' ][ 'pageNotFoundOnCHashError' ];

    // RETURN : configuration is proper
    if ( $pageNotFoundOnCHashError == false )
    {
      $this->arrReport[] = '
        <p>
        ' . $this->arr_icons[ 'ok' ] . ' $TYPO3_CONF_VARS[FE][pageNotFoundOnCHashError] ' . $this->pi_getLL( 'typo3ConfigVars_ok' ) . '
        </p>';
      $configIsOk = true;
      return $configIsOk;
    }

    // RETURN : configuration is unproper
    $prompt = '
      <h3>
        ' . $this->pi_getLL( 'typo3ConfigVars_pageNotFoundOnCHashError_header' ) . '
      </h3>
      <p>
        ' . $this->arr_icons[ 'error' ] . $this->pi_getLL( 'typo3ConfigVars_pageNotFoundOnCHashError_error' ) . '<br />
        ' . $this->arr_icons[ 'info' ] . $this->pi_getLL( 'typo3ConfigVars_pageNotFoundOnCHashError_help' ) . '
      </p>';

    $this->arrReport[] = $prompt;
    $configIsOk = false;
    return $configIsOk;
  }

  /*   * *********************************************
   *
   * ZZ
   *
   * ******************************************** */

  /**
   * createFilesStaff( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function zz_copyFiles( $srceDir, $destDir = 'uploads/tx_org/' )
  {

    //////////////////////////////////////////////////////////////////////
    //
    // Copy product images to upload folder
    // General values
    $str_pathSrce = t3lib_extMgm::siteRelPath( $this->extKey ) . $srceDir;
    $str_pathDest = $destDir;
    // General values

    foreach ( $this->arr_fileUids as $str_fileSrce => $str_fileDest )
    {
      // CONTINUE : srce is a directory only
      if ( is_dir( $str_pathSrce . $str_fileSrce ) )
      {
        continue;
      }
      // CONTINUE : srce is a directory only
      // CONTINUE : file does not exist (this may be proper)
      if ( !file_exists( $str_pathSrce . $str_fileSrce ) )
      {
        continue;
      }
      // CONTINUE : file does not exist (this may be proper)
      // #59519, dwildt, +
      if ( !is_dir( $destDir ) )
      {
        if ( !mkdir( $destDir, 0770, true ) )
        {
          $prompt = ''
                  . 'Fatal error! ' . PHP_EOL
                  . 'Failed to create ' . $destDir . PHP_EOL
                  . 'Method: ' . __METHOD__ . ' at line ' . __LINE__ . PHP_EOL
                  . PHP_EOL
                  . 'Sorry for the trouble. ' . PHP_EOL
                  . 'TYPO3 Organiser Installer ' . PHP_EOL
          ;
          die( $prompt );
        }
      }

      $bool_success = copy( $str_pathSrce . $str_fileSrce, $str_pathDest . $str_fileDest );
      // CONTINUE : copy was succesful
      if ( $bool_success )
      {
        $this->markerArray[ '###DEST###' ] = $str_fileDest;
        $this->markerArray[ '###PATH###' ] = $str_pathDest;
        $str_file_prompt = '
          <p>
            ' . $this->arr_icons[ 'ok' ] . ' ' . $this->pi_getLL( 'files_create_prompt' ) . '
          </p>';
        $str_file_prompt = $this->cObj->substituteMarkerArray( $str_file_prompt, $this->markerArray );
        $this->arrReport[] = $str_file_prompt;

        continue;
      }
      // CONTINUE : copy was succesful

      $this->markerArray[ '###SRCE###' ] = $str_pathSrce . $str_fileSrce;
      $this->markerArray[ '###DEST###' ] = $str_pathDest . $str_fileDest;
      $str_file_prompt = '
        <p>
          ' . $this->arr_icons[ 'warn' ] . ' ' . $this->pi_getLL( 'files_create_prompt_error' ) . '
        </p>';
      $str_file_prompt = $this->cObj->substituteMarkerArray( $str_file_prompt, $this->markerArray );
      $this->arrReport[] = $str_file_prompt;
    }
    // Copy product images to upload folder

    return;
  }

  /**
   * Calculate the cHash md5 value
   *
   * @param	string		$str_params: URL parameter string like &tx_browser_pi1[showUid]=12&&tx_browser_pi1[cat]=1
   * @return	string		$cHash_md5: md5 value like d218cfedf9
   *
   * @version 4.0.0
   * @since 1.0.0
   */
  private function zz_getCHash( $str_params )
  {
    switch ( true )
    {
      case( $this->typo3Version < 6000000 ):
        $cHash_array = t3lib_div::cHashParams( $str_params );
        // 140114, dwildt, 1+
        $cHash_md5 = t3lib_div::shortMD5( serialize( $cHash_array ) );
        break;
      default:
        $cacheHash = t3lib_div::makeInstance( 't3lib_cacheHash' );
        // 140114, dwildt, 1-
        $cHash_array = $cacheHash->getRelevantParameters( $str_params );
        //$cHash_md5_2 = $cacheHash->calculateCacheHash($cHash_array);
        $cHash_md5 = $cacheHash->generateForParameters( $str_params );
        //var_dump( __METHOD__, __LINE__, $cHash_array, $cHash_md5_2, $cHash_md5 );
        // 140114, dwildt, 1+
        break;
    }

    return $cHash_md5;
  }

  /**
   * zz_getMaxDbUid( )
   *
   * @param	string		$table      : the table
   * @return	integer		$int_maxUid : max uid in given table
   */
  public function zz_getMaxDbUid( $table )
  {
    $int_maxUid = false;

    $select_fields = 'max(`uid`) AS "uid"';
    $from_table = '`' . $table . '`';
    $where_clause = '';
    $groupBy = '';
    $orderBy = '';
    $limit = '';
    $uidIndexField = '';

    //var_dump($GLOBALS['TYPO3_DB']->SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField));
    $rows = $GLOBALS[ 'TYPO3_DB' ]->exec_SELECTgetRows( $select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField );

    if ( is_array( $rows ) && count( $rows ) > 0 )
    {
      $int_maxUid = $rows[ 0 ][ 'uid' ];
    }
    return $int_maxUid;
  }

  /**
   * Shop will be installed - with or without template
   *
   * @return	The		content that is displayed on the website
   */
  private function zz_getPathToIcons()
  {
    $pathToIcons = t3lib_extMgm::siteRelPath( $this->extKey ) . '/res/images/22x22/';
    $this->arr_icons[ 'error' ] = '<img width="22" height="22" src="' . $pathToIcons . 'dialog-error.png"> ';
    $this->arr_icons[ 'warn' ] = '<img width="22" height="22" src="' . $pathToIcons . 'dialog-warning.png"> ';
    $this->arr_icons[ 'ok' ] = '<img width="22" height="22" src="' . $pathToIcons . 'dialog-ok-apply.png"> ';
    $this->arr_icons[ 'info' ] = '<img width="22" height="22" src="' . $pathToIcons . 'dialog-information.png"> ';
  }

  /**
   * extMgmVersion( ): Returns the version of an extension as an interger and a string.
   *                   I.e
   *                   * int: 4007007
   *                   * str: 4.7.7
   *
   * @param	string		$_EXTKEY    : extension key
   * @return	array		$arrReturn  : version as int (integer) and str (string)
   * @access private
   * @version 2.0.0
   * @since 2.0.0
   */
  private function zz_getExtensionVersion( $_EXTKEY )
  {
    $arrReturn = null;

    if ( !t3lib_extMgm::isLoaded( $_EXTKEY ) )
    {
      $arrReturn[ 'int' ] = 0;
      $arrReturn[ 'str' ] = 0;
      return $arrReturn;
    }

    // Do not use require_once!
    require( t3lib_extMgm::extPath( $_EXTKEY ) . 'ext_emconf.php');
    $strVersion = $EM_CONF[ $_EXTKEY ][ 'version' ];

    // Set version as integer (sample: 4.7.7 -> 4007007)
    list( $main, $sub, $bugfix ) = explode( '.', $strVersion );
    $intVersion = ( ( int ) $main ) * 1000000;
    $intVersion = $intVersion + ( ( int ) $sub ) * 1000;
    $intVersion = $intVersion + ( ( int ) $bugfix ) * 1;
    // Set version as integer (sample: 4.7.7 -> 4007007)

    $arrReturn[ 'int' ] = $intVersion;
    $arrReturn[ 'str' ] = $strVersion;
    return $arrReturn;
  }

  /**
   * Shop will be installed - with or without template
   *
   * @return	The		content that is displayed on the website
   */
  private function zz_getFlexValues()
  {
    // Set defaults
    // 120613, dwildt+
    $this->markerArray[ '###WEBSITE_TITLE###' ] = 'TYPO3 Organiser';
    $this->markerArray[ '###MAIL_DEFAULT_RECIPIENT###' ] = 'mail@my-domain.com';
    // 120613, dwildt+
    // Set defaults
    // Init methods for pi_flexform
    $this->pi_initPIflexForm();

    // Get values from the flexform
    $this->arr_piFlexform = $this->cObj->data[ 'pi_flexform' ];

    if ( is_array( $this->arr_piFlexform ) )
    {
      foreach ( ( array ) $this->arr_piFlexform[ 'data' ][ 'sDEF' ][ 'lDEF' ] as $key => $arr_value )
      {
        $this->markerArray[ '###' . strtoupper( $key ) . '###' ] = $arr_value[ 'vDEF' ];
      }
    }

    // #i0014, dwildt, 140612, 1+
    $this->markerArray[ '###BE_USER###' ] = $this->markerArray[ '###BACKEND_USER###' ];


    // Set the URL
    if ( !isset( $this->markerArray[ '###URL###' ] ) )
    {
      $this->markerArray[ '###HOST###' ] = t3lib_div::getIndpEnv( 'TYPO3_REQUEST_HOST' );
    }
    if ( !$this->markerArray[ '###HOST###' ] )
    {
      $this->markerArray[ '###HOST###' ] = t3lib_div::getIndpEnv( 'TYPO3_REQUEST_HOST' );
    }
    // Set the URL
  }

}

if ( defined( 'TYPO3_MODE' ) && $TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/org_installer/pi1/class.tx_orginstaller_pi1.php' ] )
{
  include_once($TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/org_installer/pi1/class.tx_orginstaller_pi1.php' ]);
}