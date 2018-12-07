function _checkLogin( )
{
  return window._localStorageFn._hasKey( 'api_token' );
}

function _redirect( )
{
  if( ! _checkLogin() )
  	window.location.href = js_parent_var.base_url + "/login";
  return true;
}

module.exports = {
    _checkLogin	: _checkLogin,
    _redirect	: _redirect,

};