<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2013 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   70: class tx_orginstaller_pi1_typoscript
 *
 *              SECTION: Main
 *   94:     public function main( )
 *
 *              SECTION: Records
 *  124:     private function recordOrg( $uid )
 *  154:     private function recordOrg_caseAll( $uid )
 *  416:     private function recordOrg_caseOrgOnly( $uid )
 *  601:     private function recordOrgCaddy( $uid )
 *  655:     private function recordOrgDownloadsCaddy( $uid )
 *  707:     private function recordOrgStaticFiles( )
 *  747:     private function recordOrgStaticFilesPowermail1x( )
 *  765:     private function recordOrgStaticFilesPowermail2x( )
 *  783:     private function records( )
 *
 *              SECTION: Sql
 *  820:     private function sqlInsert( $records )
 *
 *              SECTION: ZZ - Helper
 *  872:     private function zzOrgCaddyConfig( )
 *  912:     private function zzOrgCaddyConfigPowermail1x( )
 *  940:     private function zzOrgCaddyConfigPowermail2x( )
 *  969:     private function zzOrgCaddyStaticFiles( )
 * 1009:     private function zzOrgCaddyStaticFilesPowermail1x( )
 * 1027:     private function zzOrgCaddyStaticFilesPowermail2x( )
 *
 * TOTAL FUNCTIONS: 17
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Plugin 'Organiser Installer' for the 'org_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_orginstaller
 * @version 3.0.0
 * @since 3.0.0
 */
class tx_orginstaller_pi1_typoscript
{
  public $prefixId      = 'tx_orginstaller_pi1_typoscript';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_orginstaller_pi1_typoscript.php';  // Path to this script relative to the extension dir.
  public $extKey        = 'org_installer';                      // The extension key.

  public $pObj = null;



 /***********************************************
  *
  * Main
  *
  **********************************************/

/**
 * main( )
 *
 * @return	void
 * @access public
 * @version 3.0.0
 * @since   3.0.0
 */
  public function main( )
  {
    $records = array( );

    $this->pObj->arrReport[ ] = '
      <h2>
       ' . $this->pObj->pi_getLL( 'ts_create_header' ) . '
      </h2>';

    $records = $this->records( );
    $this->sqlInsert( $records );
  }



 /***********************************************
  *
  * Records
  *
  **********************************************/

/**
 * recordOrg( )
 *
 * @param	[type]		$$uid: ...
 * @return	array
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordOrg( $uid )
  {
    $strUid = sprintf( '%03d', $uid );
    $this->pObj->str_tsRoot = 'page_org_' . $strUid;
    $this->pObj->arr_tsUids[$this->pObj->str_tsRoot] = $uid;

      // SWITCH : install case
    switch( true )
    {
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $record = $this->recordOrg_caseAll( $uid );
        break;
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_org' ):
        $record = $this->recordOrg_caseOrgOnly( $uid );
        break;
    }
      // SWITCH : install case

    return $record;
  }

/**
 * recordOrg_caseAll( )
 *
 * @param	[type]		$$uid: ...
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordOrg_caseAll( $uid )
  {
    $record = null;

    $strUid = sprintf ('%03d', $uid);

    $title  = strtolower( $GLOBALS['TSFE']->page['title'] );
    $title  = str_replace( ' ', null, $title );
    $title  = 'page_' . $title . '_' . $strUid;

    $this->pObj->str_tsRoot = $title;
    $this->pObj->arr_tsUids[$this->pObj->str_tsRoot] = $uid;

    $record['title']                      = $title;
    $record['uid']                        = $uid;
    $record['pid']                        = $GLOBALS['TSFE']->id;
    $record['tstamp']                     = time( );
    $record['sorting']                    = 256;
    $record['crdate']                     = time( );
    $record['cruser_id']                  = $this->pObj->markerArray['###BE_USER###'];
    $record['sitetitle']                  = $this->pObj->markerArray['###WEBSITE_TITLE###'];
    $record['root']                       = 1;
    $record['clear']                      = 3;  // Clear all
    $record['include_static_file']        = 'EXT:css_styled_content/static/,'
                                          . 'EXT:baseorg/static/,'
                                          . 'EXT:browser/static/,'
                                          . 'EXT:caddy/static/,'
                                          . 'EXT:caddy/static/properties/de/,'
                                          . 'EXT:caddy/static/css/,'
                                          . 'EXT:linkhandler/static/link_handler/,'
                                          . 'EXT:flipit/static/,'
                                          . '%flipit46%'
                                          . 'EXT:org/static/base/,'
                                          . 'EXT:org/static/calendar/201/,'
                                          . 'EXT:org/static/calendar/201/caddy/,'
                                          . 'EXT:org/static/department/601/,'
                                          . 'EXT:org/static/downloads/301/,'
                                          . 'EXT:org/static/headquarters/501/,'
                                          . 'EXT:org/static/location/701/,'
                                          . 'EXT:org/static/news/401/,'
                                          . 'EXT:org/static/staff/101/'
                                          ;
    switch( true )
    {
      case( $this->typo3Version < 4007000 ):
        $include = $arr_ts[$int_uid]['include_static_file'];
        $include  = str_replace( '%flipit46%', 'EXT:flipit/static/typo3/4.6/,', $include );
        $include  = $include . ',EXT:org/static/base/typo3/4.6/';
        $arr_ts[$int_uid]['include_static_file'] = $include;
        break;
      default:
        $include = $arr_ts[$int_uid]['include_static_file'];
        $include  = str_replace( '%flipit46%', null, $include );
        $arr_ts[$int_uid]['include_static_file'] = $include;
        break;
    }
    $record['includeStaticAfterBasedOn']  = 1;
    $record['constants'] = '
      
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.baseorg
  // plugin.caddy
  // plugin.org
  // plugin.tx_browser_pi1



  /////////////////////////////////////////
  //
  // plugin.baseorg
plugin.baseorg {
  client {
    name = TYPO3 Organiser Installer
  }
    // for baseURL
  host = ' . $this->pObj->markerArray['###HOST###'] . '/
  pages {
    root = ' . $this->pObj->arr_pageUids[ 'pageOrg_title' ] . '
    root {
      caddymini = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyCaddymini_title' ] . ' 
      libraries {
        footer = ' . $this->pObj->arr_pageUids[ 'pageOrgLibraryFooter_title' ] . '
        header {
          logo = ' . $this->pObj->arr_pageUids[ 'pageOrgLibraryHeaderLogo_title' ] . '
          slider {
            content = ' . $this->pObj->arr_pageUids[ 'pageOrgLibraryHeaderSlider_title' ] . '
          }
        }
        menu {
          bottom = ' . $this->pObj->arr_pageUids[ 'pageOrgLibraryMenubelow_title' ] . '
        }
      }
    }
  }
  slider {
    colpos = 1
  }
}
  // plugin.baseorg



  /////////////////////////////////////////
  //
  // plugin.caddy

plugin.caddy {
  pages {
    caddy           = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddy_title' ] . '
    caddyCaddymini  = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyCaddymini_title' ] . ' 
    revocation      = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyRevocation_title' ] . '
    shop            = ' . $this->pObj->arr_pageUids[ 'pageOrg_title' ] . '
    terms           = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyTerms_title' ] . '
  }
}
  // plugin.caddy



  /////////////////////////////////////////
  //
  // plugin.org

plugin.org {
  host = ' . $this->pObj->markerArray['###HOST###'] . '/
  sysfolder {
    calendar    = ' . $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ] . '
    downloads   = ' . $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ] . '
    event       = ' . $this->pObj->arr_pageUids[ 'pageOrgDataEvents_title' ] . '
    headquarter = ' . $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ] . '
    location    = ' . $this->pObj->arr_pageUids[ 'pageOrgDataLocations_title' ] . '
    news        = ' . $this->pObj->arr_pageUids[ 'pageOrgDataNews_title' ] . '
    staff       = ' . $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ] . '
  }
  pages {
    calendar                = ' . $this->pObj->arr_pageUids[ 'pageOrg_title' ] . '
    downloads               = ' . $this->pObj->arr_pageUids[ 'pageOrgDownloads_title' ] . '
    downloadsCaddy          = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ] . '
    downloadsCaddyCaddymini = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyCaddymini_title' ] . '
    event                   = ' . $this->pObj->arr_pageUids[ 'pageOrg_title' ] . '
    headquarter             = ' . $this->pObj->arr_pageUids[ 'pageOrgHeadquarters_title' ] . '
    location                = ' . $this->pObj->arr_pageUids[ 'pageOrgLocations_title' ] . '
    news                    = ' . $this->pObj->arr_pageUids[ 'pageOrgNews_title' ] . '
    shopping_cart           = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddy_title' ] . '
    shopping_cart_downloads = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ] . '
    staff                   = ' . $this->pObj->arr_pageUids[ 'pageOrgStaff_title' ] . '
  }
  url {
    default {
      calendar        = /
      caddy           = ' . $this->pObj->pi_getLL('pageOrgCaddy_titleUrl') . '/
      downloadsCaddy  = ' . $this->pObj->pi_getLL('pageOrgDocumentsCaddy_titleUrl') . '/
    }
    de {
      calendar        = /
      caddy           = ' . $this->pObj->pi_getLL('pageOrgCaddy_titleUrl') . '/
      downloadsCaddy  = ' . $this->pObj->pi_getLL('pageOrgDocumentsCaddy_titleUrl') . '/
    }
  }
}
  // organiser



  /////////////////////////////////////////
  //
  // plugin.tx_browser_pi1

plugin.tx_browser_pi1 {
  jss {
      // We need jQuery above the slider script
    placement.footer = 0
  }
}
  // plugin.tx_browser_pi1
';

    switch( true )
    {
      case( $this->typo3Version < 4007000 ):
        $html5conf = 'doctype                                 = xhtml_strict';
        break;
      default:
        $html5conf = 'doctype                                 = html5
xmlprologue                             = none';
        break;
    }

    switch($GLOBALS['TSFE']->lang)
    {
      case('de'):
        $localeAll = 'de_DE';
        break;
      default:
        $localeAll = 'en_GB';
        break;
    }

    $record['config']                    = ''.
'
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // config
  // page
  // TYPO3-Browser: ajax page object I
  // TYPO3-Browser: ajax page object II



  // config
config {
  baseURL                                 = ' . t3lib_div::getIndpEnv('TYPO3_REQUEST_HOST') . '/
  tx_realurl_enable                       = 0
  //no_cache                                = 1
  language                                = ' . $GLOBALS['TSFE']->lang . '
  locale_all                              = ' . $localeAll . '
  htmlTag_langKey                         = ' . $GLOBALS['TSFE']->lang . '
  metaCharset                             = UTF-8
  ' . $html5conf . '
  xhtml_cleaning                          = all
  admPanel                                = 1
  disablePrefixComment                    = 1
  spamProtectEmailAddresses               = 5
  spamProtectEmailAddresses_atSubst       = <span style="display:none;">spamfilter</span><span class="dummy">@</span>
  spamProtectEmailAddresses_lastDotSubst  = <span style="display:none;">spamfilter</span><span class="dummy">.</span>
}
  // config



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // page

page {
  config {
    headerComment (
        TYPO3 Organiser is brought to you by die-netzmacher.de
    )
  }
}
  // page



  ////////////////////////////////////////////////////////
  //
  // TYPO3-Browser: ajax page object I

  // Add this snippet into the setup of the TypoScript
  // template of your page.
  // Use \'page\', if the name of your page object is \'page\'
  // (this is a default but there isn\'t any rule)

[globalString = GP:tx_browser_pi1|segment=single] || [globalString = GP:tx_browser_pi1|segment=list] || [globalString = GP:tx_browser_pi1|segment=searchform]
  page >
  page < plugin.tx_browser_pi1.javascript.ajax.page
[global]
  // TYPO3-Browser: ajax page object I



  ////////////////////////////////////////////////////////
  //
  // ajax page object II

browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.default
  // Localised will be (example for German)
//browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.de

  // Example in case of localisation. Here: German has the language uid 1
//[globalVar = GP:L = 1]
//  browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.de
//  browser_ajax {
//      // Language: Configure it with the Constant Editor.
//      //   See: plugin.tx_browser_pi1.typeNum.sys_language_de
//      // Or configure here
//      //   config.sys_language_uid = YOUR_LANGUAGE_ID
//  }
//[global]
  // ajax page object II
';

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date( 'Y-m-d G:i:s' );

    return $record;
  }

/**
 * recordOrg_caseOrgOnly( )
 *
 * @param	[type]		$$uid: ...
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordOrg_caseOrgOnly( $uid )
  {
    $record = null;

    $strUid = sprintf ('%03d', $uid);

    $title  = strtolower( $GLOBALS['TSFE']->page['title'] );
    $title  = str_replace( ' ', null, $title );
    $title  = 'page_' . $title . '_' . $strUid;

    $this->pObj->str_tsRoot = $title;
    $this->pObj->arr_tsUids[$this->pObj->str_tsRoot] = $uid;

    $record['title']                      = $title;
    $record['uid']                        = $uid;
    $record['pid']                        = $GLOBALS['TSFE']->id;
    $record['tstamp']                     = time( );
    $record['sorting']                    = 256;
    $record['crdate']                     = time( );
    $record['cruser_id']                  = $this->pObj->markerArray['###BE_USER###'];
    $record['sitetitle']                  = $this->pObj->markerArray['###WEBSITE_TITLE###'];
    $record['root']                       = 1;
    $record['clear']                      = 3;  // Clear all
    $record['include_static_file']        = 'EXT:browser/static/,'
                                          . 'EXT:caddy/static/,'
                                          . 'EXT:caddy/static/properties/de/,'
                                          . 'EXT:caddy/static/css/,'
                                          . 'EXT:caddy/static/css/green,'
                                          . 'EXT:linkhandler/static/link_handler/,'
                                          . 'EXT:flipit/static/,'
                                          . '%flipit46%'
                                          . 'EXT:flipit/static/typo3/4.6/,'
                                          . 'EXT:org/static/base/,'
                                          . 'EXT:org/static/calendar/201/,'
                                          . 'EXT:org/static/department/601/,'
                                          . 'EXT:org/static/downloads/301/,'
                                          . 'EXT:org/static/headquarters/501/,'
                                          . 'EXT:org/static/location/701/,'
                                          . 'EXT:org/static/news/401/,'
                                          . 'EXT:org/static/staff/101/'
                                          ;
    switch( true )
    {
      case( $this->typo3Version < 4007000 ):
        $include = $arr_ts[$int_uid]['include_static_file'];
        $include  = str_replace( '%flipit46%', 'EXT:flipit/static/typo3/4.6/,', $include );
        $include  = $include . ',EXT:org/static/base/typo3/4.6/';
        $arr_ts[$int_uid]['include_static_file'] = $include;
        break;
      default:
        $include = $arr_ts[$int_uid]['include_static_file'];
        $include  = str_replace( '%flipit46%', null, $include );
        $arr_ts[$int_uid]['include_static_file'] = $include;
        break;
    }
    $record['includeStaticAfterBasedOn']  = 1;
    $record['constants'] = '
      
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.baseorg
  // plugin.org



  /////////////////////////////////////////
  //
  // plugin.baseorg
plugin.baseorg {
    // for baseURL
  host = ' . $this->pObj->markerArray['###HOST###'] . '/
  pages {
    root = ' . $this->pObj->arr_pageUids[ 'pageOrg_title' ] . '
    root {
      librares {
        footer = ' . $this->pObj->arr_pageUids[ 'pageOrgLibraryFooter_title' ] . '
        header {
          logo    = ' . $this->pObj->arr_pageUids[ 'pageOrgLibraryHeaderLogo_title' ] . '
          slider  = ' . $this->pObj->arr_pageUids[ 'pageOrgLibraryHeaderSlider_title' ] . '
        }
      }
    }
  }
  slider {
    colpos = 1
  }
}
  // plugin.baseorg



  /////////////////////////////////////////
  //
  // plugin.org

plugin.org {
  host = ' . $this->pObj->markerArray['###HOST###'] . '/
  sysfolder {
    calendar    = ' . $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ] . '
    downloads   = ' . $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ] . '
    event       = ' . $this->pObj->arr_pageUids[ 'pageOrgDataEvents_title' ] . '
    headquarter = ' . $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ] . '
    location    = ' . $this->pObj->arr_pageUids[ 'pageOrgDataLocations_title' ] . '
    news        = ' . $this->pObj->arr_pageUids[ 'pageOrgDataNews_title' ] . '
    staff       = ' . $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ] . '
  }
  pages {
    calendar                = ' . $this->pObj->arr_pageUids[ 'pageOrg_title' ] . '
    downloads               = ' . $this->pObj->arr_pageUids[ 'pageOrgDownloads_title' ] . '
    downloadsCaddy          = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ] . '
    downloadsCaddyCaddymini = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyCaddymini_title' ] . '
    event                   = ' . $this->pObj->arr_pageUids[ 'pageOrg_title' ] . '
    headquarter             = ' . $this->pObj->arr_pageUids[ 'pageOrgHeadquarters_title' ] . '
    location                = ' . $this->pObj->arr_pageUids[ 'pageOrgLocations_title' ] . '
    news                    = ' . $this->pObj->arr_pageUids[ 'pageOrgNews_title' ] . '
    shopping_cart           = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddy_title' ] . '
    shopping_cart_downloads = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ] . '
    staff                   = ' . $this->pObj->arr_pageUids[ 'pageOrgStaff_title' ] . '
  }
  url {
    default {
      calendar        = /
      caddy           = ' . $this->pObj->pi_getLL('pageOrgCaddy_titleUrl') . '/
      downloadsCaddy  = ' . $this->pObj->pi_getLL('pageOrgDocumentsCaddy_titleUrl') . '/
    }
    de {
      calendar        = /
      caddy           = ' . $this->pObj->pi_getLL('pageOrgCaddy_titleUrl') . '/
      downloadsCaddy  = ' . $this->pObj->pi_getLL('pageOrgDocumentsCaddy_titleUrl') . '/
    }
  }
}
  // organiser

';

    $record['config']                    = ''.
'
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // page
  // TYPO3-Browser: ajax page object I
  // TYPO3-Browser: ajax page object II



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // page (default)

page {
  config {
    headerComment (
        TYPO3 Organiser is brought to you by die-netzmacher.de
    )
  }
}
  // page (default)



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // page (AJAX)

[globalString = GP:tx_browser_pi1|segment=single] || [globalString = GP:tx_browser_pi1|segment=list] || [globalString = GP:tx_browser_pi1|segment=searchform]
  page >
  page < plugin.tx_browser_pi1.javascript.ajax.page
[global]
  // page (AJAX)



  ////////////////////////////////////////////////////////
  //
  // ajax page object II

browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.default
  // Localised will be (example for German)
//browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.de

  // Example in case of localisation. Here: German has the language uid 1
//[globalVar = GP:L = 1]
//  browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.de
//  browser_ajax {
//      // Language: Configure it with the Constant Editor.
//      //   See: plugin.tx_browser_pi1.typeNum.sys_language_de
//      // Or configure here
//      //   config.sys_language_uid = YOUR_LANGUAGE_ID
//  }
//[global]
  // ajax page object II
';

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date( 'Y-m-d G:i:s' );

    return $record;
  }

/**
 * recordOrgCaddy( )
 *
 * @param	[type]		$$uid: ...
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordOrgCaddy( $uid )
  {
    $record = null;

    $strUid = sprintf( '%03d', $uid );

    $title    = 'pageOrgCaddy_title';
    $llTitle  = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle  = str_replace( ' ', null, $llTitle );
    $llTitle  = '+page_' . $llTitle . '_' . $strUid;

    $this->pObj->arr_tsUids[ $title ] = $uid;
    $this->pObj->arr_tsTitles[ $uid ] = $title;

    $includeStaticFile  = $record['include_static_file']  = $this->zzOrgCaddyStaticFiles( );
// Not needed. Included on root page, because of minicaddy on the root page    
//    $includeStaticFile  = $includeStaticFile
//                        . ','
//                        . 'EXT:caddy/static/css/green/,'
//                        . 'EXT:org/static/calendar/201/caddy/'
//                        ;

    $record['title']                = $llTitle;
    $record['uid']                  = $uid;
    $record['pid']                  = $this->pObj->arr_pageUids[ 'pageOrgCaddy_title' ];
    $record['tstamp']               = time( );
    $record['sorting']              = 256;
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file']  = $includeStaticFile;
      // Will handled by consolidation
//    $record['constants']            = '
//  /////////////////////////////////////////
//  //
//  // caddy
//
//plugin.caddy {
//  pages {
//    caddy           = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddy_title' ] . '
//    caddyCaddymini  = %pageOrgCaddyCaddymini_title%
//    revocation      = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyRevocation_title' ] . '
//    shop            = ' . $this->pObj->arr_pageUids[ 'pageOrg_title' ] . '
//    terms           = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyTerms_title' ] . '
//  }
//}
//  // caddy
//';
//
//    $record['config']               = $this->zzOrgCaddyConfig( );
    $record['description']          = '// Created by ORGANISER INSTALLER at ' . date( 'Y-m-d G:i:s' );

    return $record;
  }

/**
 * recordOrgDownloadsCaddy( )
 *
 * @param	[type]		$$uid: ...
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function recordOrgDownloadsCaddy( $uid )
  {
    $record = null;

    $strUid   = sprintf( '%03d', $uid );
    $title    = 'pageOrgDocumentsCaddy_title';
    $llTitle  = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle  = str_replace( ' ', null, $llTitle );
    $llTitle  = '+page_' . $llTitle . '_' . $strUid;

    $this->pObj->arr_tsUids[ $title ] = $uid;
    $this->pObj->arr_tsTitles[ $uid ] = $title;
    
    $includeStaticFile  = $record['include_static_file']  = $this->zzOrgCaddyStaticFiles( );
    $includeStaticFile  = $includeStaticFile
                        . ','
                        . 'EXT:caddy/static/css/red/,'
                        . 'EXT:org/static/downloads/301/caddy/'
                        ;

    $record['title']                = $llTitle;
    $record['uid']                  = $uid;
    $record['pid']                  = $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ];
    $record['tstamp']               = time( );
    $record['sorting']              = 256;
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file']  = $includeStaticFile;
    $record['constants']            = '
  /////////////////////////////////////////
  //
  // caddy

plugin.caddy {
  pages {
    caddy           = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ] . '
    caddyCaddymini  = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyCaddymini_title' ] . '
    revocation      = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyRevocation_title' ] . '
    shop            = ' . $this->pObj->arr_pageUids[ 'pageOrgDownloads_title' ] . '
    terms           = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyTerms_title' ] . '
  }
}
  // caddy
';

    $record['config']               = $this->zzOrgCaddyConfig( );
    $record['description']          = '// Created by ORGANISER INSTALLER at ' . date( 'Y-m-d G:i:s' );

    return $record;
  }

/**
 * records( )
 *
 * @return	array		$records : the TypoScript records
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function records( )
  {
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( 'sys_template' );

      // TypoScript for the root page
    $uid = $uid + 1;
    $records[$uid] = $this->recordOrg( $uid );

      // TypoScript for the caddy page cal
    $uid = $uid + 1;
    $records[$uid] = $this->recordOrgCaddy( $uid );

      // TypoScript for the caddy page downloads
    $uid = $uid + 1;
    $records[$uid] = $this->recordOrgDownloadsCaddy( $uid );

    return $records;
  }



 /***********************************************
  *
  * Sql
  *
  **********************************************/

/**
 * sqlInsert( )
 *
 * @param	array		$records : TypoScript records for pages
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function sqlInsert( $records )
  {
    foreach( $records as $record )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $record, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'sys_template', $record );
      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->INSERTquery( 'sys_template', $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Organiser Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

        // prompt
      $pageTitle = $this->pObj->arr_pageTitles[$record['pid']];
      $pageTitle = $this->pObj->pi_getLL( $pageTitle );
      $marker['###TITLE###']     = $record['title'];
      $marker['###UID###']       = $record['uid'];
      $marker['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          '.$this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'ts_create_prompt' ).'
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
        // prompt
    }
  }



 /***********************************************
  *
  * ZZ - Helper
  *
  **********************************************/

/**
 * zzOrgCaddyConfig( )
 *
 * @return	string		$staticFiles  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zzOrgCaddyConfig( )
  {
    $config = null;

    switch( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $config = $this->zzOrgCaddyConfigPowermail1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $config = $this->zzOrgCaddyConfigPowermail2x( );
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

    return $config;
  }

/**
 * zzOrgCaddyConfigPowermail1x( )
 *
 * @return	string		$config  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zzOrgCaddyConfigPowermail1x( )
  {
    $config  = '
  ////////////////////////////////////////
  //
  // plugin.tx_powermail_pi1

plugin.tx_powermail_pi1 {
  _LOCAL_LANG {
    de {
      locallangmarker_confirmation_submit = Anmelden
    }
  }
}
  // plugin.tx_powermail_pi1
';

    return $config;
  }

/**
 * zzOrgCaddyConfigPowermail2x( )
 *
 * @return	string		$config  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zzOrgCaddyConfigPowermail2x( )
  {
      // 130721, dwildt: powermail 2.x without an ending slash!
    $config  = '
plugin.tx_powermail {
  _LOCAL_LANG {
    default {
        // Next button will be empty in Powermail 2.x
      //confirmation_next = Order without commitment
    }
    de {
        // Next button will be empty in Powermail 2.x
      //confirmation_next = Unverbindlich testen
    }
  }
}
';

    return $config;
  }

/**
 * zzOrgCaddyStaticFiles( )
 *
 * @return	string		$staticFiles  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zzOrgCaddyStaticFiles( )
  {
    $staticFiles = null;

    switch( true )
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $staticFiles = $this->zzOrgCaddyStaticFilesPowermail1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $staticFiles = $this->zzOrgCaddyStaticFilesPowermail2x( );
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

    return $staticFiles;
  }

/**
 * zzOrgCaddyStaticFilesPowermail1x( )
 *
 * @return	string		$staticFiles  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zzOrgCaddyStaticFilesPowermail1x( )
  {
    $staticFiles  = 'EXT:powermail/static/pi1/,'
                  . 'EXT:powermail/static/css_fancy/,'
                  . 'EXT:caddy/static/powermail/1x/'
                  ;

    return $staticFiles;
  }

/**
 * zzOrgCaddyStaticFilesPowermail2x( )
 *
 * @return	string		$staticFiles  : the list of static files
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zzOrgCaddyStaticFilesPowermail2x( )
  {
      // 130721, dwildt: powermail 2.x without an ending slash!
    $staticFiles  = 'EXT:powermail/Configuration/TypoScript/Main,'
                  . 'EXT:powermail/Configuration/TypoScript/CssFancy,'
                  . 'EXT:caddy/static/powermail/2x/,'
                  . 'EXT:caddy/static/powermail/2x/css/'
                  ;

    return $staticFiles;
  }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_typoscript.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_typoscript.php']);
}