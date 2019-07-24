/**
 * @param {*} uri 
 * @param {*} parameter 
 * @param {*} value 
 */
function addOrUpdateUriParameter(uri, parameter, value) {
    var new_url = normalizeAmpersand(uri);
    
    new_url = URI(new_url).normalizeQuery();

    if (new_url.hasQuery(parameter)) {
        new_url.removeQuery(parameter);
    }

    if (value != '') {
        new_url = new_url.addQuery(parameter, value);
    }

    return new_url.toString();
}

/**
 * @param {*} string 
 */
function normalizeAmpersand(string) {
    return string.replace(/&amp;/g, "&").replace(/amp%3B/g, "");
}