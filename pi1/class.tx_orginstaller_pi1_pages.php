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
 *   71: class tx_orginstaller_pi1_pages
 *
 *              SECTION: Main
 *   95:     public function main( )
 *
 *              SECTION: Create pages
 *  142:     private function pageOrgCaddy( $pageUid, $sorting )
 *  180:     private function pageOrgCaddyCaddymini( $pageUid, $sorting )
 *  220:     private function pageOrgCaddyDelivery( $pageUid, $sorting )
 *  257:     private function pageOrgLegalinfo( $pageUid, $sorting )
 *  294:     private function pageOrgLibrary( $pageUid, $sorting )
 *  345:     private function pageOrgLibraryFooter( $pageUid, $sorting )
 *  384:     private function pageOrgLibraryHeader( $pageUid, $sorting )
 *  423:     private function pageOrgNews( $pageUid, $sorting )
 *  519:     private function pageOrgCaddyRevocation( $pageUid, $sorting )
 *  557:     private function pageOrgCaddyTerms( $pageUid, $sorting )
 *  593:     private function pagesLibrary( $pageUid )
 *  619:     private function pagesLibraryRecords( $pageUid )
 *  647:     private function pagesLibrarySqlInsert( $pages )
 *  674:     private function pageOrg( $pageUid )
 *  695:     private function pageOrgRecords( $pageUid )
 *
 *              SECTION: Sql
 *  752:     private function sqlInsert( $pages )
 *
 *              SECTION: ZZ
 *  803:     private function zz_countPages( $pageUid )
 *
 * TOTAL FUNCTIONS: 18
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
class tx_orginstaller_pi1_pages
{
  public $prefixId      = 'tx_orginstaller_pi1_pages';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_orginstaller_pi1_pages.php';  // Path to this script relative to the extension dir.
  public $extKey        = 'org_installer';                      // The extension key.

  public $pObj = null;



 /***********************************************
  *
  * Main
  *
  **********************************************/

/**
 * main( ) :
 *
 * @return	void
 * @access public
 * @version 3.0.0
 * @since 1.0.0
 */
  public function main( )
  {
      // Prompt header
    $this->pObj->arrReport[ ] = '
      <h2>
       '.$this->pObj->pi_getLL('page_create_header').'
      </h2>';
      // Prompt header

      // Create pages on the root level
    $pageUid = $this->pageOrg( );
    unset( $pageUid );

    return;
  }

  

 /***********************************************
  *
  * Init
  *
  **********************************************/

/**
 * initPageOrg( ) :
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function initPageOrg( )
  {
      // Set the global vars for the root page
    $pageUid      = $GLOBALS['TSFE']->id;
    $pageTitle    = 'pageOrg_title';
      // 130723, dwildt, 1-
    //$llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;
      // Set the global vars for the root page
  }

  

 /***********************************************
  *
  * Create pages
  *
  **********************************************/

/**
 * pageOrg( ) :
 *
 * @return	integer		$pageUid: latest page uid
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrg( )
  {
    $pages = array( );

      // Init page org / the rrot page
    $this->initPageOrg( );
            
      // Get the latest uid from the pages table
    $pageUid = $this->pObj->zz_getMaxDbUid( 'pages' );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgData( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDataCal( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDataDownloads( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDataEvents( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDataHeadquarters( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDataLocations( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDataNews( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDataStaff( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgNews( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDownloads( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDownloadsCaddy( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDownloadsCaddyCaddymini( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDownloadsCaddyDelivery( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDownloadsCaddyRevocation( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgDownloadsCaddyTerms( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgStaff( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgHeadquarters( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgLocations( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgCaddy( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgCaddyCaddymini( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgCaddyDelivery( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgCaddyRevocation( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[$pageUid] = $this->pageOrgCaddyTerms( $pageUid, $sorting );

    if( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' )
    {
      list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
      $pages[$pageUid] = $this->pageOrgLegalinfo( $pageUid, $sorting );

      list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
      $pages[$pageUid] = $this->pageOrgLibrary( $pageUid, $sorting );

      list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
      $pages[$pageUid] = $this->pageOrgLibraryHeader( $pageUid, $sorting );

      list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
      $pages[$pageUid] = $this->pageOrgLibraryHeaderLogo( $pageUid, $sorting );

      list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
      $pages[$pageUid] = $this->pageOrgLibraryHeaderSlider( $pageUid, $sorting );

      list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
      $pages[$pageUid] = $this->pageOrgLibraryFooter( $pageUid, $sorting );

    }

    $this->sqlInsert( $pages );

    return $pageUid;
  }

/**
 * pageOrgCaddy( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgCaddy( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgCaddy_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'caddy',
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgCaddyCaddymini( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgCaddyCaddymini( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgCaddyCaddymini_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgCaddy_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting,
              'nav_hide'      => 1
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgCaddyDelivery( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgCaddyDelivery( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgCaddyDelivery_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgCaddy_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgCaddyRevocation( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgCaddyRevocation( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgCaddyRevocation_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgCaddy_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgCaddyTerms( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @param	string		$dateHumanReadable  : human readabel date
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgCaddyTerms( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgCaddyTerms_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgCaddy_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgData( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgData( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgData_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'org',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN



  ///////////////////////////
  //
  // INDEX

  // TCEFORM
  //    organiser tables
  // LINKHANDLER
  //    mod.tx_linkhandler
  //    RTE.default.tx_linkhandler
  // TCEMAIN
  //    clearCacheCmd
  //    permissions
  // MOD
  //    web_layout



  // PID
  // [' . $pageUid . '] organiser
  //    [%uidPageOrgDataCal%] calendar
  //    [%uidPageOrgDataDownloads%] downloads
  //    [%uidPageOrgDataNews%] news
  //    [%uidPageOrgDataStaff%] staff
  //    [%uidPageOrgDataHeadquarters%] headquarters and departments
  //    [%uidPageOrgDataEvents%] events
  //    [%uidPageOrgDataLocations%] locations

  // organiser tables
TCEFORM {
  fe_users {
    tx_org_downloads {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataDownloads%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataDownloads%
    }
    tx_org_department {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataHeadquarters%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataHeadquarters%
    }
    tx_org_news {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataNews%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataNews%
    }
    usergroup {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataStaff%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataStaff%
    }
  }
  fe_groups {
    subgroup {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataStaff%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataStaff%
    }
  }
  tx_org_cal_all_tables {
    fe_users {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataStaff%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataStaff%
    }
    tx_org_cal {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataCal%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataCal%
    }
    tx_org_calentrance < .tx_org_cal
    tx_org_calspecial  < .tx_org_cal
    tx_org_caltype     < .tx_org_cal
    tx_org_department {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataHeadquarters%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataHeadquarters%
    }
    tx_org_departmentcat < .tx_org_department
    tx_org_event {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataEvents%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataEvents%
    }
    tx_org_downloads {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataDownloads%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataDownloads%
    }
    tx_org_downloadscat   < .tx_org_downloads
    tx_org_downloadsmedia < .tx_org_downloads
    tx_org_headquarters {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataHeadquarters%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataHeadquarters%
    }
    tx_org_news {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataNews%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataNews%
    }
    tx_org_newscat < .tx_org_news
    tx_org_location {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataLocations%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataLocations%
    }
  }
  tx_org_cal            < .tx_org_cal_all_tables
  tx_org_calentrance    < .tx_org_cal_all_tables
  tx_org_calspecial     < .tx_org_cal_all_tables
  tx_org_caltype        < .tx_org_cal_all_tables
  tx_org_department     < .tx_org_cal_all_tables
  tx_org_department {
    manager {
      PAGE_TSCONFIG_IDLIST  = ' . $pageUid . ',%uidPageOrgDataStaff%
      PAGE_TSCONFIG_ID      = %uidPageOrgDataStaff%
    }
    fe_users < .manager
  }
  tx_org_downloads      < .tx_org_cal_all_tables
  tx_org_downloadscat   < .tx_org_cal_all_tables
  tx_org_downloadsmedia < .tx_org_cal_all_tables
  tx_org_event          < .tx_org_cal_all_tables
  tx_org_headquarters   < .tx_org_cal_all_tables
  tx_org_location       < .tx_org_cal_all_tables
  tx_org_news           < .tx_org_cal_all_tables
  tx_org_newscat        < .tx_org_cal_all_tables
}
  // organiser tables
  // TCEFORM




  /////////////////////////////////////
  //
  // LINKHANDLER

  // mod.tx_linkhandler
mod.tx_linkhandler {
  fe_users.onlyPids             = %uidPageOrgDataStaff%
  tx_org_cal.onlyPids           = %uidPageOrgDataCal%
  tx_org_department.onlyPids    = %uidPageOrgDataHeadquarters%
  tx_org_downloads.onlyPids     = %uidPageOrgDataDownloads%
  tx_org_event.onlyPids         = %uidPageOrgDataEvents%
  tx_org_headquarters.onlyPids  = %uidPageOrgDataHeadquarters%
  tx_org_location.onlyPids      = %uidPageOrgDataLocations%
  tx_org_news.onlyPids          = %uidPageOrgDataNews%
}

  // Remove RTE default configuration
RTE.default.tx_linkhandler >
  // Copy configuration from mod to RTE
RTE.default.tx_linkhandler < mod.tx_linkhandler

  // LINKHANDLER



  ////////////////////////////////////////////////////////////////////////
  //
  // TCEMAIN

TCEMAIN {
  clearCacheCmd = pages
  permissions {
    // ' . $this->pObj->markerArray['###GROUP_UID###'] . ': ' . $this->pObj->markerArray['###GROUP_TITLE###'] . '
    groupid = ' . $this->pObj->markerArray['###GROUP_UID###'] . '
    group   = show,edit,delete,new,editcontent
  }
}
  // TCEMAIN
  
  
  
  ///////////////////////////
  //
  // MOD
  
mod {
  web_list {
      // Deny all tables!
    allowedNewTables = xxx
  }
}
  // MOD


// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- END

'
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDataCal( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDataCal( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDataCal_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgData_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'org_cal',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

mod {
  web_list {
    allowedNewTables (
      tx_org_cal, 
      tx_org_calentrance, 
      tx_org_calspecial, 
      tx_org_caltype, 
      tx_org_tax
    )
  }
}

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- END

'
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDataDownloads( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDataDownloads( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDataDownloads_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgData_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'org_dwnlds',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

mod {
  web_list {
    allowedNewTables (
      tx_org_downloads,
      tx_org_downloadscat,
      tx_org_downloadsmedia
    )
  }
}

TCAdefaults {
  tx_org_downloads {
    documents_display_label = 0
    linkicon_width          = 40
    thumbnail_width         = 200m
    thumbnail_height        = 600m
    type                    = download_shipping
  }
}

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- END

'
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDataEvents( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDataEvents( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDataEvents_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgData_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'org_event',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

mod {
  web_list {
    allowedNewTables (
      tx_org_event
    )
  }
}

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- END

'
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDataHeadquarters( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDataHeadquarters( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDataHeadquarters_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgData_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'org_headq',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

mod {
  web_list {
    allowedNewTables (
      tx_org_headquarters,
      tx_org_department,
      tx_org_departmentcat
    )
  }
}

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- END

'
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDataLocations( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDataLocations( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDataLocations_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgData_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'org_locat',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

mod {
  web_list {
    allowedNewTables (
      tx_org_location
    )
  }
}

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- END

'
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDataNews( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDataNews( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDataNews_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgData_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'org_news',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN


mod {
  web_list {
    allowedNewTables (
      tx_org_news,
      tx_org_newscat
    )
  }
}

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- END

'
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDataStaff( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDataStaff( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDataStaff_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgData_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'org_staff',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

mod {
  web_list {
    allowedNewTables (
      fe_users,
      fe_groups
    )
  }
}

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- END

'
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDownloads( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDownloads( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDownloads_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDownloadsCaddy( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDownloadsCaddy( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDownloadsCaddy_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgDownloads_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'caddy',
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDownloadsCaddyCaddymini( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDownloadsCaddyCaddymini( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDownloadsCaddyCaddymini_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgDownloadsCaddy_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting,
              'nav_hide'      => 1
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDownloadsCaddyDelivery( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDownloadsCaddyDelivery( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDownloadsCaddyDelivery_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgDownloadsCaddy_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDownloadsCaddyRevocation( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDownloadsCaddyRevocation( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDownloadsCaddyRevocation_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgDownloadsCaddy_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgDownloadsCaddyTerms( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @param	string		$dateHumanReadable  : human readabel date
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgDownloadsCaddyTerms( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgDownloadsCaddyTerms_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgDownloadsCaddy_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgHeadquarters( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgHeadquarters( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgHeadquarters_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgLocations( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgLocations( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgLocations_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgLegalinfo( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgLegalinfo( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgLegalinfo_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgLibrary( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgLibrary( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgLibrary_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $dateHumanReadable  = date('Y-m-d G:i:s');

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'module'        => 'library',
              'urlType'       => 1,
              'sorting'       => $sorting,
              'TSconfig'      => '

// ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

TCEMAIN {
  clearCacheCmd = pages
}

// ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- END

'
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgLibraryFooter( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgLibraryFooter( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgLibraryFooter_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgLibrary_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgLibraryHeader( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgLibraryHeader( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgLibraryHeader_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgLibrary_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgLibraryHeaderLogo( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgLibraryHeaderLogo( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgLibraryHeaderLogo_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgLibraryHeader_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgLibraryHeaderSlider( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgLibraryHeaderSlider( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgLibraryHeaderSlider_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle     = 'pageOrgLibraryHeader_title';
    $pid          = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $pid,
              'title'         => $llPageTitle,
              'dokType'       => 254,  // 254: sysfolder
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgNews( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgNews( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgNews_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

/**
 * pageOrgStaff( ) :
 *
 * @param	integer		$pageUid            : uid of the current page
 * @param	integer		$sorting            : sorting value
 * @return	array		$page               : current page record
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function pageOrgStaff( $pageUid, $sorting )
  {
    $pageTitle    = 'pageOrgStaff_title';
    $llPageTitle  = $this->pObj->pi_getLL( $pageTitle );

    $page = array
            (
              'uid'           => $pageUid,
              'pid'           => $GLOBALS['TSFE']->id,
              'title'         => $llPageTitle,
              'dokType'       => 1,  // 1: page
              'crdate'        => time( ),
              'tstamp'        => time( ),
              'perms_userid'  => $this->pObj->markerArray['###BE_USER###'],
              'perms_groupid' => $this->pObj->markerArray['###GROUP_UID###'],
              'perms_user'    => 31, // 31: Full access
              'perms_group'   => 31, // 31: Full access
              'urlType'       => 1,
              'sorting'       => $sorting
            );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }



 /***********************************************
  *
  * Sql
  *
  **********************************************/

/**
 * pageOrg( ) :
 *
 * @param	array		$pages: page records
 * @return	void
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function sqlInsert( $pages )
  {
    foreach( $pages as $page )
    {
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'pages', $page );
      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->INSERTquery( 'pages', $page );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

        // prompt
      $marker['###TITLE###'] = $page['title'];
      $marker['###UID###']   = $page['uid'];
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'page_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[] = $prompt;
        // prompt
    }

    unset($pages);
  }



 /***********************************************
  *
  * ZZ
  *
  **********************************************/

/**
 * zz_countPages( ) :
 *
 * @param	integer		$pageUid    : current page uid
 * @return	string		$csvResult  : pageUid, sorting
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function zz_countPages( $pageUid )
  {
    static $counter = 0;

    $counter  = $counter + 1 ;
    $pageUid  = $pageUid + 1 ;
    $sorting  = 256 * $counter;

    $csvResult = $pageUid . ',' . $sorting;

    return $csvResult;
  }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_pages.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_pages.php']);
}