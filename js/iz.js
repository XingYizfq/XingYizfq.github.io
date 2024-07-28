var str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
var arr = str.split("");
var result = "";
for (var i = 0; i < 4; i++) {
    var n = Math.floor(Math.random() * arr.length);
    result += arr[n];
}
document.getElementById("iz").innerHTML = result;
