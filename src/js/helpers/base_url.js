/**
 * -------------------------------------------------------------------------------------------------------------------------------
 * @returns {string}
 */
export function baseUrl() {
  var pathparts = location.pathname.split('/');
  if (location.host == 'localhost') {
    var url = location.origin + '/' + pathparts[1].trim('/') + '/';
  } else {
    var url = location.origin;
  }
  return url;
}
