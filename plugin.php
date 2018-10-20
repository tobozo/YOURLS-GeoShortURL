<?php
/*

  Plugin Name: GeoShortURL
  Plugin URI: http://github.com/tobozo/YOURLS-GeoShortURL
  Description: Use GeoIP to serve different redirections depending on the country of the originating IP Address
  Version: 0.1
  Author: tobozo
  Author URI: http://github.com/tobozo/
  
*/
// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();
 
yourls_add_action( 'plugins_loaded', 'geo_short_url_admin_page_add' );

function geo_short_url_admin_page_add() {
  yourls_register_plugin_page( 'geo_short_url', 'Per-country Short URLs GeoIP settings', 'geo_short_url_admin_page_do' );
}

// Display admin page
function geo_short_url_admin_page_do() {
    if( isset( $_POST['geo_short_url_mode'] ) ) {
        yourls_verify_nonce( 'geo_short_url' );
        geo_short_url_admin_page_update();
    }
    
    $mode = intval(yourls_get_option( 'geo_short_url_mode', 1 ));
    $nonce = yourls_create_nonce( 'geo_short_url' );
    
    echo '<h2>GeoIP-Redirect Redirection Rules</h2>';
    echo '<p>This plugin allows you to configure how the GeoShortUrl plugin operates.</p>';
    echo '<ul>';
    echo '<li>Choose the GeoIP broker from this menu.</li>';
    echo '<li>Create short URLs with "-xx" country code suffix to override the main redirect in a per-country fashion.</li>';
    echo '</ul>';
    echo '<form method="post">';
    echo '<input type="hidden" name="nonce" value="' . $nonce . '" />';
    
    echo '<label for="geo_short_url_mode">Select Redirect Search Mode:</label>';
    echo '<select id="geo_short_url_mode" name="geo_short_url_mode">';
    
    $opt1 = ( $mode == 1 ? ' selected' : '');
    $opt2 = ( $mode == 2 ? ' selected' : '');
    $opt3 = ( $mode == 3 ? ' selected' : '');
    
    echo '<option value=1' . $opt1 . '>Inherit Country code from YOURLS GeoIP plugin</option>';
    echo '<option value=2' . $opt2 . '>Use nginx built-in geo module + proxy_set_header</option>';
    echo '<option value=3' . $opt3 . '>Disable per-country Short URLs</option>';
    
    echo '<p><input type="submit" value="Update Redirect Search Mode" /></p>';

    echo '</select>';
    echo '</form>';
}

// Update option in database
function geo_short_url_admin_page_update() {
    $mode = $_POST['geo_short_url_mode'];
    
    if( $mode ) {
        $mode = intval($mode);
        
        if ( yourls_get_option( 'geo_short_url_mode' ) !== false ) {
            echo '<b>Redirect Search mode was updated successfully.</b>';
            yourls_update_option( 'geo_short_url_mode', $mode );
        } else {
            echo '<b>Redirect Search mode was stored successfully.</b>';
            yourls_add_option( 'geo_short_url_mode', $mode );
        }
    }
}

 
yourls_add_filter( 'get_request', 'geo_get_request' );
 
function geo_get_request( $request ) {

  if(substr($request, -1)=='+') return $request;
  
  $mode  = intval(yourls_get_option( 'geo_short_url_mode', 1 ));
  
  switch($mode) {
    case 1: // native
      $ip = yourls_get_IP();
      $countryCode = strtolower(yourls_geo_ip_to_countrycode( $ip ));    
    break;
    case 2: 
      // Requires nginx built-in geo module
      // A nginx config directive is used to inject the GeoIP country code as a server var:
      // proxy_set_header X-GEOIP-COUNTRY-CODE $geoip_country_code;
      $countryCode = strtolower($_SERVER['HTTP_X_GEOIP_COUNTRY_CODE']);
    break;
    default:
    case 3: // off
      return $request;
    break;
  }
  
  $geoRequest = $request .'-'. $countryCode;
  $geoLongURL = yourls_get_keyword_longurl( $geoRequest );
  
  if(!empty($geoLongURL)) {
    return $geoRequest;
  } else {
    return $request;
  }
  
}

