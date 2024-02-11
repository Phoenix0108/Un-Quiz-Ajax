function setcookieId(id) {
    now = new Date();
    time = now.getTime()
    expireTime = time + 1000 * 600;
    now.setTime(expireTime)
    console.log(now.toUTCString())
    document.cookie = 'token=' + id + ';expires=' + now.toUTCString() + ';path=/';
}
$.ajax({
    url: "http://127.0.0.1/verifCo",
    type: "POST",
    dataType: "json",
    success: function (data) {
        if (data.stateCo) {
            setcookieId(data.token)
        } else {
            window.location.href = "http://127.0.0.1"
        }
    }
})