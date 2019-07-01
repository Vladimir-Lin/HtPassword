<?php

require_once dirname(__FILE__) . "/config.php" ;

function hasParameter($KEY)
{
  if ( $_POST [ $KEY ] == '' ) return false ;
  return true                               ;
}

function Parameter($KEY)
{
  if ($_POST [ $KEY ] == '' ) return "" ;
  return $_POST [ $KEY ]                ;
}

class Accounts
{

public $PluginPath  ;
public $RootPath    ;
public $CurrentRoot ;
public $Language    ;
public $HtPassword  ;
public $Width       ;
public $Appendable  ;
public $Deletable   ;

function __construct ( $plugin , $root , $lang , $passwd )
{
  $this -> PluginPath  = $plugin                               ;
  $this -> RootPath    = $root                                 ;
  $this -> Language    = $lang                                 ;
  $this -> HtPassword  = $passwd                               ;
  $this -> CurrentRoot = str_replace  ( $root , "" , $plugin ) ;
  $this -> Appendable  = true                                  ;
  $this -> Deletable   = true                                  ;
}

function __destruct()
{
}

public function setAppend ( $canAppend )
{
  $this -> Appendable = ( $canAppend == "Yes" ) ;
}

public function setDelete ( $canDelete )
{
  $this -> Deletable = ( $canDelete == "Yes" ) ;
}

public function ReplaceStrings($SOURCE,$REPLACES)
{
  $SRCS = $SOURCE                             ;
  $KEYS = array_keys    ( $REPLACES         ) ;
  foreach               ( $KEYS as $K       ) {
    $VAL  = $REPLACES   [ $K                ] ;
    $SRCS = str_replace ( $K , $VAL , $SRCS ) ;
  }                                           ;
  return $SRCS                                ;
}

function FrameWorkFile ( )
{
  $MYPATH = $this -> PluginPath               ;
  return "{$MYPATH}/templates/FrameWork.html" ;
}

function TemplateFile ( )
{
  $MYPATH = $this -> PluginPath               ;
  $LANGTH = $this -> Language                 ;
  return "{$MYPATH}/templates/{$LANGTH}.html" ;
}

function PasswordFile ( )
{
  $RTPATH   = $this -> RootPath   ;
  $HTPWD    = $this -> HtPassword ;
  $FILENAME = "{$RTPATH}{$HTPWD}" ;
  return $FILENAME                ;
}

function FrameWorkHtml ( )
{
  $FILENAME = $this -> FrameWorkFile (           ) ;
  return file_get_contents           ( $FILENAME ) ;
}

function TemplateHtml ( )
{
  $FILENAME = $this -> TemplateFile (           ) ;
  return file_get_contents          ( $FILENAME ) ;
}

function Listings ( )
{
  $FILENAME = $this -> PasswordFile (                     ) ;
  $ACCOUNTS = file_get_contents     ( $FILENAME           ) ;
  $ACCTS    = explode               ( "\n" , $ACCOUNTS    ) ;
  $LISTS    = array                 (                     ) ;
  foreach                           ( $ACCTS as $act      ) {
    if                              ( strlen ( $act ) > 0 ) {
      $LL   = explode               ( ":" , $act          ) ;
      if                            ( count ( $LL ) > 1   ) {
        array_push                  ( $LISTS , $LL [ 0 ]  ) ;
      }                                                     ;
    }                                                       ;
  }                                                         ;
  return $LISTS                                             ;
}

// Append htpasswd -mb [filename] [username] [password]
function AppendPassword ( $Username , $Passwd )
{
  ////////////////////////////////////////////////////////////////////////////
  global $wgHtPassword                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $FILENAME = $this -> PasswordFile ( )                                      ;
  $EXECHT   = "{$wgHtPassword} -mb {$FILENAME} {$Username} {$Passwd}"        ;
  ////////////////////////////////////////////////////////////////////////////
  exec ( $EXECHT )                                                           ;
}

// Delete htpasswd -D [filename] [username]
function DeletePassword ( $Username )
{
  ////////////////////////////////////////////////////////////////////////////
  global $wgHtPassword                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $FILENAME = $this -> PasswordFile ( )                                      ;
  $EXECHT   = "{$wgHtPassword} -D {$FILENAME} {$Username}"                   ;
  ////////////////////////////////////////////////////////////////////////////
  exec ( $EXECHT )                                                           ;
}

function Person ( $ACCOUNT )
{
  $CRT    = $this -> CurrentRoot                                              ;
  $SRC    = "{$CRT}/images/delete.png"                                        ;
  $JSC    = "DeleteHtUser('{$ACCOUNT}');"                                     ;
  $ATDX   = "<td class='AccountCell'>{$ACCOUNT}</td>"                         ;
  if ( $this -> Deletable )                                                   {
    $IMGX = "<img src=\"{$SRC}\" width=12 height=12>"                         ;
    $IMGC = "<button onclick=\"{$JSC}\">{$IMGX}</button>"                     ;
  } else                                                                      {
    $IMGC = ""                                                                ;
  }                                                                           ;
  $ATIM   = "<td nowrap='nowrap' width='1%' class='AccountCell'>{$IMGC}</td>" ;
  $HTML   = "<tr>\n{$ATIM}\n{$ATDX}\n</tr>"                                   ;
  return $HTML                                                                ;
}

function Players ( )
{
  ////////////////////////////////////////////////////////////////////////////
  $LISTS = $this -> Listings ( )                                             ;
  if ( count ( $LISTS ) <= 0 ) return ""                                     ;
  ////////////////////////////////////////////////////////////////////////////
  $HTML   = ""                                                               ;
  ////////////////////////////////////////////////////////////////////////////
  $TITLE  = "<tr><td colspan=2 id='AccountTitle'>Accounts</td></tr>"         ;
  $SPACE  = "<tr><td colspan=2>&nbsp;</td></tr>"                             ;
  $HTML   = "{$TITLE}\n{$SPACE}"                                             ;
  ////////////////////////////////////////////////////////////////////////////
  foreach ( $LISTS as $L )                                                   {
    $ACTX = $this -> Person ( $L )                                           ;
    $HTML = "{$HTML}\n{$ACTX}"                                               ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $SPACE  = "<tr><td colspan=2>&nbsp;</td></tr>"                             ;
  $HTML   = "{$HTML}\n{$SPACE}"                                              ;
  ////////////////////////////////////////////////////////////////////////////
  return $HTML                                                               ;
}

function Editing ( )
{
  ////////////////////////////////////////////////////////////////////////////
  global $wgHtPassword                                                       ;
  ////////////////////////////////////////////////////////////////////////////
  $MAPS      = array                   (                                   ) ;
  $SCRIPTS   = $this -> TemplateHtml   (                                   ) ;
  ////////////////////////////////////////////////////////////////////////////
  $APPX      = "No"                                                          ;
  $DELX      = "No"                                                          ;
  if ( $this -> Appendable ) $APPX = "Yes"                                   ;
  if ( $this -> Deletable  ) $DELX = "Yes"                                   ;
  ////////////////////////////////////////////////////////////////////////////
  $MAPS [ "$(PASSWORD-WIDTH)"    ] = $this -> Width                          ;
  $MAPS [ "$(PASSWORD-ROOT)"     ] = $this -> CurrentRoot                    ;
  $MAPS [ "$(PASSWORD-LANGUAGE)" ] = $this -> Language                       ;
  $MAPS [ "$(PASSWORD-FILE)"     ] = $this -> HtPassword                     ;
  $MAPS [ "$(PASSWORD-WIDTH)"    ] = $this -> Width                          ;
  $MAPS [ "$(PASSWORD-APPEND)"   ] = $APPX                                   ;
  $MAPS [ "$(PASSWORD-DELETE)"   ] = $DELX                                   ;
  $MAPS [ "$(ACCOUNT-LISTINGS)"  ] = $this -> Players ( )                    ;
  ////////////////////////////////////////////////////////////////////////////
  $SCRIPTS   = $this -> ReplaceStrings ( $SCRIPTS            , $MAPS       ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $SCRIPTS                                                            ;
}

function Content ( )
{
  ////////////////////////////////////////////////////////////////////////////
  $FRAMEWORK = $this -> FrameWorkHtml (                                    ) ;
  $SCRIPTS   = $this -> Editing       (                                    ) ;
  $FRAMEWORK = str_replace ( "$(PASSWORD-BLOCK)" , $SCRIPTS , $FRAMEWORK   ) ;
  ////////////////////////////////////////////////////////////////////////////
  return $FRAMEWORK                                                          ;
}

} ;

?>
