<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2014 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 *   89: class tx_orginstaller_pi1_pages
 *
 *              SECTION: Main
 *  113:     public function main( )
 *
 *              SECTION: Init
 *  145:     private function initPageOrg( )
 *
 *              SECTION: Create pages
 *  173:     private function pageOrg( )
 *  289:     private function pageOrgCaddy( $pageUid, $sorting )
 *  327:     private function pageOrgCaddyCaddymini( $pageUid, $sorting )
 *  368:     private function pageOrgCaddyDelivery( $pageUid, $sorting )
 *  407:     private function pageOrgCaddyRevocation( $pageUid, $sorting )
 *  447:     private function pageOrgCaddyTerms( $pageUid, $sorting )
 *  486:     private function pageOrgData( $pageUid, $sorting )
 *  710:     private function pageOrgDataCal( $pageUid, $sorting )
 *  772:     private function pageOrgDataDownloads( $pageUid, $sorting )
 *  842:     private function pageOrgDataEvents( $pageUid, $sorting )
 *  900:     private function pageOrgDataHeadquarters( $pageUid, $sorting )
 *  960:     private function pageOrgDataLocations( $pageUid, $sorting )
 * 1018:     private function pageOrgDataNews( $pageUid, $sorting )
 * 1078:     private function pageOrgDataStaff( $pageUid, $sorting )
 * 1137:     private function pageOrgDocuments( $pageUid, $sorting )
 * 1173:     private function pageOrgDocumentsCaddy( $pageUid, $sorting )
 * 1213:     private function pageOrgDocumentsCaddyCaddymini( $pageUid, $sorting )
 * 1254:     private function pageOrgDocumentsCaddyDelivery( $pageUid, $sorting )
 * 1293:     private function pageOrgDocumentsCaddyRevocation( $pageUid, $sorting )
 * 1333:     private function pageOrgDocumentsCaddyTerms( $pageUid, $sorting )
 * 1372:     private function pageOrgHeadquarters( $pageUid, $sorting )
 * 1409:     private function pageOrgLocations( $pageUid, $sorting )
 * 1446:     private function pageOrgLegalinfo( $pageUid, $sorting )
 * 1483:     private function pageOrgLibrary( $pageUid, $sorting )
 * 1534:     private function pageOrgLibraryFooter( $pageUid, $sorting )
 * 1573:     private function pageOrgLibraryHeader( $pageUid, $sorting )
 * 1612:     private function pageOrgLibraryHeaderLogo( $pageUid, $sorting )
 * 1651:     private function pageOrgLibraryHeaderSlider( $pageUid, $sorting )
 * 1690:     private function pageOrgNews( $pageUid, $sorting )
 * 1727:     private function pageOrgStaff( $pageUid, $sorting )
 *
 *              SECTION: Sql
 * 1771:     private function sqlInsert( $pages )
 *
 *              SECTION: ZZ
 * 1822:     private function zz_countPages( $pageUid )
 *
 * TOTAL FUNCTIONS: 34
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Plugin 'Organiser Installer' for the 'org_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_orginstaller
 * @version 6.0.0
 * @since 3.0.0
 */
class tx_orginstaller_pi1_pages
{

  public $prefixId = 'tx_orginstaller_pi1_pages';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_orginstaller_pi1_pages.php';  // Path to this script relative to the extension dir.
  public $extKey = 'org_installer';                      // The extension key.
  public $pObj = null;

  /*   * *********************************************
   *
   * Main
   *
   * ******************************************** */

  /**
   * main( ) :
   *
   * @return	void
   * @access public
   * @version 3.0.0
   * @since 1.0.0
   */
  public function main()
  {
    // Prompt header
    $this->pObj->arrReport[] = '
      <h2>
       ' . $this->pObj->pi_getLL( 'page_create_header' ) . '
      </h2>';
    // Prompt header
    // Create pages on the root level
    $pageUid = $this->pageOrg();
    unset( $pageUid );

    return;
  }

  /*   * *********************************************
   *
   * Init
   *
   * ******************************************** */

  /**
   * initPageOrg( ) :
   *
   * @return	void
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function initPageOrg()
  {
    // Set the global vars for the root page
    $pageUid = $GLOBALS[ 'TSFE' ]->id;
    $pageTitle = 'pageOrg_title';
    // 130723, dwildt, 1-
    //$llPageTitle  = $this->pObj->pi_getLL( $pageTitle );
    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;
    // Set the global vars for the root page
  }

  /*   * *********************************************
   *
   * Create pages
   *
   * ******************************************** */

  /**
   * orderEnglish( $pageUid ) :
   *
   * @param $pageUid
   * @return	integer		$pageUid: latest page uid
   * @access private
   * @version 6.0.0
   * @since 6.0.0
   */
  private function orderEnglish( $pageUid )
  {
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgData( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataCal( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataDownloads( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataEvents( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataHeadquarters( $pageUid, $sorting );

    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataJobs( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataLocations( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataNews( $pageUid, $sorting );

    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataService( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataStaff( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocuments( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddy( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddyCaddymini( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddyDelivery( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddyRevocation( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddyTerms( $pageUid, $sorting );

    // #61826, 140923, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgEvents( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgHeadquarters( $pageUid, $sorting );

    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgJobs( $pageUid, $sorting );

    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgJobsJobsApply( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLocations( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgNews( $pageUid, $sorting );

    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgService( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgStaff( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCaddy( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCaddyCaddymini( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCaddyDelivery( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCaddyRevocation( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCaddyTerms( $pageUid, $sorting );

    // SWITCH : install case
    $installCase = $this->pObj->markerArray[ '###INSTALL_CASE###' ];
    switch ( $installCase )
    {
      case( 'install_org' ):
        $this->sqlInsert( $pages );
        return;
      case( 'install_all' ):
        // follow the workflow
        break;
      default:
        $prompt = __METHOD__ . ' #' . __LINE__ . ': Undefined value in switch: "' . $installCase . '"';
        die( $prompt );
    }
    // SWITCH : install case

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLegalinfo( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgTYPO3IntegratorsDevider( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgTYPO3Integrators( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibrary( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryHeader( $pageUid, $sorting );

    // #61693, 140917, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryMenu( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryMenubelow( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryHeaderLogo( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryHeaderSlider( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryFooter( $pageUid, $sorting );

    $this->sqlInsert( $pages );

    return $pageUid;
  }

  /**
   * orderGerman( $pageUid ) :
   *
   * @param $pageUid
   * @return	integer		$pageUid: latest page uid
   * @access private
   * @version 6.0.0
   * @since 6.0.0
   */
  private function orderGerman( $pageUid )
  {
    // Daten
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgData( $pageUid, $sorting );

    // Daten: Dienstleistung
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataService( $pageUid, $sorting );

    // Daten: Dokument
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataDownloads( $pageUid, $sorting );

    // Daten: Firma
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataHeadquarters( $pageUid, $sorting );

    // #61779, 140921, dwildt, 2+
    // Daten: Jobs
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataJobs( $pageUid, $sorting );

    // Daten: Kalender
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataCal( $pageUid, $sorting );

    // Daten: Nachrichten
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataNews( $pageUid, $sorting );

    // Daten: Personen
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataStaff( $pageUid, $sorting );

    // Daten: Veranstaltung
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataEvents( $pageUid, $sorting );

    // Daten: Veranstaltungsort
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataLocations( $pageUid, $sorting );

    // Dienstleistung
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgService( $pageUid, $sorting );

    // Dokument
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocuments( $pageUid, $sorting );

    // Dokument: Warenkorb
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddy( $pageUid, $sorting );

    // Dokument: Warenkorb: ...
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddyCaddymini( $pageUid, $sorting );

    // Dokument: Warenkorb: ...
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddyDelivery( $pageUid, $sorting );

    // Dokument: Warenkorb: ...
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddyRevocation( $pageUid, $sorting );

    // Dokument: Warenkorb: ...
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddyTerms( $pageUid, $sorting );

    // Firma
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgHeadquarters( $pageUid, $sorting );

    // Job
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgJobs( $pageUid, $sorting );

    // Job: Bewerbung
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgJobsJobsApply( $pageUid, $sorting );

    // Nachricht
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgNews( $pageUid, $sorting );

    // Personen
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgStaff( $pageUid, $sorting );

    // #61826, 140923, dwildt, 3+
    // Veranstaltungen
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgEvents( $pageUid, $sorting );

    // Veranstaltungsort
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLocations( $pageUid, $sorting );


    // Warenkorb
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCaddy( $pageUid, $sorting );

    // Warenkorb: ...
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCaddyCaddymini( $pageUid, $sorting );

    // Warenkorb: ...
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCaddyDelivery( $pageUid, $sorting );

    // Warenkorb: ...
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCaddyRevocation( $pageUid, $sorting );

    // Warenkorb: ...
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCaddyTerms( $pageUid, $sorting );

    // SWITCH : install case
    $installCase = $this->pObj->markerArray[ '###INSTALL_CASE###' ];
    switch ( $installCase )
    {
      case( 'install_org' ):
        $this->sqlInsert( $pages );
        return;
      case( 'install_all' ):
        // follow the workflow
        break;
      default:
        $prompt = __METHOD__ . ' #' . __LINE__ . ': Undefined value in switch: "' . $installCase . '"';
        die( $prompt );
    }
    // SWITCH : install case

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLegalinfo( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgTYPO3IntegratorsDevider( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgTYPO3Integrators( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibrary( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryHeader( $pageUid, $sorting );

    // #61693, 140917, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryMenu( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryMenubelow( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryHeaderLogo( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryHeaderSlider( $pageUid, $sorting );

    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLibraryFooter( $pageUid, $sorting );

    $this->sqlInsert( $pages );

    return $pageUid;
  }

  /**
   * pageOrg( ) :
   *
   * @return	integer		$pageUid: latest page uid
   * @access private
   * @version 6.0.0
   * @since 1.0.0
   */
  private function pageOrg()
  {
    $pages = array();

    // Init page org / the rrot page
    $this->initPageOrg();

    // Get the latest uid from the pages table
    $pageUid = $this->pObj->zz_getMaxDbUid( 'pages' );

    switch( $this->pObj->get_Llstatic())
    {
      case( 'German' ):
        $pageUid = $this->orderGerman( $pageUid );
        break;
      case( 'English' ):
      default:
        $pageUid = $this->orderEnglish( $pageUid );
        break;
    }

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
    $pageTitle = 'pageOrgCaddy_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'caddy',
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgCaddyCaddymini_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCaddy_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'caddymini',
      'urlType' => 1,
      'sorting' => $sorting,
      'nav_hide' => 1
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
    $pageTitle = 'pageOrgCaddyDelivery_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCaddy_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgCaddyRevocation_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCaddy_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgCaddyTerms_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCaddy_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgData_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'org',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => null // Will set while consolidation
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
    $pageTitle = 'pageOrgDataCal_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgData_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable = date( 'Y-m-d G:i:s' );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'org_cal',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => '

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
    $pageTitle = 'pageOrgDataDownloads_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgData_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable = date( 'Y-m-d G:i:s' );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'org_dwnlds',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => '

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
    $pageTitle = 'pageOrgDataEvents_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgData_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable = date( 'Y-m-d G:i:s' );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'org_event',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => '

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
    $pageTitle = 'pageOrgDataHeadquarters_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgData_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable = date( 'Y-m-d G:i:s' );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'org_headq',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

mod {
  web_list {
    allowedNewTables (
      tx_org_headquarters,
      tx_org_headquarterscat
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
   * pageOrgDataJobs( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgDataJobs( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDataJobs_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgData_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable = date( 'Y-m-d G:i:s' );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'org_job',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

mod {
  web_list {
    allowedNewTables (
      tx_org_job,
      tx_org_jobcat,
      tx_org_jobsector,
      tx_org_jobworkinghours    )
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
    $pageTitle = 'pageOrgDataLocations_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgData_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable = date( 'Y-m-d G:i:s' );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'org_locat',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => '

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
    $pageTitle = 'pageOrgDataNews_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgData_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable = date( 'Y-m-d G:i:s' );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'org_news',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => '

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
   * pageOrgDataService( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgDataService( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDataService_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgData_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable = date( 'Y-m-d G:i:s' );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'org_srvce',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

mod {
  web_list {
    allowedNewTables (
      tx_org_service,
      tx_org_servicecat,
      tx_org_servicesector,
      tx_org_servicetargetgroup
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
   * @version 6.0.0
   * @since 1.0.0
   */
  private function pageOrgDataStaff( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDataStaff_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgData_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];


    $dateHumanReadable = date( 'Y-m-d G:i:s' );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'org_staff',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN

mod {
  web_list {
    allowedNewTables (
      // #61703, dwildt, 2-
      //fe_users,
      //fe_groups
      // #61703, dwildt, 2+
      tx_org_staff,
      tx_org_staffgroup
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
   * pageOrgDocuments( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgDocuments( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDocuments_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgDocumentsCaddy( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgDocumentsCaddy( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDocumentsCaddy_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgDocuments_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'caddy',
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgDocumentsCaddyCaddymini( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgDocumentsCaddyCaddymini( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDocumentsCaddyCaddymini_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgDocumentsCaddy_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'caddymini',
      'urlType' => 1,
      'sorting' => $sorting,
      'nav_hide' => 1
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgDocumentsCaddyDelivery( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgDocumentsCaddyDelivery( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDocumentsCaddyDelivery_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgDocumentsCaddy_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgDocumentsCaddyRevocation( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgDocumentsCaddyRevocation( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDocumentsCaddyRevocation_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgDocumentsCaddy_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgDocumentsCaddyTerms( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @param	string		$dateHumanReadable  : human readabel date
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgDocumentsCaddyTerms( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDocumentsCaddyTerms_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgDocumentsCaddy_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgJobs( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgJobs( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgJobs_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgJobsJobsApply( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgJobsJobsApply( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgJobsJobsApply_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgJobs_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgEvents( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgEvents( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgEvents_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgHeadquarters_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgLocations_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
   * @version 6.0.0
   * @since 1.0.0
   */
  private function pageOrgLegalinfo( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgLegalinfo_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'crdate' => time(),
      'dokType' => 1, // 1: page
      'nav_hide' => 1, // Don't display in menus
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'sorting' => $sorting,
      'tstamp' => time(),
      'urlType' => 1
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
    $pageTitle = 'pageOrgLibrary_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $dateHumanReadable = date( 'Y-m-d G:i:s' );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'module' => 'library',
      'urlType' => 1,
      'sorting' => $sorting,
      'TSconfig' => '

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
    $pageTitle = 'pageOrgLibraryFooter_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgLibrary_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgLibraryHeader_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgLibrary_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgLibraryHeaderLogo_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgLibraryHeader_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgLibraryHeaderSlider_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgLibraryHeader_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgLibraryMenu( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @internal #61693
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgLibraryMenu( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgLibraryMenu_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgLibrary_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgLibraryMenubelow( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgLibraryMenubelow( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgLibraryMenubelow_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgLibrary_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 254, // 254: sysfolder
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgNews_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgService( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgService( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgService_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
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
    $pageTitle = 'pageOrgStaff_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgTYPO3Integrators( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 6.0.0
   * @since 1.0.0
   */
  private function pageOrgTYPO3Integrators( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgTYPO3Integrators_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'crdate' => time(),
      'dokType' => 1, // 1: page
      'nav_hide' => 1, // Don't display in menus
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'title' => $llPageTitle,
      'urlType' => 1,
      'sorting' => $sorting,
      'tstamp' => time()
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgTYPO3IntegratorsDevider( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgTYPO3IntegratorsDevider( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgTYPO3IntegratorsDevider_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 199, // 199: devider
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /*   * *********************************************
   *
   * Sql
   *
   * ******************************************** */

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
    foreach ( $pages as $page )
    {
      $GLOBALS[ 'TYPO3_DB' ]->exec_INSERTquery( 'pages', $page );
      $error = $GLOBALS[ 'TYPO3_DB' ]->sql_error();

      if ( $error )
      {
        $query = $GLOBALS[ 'TYPO3_DB' ]->INSERTquery( 'pages', $page );
        $prompt = '<div style="border:1em solid red;margin:1em;padding:2em;">' . PHP_EOL
                . 'SQL-ERROR<br />' . PHP_EOL
                . 'query: ' . $query . '.<br />' . PHP_EOL
                . 'error: ' . $error . '.<br />' . PHP_EOL
                . 'Sorry for the trouble.<br />' . PHP_EOL
                . 'TYPO3-Organiser Installer<br />' . PHP_EOL
                . __METHOD__ . ' (' . __LINE__ . ')' . PHP_EOL
                . '</div>' . PHP_EOL
                . '<div style="border:1em solid blue;margin:1em;padding:2em;">' . PHP_EOL
                . 'HELP<br />' . PHP_EOL
                . '1. Please save the installer plugin again. Probably the SQL error is solved.<br />' . PHP_EOL
                . '2. Reload this page.<br />' . PHP_EOL
                . '3. If error occurs again, please update your database. <br />' . PHP_EOL
                . '   See: System > Install > Import action > Database analyzer [Compare current databse with spezifications]<br />' . PHP_EOL
                . '4. Remove installed pages.<br />' . PHP_EOL
                . '5. Reload this page.' . PHP_EOL
                . '</div>' . PHP_EOL
        ;
        die( $prompt );
      }

      // prompt
      $marker[ '###TITLE###' ] = $page[ 'title' ];
      $marker[ '###UID###' ] = $page[ 'uid' ];
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons[ 'ok' ] . ' ' . $this->pObj->pi_getLL( 'page_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[] = $prompt;
      // prompt
    }

    unset( $pages );
  }

  /*   * *********************************************
   *
   * ZZ
   *
   * ******************************************** */

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

    $counter = $counter + 1;
    $pageUid = $pageUid + 1;
    $sorting = 256 * $counter;

    $csvResult = $pageUid . ',' . $sorting;

    return $csvResult;
  }

}

if ( defined( 'TYPO3_MODE' ) && $TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/org_installer/pi1/class.tx_orginstaller_pi1_pages.php' ] )
{
  include_once($TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/org_installer/pi1/class.tx_orginstaller_pi1_pages.php' ]);
}