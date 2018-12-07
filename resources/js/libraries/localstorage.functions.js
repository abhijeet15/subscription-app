function _set( key, value )
{
  localStorage.setItem(key, value);
}

function _get( key )
{
  return localStorage.getItem(key);
}

function _clearKeys( )
{
  localStorage.clear();
}

function _hasKey( key )
{
	let key_value = localStorage.getItem(key)
  	return ( key_value ) ? true : false;
}

module.exports = {
    _set		: _set,
    _get		: _get,
    _clearKeys	: _clearKeys,
    _hasKey		: _hasKey,
};