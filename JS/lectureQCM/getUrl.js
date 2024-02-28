function getUrl() {
    urlGet = location.search;
    dicValUrl = {};
    uri = urlGet.split("?");
    if (uri.length == 2) {
        body = uri[1]
        paire_valeur = body.split("&");
        for (i = 0; i < paire_valeur.length; i++) {
            paire = paire_valeur[i].split("=");
            if (paire.length == 2) {
                dicValUrl[paire[0]] = paire[1];
            }
        }
        if (dicValUrl) {
            return dicValUrl;
        }
    }
    return false
}