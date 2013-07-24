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
 *   78: class tx_orginstaller_pi1_consolidate
 *
 *              SECTION: Main
 *  104:     public function main( )
 *
 *              SECTION: pages
 *  131:     private function pageCaddy( )
 *  166:     private function pageCaddyContentJss( )
 *  219:     private function pageCaddyPluginCaddy( )
 *  392:     private function pageCaddyPluginCaddyMini( )
 *  435:     private function pageCaddyPluginPowermail( )
 *  475:     private function pageCaddyPluginPowermail1x( )
 *  504:     private function pageCaddyPluginPowermail2x( )
 *  594:     private function pageCaddyTyposcript( )
 *  627:     private function pageCaddyTyposcript1x( )
 *  695:     private function pageCaddyTyposcript2x( )
 *  751:     private function pageRoot( )
 *  782:     private function pageRootFileCopy( $timestamp )
 *  836:     private function pageRootPluginInstallHide( )
 *  858:     private function pageRootProperties( $timestamp )
 *  912:     private function pageRootTyposcriptOtherHide( )
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
 * @version 3.0.0
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

    $this->pageRoot( );
    $this->pageCaddy( );
  }



 /***********************************************
  *
  * pages
  *
  **********************************************/

/**
 * pageCaddy( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageCaddy( )
  {
    $records    = array( );
    $pageTitle  = $this->pObj->pi_getLL( 'pageOrgCaddy_title' );

      // Update the jss script
    $records    = $this->pageCaddyContentJss( );
    $this->sqlUpdateContent( $records, $pageTitle );

      // Update the powermail plugin
    $records    = $this->pageCaddyPluginPowermail( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the caddy plugin
    $records    = $this->pageCaddyPluginCaddy( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the caddy plugin
    $records    = $this->pageCaddyPluginCaddyMini( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Update the TypoScript
    $records    = $this->pageCaddyTyposcript( );
    $this->sqlUpdateTyposcript( $records, $pageTitle );

  }

/**
 * pageCaddyContentJss( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.4
 * @since   3.0.4
 */
  private function pageCaddyContentJss( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_contentUids['content_caddy_header'];

      // values
    $llHeader = $this->pObj->pi_getLL( 'content_caddy_header' );
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

    $jssScript = $this->pObj->pi_getLL('content_caddy_bodytext');
    $jssScript = str_replace( '###POWERMAIL_FIELDSET_DELIVERYORDER_ADDRESS###', $pmFieldsetHtmlId, $jssScript );


    $records[$uid]['header']      = $llHeader;
    $records[$uid]['bodytext']    = $jssScript;

    return $records;
  }

/**
 * pageCaddyPluginCaddy( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageCaddyPluginCaddy( )
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
                      . $this->pObj->pi_getLL( 'plugin_caddy_note_note_' . $pmX ) .
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
                      . $this->zz_getPowermailUid( 'record_pm_field_title_email' ) .
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
                      . $this->zz_getPowermailUid( 'record_pm_field_title_companyBilling' ) .
                    '</value>
                </field>
                <field index="firstName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_firstnameBilling' ) .
                    '</value>
                </field>
                <field index="lastName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_surnameBilling' ) .
                    '</value>
                </field>
                <field index="address">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_streetBilling' ) .
                    '</value>
                </field>
                <field index="zip">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_zipBilling' ) .
                    '</value>
                </field>
                <field index="city">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_locationBilling' ) .
                    '</value>
                </field>
                <field index="country">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_countryBilling' ) .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="deliveryorder">
            <language index="lDEF">
                <field index="company">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_companyDelivery' ) .
                    '</value>
                </field>
                <field index="firstName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_firstnameDelivery' ) .
                    '</value>
                </field>
                <field index="lastName">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_surnameDelivery' ) .
                    '</value>
                </field>
                <field index="address">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_streetDelivery' ) .
                    '</value>
                </field>
                <field index="zip">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_zipDelivery' ) .
                    '</value>
                </field>
                <field index="city">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_locationDelivery' ) .
                    '</value>
                </field>
                <field index="country">
                    <value index="vDEF">'
                      . $this->zz_getPowermailUid( 'record_pm_field_title_countryDelivery' ) .
                    '</value>
                </field>
            </language>
        </sheet>
        <sheet index="paths">
            <language index="lDEF">
                <field index="terms">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-draft.pdf</value>
                </field>
                <field index="revocation">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-draft.pdf</value>
                </field>
                <field index="invoice">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-draft.pdf</value>
                </field>
                <field index="deliveryorder">
                    <value index="vDEF">typo3conf/ext/quick_shop/res/pdf/typo3-quick-shop-draft.pdf</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';

    return $records;
  }

/**
 * pageCaddyPluginCaddyMini( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageCaddyPluginCaddyMini( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'pluginCaddyminiPageOrgCaddyCaddymini_header' ];

      // values
    $llHeader   = $this->pObj->pi_getLL( 'pluginCaddyminiPageOrgCaddyCaddymini_header' );
    $pidOfCaddy = $this->pObj->arr_pageUids[ 'pageOrgCaddy_title' ];
      // values

    $records[$uid]['header']      = $llHeader;
    $records[$uid]['pi_flexform'] = null .
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="sdefPidCaddy">
                    <value index="vDEF">' . $pidOfCaddy . '</value>
                </field>
                <field index="sdefCaddyMode">
                    <value index="vDEF">woItems</value>
                </field>
                <field index="sdefDrs">
                    <value index="vDEF">0</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';

    return $records;
  }

/**
 * pageCaddyPluginPowermail( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageCaddyPluginPowermail( )
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
        $records = $this->pageCaddyPluginPowermail1x( );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $records = $this->pageCaddyPluginPowermail2x( );
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
 * pageCaddyPluginPowermail1x( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageCaddyPluginPowermail1x( )
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
 * pageCaddyPluginPowermail2x( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageCaddyPluginPowermail2x( )
  {
    $records  = null;
    $uid      = $this->pObj->arr_pluginUids[ 'pluginPowermailPageOrgCaddy_header' ];

    $llHeader         = $this->pObj->pi_getLL( 'pluginPowermailPageOrgCaddy_header' );
    $uidForm          = $this->pObj->powermailPageOrgCaddy->getValue( 'record_pm_form_title_caddyorder' );
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
 * pageCaddyTyposcript( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageCaddyTyposcript( )
  {
    $records = null;

    $pmX = $this->powermailVersionAppendix( );
    switch( true )
    {
      case( $pmX == '1x' ):
        $records = $this->pageCaddyTyposcript1x( );
        break;
      case( $pmX == '2x' ):
        $records = $this->pageCaddyTyposcript2x( );
        break;
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is neither 1x nor 2x. Internal: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die( $prompt );
        break;
    }

    return $records;
  }

/**
 * pageCaddyTyposcript1x( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageCaddyTyposcript1x( )
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


    $records[$uid]['title']   = $llTitle;
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
page.10.subparts.menue.20 >
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
 * pageCaddyTyposcript2x( )
 *
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageCaddyTyposcript2x( )
  {
    $records = null;

    $title  = 'pageOrgCaddy_title';
    $uid    = $this->pObj->arr_tsUids[ $title ];

    $strUid = sprintf( '%03d', $uid );
    $llTitle  = strtolower( $this->pObj->pi_getLL( $title ) );
    $llTitle  = str_replace( ' ', null, $llTitle );
    $llTitle  = '+page_' . $llTitle . '_' . $strUid;

    $records[$uid]['title']   = $llTitle;
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
page.10.subparts.menue.20 >
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
 * pageRoot( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageRoot( )
  {
    $records    = array( );
    $timestamp  = time();
    $pageTitle  = $GLOBALS['TSFE']->page['title'];

      // Update page properties
    $records = $this->pageRootProperties( $timestamp );
    $this->sqlUpdatePages( $records, $pageTitle );

      // Copy header image
    $this->pageRootFileCopy( $timestamp );

      // Hide the installer plugin
    $records    = $this->pageRootPluginInstallHide( );
    $this->sqlUpdatePlugin( $records, $pageTitle );

      // Hide the TypoScript template
    $this->pageRootTyposcriptOtherHide( );
    $this->sqlUpdateTyposcriptOtherHide( );
  }

/**
 * pageRootFileCopy( )
 *
 * @param	integer		$timestamp  : current time
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageRootFileCopy( $timestamp )
  {
      // Files
    $str_fileSrce = 'quick_shop_header_image_210px.jpg';
    $str_fileDest = 'typo3_org_' . $timestamp . '.jpg';

      // Paths
    $str_pathSrceAbs  = t3lib_extMgm::extPath( 'quick_shop' ) . 'res/images/';
    $str_pathSrce     = t3lib_extMgm::siteRelPath( 'quick_shop' ) . 'res/images/';
    $str_pathDest     = 'uploads/media/';

//    if( ! file_exists( $str_pathSrceAbs . $str_fileSrce ) )
//    {
//var_dump( __METHOD__, __LINE__, $str_pathSrceAbs . $str_fileSrce, 0 );
//    }
      // Copy
    $success = copy( $str_pathSrce . $str_fileSrce, $str_pathDest . $str_fileDest );
//var_dump( __METHOD__, __LINE__, $str_pathSrce . $str_fileSrce, $str_pathDest . $str_fileDest, $success );
      // SWICTH : prompt depending on success
    switch( $success )
    {
      case( false ):
        $this->pObj->markerArray['###SRCE###'] = $str_pathSrce . $str_fileSrce;
        $this->pObj->markerArray['###DEST###'] = $str_pathDest . $str_fileDest;
        $prompt = '
          <p>
            '.$this->pObj->arr_icons['warn'].' '.$this->pObj->pi_getLL('files_create_prompt_error').'
          </p>';
        $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
        $this->pObj->arrReport[ ] = $prompt;
        break;
      case( true ):
      default:
        $this->pObj->markerArray['###DEST###'] = $str_fileDest;
        $this->pObj->markerArray['###PATH###'] = $str_pathDest;
        $prompt = '
          <p>
            '.$this->pObj->arr_icons['ok'].' '.$this->pObj->pi_getLL('files_create_prompt').'
          </p>';
        $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $this->pObj->markerArray );
        $this->pObj->arrReport[ ] = $prompt;
        break;
    }
      // SWICTH : prompt depending on success
  }

/**
 * pageRootPluginInstallHide( )
 *
 * @return	array		$records : the plugin record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageRootPluginInstallHide( )
  {
    $records = null;

    $uid    = $this->pObj->cObj->data['uid'];
    $header = $this->pObj->cObj->data['header'];

    $records[$uid]['header'] = $header;
    $records[$uid]['hidden'] = 1;

    return $records;
  }

/**
 * pageRootProperties( )
 *
 * @param	integer		$timestamp  : current time
 * @return	array		$records    : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageRootProperties( $timestamp )
  {
    $records = null;

    $uid          = $GLOBALS['TSFE']->id;
    $is_siteroot  = null;
    $groupUid     = $this->pObj->markerArray['###GROUP_UID###'];
    $groupTitle   = $this->pObj->markerArray['###GROUP_TITLE###'];

      // SWITCH : siteroot depends on toplevel
    switch( $this->pObj->bool_topLevel )
    {
      case( true ):
        $is_siteroot = 1;
        break;
      case( false ):
      default:
        $is_siteroot = 0;
        break;
    }
      // SWITCH : siteroot depends on toplevel

    $records[$uid]['title']       = $this->pObj->pi_getLL( 'pageOrg_title' );
    $records[$uid]['nav_hide']    = 1;
    $records[$uid]['is_siteroot'] = $is_siteroot;
    $records[$uid]['media']       = 'typo3_org_' . $timestamp . '.jpg';
    $records[$uid]['module']      = null;
    $records[$uid]['TSconfig']    = '

// ORGANISER INSTALLER at ' . date( 'Y-m-d G:i:s' ) . ' -- BEGIN

TCEMAIN {
  permissions {
    // ' . $groupUid . ': ' . $groupTitle . '
    groupid = ' . $groupUid . '
    group   = show,edit,delete,new,editcontent
  }
}

// ORGANISER INSTALLER at ' . date( 'Y-m-d G:i:s' ) . ' -- END

';

    return $records;
  }

/**
 * pageRootTyposcriptOtherHide( )
 *
 * @return	array		$record : the TypoScript record
 * @access private
 * @version 3.0.0
 * @since   3.0.0
 */
  private function pageRootTyposcriptOtherHide( )
  {
    // Do nothing
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
    $this->sqlUpdatePlugin( $records, $pageTitle );
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
                  'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
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
                  'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
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
                  'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
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
                'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
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
  private function zz_getPowermailUid( $label )
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
        $powermailUid = $this->zz_getPowermailUid1x( $label );
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $powermailUid = $this->zz_getPowermailUid2x( $label );
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
  private function zz_getPowermailUid1x( $label )
  {
    $powermailUid = $this->pObj->arr_recordUids[ $label ];

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
  private function zz_getPowermailUid2x( $label )
  {
    $powermailUid = 'tx_powermail_domain_model_fields_'
                  . $this->pObj->arr_recordUids[ $label ];

    return $powermailUid;
  }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_consolidate.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_consolidate.php']);
}