<?php
/**
 * Try to implement the same API of the PHP built-in JSON extension, so that
 * projects relying on it can be ported to php installs where the extension is
 * missing.
 *
 * If the xmlrpc extension is loaded, all new functions will be created as 'alt',
 * ie: json_alt_encode, json_alt_decode
 *
 * @version $Id: json_extension_api.php,v 1.1 2007/11/16 12:37:38 manolis Exp $
 * @author Gaetano Giunta
 * @copyright 2006
 *
 * @requires phpxmlrpc version 2.1 or later
 */

// requires: xmlrpc.inc
// requires: jsonrpc.inc

// In default operating mode, the internal charset that the php extension assumes is UTF-8
// so let's emulate it to our best, whilst givig user a chance to change this behaviour...
$GLOBALS['xmlrpc_internalencoding'] = 'UTF-8';

// We allow the user to decide wheter decoding '"a"', '1', 'true', 'null' works
// or returns false (the php extension changed this behaviour halfway...
if (version_compare(phpversion(), '5.2.1') >= 0 || (version_compare(phpversion(), '4.4.5') >= 0 && version_compare(phpversion(), '5.0') < 0))
{
  $GLOBALS['json_extension_api_120_behaviour'] = false;
}
else
{
  $GLOBALS['json_extension_api_120_behaviour'] = true;
}

if (!extension_loaded('json'))
{

  /**
  * Takes a php value (array or object) and returns its json representation
  * @param mixed $value
  * @return string
  *
  * @bug if value is an ISO-8859-1 string with chars outside of ASCII, the php extension returns NULL, and we do not...
  */
  function json_encode($value)
  {
    $jsval = php_jsonrpc_encode($value, array());
    // make sure we emulate the std php behaviour: strings to be encoded are UTF-8!!!
    return $jsval->serialize();
  }

  /**
  * Takes a json-formetted string and decodes it into php values
  * @param string $json
  * @param bool $assoc
  * @return mixed
  *
  * @todo add support for assoc=false
  */
  function json_decode($json, $assoc=false)
  {
    $jsval = php_jsonrpc_decode_json($json);
    if (!$jsval)
    {
      return NULL;
    }
    else
    {
      // up to php version 5.2.1, json_decode only accepted structs and arrays as top-level elements
      if ($GLOBALS['json_extension_api_120_behaviour'] && ($jsval->mytype != 3 && $jsval->mytype != 2))
        return NULL;
      $options = $assoc ? array() : array('decode_php_objs');
      $val = php_jsonrpc_decode($jsval, $options);
      return $val;
    }
  }

}
else
{
  // in case json extension is already loaded, register all funcions w.
  // different names, eg. json_alt_encode
  $content = file_get_contents(__FILE__);
  $content = str_replace(array("!extension_loaded('json')", 'function json_', '<?php', '?>'), array('true', 'function json_alt_', '', ''), $content);
  eval($content);
}
?>