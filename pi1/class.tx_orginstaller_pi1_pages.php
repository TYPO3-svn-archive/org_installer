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
 *  289:     private function pageOrgCalCaddy( $pageUid, $sorting )
 *  327:     private function pageOrgCalCaddyCaddymini( $pageUid, $sorting )
 *  368:     private function pageOrgCalDelivery( $pageUid, $sorting )
 *  407:     private function pageOrgCalRevocation( $pageUid, $sorting )
 *  447:     private function pageOrgCalTerms( $pageUid, $sorting )
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
 * 1254:     private function pageOrgDocumentsDelivery( $pageUid, $sorting )
 * 1293:     private function pageOrgDocumentsRevocation( $pageUid, $sorting )
 * 1333:     private function pageOrgDocumentsTerms( $pageUid, $sorting )
 * 1372:     private function pageOrgHeadquarters( $pageUid, $sorting )
 * 1409:     private function pageOrgCalLocations( $pageUid, $sorting )
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
    // Data
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgData( $pageUid, $sorting );

    // Data: Cal
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataCal( $pageUid, $sorting );

    // Data: Companies
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataHeadquarters( $pageUid, $sorting );

    // Data: Documents
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataDownloads( $pageUid, $sorting );

    // Data: Events
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataEvents( $pageUid, $sorting );

    // Data: Jobs
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataJobs( $pageUid, $sorting );

    // Data: Locations
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataLocations( $pageUid, $sorting );

    // Data: News
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataNews( $pageUid, $sorting );

    // Data: People
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataStaff( $pageUid, $sorting );

    // Data: Service
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDataService( $pageUid, $sorting );

    // Cal
    // #61838, 140924, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCal( $pageUid, $sorting );

    // Cal: Cal
    // #i0017, 141013, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalCal( $pageUid, $sorting );

    // Cal: Events
    // #61826, 140923, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalEvents( $pageUid, $sorting );

    // Cal: Locations
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalLocations( $pageUid, $sorting );

    // Cal: Caddy
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalCaddy( $pageUid, $sorting );

    // Cal: Caddy: CaddyMini
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalCaddyCaddymini( $pageUid, $sorting );

    // Cal: Delivery
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalDelivery( $pageUid, $sorting );

    // Cal: Revocation
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalRevocation( $pageUid, $sorting );

    // Cal: Terms
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalTerms( $pageUid, $sorting );

    // Companies
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgHeadquarters( $pageUid, $sorting );

    // Documents
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocuments( $pageUid, $sorting );

    // Documents: Documents
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsDocuments( $pageUid, $sorting );

    // Documents: Caddy
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddy( $pageUid, $sorting );

    // Documents: Caddy: Caddymini
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddyCaddymini( $pageUid, $sorting );

    // Documents: Delivery
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsDelivery( $pageUid, $sorting );

    // Documents: Revocation
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsRevocation( $pageUid, $sorting );

    // Documents: Terms
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsTerms( $pageUid, $sorting );

    // Jobs
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgJobs( $pageUid, $sorting );

//    // Jobs: Jobs
//    // #i0017, 140921, dwildt, 2+
//    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
//    $pages[ $pageUid ] = $this->pageOrgJobsJobs( $pageUid, $sorting );

    // Jobs: Apply
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgJobsJobsApply( $pageUid, $sorting );

    // News
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgNews( $pageUid, $sorting );

    // People
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgStaff( $pageUid, $sorting );

    // Service
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgService( $pageUid, $sorting );

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

    // Legal Info
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLegalinfo( $pageUid, $sorting );

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

    // Dokument: Dokument
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsDocuments( $pageUid, $sorting );

    // Dokument: Warenkorb
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddy( $pageUid, $sorting );

    // Dokument: Warenkorb: ...
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsCaddyCaddymini( $pageUid, $sorting );

    // Dokument: AGB
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsTerms( $pageUid, $sorting );

    // Dokument: Versand
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsDelivery( $pageUid, $sorting );

    // Dokument: Widerruf
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgDocumentsRevocation( $pageUid, $sorting );

    // Firma
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgHeadquarters( $pageUid, $sorting );

    // Job
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgJobs( $pageUid, $sorting );

//    // #i0017, 140921, dwildt, 2+
//    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
//    $pages[ $pageUid ] = $this->pageOrgJobsJobs( $pageUid, $sorting );

    // Job: Bewerbung
    // #61779, 140921, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgJobsJobsApply( $pageUid, $sorting );

    // #61838, 140924, dwildt, 2+
    // Kalender
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCal( $pageUid, $sorting );

    // #i0017, 141013, dwildt, 2+
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalCal( $pageUid, $sorting );

    // #61826, 140923, dwildt, 3+
    // Kalender: Veranstaltungen
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalEvents( $pageUid, $sorting );

    // Kalender: Veranstaltungsort
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalLocations( $pageUid, $sorting );

    // Kalender: Warenkorb
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalCaddy( $pageUid, $sorting );

    // Kalender: Warenkorb: ...
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalCaddyCaddymini( $pageUid, $sorting );

    // Kalender: Warenkorb: AGB
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalTerms( $pageUid, $sorting );

    // Kalender: Warenkorb: Versand
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalDelivery( $pageUid, $sorting );

    // Kalender: Warenkorb: Widerruf
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgCalRevocation( $pageUid, $sorting );

    // Nachricht
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgNews( $pageUid, $sorting );

    // Personen
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgStaff( $pageUid, $sorting );

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

    // Impressum
    list( $pageUid, $sorting) = explode( ',', $this->zz_countPages( $pageUid ) );
    $pages[ $pageUid ] = $this->pageOrgLegalinfo( $pageUid, $sorting );

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
    // Init page org / the rrot page
    $this->initPageOrg();

    // Get the latest uid from the pages table
    $pageUid = $this->pObj->zz_getMaxDbUid( 'pages' );

    switch ( $this->pObj->get_Llstatic() )
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
   * pageOrgCal( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @internal #61838
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgCal( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgCal_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $GLOBALS[ 'TSFE' ]->id,
      'title' => $llPageTitle,
      'dokType' => 4, // 1: page, 4: shortcut
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'shortcut_mode' => 1, // 1: first subpage
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgCalCal( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @internal #61838, #i0017
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgCalCal( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgCalCal_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCal_title';
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
   * pageOrgCalCaddy( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgCalCaddy( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgCalCaddy_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCal_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      //'nav_hide' => 1, // Don't display in menus
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
   * pageOrgCalCaddyCaddymini( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgCalCaddyCaddymini( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgCalCaddyCaddymini_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCalCaddy_title';
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
   * pageOrgCalDelivery( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgCalDelivery( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgCalDelivery_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCal_title';
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
   * pageOrgCalRevocation( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgCalRevocation( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgCalRevocation_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCal_title';
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
   * pageOrgCalTerms( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @param	string		$dateHumanReadable  : human readabel date
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgCalTerms( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgCalTerms_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCal_title';
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
   * pageOrgCalEvents( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 6.0.0
   * @since 1.0.0
   */
  private function pageOrgCalEvents( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgCalEvents_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCal_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      //'nav_hide' => 1, // Don't display in menus
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
   * pageOrgCalLocations( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 6.0.0
   * @since 1.0.0
   */
  private function pageOrgCalLocations( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgCalLocations_title';
    $llPageTitle = $this->pObj->pi_getLL( $pageTitle );
    $pidTitle = 'pageOrgCal_title';
    $pid = $this->pObj->arr_pageUids[ $pidTitle ];

    $page = array
      (
      'uid' => $pageUid,
      'pid' => $pid,
      'title' => $llPageTitle,
      'dokType' => 1, // 1: page
      'crdate' => time(),
      //'nav_hide' => 1, // Don't display in menus
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
      tx_org_event,
      tx_org_eventcat
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
      tx_org_location,
      tx_org_locationcat
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
      'dokType' => 4, // 1: page, 4: shortcut
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      'shortcut_mode' => 1, // 1: first subpage
      'sorting' => $sorting,
      'urlType' => 1
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgDocumentsDocuments( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @internal #61838, #i0017
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgDocumentsDocuments( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDocumentsDocuments_title';
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
      'nav_hide' => 1, // Don't display in menus
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
   * pageOrgDocumentsDelivery( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgDocumentsDelivery( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDocumentsDelivery_title';
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
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgDocumentsRevocation( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgDocumentsRevocation( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDocumentsRevocation_title';
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
      'urlType' => 1,
      'sorting' => $sorting
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgDocumentsTerms( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @param	string		$dateHumanReadable  : human readabel date
   * @return	array		$page               : current page record
   * @access private
   * @version 3.0.0
   * @since 1.0.0
   */
  private function pageOrgDocumentsTerms( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgDocumentsTerms_title';
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
      //'dokType' => 4, // 1: page, 4: shortcut
      'dokType' => 1, // 1: page, 4: shortcut
      'crdate' => time(),
      'tstamp' => time(),
      'perms_userid' => $this->pObj->markerArray[ '###BE_USER###' ],
      'perms_groupid' => $this->pObj->markerArray[ '###GROUP_UID###' ],
      'perms_user' => 31, // 31: Full access
      'perms_group' => 31, // 31: Full access
      //'shortcut_mode' => 1, // 1: first subpage
      'sorting' => $sorting,
      'urlType' => 1
    );

    $this->pObj->arr_pageUids[ $pageTitle ] = $pageUid;
    $this->pObj->arr_pageTitles[ $pageUid ] = $pageTitle;

    return $page;
  }

  /**
   * pageOrgJobsJobs( ) :
   *
   * @param	integer		$pageUid            : uid of the current page
   * @param	integer		$sorting            : sorting value
   * @return	array		$page               : current page record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgJobsJobs( $pageUid, $sorting )
  {
    $pageTitle = 'pageOrgJobsJobs_title';
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
      'nav_hide' => 1, // Don't display in menus
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
   * @version 6.0.0
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
        // #61666, 141003, dwildt
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
                . '   See: System > Install > Import action > Database analyzer [Compare current database with spezifications]<br />' . PHP_EOL
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