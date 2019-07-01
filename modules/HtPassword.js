var AssignAccountTitle = function ( )
{
  var hat = $( "#HiddenAccount" ) . html ( ) ;
  $( "#AccountTitle" ) . html ( hat ) ;
}

var AppendHtUser = function ( )
{
  var root     = $( "#htroot"    ) . val ( ) ;
  var lang     = $( "#htlang"    ) . val ( ) ;
  var file     = $( "#htfile"    ) . val ( ) ;
  var width    = $( "#htwidth"   ) . val ( ) ;
  var append   = $( "#htappend"  ) . val ( ) ;
  var del      = $( "#htdelete"  ) . val ( ) ;
  var account  = $( "#htaccount" ) . val ( ) ;
  var htpasswd = $( "#htpasswd"  ) . val ( ) ;
  var htagain  = $( "#htagain"   ) . val ( ) ;
  ////////////////////////////////////////////
  if ( account . length <= 0 ) {
    alert ( "Please provide account name!" ) ;
    return ;
  }
  ////////////////////////////////////////////
  if ( htpasswd . length <= 7 ) {
    alert ( "Password should have more than 7 characters!" ) ;
    return ;
  }
  ////////////////////////////////////////////
  if ( htpasswd != htagain ) {
    alert ( "Password verification fails" ) ;
    return ;
  }
  ////////////////////////////////////////////
  var URL = root + "/ajax/ajaxPassword.php" ;
  $.ajax({
    url: URL ,
    type: "POST",
    cache: false,
    async: false,
    dataType: 'json',
    data: {
      Root: root ,
      Language: lang ,
      File: file ,
      Width: width ,
      Append: append ,
      Delete: del ,
      Account: account ,
      Password: htpasswd
    },
    success: function ( data ) {
      var tzHtml = data [ "Answer" ] ;
      if ( tzHtml === 'Yes' ) {
        $( "#HtPassword" ) . html ( data [ "Message" ] ) ;
      } else {
        alert ( data [ "Problem" ] ) ;
      } ;
    } ,
    error: function ( xhr , ajaxOptions , thrownError ) {
      alert ( thrownError + " => " + ajaxOptions ) ;
    } ,
  });
}

var DeleteHtUser = function ( user )
{
  var root   = $( "#htroot"   ) . val ( ) ;
  var lang   = $( "#htlang"   ) . val ( ) ;
  var file   = $( "#htfile"   ) . val ( ) ;
  var width  = $( "#htwidth"  ) . val ( ) ;
  var append = $( "#htappend" ) . val ( ) ;
  var del    = $( "#htdelete" ) . val ( ) ;
  var URL    = root + "/ajax/ajaxDelete.php" ;
  $.ajax({
    url: URL ,
    type: "POST",
    cache: false,
    async: false,
    dataType: 'json',
    data: {
      Root: root ,
      Language: lang ,
      File: file ,
      Width: width ,
      Append: append ,
      Delete: del ,
      Account: user
    },
    success: function ( data ) {
      var tzHtml = data [ "Answer" ] ;
      if ( tzHtml === 'Yes' ) {
        $( "#HtPassword" ) . html ( data [ "Message" ] ) ;
      } else {
        alert ( data [ "Problem" ] ) ;
      } ;
    } ,
    error: function ( xhr , ajaxOptions , thrownError ) {
      alert ( thrownError + " => " + ajaxOptions ) ;
    } ,
  });
}
