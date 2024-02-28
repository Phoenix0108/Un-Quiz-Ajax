function getCookie() {
    allCookie = decodeURIComponent(document.cookie).split(";")
    cookie = {}
    for (i = 0; i < allCookie.length; i++) {
        cok = allCookie[i].split("=");
        if (cok[0][0] == " ") {
            nom_cookie = cok[0].substring(1)
            cookie[nom_cookie] = cok[1]
        } else {
            cookie[cok[0]] = cok[1]
        }

    }
    return cookie
}
function setCookie(name, value, s = 0) {
    if (s != 0) {
        date = new Date();
        time = date.getTime();
        date.setTime(time + 1000 * s);
        document.cookie = name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
    } else {
        document.cookie = name + "=" + value + ";path=/";
    }
}
cookie = getCookie();