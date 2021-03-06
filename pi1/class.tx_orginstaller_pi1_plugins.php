<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2015 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 *   77: class tx_orginstaller_pi1_plugins
 *
 *              SECTION: Main
 *  101:     public function main( )
 *  122:     private function mainRecords( )
 *
 *              SECTION: Browser - TYPO3 without PHP
 *  183:     private function browserPageOrg( $uid )
 *  232:     private function browserPageOrgDocumentsDocuments( $uid )
 *  281:     private function browserPageOrgHeadquarters( $uid )
 *  330:     private function browserPageOrgCalLocations( $uid )
 *  379:     private function browserPageOrgNews( $uid )
 *  428:     private function browserPageOrgStaff( $uid )
 *
 *              SECTION: Caddy
 *  485:     private function caddyPageOrgCaddy( $uid )
 *  518:     private function caddyPageOrgDocumentsCaddy( $uid )
 *  551:     private function caddyminiPageOrgCaddyCaddymini( $uid )
 *  597:     private function caddyminiPageOrgDocumentsCaddyCaddymini( $uid )
 *
 *              SECTION: Powermail
 *  649:     private function powermailPageOrgCaddy( $uid )
 *  688:     private function powermailPageOrgCaddy1x( $uid )
 *  744:     private function powermailPageOrgCaddy2x( $uid )
 *  776:     private function powermailPageOrgDocumentsCaddy( $uid )
 *  815:     private function powermailPageOrgDocumentsCaddy1x( $uid )
 *  871:     private function powermailPageOrgDocumentsCaddy2x( $uid )
 *
 *              SECTION: Sql
 *  911:     private function sqlInsert( $records )
 *
 *              SECTION: zz - helper
 *  962:     private function zzGetFlexformBrowser( )
 *
 * TOTAL FUNCTIONS: 20
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Plugin 'Organiser Installer' for the 'org_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_orginstaller
 * @version 7.2.0
 * @since 3.0.0
 */
class tx_orginstaller_pi1_plugins
{

  public $prefixId = 'tx_orginstaller_pi1_plugins';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_orginstaller_pi1_plugins.php';  // Path to this script relative to the extension dir.
  public $extKey = 'org_installer';                      // The extension key.
  public $pObj = null;

  /*   * *********************************************
   *
   * Main
   *
   * ******************************************** */

  /**
   * main( )
   *
   * @return	void
   * @access public
   * @version 3.0.0
   * @since   0.0.1
   */
  public function main()
  {
    $records = array();

    $this->pObj->arrReport[] = '
      <h2>
       ' . $this->pObj->pi_getLL( 'plugin_create_header' ) . '
      </h2>';

    $records = $this->mainRecords();
    $this->sqlInsert( $records );
  }

  /**
   * mainRecords( )
   *
   * @return	array		$records : the plugin records
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function mainRecords()
  {
    $records = array();
    $uid = $this->pObj->zz_getMaxDbUid( 'tt_content' );

    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrg( $uid );

    // #61838, 140923, dwildt, 2+
    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrgCalCal( $uid );

    // #61826, 140923, dwildt, 2+
    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrgCalEvents( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrgCalLocations( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrgDocumentsDocuments( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrgHeadquarters( $uid );

    // #61779, 140921, dwildt, 2+
    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrgJobs( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrgNews( $uid );

    // #61779, 140921, dwildt, 2+
    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrgService( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrgStaff( $uid );

    // #67210, 150531, dwildt, 2+
    $uid = $uid + 1;
    $records[ $uid ] = $this->browserPageOrgStaffVcard( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->caddyPageOrgCaddy( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->caddyminiPageOrgCaddyCaddymini( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->caddyPageOrgDocumentsCaddy( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->caddyminiPageOrgDocumentsCaddyCaddymini( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->powermailPageOrgCaddy( $uid );

    $uid = $uid + 1;
    $records[ $uid ] = $this->powermailPageOrgDocumentsCaddy( $uid );

    // #61779, 140921, dwildt, 2+
    $uid = $uid + 1;
    $records[ $uid ] = $this->powermailPageOrgJobsJobsApply( $uid );

    return $records;
  }

  /*   * *********************************************
   *
   * Browser - TYPO3 without PHP
   *
   * ******************************************** */

  /**
   * browserPageOrg( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function browserPageOrg( $uid )
  {
    // #61838, 140923, dwildt, 1+
    return;

    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalCal_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgCalCal_header' ] = $uid;

    $ffDownloads = 'no';
    // #61819, 140923, dwildt, 2-
    //$ffJavascript = 'list_and_single';
    //$ffjQueryUi   = 'blitzer';
    // #61819, 140923, dwildt, 2+
    $ffJavascript = 'disabled';
    $ffjQueryUi = 'z_none';
    $ffMode = 201;  // calendar
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalCal_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalCal_ffListTitle' ) );
    $ffStatistics = 'no';
    $ffTableField = 'tx_org_cal.title';
    // #61819, 140923, dwildt, 1-
    //$ffRecBrowser = 'by_flexform';
    // #61819, 140923, dwildt, 2+
    $ffRecBrowser = 'disabled';
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/Foundation/main_01.html';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    // #61819, 140923, dwildt, 1+
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );


    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $GLOBALS[ 'TSFE' ]->id;
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256 * 1;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /**
   * browserPageOrgCalCal( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @internal #61838, #i0017
   * @version 6.0.0
   * @since   6.0.0
   */
  private function browserPageOrgCalCal( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalCal_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgCalCal_header' ] = $uid;

    $ffDownloads = 'no';
    $ffJavascript = 'disabled';
    $ffjQueryUi = 'z_none';
    $ffMode = 201;  // calendar
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalCal_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalCal_ffListTitle' ) );
    $ffStatistics = 'no';
    $ffTableField = 'tx_org_cal.title';
    $ffRecBrowser = 'disabled';
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/Foundation/main_03.html';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );


    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgCalCal_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256 * 1;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /**
   * browserPageOrgCalEvents( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @internal #61826
   * @version 6.0.0
   * @since   6.0.0
   */
  private function browserPageOrgCalEvents( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalEvents_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgCalEvents_header' ] = $uid;

    $ffJavascript = 'disabled';
    $ffjQueryUi = 'z_none';
    $ffMode = 61826;
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalEvents_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalEvents_ffListTitle' ) );
    $ffTableField = 'tx_org_event.title';
    $ffDownloads = 'no';
    $ffStatistics = 'no';
    $ffRecBrowser = 'disabled';
    // #61696, 140920, dwildt, 1+
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/Foundation/main_01.html';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    // #61696, 140920, dwildt, 1+
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgCalEvents_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'hidden' ] = 0;
    $record[ 'sorting' ] = 128;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /**
   * browserPageOrgCalLocations( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function browserPageOrgCalLocations( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalLocations_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgCalLocations_header' ] = $uid;

    $ffJavascript = 'disabled';
    $ffjQueryUi = 'z_none';
    $ffMode = 701;
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalLocations_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgCalLocations_ffListTitle' ) );
    $ffTableField = 'tx_org_location.title';
    $ffDownloads = 'no';
    $ffStatistics = 'no';
    $ffRecBrowser = 'disabled';
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/Foundation/main_01.html';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgCalLocations_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 128;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /**
   * browserPageOrgDocumentsDocuments( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function browserPageOrgDocumentsDocuments( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgDocumentsDocuments_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgDocumentsDocuments_header' ] = $uid;

    $ffJavascript = 'disabled';
    // #62018, 141003, dwildt, 1-
    //$ffjQueryUi   = 'blitzer';
    // #62018, 141003, dwildt, 1+
    $ffjQueryUi = 'z_none';
    $ffMode = 301;
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgDocumentsDocuments_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgDocumentsDocuments_ffListTitle' ) );
    $ffTableField = 'tx_org_downloads.title';
    $ffDownloads = 'yes';
    $ffStatistics = 'yes';
    // #62018, 141003, dwildt, 1-
    //$ffRecBrowser = 'by_flexform';
    // #62018, 141003, dwildt, 2+
    $ffRecBrowser = 'disabled';
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/Foundation/main_03.html';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    // #62018, 141003, dwildt, 1+
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgDocumentsDocuments_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 128;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /**
   * browserPageOrgHeadquarters( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function browserPageOrgHeadquarters( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgHeadquarters_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgHeadquarters_header' ] = $uid;

    $ffJavascript = 'disabled';
    // #61696, 140920, dwildt, 1-
    //$ffjQueryUi   = 'blitzer';
    // #61696, 140920, dwildt, 1+
    $ffjQueryUi = 'z_none';
    $ffMode = 501;
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgHeadquarters_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgHeadquarters_ffListTitle' ) );
    $ffTableField = 'tx_org_headquarters.title';
    $ffDownloads = 'no';
    $ffStatistics = 'no';
    $ffRecBrowser = 'disabled';
    // #61696, 140920, dwildt, 1+
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/Foundation/main_04.html';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    // #61696, 140920, dwildt, 1+
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgHeadquarters_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 128;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /**
   * browserPageOrgJobs( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function browserPageOrgJobs( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgJobs_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgJobs_header' ] = $uid;

    $ffJavascript = 'disabled';
    $ffjQueryUi = 'z_none';
    $ffMode = 593611;
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgJobs_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgJobs_ffListTitle' ) );
    $ffTableField = 'tx_org_staff.title';
    $ffDownloads = 'no';
    $ffStatistics = 'no';
    // #61696, 140920, dwildt, 1-
    //$ffRecBrowser = 'by_flexform';
    // #61696, 140920, dwildt, 2+
    $ffRecBrowser = 'disabled';
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/Foundation/main_01.html';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    // #61696, 140920, dwildt, 1+
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgJobs_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    //$record[ 'hidden' ] = 1;
    $record[ 'sorting' ] = 128;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /**
   * browserPageOrgNews( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function browserPageOrgNews( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgNews_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgNews_header' ] = $uid;

    // #i0008, 130912, dwildt
    $ffJavascript = 'disabled';
    // #61696, 140918, dwildt, 1-
    //$ffjQueryUi   = 'blitzer';
    // #61696, 140918, dwildt, 1+
    $ffjQueryUi = 'z_none';
    $ffMode = 401;
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgNews_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgNews_ffListTitle' ) );
    $ffTableField = 'tx_org_news.title';
    $ffDownloads = 'no';
    $ffStatistics = 'no';
    // #61696, 140918, dwildt, 1-
    //$ffRecBrowser = 'by_flexform';
    // #61696, 140918, dwildt, 2+
    $ffRecBrowser = 'disabled';
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/Foundation/main_02.html';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    // #61696, 140918, dwildt, 1+
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgNews_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 128;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /**
   * browserPageOrgService( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function browserPageOrgService( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgService_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgService_header' ] = $uid;

    $ffJavascript = 'disabled';
    $ffjQueryUi = 'z_none';
    $ffMode = 593621;
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgService_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgService_ffListTitle' ) );
    $ffTableField = 'tx_org_staff.title';
    $ffDownloads = 'no';
    $ffStatistics = 'no';
    // #61696, 140920, dwildt, 1-
    //$ffRecBrowser = 'by_flexform';
    // #61696, 140920, dwildt, 2+
    $ffRecBrowser = 'disabled';
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/Foundation/main_02.html';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    // #61696, 140920, dwildt, 1+
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgService_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'hidden' ] = 1;
    $record[ 'sorting' ] = 128;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /**
   * browserPageOrgStaff( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 6.0.0
   * @since   0.0.1
   */
  private function browserPageOrgStaff( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgStaff_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgStaff_header' ] = $uid;

    // #61696, 140920, dwildt, 2-
    //$ffJavascript = 'list_and_single';
    //$ffjQueryUi   = 'blitzer';
    // #61696, 140920, dwildt, 2+
    $ffJavascript = 'disabled';
    $ffjQueryUi = 'z_none';
    $ffMode = 101;
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgStaff_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgStaff_ffListTitle' ) );
    $ffTableField = 'tx_org_staff.title';
    $ffDownloads = 'no';
    $ffStatistics = 'no';
    // #61696, 140920, dwildt, 1-
    //$ffRecBrowser = 'by_flexform';
    // #61696, 140920, dwildt, 2+
    $ffRecBrowser = 'disabled';
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/Foundation/main_02.html';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    // #61696, 140920, dwildt, 1+
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgStaff_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 128;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /**
   * browserPageOrgStaffVcard( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @internal #67210
   * @version 7.2.0
   * @since   7.2.0
   */
  private function browserPageOrgStaffVcard( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginBrowserPageOrgStaffVcard_header' );
    $this->pObj->arr_pluginUids[ 'pluginBrowserPageOrgStaffVcard_header' ] = $uid;

    // #61696, 140920, dwildt, 2-
    //$ffJavascript = 'list_and_single';
    //$ffjQueryUi   = 'blitzer';
    // #61696, 140920, dwildt, 2+
    $ffJavascript = 'disabled';
    $ffjQueryUi = 'z_none';
    $ffMode = 120;
    $ffMycomment = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgStaffVcard_ffMycomment' ) );
    $ffListTitle = htmlspecialchars( $this->pObj->pi_getLL( 'pluginBrowserPageOrgStaffVcard_ffListTitle' ) );
    $ffTableField = 'tx_org_staff.title';
    $ffDownloads = 'no';
    $ffStatistics = 'no';
    $ffRecBrowser = 'disabled';
    $ffTemplate = 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl';

    $pi_flexform = $this->zzGetFlexformBrowser();
    $pi_flexform = str_replace( '%cssJqueryUi%', $ffjQueryUi, $pi_flexform );
    $pi_flexform = str_replace( '%downloads%', $ffDownloads, $pi_flexform );
    $pi_flexform = str_replace( '%javascript%', $ffJavascript, $pi_flexform );
    $pi_flexform = str_replace( '%mode%', $ffMode, $pi_flexform );
    $pi_flexform = str_replace( '%mycomment%', $ffMycomment, $pi_flexform );
    $pi_flexform = str_replace( '%listtitle%', $ffListTitle, $pi_flexform );
    $pi_flexform = str_replace( '%recordbrowser%', $ffRecBrowser, $pi_flexform );
    $pi_flexform = str_replace( '%socialMediaTableFieldList%', $ffTableField, $pi_flexform );
    $pi_flexform = str_replace( '%statistics%', $ffStatistics, $pi_flexform );
    // #61696, 140920, dwildt, 1+
    $pi_flexform = str_replace( 'EXT:browser/Resources/Private/Templates/HTML/main.tmpl', $ffTemplate, $pi_flexform );

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgStaffVcard_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 128;
    $record[ 'CType' ] = 'list';
    $record[ 'list_type' ] = 'browser_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'pages' ] = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $record[ 'recursive' ] = 250;
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = $pi_flexform;

    return $record;
  }

  /*   * *********************************************
   *
   * Caddy
   *
   * ******************************************** */

  /**
   * caddyPageOrgCaddy( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function caddyPageOrgCaddy( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginCaddyPageOrgCaddy_header' );
    $this->pObj->arr_pluginUids[ 'pluginCaddyPageOrgCaddy_header' ] = $uid;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgCalCaddy_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256;
    $record[ 'CType' ] = 'list';
    $record[ 'header' ] = $llHeader;
    $record[ 'list_type' ] = 'caddy_pi1';
    $record[ 'sectionIndex' ] = 1;
// Will updated by consolidate->pageCaddyPluginCaddy
//    $record['pi_flexform']  = '';

    return $record;
  }

  /**
   * caddyPageOrgDocumentsCaddy( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function caddyPageOrgDocumentsCaddy( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginCaddyPageOrgDocumentsCaddy_header' );
    $this->pObj->arr_pluginUids[ 'pluginCaddyPageOrgDocumentsCaddy_header' ] = $uid;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256;
    $record[ 'CType' ] = 'list';
    $record[ 'header' ] = $llHeader;
    $record[ 'list_type' ] = 'caddy_pi1';
    $record[ 'sectionIndex' ] = 1;
// Will updated by consolidate->pageCaddyPluginCaddy
//    $record['pi_flexform']  = '';

    return $record;
  }

  /**
   * caddyminiPageOrgCaddyCaddymini( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.5
   * @since   3.0.5
   * @internal  #i0007
   */
  private function caddyminiPageOrgCaddyCaddymini( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginCaddyminiPageOrgCaddyCaddymini_header' );
    $this->pObj->arr_pluginUids[ 'pluginCaddyminiPageOrgCaddyCaddymini_header' ] = $uid;

    $uidCaddyPage = $this->pObj->arr_pageUids[ 'pageOrgCalCaddy_title' ];

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgCalCaddyCaddymini_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256;
    $record[ 'CType' ] = 'list';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100; // hidden
    $record[ 'list_type' ] = 'caddy_pi3';
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="sdefPidCaddy">
                    <value index="vDEF">' . $uidCaddyPage . '</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';

    return $record;
  }

  /**
   * caddyminiPageOrgDocumentsCaddyCaddymini( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.5
   * @since   3.0.5
   * @internal  #i0007
   */
  private function caddyminiPageOrgDocumentsCaddyCaddymini( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginCaddyminiPageOrgDocumentsCaddyCaddymini_header' );
    $this->pObj->arr_pluginUids[ 'pluginCaddyminiPageOrgDocumentsCaddyCaddymini_header' ] = $uid;

    $uidCaddyPage = $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ];

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyCaddymini_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256;
    $record[ 'CType' ] = 'list';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100; // hidden
    $record[ 'list_type' ] = 'caddy_pi3';
    $record[ 'sectionIndex' ] = 1;
    $record[ 'pi_flexform' ] = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="sdefPidCaddy">
                    <value index="vDEF">' . $uidCaddyPage . '</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';

    return $record;
  }

  /*   * *********************************************
   *
   * Powermail
   *
   * ******************************************** */

  /**
   * powermailPageOrgCaddy( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function powermailPageOrgCaddy( $uid )
  {
    switch ( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $record = $this->powermailPageOrgCaddy1x( $uid );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $record = $this->powermailPageOrgCaddy2x( $uid );
        break;
      case( $this->pObj->powermailVersionInt >= 3000000 ):
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is 3.x: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $record;
  }

  /**
   * powermailPageOrgCaddy1x( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function powermailPageOrgCaddy1x( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_header' );
    $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgCaddy_header' ] = $uid;

    $emailRecipient = $this->pObj->markerArray[ '###MAIL_DEFAULT_RECIPIENT###' ]
            . PHP_EOL
            . 'Organiser'
    ;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgCalCaddy_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256 * 3;
    $record[ 'CType' ] = 'powermail_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'list_type' ] = '';
    $record[ 'sectionIndex' ] = 1;
    $record[ 'tx_powermail_title' ] = 'org';
    $record[ 'tx_powermail_recipient' ] = $emailRecipient;
    $record[ 'tx_powermail_subject_r' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_subject_r1x' );
    $record[ 'tx_powermail_subject_s' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_subject_s1x' );
// Will updated by consolidate->pageCaddyPluginPowermail
//    $record['tx_powermail_sender']        = $str_sender;
//    $record['tx_powermail_sendername']    = $str_sendername;
    $record[ 'tx_powermail_confirm' ] = 1;
    $record[ 'tx_powermail_pages' ] = null;
    $record[ 'tx_powermail_multiple' ] = 0;
    $record[ 'tx_powermail_recip_table' ] = 0;
    $record[ 'tx_powermail_recip_id' ] = null;
    $record[ 'tx_powermail_recip_field' ] = null;
    $record[ 'tx_powermail_thanks' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_thanks1x' );
    $record[ 'tx_powermail_mailsender' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_body_s1x' );
    $record[ 'tx_powermail_mailreceiver' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_body_r1x' );
    $record[ 'tx_powermail_redirect' ] = null;
    $record[ 'tx_powermail_fieldsets' ] = 4;
    $record[ 'tx_powermail_users' ] = 0;
    $record[ 'tx_powermail_preview' ] = 0;

    return $record;
  }

  /**
   * powermailPageOrgCaddy2x( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function powermailPageOrgCaddy2x( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_header' );
    $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgCaddy_header' ] = $uid;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgCalCaddy_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256 * 3;
    $record[ 'CType' ] = 'list';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'list_type' ] = 'powermail_pi1';
// Will updated by consolidate->pageCaddyPluginPowermail
//    $record['pi_flexform']              = null;

    return $record;
  }

  /**
   * powermailPageOrgDocumentsCaddy( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function powermailPageOrgDocumentsCaddy( $uid )
  {
    switch ( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $record = $this->powermailPageOrgDocumentsCaddy1x( $uid );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $record = $this->powermailPageOrgDocumentsCaddy2x( $uid );
        break;
      case( $this->pObj->powermailVersionInt >= 3000000 ):
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is 3.x: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $record;
  }

  /**
   * powermailPageOrgDocumentsCaddy1x( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function powermailPageOrgDocumentsCaddy1x( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_header' );
    $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgDocumentsCaddy_header' ] = $uid;

    $emailRecipient = $this->pObj->markerArray[ '###MAIL_DEFAULT_RECIPIENT###' ]
            . PHP_EOL
            . 'Organiser'
    ;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256 * 3;
    $record[ 'CType' ] = 'powermail_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'list_type' ] = '';
    $record[ 'sectionIndex' ] = 1;
    $record[ 'tx_powermail_title' ] = 'org';
    $record[ 'tx_powermail_recipient' ] = $emailRecipient;
    $record[ 'tx_powermail_subject_r' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_subject_r1x' );
    $record[ 'tx_powermail_subject_s' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_subject_s1x' );
// Will updated by consolidate->pageCaddyPluginPowermail
//    $record['tx_powermail_sender']        = $str_sender;
//    $record['tx_powermail_sendername']    = $str_sendername;
    $record[ 'tx_powermail_confirm' ] = 1;
    $record[ 'tx_powermail_pages' ] = null;
    $record[ 'tx_powermail_multiple' ] = 0;
    $record[ 'tx_powermail_recip_table' ] = 0;
    $record[ 'tx_powermail_recip_id' ] = null;
    $record[ 'tx_powermail_recip_field' ] = null;
    $record[ 'tx_powermail_thanks' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_thanks1x' );
    $record[ 'tx_powermail_mailsender' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_body_s1x' );
    $record[ 'tx_powermail_mailreceiver' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_body_r1x' );
    $record[ 'tx_powermail_redirect' ] = null;
    $record[ 'tx_powermail_fieldsets' ] = 4;
    $record[ 'tx_powermail_users' ] = 0;
    $record[ 'tx_powermail_preview' ] = 0;

    return $record;
  }

  /**
   * powermailPageOrgDocumentsCaddy2x( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function powermailPageOrgDocumentsCaddy2x( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_header' );
    $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgDocumentsCaddy_header' ] = $uid;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256 * 3;
    $record[ 'CType' ] = 'list';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'list_type' ] = 'powermail_pi1';
// Will updated by consolidate->pageCaddyPluginPowermail
//    $record['pi_flexform']              = null;

    return $record;
  }

  /**
   * powermailPageOrgJobsJobsApply( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function powermailPageOrgJobsJobsApply( $uid )
  {
    switch ( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $record = $this->powermailPageOrgJobsJobsApply1x( $uid );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $record = $this->powermailPageOrgJobsJobsApply2x( $uid );
        break;
      case( $this->pObj->powermailVersionInt >= 3000000 ):
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is 3.x: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $record;
  }

  /**
   * powermailPageOrgJobsJobsApply1x( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function powermailPageOrgJobsJobsApply1x( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginPowermailPageOrgJobsJobsApply_header' );
    $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgJobsJobsApply_header' ] = $uid;

    $emailRecipient = $this->pObj->markerArray[ '###MAIL_DEFAULT_RECIPIENT###' ]
            . PHP_EOL
            . 'Organiser'
    ;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgJobsJobsApply_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256 * 3;
    $record[ 'CType' ] = 'powermail_pi1';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'list_type' ] = '';
    $record[ 'sectionIndex' ] = 1;
    $record[ 'tx_powermail_title' ] = 'org';
    $record[ 'tx_powermail_recipient' ] = $emailRecipient;
    $record[ 'tx_powermail_subject_r' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgJobsJobsApply_subject_r1x' );
    $record[ 'tx_powermail_subject_s' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgJobsJobsApply_subject_s1x' );
// Will updated by consolidate->pageJobsJobsApplyPluginPowermail
//    $record['tx_powermail_sender']        = $str_sender;
//    $record['tx_powermail_sendername']    = $str_sendername;
    $record[ 'tx_powermail_confirm' ] = 1;
    $record[ 'tx_powermail_pages' ] = null;
    $record[ 'tx_powermail_multiple' ] = 0;
    $record[ 'tx_powermail_recip_table' ] = 0;
    $record[ 'tx_powermail_recip_id' ] = null;
    $record[ 'tx_powermail_recip_field' ] = null;
    $record[ 'tx_powermail_thanks' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgJobsJobsApply_thanks1x' );
    $record[ 'tx_powermail_mailsender' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgJobsJobsApply_body_s1x' );
    $record[ 'tx_powermail_mailreceiver' ] = $this->pObj->pi_getLL( 'pluginPowermailPageOrgJobsJobsApply_body_r1x' );
    $record[ 'tx_powermail_redirect' ] = null;
    $record[ 'tx_powermail_fieldsets' ] = 4;
    $record[ 'tx_powermail_users' ] = 0;
    $record[ 'tx_powermail_preview' ] = 0;

    return $record;
  }

  /**
   * powermailPageOrgJobsJobsApply2x( )
   *
   * @param	integer		$uid: uid of the current plugin
   * @return	array		$record : the plugin record
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function powermailPageOrgJobsJobsApply2x( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'pluginPowermailPageOrgJobsJobsApply_header' );
    $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgJobsJobsApply_header' ] = $uid;

    $record[ 'uid' ] = $uid;
    $record[ 'pid' ] = $this->pObj->arr_pageUids[ 'pageOrgJobsJobsApply_title' ];
    $record[ 'tstamp' ] = time();
    $record[ 'crdate' ] = time();
    $record[ 'cruser_id' ] = $this->pObj->markerArray[ '###BE_USER###' ];
    $record[ 'sorting' ] = 256 * 3;
    $record[ 'CType' ] = 'list';
    $record[ 'header' ] = $llHeader;
    $record[ 'header_layout' ] = 100;  // hidden
    $record[ 'list_type' ] = 'powermail_pi1';
// Will updated by consolidate->pageJobsJobsApplyPluginPowermail
//    $record['pi_flexform']              = null;

    return $record;
  }

  /*   * *********************************************
   *
   * Sql
   *
   * ******************************************** */

  /**
   * sqlInsert( )
   *
   * @param	array		$records : TypoScript records for pages
   * @return	void
   * @access private
   * @version 6.0.7
   * @since   0.0.1
   */
  private function sqlInsert( $records )
  {
    foreach ( $records as $record )
    {
      // #i0028, 141218, dwildt, +
      if ( empty( $record ) )
      {
        //var_dump(__METHOD__, __LINE__, $records );
        continue;
      }

      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery( 'tt_content', $record ) );
      $GLOBALS[ 'TYPO3_DB' ]->exec_INSERTquery( 'tt_content', $record );
      $error = $GLOBALS[ 'TYPO3_DB' ]->sql_error();

      if ( $error )
      {
        $query = $GLOBALS[ 'TYPO3_DB' ]->INSERTquery( 'tt_content', $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                'query: ' . $query . '.<br />' . PHP_EOL .
                'error: ' . $error . '.<br />' . PHP_EOL .
                'Sorry for the trouble.<br />' . PHP_EOL .
                'TYPO3-Organiser Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

      // prompt
      $pageTitle = $this->pObj->arr_pageTitles[ $record[ 'pid' ] ];
      $pageTitle = $this->pObj->pi_getLL( $pageTitle );
      $marker[ '###HEADER###' ] = $record[ 'header' ];
      $marker[ '###TITLE_PID###' ] = '"' . $pageTitle . '" (uid ' . $record[ 'pid' ] . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons[ 'ok' ] . ' ' . $this->pObj->pi_getLL( 'plugin_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[] = $prompt;
      // prompt
    }
  }

  /*   * *********************************************
   *
   * zz - helper
   *
   * ******************************************** */

  /**
   * zzGetFlexformBrowser( )
   *
   * @return	string		$flexform : flexform for the browser plugin
   * @access private
   * @version 3.0.0
   * @since   0.0.1
   */
  private function zzGetFlexformBrowser()
  {
    $flexform = '' .
            '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="myComment">
                    <value index="vDEF">%mycomment%</value>
                </field>
                <field index="views">
                    <value index="vDEF">selected</value>
                </field>
                <field index="viewsHandleFromTemplateOnly">
                    <value index="vDEF">1</value>
                </field>
                <field index="viewsList">
                    <value index="vDEF">%mode%</value>
                </field>
                <field index="downloads.enabled">
                    <value index="vDEF">%downloads%</value>
                </field>
                <field index="statistics.enabled">
                    <value index="vDEF">%statistics%</value>
                </field>
            </language>
        </sheet>
        <sheet index="viewList">
            <language index="lDEF">
                <field index="title">
                    <value index="vDEF">%listtitle%</value>
                </field>
                <field index="titleWrap">
                    <value index="vDEF">&lt;h1 class=&quot;csc-firstHeader&quot;&gt;|&lt;/h1&gt;</value>
                </field>
            </language>
        </sheet>
        <sheet index="viewSingle">
            <language index="lDEF">
                <field index="record_browser">
                    <value index="vDEF">%recordbrowser%</value>
                </field>
            </language>
        </sheet>
        <sheet index="templating">
            <language index="lDEF">
                <field index="template">
                    <value index="vDEF">EXT:browser/Resources/Private/Templates/HTML/main.tmpl</value>
                </field>
                <field index="css.jqui">
                    <value index="vDEF">%cssJqueryUi%</value>
                </field>
            </language>
        </sheet>
        <sheet index="javascript">
            <language index="lDEF">
                <field index="mode">
                    <value index="vDEF">%javascript%</value>
                </field>
            </language>
        </sheet>
        <sheet index="socialmedia">
            <language index="lDEF">
                <field index="enabled">
                    <value index="vDEF">enabled_wi_individual_template</value>
                </field>
                <field index="tablefieldTitle_list">
                    <value index="vDEF">%socialMediaTableFieldList%</value>
                </field>
                <field index="bookmarks_list">
                    <value index="vDEF">facebook,google,twitter</value>
                </field>
                <field index="tablefieldTitle_single">
                    <value index="vDEF">%socialMediaTableFieldList%</value>
                </field>
                <field index="bookmarks_single">
                    <value index="vDEF">facebook,google,twitter</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';

    return $flexform;
  }

}

if ( defined( 'TYPO3_MODE' ) && $TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/org_installer/pi1/class.tx_orginstaller_pi1_plugins.php' ] )
{
  include_once($TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/org_installer/pi1/class.tx_orginstaller_pi1_plugins.php' ]);
}
