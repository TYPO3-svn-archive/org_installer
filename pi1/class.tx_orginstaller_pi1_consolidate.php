<?php
/***************************************************************
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
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   78: class tx_orginstaller_pi1_consolidate
 *
 *              SECTION: Main
 *  104:     public function main( )
 *
 *              SECTION: pages
 *  131:     private function pageOrgCaddy( )
 *  166:     private function pageOrgCaddy_contentJss( )
 *  219:     private function pageOrgCaddy_pluginCaddy( )
 *  392:     private function pageOrgCaddy_pluginCaddyMini( )
 *  435:     private function pageOrgCaddy_pluginPowermail( )
 *  475:     private function pageOrgCaddy_pluginPowermail1x( )
 *  504:     private function pageOrgCaddy_pluginPowermail2x( )
 *  594:     private function pageOrgCaddy_typoscript( )
 *  627:     private function pageOrgCaddy_typoscript1x( )
 *  695:     private function pageOrgCaddy_typoscript2x( )
 *  751:     private function pageOrg( )
 *  782:     private function pageOrg_fileCopy( $timestamp )
 *  836:     private function pageOrg_pluginInstallHide( )
 *  858:     private function pageOrg_properties( $timestamp )
 *  912:     private function pageOrg_typoscriptOtherHide( )
 *
 *              SECTION: Sql
 *  935:     private function sqlUpdateContent( $records, $pageTitle )
 *  950:     private function sqlUpdatePlugin( $records, $pageTitle )
 *  998:     private function powermailVersionAppendix( )
 * 1043:     private function sqlUpdatePages( $records, $pageTitle )
 * 1091:     private function sqlUpdateTyposcript( $records, $pageTitle )
 * 1138:     private function sqlUpdateTyposcriptOtherHide( )
 *
 *              SECTION: ZZ
 * 1193:     private function zz_getPowermailUid( $label )
 * 1234:     private function zz_getPowermailUid1x( $label )
 * 1250:     private function zz_getPowermailUid2x( $label )
 *
 * TOTAL FUNCTIONS: 25
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
class tx_orginstaller_pi1_consolidate
{
  public $prefixId      = 'tx_orginstaller_pi1_consolidate';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_orginstaller_pi1_consolidate.php';  // Path to this script relative to the extension dir.
  public $extKey        = 'org_installer';                      // The extension key.

  public $pObj = null;

  private $powermailVersionAppendix = null;



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
    $this->pObj->arrReport[] = '
      <h2>
       ' . $this->pObj->pi_getLL( 'consolidate_header' ) . '
      </h2>';

    $this->pageOrg( );
    $this->pageOrgCaddy( );
    $this->pageOrgData( );
    $this->pageOrgDocumentsCaddy( );
    $this->pageOrgLibraryHeaderLogo( );
  }



 /***********************************************
  *
  * pages
  *
  **********************************************/

/**
 * pageOrg( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrg( )
  {
    $records    = array( );
    $timestamp  = time();
    $pageTitle  = $GLOBALS['TSFE']->page['title'];

      // Update page properties
    $records = $this->pageOrg_properties( );
    $this->sqlUpdatePages( $records, $pageTitle );

      // Copy header image
    $this->pageOrg_fileCopy( $timestamp );

      // Hide the installer plugin
    $records  = $this->pageOrg_pluginInstallHide( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Hide the TypoScript template
    $this->pageOrg_typoscriptOtherHide( );
    $this->sqlUpdateTyposcriptOtherHide( );
  }

/**
 * pageOrg_fileCopy( )
 *
 * @param	integer		$timestamp  : current time
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrg_fileCopy( $timestamp )
  {
    unset( $timestamp );
//      // Files
//    $str_fileSrce = 'quick_shop_header_image_210px.jpg';
//    $str_fileDest = 'typo3_org_' . $timestamp . '.jpg';
//
//      // Paths
//    //$str_pathSrceAbs  = t3lib_extMgm::extPath( 'quick_shop' ) . 'res/images/';
//    $str_pathSrce     = t3lib_extMgm::siteRelPath( 'quick_shop' ) . 'res/images/';
//    $str_pathDest     = 'uploads/media/';
//
////    if( ! file_exists( $str_pathSrceAbs . $str_fileSrce ) )
////    {
////var_dump( __METHOD__, __LINE__, $str_pathSrceAbs . $str_fileSrce, 0 );
////    }
//      // Copy
//    $success = copy( $str_pathSrce . $str_fileSrce, $str_pathDest . $str_fileDest );
////var_dump( __METHOD__, __LINE__, $str_pathSrce . $str_fileSrce, $str_pathDest . $str_fileDest, $success );
//      // SWICTH : prompt depending on success
//    switch( $success )
//    {
//      case( false ):
//        $this->pObj->markerArray['###SRCE###'] = $str_pathSrce . $str_fileSrce;
//        $this->pObj->markerArray['###DEST###'] = $str_pathDest . $str_fileDest;
//        $prompt = '
//          <p>
//            '.$this->pObj->arr_icons['warn'].' '.$this->pObj->pi_getLL('files_create_prompt_error').'
//          </p>';
//        $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
//        $this->pObj->arrReport[ ] = $prompt;
//        break;
//      case( true ):
//      default:
//        $this->pObj->markerArray['###DEST###'] = $str_fileDest;
//        $this->pObj->markerArray['###PATH###'] = $str_pathDest;
//        $prompt = '
//          <p>
//            '.$this->pObj->arr_icons['ok'].' '.$this->pObj->pi_getLL('files_create_prompt').'
//          </p>';
//        $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
//        $this->pObj->arrReport[ ] = $prompt;
//        break;
//    }
//      // SWICTH : prompt depending on success
  }

/**
 * pageOrg_pluginInstallHide( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrg_pluginInstallHide( )
  {
    $records = null;

    $uid    = $this->pObj->cObj->data['uid'];
    $header = $this->pObj->cObj->data['header'];

    $records[$uid]['header'] = $header;
    $records[$uid]['hidden'] = 1;

    return $records;
  }

/**
 * pageOrg_properties( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrg_properties( )
  {
    $records = null;

    $uid          = $GLOBALS['TSFE']->id;
    $is_siteroot  = null;
    $groupUid     = $this->pObj->markerArray['###GROUP_UID###'];
    $groupTitle   = $this->pObj->markerArray['###GROUP_TITLE###'];

      // #i0011, 130925, dwildt, 12-
//      // SWITCH : siteroot depends on toplevel
//    switch( $this->pObj->bool_topLevel )
//    {
//      case( true ):
//        $is_siteroot = 1;
//        break;
//      case( false ):
//      default:
//        $is_siteroot = 0;
//        break;
//    }
//      // SWITCH : siteroot depends on toplevel
      // #i0011, 130925, dwildt, 12-

      // SWITCH : install case
    $installCase = $this->pObj->markerArray['###INSTALL_CASE###'];
    switch( $installCase )
    {
      case( 'install_org' ):
          // #i0011, 130925, dwildt, 1+
        $is_siteroot = 0;
        $records[$uid]['nav_title'] = null;
        break;
      case( 'install_all' ):
          // #i0011, 130925, dwildt, 1+
        $is_siteroot = 1;
        $records[$uid]['nav_title'] = $this->pObj->pi_getLL( 'pageQuickshop_titleNav' );
        break;
      default:
        $prompt = __METHOD__ .  ' #' . __LINE__ . ': Undefined value in switch: "' . $installCase . '"';
        die( $prompt );
    }
      // SWITCH : install case

    $records[$uid]['title']       = $this->pObj->pi_getLL( 'pageOrg_title' );
    $records[$uid]['nav_hide']    = 0;
    $records[$uid]['is_siteroot'] = $is_siteroot;
    $records[$uid]['module']      = null;
    $records[$uid]['TSconfig']    = '

// ORGANISER INSTALLER at ' . date( 'Y-m-d G:i:s' ) . ' -- BEGIN

  /////////////////////////////////////
  //
  // INDEX
  //
  // TCEMAIN.permissions


  // TCEMAIN.permissions
TCEMAIN {
  permissions {
    // ' . $groupUid . ': ' . $groupTitle . '
    groupid = ' . $groupUid . '
    group   = show,edit,delete,new,editcontent
  }
}
  // TCEMAIN.permissions

// ORGANISER INSTALLER at ' . date( 'Y-m-d G:i:s' ) . ' -- END

';
    $records[$uid]['TSconfig'] = $this->zz_replacePageUids( $records[$uid]['TSconfig'] );

    return $records;
  }

/**
 * pageOrg_typoscriptOtherHide( )
 *
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrg_typoscriptOtherHide( )
  {
    // Do nothing
  }

/**
 * pageOrgCaddy( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgCaddy( )
  {
    $records    = array( );
    $pageTitle  = $this->pObj->pi_getLL( 'pageOrgCaddy_title' );

      // Update the jss script
    $records    = $this->pageOrgCaddy_contentJss( );
    $this->sqlUpdateContent( $records, $pageTitle );

      // Update the powermail plugin
    $records    = $this->pageOrgCaddy_pluginPowermail( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the caddy plugin
    $records    = $this->pageOrgCaddy_pluginCaddy( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the TypoScript
    $records    = $this->pageOrgCaddy_typoscript( );
    $this->sqlUpdateTyposcript( $records, $pageTitle );

  }

/**
 * pageOrgCaddy_contentJss( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.4
 * @since   3.0.4
 */
  private function pageOrgCaddy_contentJss( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_contentUids['content_pageOrgCaddy_header'];

      // values
    $llHeader = $this->pObj->pi_getLL( 'content_pageOrgCaddy_header' );
      // values

    $pmFieldsetUid = $this->pObj->powermailPageOrgCaddy->getValue( 'record_pm_fSets_title_deliveryAddress' );
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
        $pmFieldsetHtmlId = 'tx-powermail-pi1_fieldset_' . $pmFieldsetUid;
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $pmFieldsetHtmlId = 'powermail_fieldset_' . $pmFieldsetUid;
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

    $jssScript = $this->pObj->pi_getLL('content_pageOrgCaddy_bodytext');
    $jssScript = str_replace( '###POWERMAIL_FIELDSET_DELIVERYORDER_ADDRESS###', $pmFieldsetHtmlId, $jssScript );


    $records[$uid]['header']      = $llHeader;
    $records[$uid]['bodytext']    = $jssScript;

    return $records;
  }

/**
 * pageOrgCaddy_pluginCaddy( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgCaddy_pluginCaddy( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'pluginCaddyPageOrgCaddy_header' ];
    $pmX      = $this->powermailVersionAppendix( );

      // values
    $llHeader = $this->pObj->pi_getLL( 'pluginCaddyPageOrgCaddy_header' );
      // values

    $records[$uid]['header']      = $llHeader;
    $records[$uid]['pi_flexform'] = null .
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="note">
            <language index="lDEF">
                <field index="note">
                    <value index="vDEF">'
                      . $this->pObj->pi_getLL( 'pluginCaddyPageOrgCaddy_note_' . $pmX ) .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="origin">
            <language index="lDEF">
                <field index="order">
                    <value index="vDEF">3972</value>
                </field>
                <field index="invoice">
                    <value index="vDEF">83</value>
                </field>
                <field index="deliveryorder">
                    <value index="vDEF">216</value>
                </field>
                <field index="min">
                    <value index="vDEF">3</value>
                </field>
                <field index="max">
                    <value index="vDEF">10</value>
                </field>
            </language>
        </sheet>
        <sheet index="email">
            <language index="lDEF">
                <field index="customerEmail">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_email' ) .
                    '</value>
                </field>
                <field index="termsMode">
                    <value index="vDEF">all</value>
                </field>
                <field index="revocationMode">
                    <value index="vDEF">all</value>
                </field>
                <field index="invoiceMode">
                    <value index="vDEF">all</value>
                </field>
                <field index="deliveryorderMode">
                    <value index="vDEF">all</value>
                </field>
            </language>
        </sheet>
        <sheet index="invoice">
            <language index="lDEF">
                <field index="company">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_companyBilling' ) .
                    '</value>
                </field>
                <field index="firstName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_firstnameBilling' ) .
                    '</value>
                </field>
                <field index="lastName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_surnameBilling' ) .
                    '</value>
                </field>
                <field index="address">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_streetBilling' ) .
                    '</value>
                </field>
                <field index="zip">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_zipBilling' ) .
                    '</value>
                </field>
                <field index="city">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_locationBilling' ) .
                    '</value>
                </field>
                <field index="country">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_countryBilling' ) .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="deliveryorder">
            <language index="lDEF">
                <field index="company">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_companyDelivery' ) .
                    '</value>
                </field>
                <field index="firstName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_firstnameDelivery' ) .
                    '</value>
                </field>
                <field index="lastName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_surnameDelivery' ) .
                    '</value>
                </field>
                <field index="address">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_streetDelivery' ) .
                    '</value>
                </field>
                <field index="zip">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_zipDelivery' ) .
                    '</value>
                </field>
                <field index="city">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_locationDelivery' ) .
                    '</value>
                </field>
                <field index="country">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgCaddy_title', 'record_pm_field_title_countryDelivery' ) .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="paths">
            <language index="lDEF">
                <field index="terms">
                    <value index="vDEF">typo3conf/ext/org/res/pdf/typo3-organiser_for_caddy.pdf</value>
                </field>
                <field index="revocation">
                    <value index="vDEF">typo3conf/ext/org/res/pdf/typo3-organiser_for_caddy.pdf</value>
                </field>
                <field index="invoice">
                    <value index="vDEF">typo3conf/ext/org/res/pdf/typo3-organiser_for_caddy.pdf</value>
                </field>
                <field index="deliveryorder">
                    <value index="vDEF">typo3conf/ext/org/res/pdf/typo3-organiser_for_caddy.pdf</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';

    return $records;
  }

/**
 * pageOrgCaddy_pluginPowermail( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgCaddy_pluginPowermail( )
  {
    $records  = null;

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
        $records = $this->pageOrgCaddy_pluginPowermail1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $records = $this->pageOrgCaddy_pluginPowermail2x( );
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

    return $records;
  }

/**
 * pageOrgCaddy_pluginPowermail1x( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgCaddy_pluginPowermail1x( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgCaddy_header' ];

      // values
    $llHeader       = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_header' );
    $uidEmail       = $this->pObj->powermailPageOrgCaddy->getValue( 'record_pm_field_title_email' );
    $customerEmail  = 'uid' . $uidEmail;
    $uidFirstname   = $this->pObj->powermailPageOrgCaddy->getValue( 'record_pm_field_title_firstnameBilling' );
    $uidSurname     = $this->pObj->powermailPageOrgCaddy->getValue( 'record_pm_field_title_surnameBilling' );
    $customerName   = 'uid' . $uidFirstname . ',uid' . $uidSurname;
      // values

    $records[$uid]['header']                  = $llHeader;
    $records[$uid]['tx_powermail_sender']     = $customerEmail;
    $records[$uid]['tx_powermail_sendername'] = $customerName;

    return $records;
  }

/**
 * pageOrgCaddy_pluginPowermail2x( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgCaddy_pluginPowermail2x( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgCaddy_header' ];

    $llHeader         = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_header' );
    $uidForm          = $this->pObj->powermailPageOrgCaddy->getValue( 'record_pm_form_title_pageOrgCaddy' );
    $receiverSubject  = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_subject_r2x' );
    $receiverBody     = htmlspecialchars( $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_body_r2x' ) );
    list( $name, $domain) = explode( '@', $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###'] );
    unset( $name );
    $senderEmail      = 'noreply@' . $domain;
    $senderSubject    = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_subject_s2x' );
    $senderBody       = htmlspecialchars( $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_body_s2x' ) );
    $thxBody          = htmlspecialchars( $this->pObj->pi_getLL('pluginPowermailPageOrgCaddy_thanks2x') );

    $records[$uid]['header']      = $llHeader;
    $records[$uid]['pi_flexform'] = null .
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="main">
            <language index="lDEF">
                <field index="settings.flexform.main.form">
                    <value index="vDEF">' . $uidForm . '</value>
                </field>
                <field index="settings.flexform.main.confirmation">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
        <sheet index="receiver">
            <language index="lDEF">
                <field index="settings.flexform.receiver.name">
                    <value index="vDEF">{billingaddressfirstname} {billingaddresslastname}</value>
                </field>
                <field index="settings.flexform.receiver.email">
                    <value index="vDEF">{contactdataemail}</value>
                </field>
                <field index="settings.flexform.receiver.subject">
                    <value index="vDEF">' . $receiverSubject . '</value>
                </field>
                <field index="settings.flexform.receiver.body">
                    <value index="vDEF">' . $receiverBody . '</value>
                    <value index="_TRANSFORM_vDEF.vDEFbase">' . $receiverBody . '</value>
                </field>
            </language>
        </sheet>
        <sheet index="sender">
            <language index="lDEF">
                <field index="settings.flexform.sender.name">
                    <value index="vDEF">Organiser</value>
                </field>
                <field index="settings.flexform.sender.email">
                    <value index="vDEF">' . $senderEmail . '</value>
                </field>
                <field index="settings.flexform.sender.subject">
                    <value index="vDEF">' . $senderSubject . '</value>
                </field>
                <field index="settings.flexform.sender.body">
                    <value index="vDEF">' . $senderBody . '</value>
                    <value index="_TRANSFORM_vDEF.vDEFbase">' . $senderBody . '</value>
                </field>
            </language>
        </sheet>
        <sheet index="thx">
            <language index="lDEF">
                <field index="settings.flexform.thx.body">
                    <value index="vDEF">' . $thxBody . '</value>
                    <value index="_TRANSFORM_vDEF.vDEFbase">' . $thxBody . '</value>
                </field>
                <field index="settings.flexform.thx.redirect">
                    <value index="vDEF"></value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';

    return $records;
  }

/**
 * pageOrgCaddy_typoscript( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgCaddy_typoscript( )
  {
    $records = null;

    $pmX = $this->powermailVersionAppendix( );
    switch( true )
    {
      case( $pmX == '1x' ):
        $records = $this->pageOrgCaddy_typoscript1x( );
        break;
      case( $pmX == '2x' ):
        $records = $this->pageOrgCaddy_typoscript2x( );
        break;
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is neither 1x nor 2x. Internal: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    unset( $pmX );

    return $records;
  }

/**
 * pageOrgCaddy_typoscript1x( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgCaddy_typoscript1x( )
  {
    $records = null;

    $title  = 'pageOrgCaddy_title';
    $uid    = $this->pObj->arr_tsUids[ $title ];

    $strUid = sprintf( '%03d', $uid );
    $llTitle  = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle  = str_replace( ' ', null, $llTitle );
    $llTitle  = '+page_' . $llTitle . '_' . $strUid;

    list( $noreply, $domain ) = explode( '@', $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###'] );
    $noreply                  = 'noreply@' . $domain;


    $records[$uid]['title']     = $llTitle;
    $records[$uid]['constants'] = '
  /////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.caddy
  // plugin.powermail



//  Not needed: Is included at the root page
//
//  /////////////////////////////////////////
//  //
//  // plugin.caddy
//
//plugin.caddy {
//  pages {
//    caddy       = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddy_title' ] . '
//    caddymini   = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyCaddymini_title' ] . '
//    revocation  = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyRevocation_title' ] . '
//    shop        = ' . $this->pObj->arr_pageUids[ 'pageOrg_title' ] . '
//    terms       = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyTerms_title' ] . '
//  }
//}
//  // plugin.caddy



  /////////////////////////////////////////
  //
  // plugin.powermail

plugin.powermail {
  js {
    toHeader = 1
  }
}
  // plugin.powermail

';

    $records[$uid]['config']  = '
plugin.tx_powermail_pi1 {
  email {
    sender_mail {
      sender {
        name {
          value = Organiser
        }
        email {
          value = ' . $noreply . '
        }
      }
    }
  }
  _LOCAL_LANG {
    default {
      locallangmarker_confirmation_submit = Test Organiser without commitment!
    }
    de {
      locallangmarker_confirmation_submit = Organiser unverbindlich testen!
    }
  }
}';

      // SWITCH : install case
    switch( true )
    {
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $records[$uid]['config']  = $records[$uid]['config'] . '

  // Don\'t display the mini caddy
page.10.subparts.menue.10 >
';
        break;
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_org' ):
        // Do nothing
        break;
    }
      // SWITCH : install case

    return $records;
  }

/**
 * pageOrgCaddy_typoscript2x( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgCaddy_typoscript2x( )
  {
    $records = null;

    $title  = 'pageOrgCaddy_title';
    $uid    = $this->pObj->arr_tsUids[ $title ];

    $strUid = sprintf( '%03d', $uid );
    $llTitle  = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle  = str_replace( ' ', null, $llTitle );
    $llTitle  = '+page_' . $llTitle . '_' . $strUid;

    $records[$uid]['title']   = $llTitle;
    $records[$uid]['constants'] = '
  /////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.caddy
  // plugin.tx_powermail


//  Not needed: Is included at the root page
//
//  /////////////////////////////////////////
//  //
//  // plugin.caddy
//
//plugin.caddy {
//  pages {
//    caddy       = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddy_title' ] . '
//    caddymini   = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyCaddymini_title' ] . '
//    revocation  = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyRevocation_title' ] . '
//    shop        = ' . $this->pObj->arr_pageUids[ 'pageOrg_title' ] . '
//    terms       = ' . $this->pObj->arr_pageUids[ 'pageOrgCaddyTerms_title' ] . '
//  }
//}
//  // plugin.caddy



  /////////////////////////////////////////
  //
  // plugin.tx_powermail

plugin.tx_powermail {
  settings {
    javascript {
        // We take jQuery from tx_browser_pi1 or from T3jQuery (recommended)
      powermailJQuery =
      powermailJQueryUi =
    }
  }
}
  // plugin.tx_powermail

';
    $records[$uid]['constants'] = $this->zz_replacePageUids( $records[$uid]['constants'] );

    $records[$uid]['config']  = '
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
  // plugin.caddy
';

      // SWITCH : install case
    switch( true )
    {
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $records[$uid]['config']  = $records[$uid]['config'] . '

  // Don\'t display the mini caddy
page.10.subparts.menue.10 >
';
        break;
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_org' ):
        // Do nothing
        break;
    }
      // SWITCH : install case


    return $records;
  }

/**
 * pageOrgDocumentsCaddy( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgDocumentsCaddy( )
  {
    $records    = array( );
    $pageTitle  = $this->pObj->pi_getLL( 'pageOrgDocumentsCaddy_title' );

      // Update the jss script
    $records    = $this->pageOrgDocumentsCaddy_contentJss( );
    $this->sqlUpdateContent( $records, $pageTitle );

      // Update the powermail plugin
    $records    = $this->pageOrgDocumentsCaddy_pluginPowermail( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the caddy plugin
    $records    = $this->pageOrgDocumentsCaddy_pluginCaddy( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the TypoScript
    $records    = $this->pageOrgDocumentsCaddy_typoscript( );
    $this->sqlUpdateTyposcript( $records, $pageTitle );

  }

/**
 * pageOrgDocumentsCaddy_contentJss( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.4
 * @since   3.0.4
 */
  private function pageOrgDocumentsCaddy_contentJss( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_contentUids['content_pageOrgDocumentsCaddy_header'];

      // values
    $llHeader = $this->pObj->pi_getLL( 'content_pageOrgDocumentsCaddy_header' );
      // values

    $pmFieldsetUid = $this->pObj->powermailPageOrgDocumentsCaddy->getValue( 'record_pm_fSets_title_deliveryAddress' );
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
        $pmFieldsetHtmlId = 'tx-powermail-pi1_fieldset_' . $pmFieldsetUid;
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $pmFieldsetHtmlId = 'powermail_fieldset_' . $pmFieldsetUid;
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

    $jssScript = $this->pObj->pi_getLL('content_pageOrgDocumentsCaddy_bodytext');
    $jssScript = str_replace( '###POWERMAIL_FIELDSET_DELIVERYORDER_ADDRESS###', $pmFieldsetHtmlId, $jssScript );


    $records[$uid]['header']      = $llHeader;
    $records[$uid]['bodytext']    = $jssScript;

    return $records;
  }

/**
 * pageOrgDocumentsCaddy_pluginCaddy( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgDocumentsCaddy_pluginCaddy( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'pluginCaddyPageOrgDocumentsCaddy_header' ];
    $pmX      = $this->powermailVersionAppendix( );

      // values
    $llHeader = $this->pObj->pi_getLL( 'pluginCaddyPageOrgDocumentsCaddy_header' );
      // values

    $records[$uid]['header']      = $llHeader;
    $records[$uid]['pi_flexform'] = null .
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="note">
            <language index="lDEF">
                <field index="note">
                    <value index="vDEF">'
                      . $this->pObj->pi_getLL( 'pluginCaddyPageOrgDocumentsCaddy_note_' . $pmX ) .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="origin">
            <language index="lDEF">
                <field index="order">
                    <value index="vDEF">3972</value>
                </field>
                <field index="invoice">
                    <value index="vDEF">83</value>
                </field>
                <field index="deliveryorder">
                    <value index="vDEF">216</value>
                </field>
                <field index="min">
                    <value index="vDEF">3</value>
                </field>
                <field index="max">
                    <value index="vDEF">10</value>
                </field>
            </language>
        </sheet>
        <sheet index="email">
            <language index="lDEF">
                <field index="customerEmail">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_email' ) .
                    '</value>
                </field>
                <field index="termsMode">
                    <value index="vDEF">all</value>
                </field>
                <field index="revocationMode">
                    <value index="vDEF">all</value>
                </field>
                <field index="invoiceMode">
                    <value index="vDEF">all</value>
                </field>
                <field index="deliveryorderMode">
                    <value index="vDEF">all</value>
                </field>
            </language>
        </sheet>
        <sheet index="invoice">
            <language index="lDEF">
                <field index="company">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_companyBilling' ) .
                    '</value>
                </field>
                <field index="firstName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_firstnameBilling' ) .
                    '</value>
                </field>
                <field index="lastName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_surnameBilling' ) .
                    '</value>
                </field>
                <field index="address">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_streetBilling' ) .
                    '</value>
                </field>
                <field index="zip">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_zipBilling' ) .
                    '</value>
                </field>
                <field index="city">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_locationBilling' ) .
                    '</value>
                </field>
                <field index="country">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_countryBilling' ) .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="deliveryorder">
            <language index="lDEF">
                <field index="company">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_companyDelivery' ) .
                    '</value>
                </field>
                <field index="firstName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_firstnameDelivery' ) .
                    '</value>
                </field>
                <field index="lastName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_surnameDelivery' ) .
                    '</value>
                </field>
                <field index="address">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_streetDelivery' ) .
                    '</value>
                </field>
                <field index="zip">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_zipDelivery' ) .
                    '</value>
                </field>
                <field index="city">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_locationDelivery' ) .
                    '</value>
                </field>
                <field index="country">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'pageOrgDocumentsCaddy_title', 'record_pm_field_title_countryDelivery' ) .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="paths">
            <language index="lDEF">
                <field index="terms">
                    <value index="vDEF">typo3conf/ext/org/res/pdf/typo3-organiser_for_caddy.pdf</value>
                </field>
                <field index="revocation">
                    <value index="vDEF">typo3conf/ext/org/res/pdf/typo3-organiser_for_caddy.pdf</value>
                </field>
                <field index="invoice">
                    <value index="vDEF">typo3conf/ext/org/res/pdf/typo3-organiser_for_caddy.pdf</value>
                </field>
                <field index="deliveryorder">
                    <value index="vDEF">typo3conf/ext/org/res/pdf/typo3-organiser_for_caddy.pdf</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';

    return $records;
  }

/**
 * pageOrgDocumentsCaddy_pluginPowermail( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgDocumentsCaddy_pluginPowermail( )
  {
    $records  = null;

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
        $records = $this->pageOrgDocumentsCaddy_pluginPowermail1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $records = $this->pageOrgDocumentsCaddy_pluginPowermail2x( );
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

    return $records;
  }

/**
 * pageOrgDocumentsCaddy_pluginPowermail1x( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgDocumentsCaddy_pluginPowermail1x( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgDocumentsCaddy_header' ];

      // values
    $llHeader       = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_header' );
    $uidEmail       = $this->pObj->powermailPageOrgDocumentsCaddy->getValue( 'record_pm_field_title_email' );
    $customerEmail  = 'uid' . $uidEmail;
    $uidFirstname   = $this->pObj->powermailPageOrgDocumentsCaddy->getValue( 'record_pm_field_title_firstnameBilling' );
    $uidSurname     = $this->pObj->powermailPageOrgDocumentsCaddy->getValue( 'record_pm_field_title_surnameBilling' );
    $customerName   = 'uid' . $uidFirstname . ',uid' . $uidSurname;
      // values

    $records[$uid]['header']                  = $llHeader;
    $records[$uid]['tx_powermail_sender']     = $customerEmail;
    $records[$uid]['tx_powermail_sendername'] = $customerName;

    return $records;
  }

/**
 * pageOrgDocumentsCaddy_pluginPowermail2x( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgDocumentsCaddy_pluginPowermail2x( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgDocumentsCaddy_header' ];

    $llHeader         = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_header' );
    $uidForm          = $this->pObj->powermailPageOrgDocumentsCaddy->getValue( 'record_pm_form_title_pageOrgDocumentsCaddy' );
    $receiverSubject  = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_subject_r2x' );
    $receiverBody     = htmlspecialchars( $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_body_r2x' ) );
    list( $name, $domain) = explode( '@', $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###'] );
    unset( $name );
    $senderEmail      = 'noreply@' . $domain;
    $senderSubject    = $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_subject_s2x' );
    $senderBody       = htmlspecialchars( $this->pObj->pi_getLL( 'pluginPowermailPageOrgDocumentsCaddy_body_s2x' ) );
    $thxBody          = htmlspecialchars( $this->pObj->pi_getLL('pluginPowermailPageOrgDocumentsCaddy_thanks2x') );

    $records[$uid]['header']      = $llHeader;
    $records[$uid]['pi_flexform'] = null .
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="main">
            <language index="lDEF">
                <field index="settings.flexform.main.form">
                    <value index="vDEF">' . $uidForm . '</value>
                </field>
                <field index="settings.flexform.main.confirmation">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
        <sheet index="receiver">
            <language index="lDEF">
                <field index="settings.flexform.receiver.name">
                    <value index="vDEF">{billingaddressfirstname} {billingaddresslastname}</value>
                </field>
                <field index="settings.flexform.receiver.email">
                    <value index="vDEF">{contactdataemail}</value>
                </field>
                <field index="settings.flexform.receiver.subject">
                    <value index="vDEF">' . $receiverSubject . '</value>
                </field>
                <field index="settings.flexform.receiver.body">
                    <value index="vDEF">' . $receiverBody . '</value>
                    <value index="_TRANSFORM_vDEF.vDEFbase">' . $receiverBody . '</value>
                </field>
            </language>
        </sheet>
        <sheet index="sender">
            <language index="lDEF">
                <field index="settings.flexform.sender.name">
                    <value index="vDEF">Organiser</value>
                </field>
                <field index="settings.flexform.sender.email">
                    <value index="vDEF">' . $senderEmail . '</value>
                </field>
                <field index="settings.flexform.sender.subject">
                    <value index="vDEF">' . $senderSubject . '</value>
                </field>
                <field index="settings.flexform.sender.body">
                    <value index="vDEF">' . $senderBody . '</value>
                    <value index="_TRANSFORM_vDEF.vDEFbase">' . $senderBody . '</value>
                </field>
            </language>
        </sheet>
        <sheet index="thx">
            <language index="lDEF">
                <field index="settings.flexform.thx.body">
                    <value index="vDEF">' . $thxBody . '</value>
                    <value index="_TRANSFORM_vDEF.vDEFbase">' . $thxBody . '</value>
                </field>
                <field index="settings.flexform.thx.redirect">
                    <value index="vDEF"></value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';

    return $records;
  }

/**
 * pageOrgDocumentsCaddy_typoscript( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgDocumentsCaddy_typoscript( )
  {
    $records = null;

    $pmX = $this->powermailVersionAppendix( );
    switch( true )
    {
      case( $pmX == '1x' ):
        $records = $this->pageOrgDocumentsCaddy_typoscript1x( );
        break;
      case( $pmX == '2x' ):
        $records = $this->pageOrgDocumentsCaddy_typoscript2x( );
        break;
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is neither 1x nor 2x. Internal: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    unset( $pmX );

    return $records;
  }

/**
 * pageOrgDocumentsCaddy_typoscript1x( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgDocumentsCaddy_typoscript1x( )
  {
    $records = null;

    $title  = 'pageOrgDocumentsCaddy_title';
    $uid    = $this->pObj->arr_tsUids[ $title ];

    $strUid = sprintf( '%03d', $uid );
    $llTitle  = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle  = str_replace( ' ', null, $llTitle );
    $llTitle  = '+page_' . $llTitle . '_' . $strUid;

    list( $noreply, $domain ) = explode( '@', $this->pObj->markerArray['###MAIL_DEFAULT_RECIPIENT###'] );
    $noreply                  = 'noreply@' . $domain;


    $records[$uid]['title']     = $llTitle;
    $records[$uid]['constants'] = '
  /////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.caddy
  // plugin.powermail



//  Not needed: Is included at the page documents
//
//  /////////////////////////////////////////
//  //
//  // plugin.caddy
//
//plugin.caddy {
//  pages {
//    caddy       = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ] . '
//    caddymini   = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyCaddymini_title' ] . '
//    revocation  = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyRevocation_title' ] . '
//    shop        = ' . $this->pObj->arr_pageUids[ 'pageOrgDocuments_title' ] . '
//    terms       = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyTerms_title' ] . '
//  }
//}



  /////////////////////////////////////////
  //
  // plugin.powermail

plugin.powermail {
  js {
    toHeader = 1
  }
}
  // plugin.powermail

';

    $records[$uid]['config']  = '
plugin.tx_powermail_pi1 {
  email {
    sender_mail {
      sender {
        name {
          value = Organiser
        }
        email {
          value = ' . $noreply . '
        }
      }
    }
  }
  _LOCAL_LANG {
    default {
      locallangmarker_confirmation_submit = Test Organiser without commitment!
    }
    de {
      locallangmarker_confirmation_submit = Organiser unverbindlich testen!
    }
  }
}';

      // SWITCH : install case
    switch( true )
    {
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $records[$uid]['config']  = $records[$uid]['config'] . '

  // Don\'t display the mini caddy
page.10.subparts.menue.10 >
';
        break;
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_org' ):
        // Do nothing
        break;
    }
      // SWITCH : install case

    return $records;
  }

/**
 * pageOrgDocumentsCaddy_typoscript2x( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgDocumentsCaddy_typoscript2x( )
  {
    $records = null;

    $title  = 'pageOrgDocumentsCaddy_title';
    $uid    = $this->pObj->arr_tsUids[ $title ];

    $strUid = sprintf( '%03d', $uid );
    $llTitle  = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle  = str_replace( ' ', null, $llTitle );
    $llTitle  = '+page_' . $llTitle . '_' . $strUid;

    $records[$uid]['title']   = $llTitle;
    $records[$uid]['constants'] = '
  /////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.caddy
  // plugin.tx_powermail



//  Not needed: Is included at the page documents
//
//  /////////////////////////////////////////
//  //
//  // plugin.caddy
//
//plugin.caddy {
//  pages {
//    caddy       = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddy_title' ] . '
//    caddymini   = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyCaddymini_title' ] . '
//    revocation  = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyRevocation_title' ] . '
//    shop        = ' . $this->pObj->arr_pageUids[ 'pageOrgDocuments_title' ] . '
//    terms       = ' . $this->pObj->arr_pageUids[ 'pageOrgDocumentsCaddyTerms_title' ] . '
//  }
//}




  /////////////////////////////////////////
  //
  // plugin.tx_powermail

plugin.tx_powermail {
  settings {
    javascript {
        // We take jQuery from tx_browser_pi1 or from T3jQuery (recommended)
      powermailJQuery =
      powermailJQueryUi =
    }
  }
}
  // plugin.tx_powermail

';

    $records[$uid]['config']  = '
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

      // SWITCH : install case
    switch( true )
    {
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $records[$uid]['config']  = $records[$uid]['config'] . '

  // Don\'t display the mini caddy
page.10.subparts.menue.10 >
';
        break;
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_org' ):
        // Do nothing
        break;
    }
      // SWITCH : install case


    return $records;
  }

/**
 * pageOrgLibraryHeaderLogo( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgLibraryHeaderLogo( )
  {
      // SWITCH : install case
    $installCase = $this->pObj->markerArray['###INSTALL_CASE###'];
    switch( $installCase )
    {
      case( 'install_org' ):
        return;
        break;
      case( 'install_all' ):
        // follow the workflow
        break;
      default:
        $prompt = __METHOD__ .  ' #' . __LINE__ . ': Undefined value in switch: "' . $installCase . '"';
        die( $prompt );
    }
      // SWITCH : install case

    $records    = array( );
    $pageUid    = $this->pObj->arr_pageUids[ 'pageOrgLibraryHeaderLogo_title' ];
    $pageTitle  = $this->pObj->arr_pageTitles[ $pageUid ];

      // Update page properties
    $records = $this->pageOrgLibraryHeaderLogo_content( );
    $this->sqlUpdateContent( $records, $pageTitle );
  }

/**
 * pageOrgLibraryHeaderLogo_content( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgLibraryHeaderLogo_content( )
  {
    $records = null;

    $llLabel  = 'content_pageOrgLibraryHeaderLogo_header';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $uid      = $this->pObj->arr_contentUids[ $llLabel ];

    $image_link = $this->pObj->pi_getLL('content_pageOrgLibraryHeaderLogo_image_link');
    $image_link = $this->zz_replacePageUids( $image_link );

    $records[$uid]['header']      = $llTitle;
    $records[$uid]['image_link']  = $image_link;
      // #i0002, 13-07-30, dwildt, 1+
    $records[$uid]['image_zoom']  = 1;


    return $records;
  }

/**
 * pageOrgData( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgData( )
  {
    $records    = array( );
    $pageUid    = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $pageTitle  = $this->pObj->arr_pageTitles[ $pageUid ];

      // Update page properties
    $records = $this->pageOrgData_properties( );
    $this->sqlUpdatePages( $records, $pageTitle );

  }

/**
 * pageOrgData_properties( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageOrgData_properties( )
  {
    $records = null;

    $uid          = $this->pObj->arr_pageUids[ 'pageOrgData_title' ];
    $groupUid     = $this->pObj->markerArray['###GROUP_UID###'];
    $groupTitle   = $this->pObj->markerArray['###GROUP_TITLE###'];

    $dateHumanReadable  = date('Y-m-d G:i:s');

    $records[$uid]['TSconfig']    = '

// Created by ORGANISER INSTALLER at ' . $dateHumanReadable . ' -- BEGIN



  ///////////////////////////
  //
  // INDEX

  // TCEFORM
  //    organiser tables
  // TCEMAIN
  //    clearCacheCmd
  //    permissions
  // MOD
  //    web_layout



  // PID
  // [' . $uid . '] organiser
  //    [%pageOrgDataCal_title%] calendar
  //    [%pageOrgDataDownloads_title%] downloads
  //    [%pageOrgDataEvents_title%] events
  //    [%pageOrgDataHeadquarters_title%] headquarters
  //    [%pageOrgDataLocations_title%] locations
  //    [%pageOrgDataNews_title%] news
  //    [%pageOrgDataStaff_title%] staff

  // organiser tables
TCEFORM {
  tx_org_cal_all_tables {
    tx_org_cal {
      PAGE_TSCONFIG_IDLIST  = ' . $uid . ',%pageOrgDataCal_title%
      PAGE_TSCONFIG_ID      = %pageOrgDataCal_title%
    }
    tx_org_calentrance < .tx_org_cal
    tx_org_calspecial  < .tx_org_cal
    tx_org_caltype     < .tx_org_cal
    tx_org_downloads {
      PAGE_TSCONFIG_IDLIST  = ' . $uid . ',%pageOrgDataDownloads_title%
      PAGE_TSCONFIG_ID      = %pageOrgDataDownloads_title%
    }
    tx_org_downloadscat   < .tx_org_downloads
    tx_org_downloadsmedia < .tx_org_downloads
    tx_org_event {
      PAGE_TSCONFIG_IDLIST  = ' . $uid . ',%pageOrgDataEvents_title%
      PAGE_TSCONFIG_ID      = %pageOrgDataEvents_title%
    }
    tx_org_eventcat < .tx_org_event
    tx_org_headquarters {
      PAGE_TSCONFIG_IDLIST  = ' . $uid . ',%pageOrgDataHeadquarters_title%
      PAGE_TSCONFIG_ID      = %pageOrgDataHeadquarters_title%
    }
    tx_org_headquarterscat < .tx_org_headquarters
    tx_org_location {
      PAGE_TSCONFIG_IDLIST  = ' . $uid . ',%pageOrgDataLocations_title%
      PAGE_TSCONFIG_ID      = %pageOrgDataLocations_title%
    }
    tx_org_job {
      PAGE_TSCONFIG_IDLIST  = ' . $uid . ',%pageOrgDataJob_title%
      PAGE_TSCONFIG_ID      = %pageOrgDataJob_title%
    }
    tx_org_jobcat < .tx_org_job
    tx_org_news {
      PAGE_TSCONFIG_IDLIST  = ' . $uid . ',%pageOrgDataNews_title%
      PAGE_TSCONFIG_ID      = %pageOrgDataNews_title%
    }
    tx_org_newscat < .tx_org_news
    tx_org_service {
      PAGE_TSCONFIG_IDLIST  = ' . $uid . ',%pageOrgDataService_title%
      PAGE_TSCONFIG_ID      = %pageOrgDataService_title%
    }
    tx_org_servicecat < .tx_org_service
    tx_org_staff {
      PAGE_TSCONFIG_IDLIST  = ' . $uid . ',%pageOrgDataStaff_title%
      PAGE_TSCONFIG_ID      = %pageOrgDataStaff_title%
    }
    tx_org_staffcat < .tx_org_staff
  }
  tx_org_cal            < .tx_org_cal_all_tables
  tx_org_calentrance    < .tx_org_cal_all_tables
  tx_org_calspecial     < .tx_org_cal_all_tables
  tx_org_caltype        < .tx_org_cal_all_tables
  tx_org_downloads      < .tx_org_cal_all_tables
  tx_org_downloadscat   < .tx_org_cal_all_tables
  tx_org_downloadsmedia < .tx_org_cal_all_tables
  tx_org_event          < .tx_org_cal_all_tables
  tx_org_headquarters   < .tx_org_cal_all_tables
  tx_org_location       < .tx_org_cal_all_tables
  tx_org_job            < .tx_org_cal_all_tables
  tx_org_jobcat         < .tx_org_cal_all_tables
  tx_org_news           < .tx_org_cal_all_tables
  tx_org_newscat        < .tx_org_cal_all_tables
  tx_org_service        < .tx_org_cal_all_tables
  tx_org_servicecat     < .tx_org_cal_all_tables
  tx_org_staff          < .tx_org_cal_all_tables
  tx_org_staffcat       < .tx_org_cal_all_tables
}
  // organiser tables
  // TCEFORM



  ////////////////////////////////////////////////////////////////////////
  //
  // TCEMAIN

TCEMAIN {
  clearCacheCmd = pages
  permissions {
    // ' . $groupUid . ': ' . $groupTitle . '
    groupid = ' . $groupUid . '
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

';
    $records[$uid]['TSconfig'] = $this->zz_replacePageUids( $records[$uid]['TSconfig'] );

    return $records;
  }



 /***********************************************
  *
  * Sql
  *
  **********************************************/

/**
 * sqlUpdateContent( )
 *
 * @param	array		$records  : tt_content records for pages
 * @param	string		$pageTitle  : title of the page
 * @return	void
 * @access private
 * @version 3.0.4
 * @since   3.0.4
 */
  private function sqlUpdateContent( $records, $pageTitle )
  {
    $table = 'tt_content';

    foreach( $records as $uid => $record )
    {
      $where      = 'uid = ' . $uid;
      $fields     = array_keys( $record );
      $csvFields  = implode( ', ', $fields );
      $csvFields  = str_replace( 'header, ', null, $csvFields );

      //var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $table, $where, $record );

      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Organiser Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

      $this->pObj->markerArray['###FIELD###']     = $csvFields;
      $this->pObj->markerArray['###TITLE###']     = '"' . $record['header'] . '"';
      $this->pObj->markerArray['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $uid . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'consolidate_prompt_content' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
      $this->pObj->arrReport[ ] = $prompt;
    }
  }

/**
 * sqlUpdatePlugin( )
 *
 * @param	array		$records  : tt_content records for pages
 * @param	string		$pageTitle  : title of the page
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function sqlUpdatePlugin( $records, $pageTitle )
  {
    $this->sqlUpdateContent( $records, $pageTitle );
  }

/**
 * powermailVersionAppendix( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function powermailVersionAppendix( )
  {
    if( $this->powermailVersionAppendix !== null )
    {
      return $this->powermailVersionAppendix;
    }

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
        $this->powermailVersionAppendix = '1x';
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $this->powermailVersionAppendix = '2x';
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

    return $this->powermailVersionAppendix;
  }

/**
 * sqlUpdatePages( )
 *
 * @param	array		$records  : TypoScript records for pages
 * @param	string		$pageTitle  : title of the page
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function sqlUpdatePages( $records, $pageTitle )
  {
    $table = 'pages';

    foreach( $records as $uid => $record )
    {
      $where      = 'uid = ' . $uid;
      $fields     = array_keys( $record );
      $csvFields  = implode( ', ', $fields );

//      var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $table, $where, $record );

      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Organiser Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

      $this->pObj->markerArray['###FIELD###']     = $csvFields;
      $this->pObj->markerArray['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $uid . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'consolidate_prompt_page' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
      $this->pObj->arrReport[ ] = $prompt;
    }
  }

/**
 * sqlUpdateTyposcript( )
 *
 * @param	array		$records  : TypoScript records for pages
 * @param	string		$pageTitle  : title of the page
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function sqlUpdateTyposcript( $records, $pageTitle )
  {
    $table = 'sys_template';

    foreach( $records as $uid => $record )
    {
      $where      = 'uid = ' . $uid;
      $fields     = array_keys( $record );
      $csvFields  = implode( ', ', $fields );
      $csvFields  = str_replace( 'title, ', null, $csvFields );

      //var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $table, $where, $record );

      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Organiser Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }
      $this->pObj->markerArray['###FIELD###']     = $csvFields;
      $this->pObj->markerArray['###TITLE###']     = '"' . $record['title'] . '"';
      $this->pObj->markerArray['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $uid . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'consolidate_prompt_content' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
      $this->pObj->arrReport[ ] = $prompt;
    }
  }

/**
 * sqlUpdateTyposcriptOtherHide( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function sqlUpdateTyposcriptOtherHide( )
  {
    $pageTitle = $GLOBALS['TSFE']->page['title'];

    $table = 'sys_template';

    $record = array( 'hidden' => 1 );

    $uid    = $this->pObj->arr_tsUids[ $this->pObj->str_tsRoot ];
    $pid    = $GLOBALS['TSFE']->id;
    $where  = 'pid = ' . $pid . ' AND uid NOT LIKE ' . $uid;

    //var_dump( __METHOD__, __LINE__, $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record ) );
    $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $table, $where, $record );

    $error = $GLOBALS['TYPO3_DB']->sql_error( );

    if( $error )
    {
      $query  = $GLOBALS['TYPO3_DB']->UPDATEquery( $table, $where, $record );
      $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                'query: ' . $query . '.<br />' . PHP_EOL .
                'error: ' . $error . '.<br />' . PHP_EOL .
                'Sorry for the trouble.<br />' . PHP_EOL .
                'TYPO3-Organiser Installer<br />' . PHP_EOL .
              __METHOD__ . ' (' . __LINE__ . ')';
      die( $prompt );
    }

    $this->pObj->markerArray['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $uid . ')';
    $prompt = '
      <p>
        ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'consolidate_prompt_template' ) . '
      </p>';
    $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
    $this->pObj->arrReport[ ] = $prompt;
  }



 /***********************************************
  *
  * ZZ
  *
  **********************************************/

/**
 * zz_getPowermailUid( )
 *
 * @param	string		$label        : label for the powermail field
 * @return	string		$powermailUid : uid of the powermail field record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zz_getPowermailUid( $page, $label )
  {
    $powermailUid = null;

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
        $powermailUid = $this->zz_getPowermailUid1x( $page, $label );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $powermailUid = $this->zz_getPowermailUid2x( $page, $label );
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

    return $powermailUid;
  }

/**
 * zz_getPowermailUid1x( )
 *
 * @param	string		$label        : label for the powermail field
 * @return	string		$powermailUid : uid of the powermail field record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zz_getPowermailUid1x( $page, $label )
  {
    switch( $page )
    {
      case( 'pageOrgCaddy_title' ):
        $powermailUid = $this->pObj->powermailPageOrgCaddy->getValue( $label );
        break;
      case( 'pageOrgDocumentsCaddy_title' ):
        $powermailUid = $this->pObj->powermailPageOrgDocumentsCaddy->getValue( $label );
        break;
      default:
        $prompt = __METHOD__ . ' #' . __LINE__ . ': undefined value in switch!';
        die( $prompt );
        break;
    }

    return $powermailUid;
  }

/**
 * zz_getPowermailUid2x( )
 *
 * @param	string		$label        : label for the powermail field
 * @return	string		$powermailUid : uid of the powermail field record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zz_getPowermailUid2x( $page, $label )
  {
    switch( $page )
    {
      case( 'pageOrgCaddy_title' ):
//        $powermailUid = 'tx_powermail_domain_model_fields_'
//                      . $this->pObj->powermailPageOrgCaddy->getValue( $label );
        $powermailUid = $this->pObj->powermailPageOrgCaddy->getValue( $label );
        break;
      case( 'pageOrgDocumentsCaddy_title' ):
//        $powermailUid = 'tx_powermail_domain_model_fields_'
//                      . $this->pObj->powermailPageOrgDocumentsCaddy->getValue( $label );
        $powermailUid = $this->pObj->powermailPageOrgDocumentsCaddy->getValue( $label );
        break;
      default:
        $prompt = __METHOD__ . ' #' . __LINE__ . ': undefined value in switch!';
        die( $prompt );
        break;
    }

    return $powermailUid;
  }

/**
 * zz_replacePageUids( )
 *
 * @param       string          $content
 * @return	string		$content
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function zz_replacePageUids( $content )
  {
    $needle   = array( );
    $replace  = array( );

    foreach( ( array ) $this->pObj->arr_pageUids as $page => $uid )
    {
      $needle[ ]  = '%' . $page . '%';
      $replace[ ] = $uid;
    }

    $content = str_replace( $needle, $replace, $content );


    return $content;
  }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_consolidate.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_consolidate.php']);
}