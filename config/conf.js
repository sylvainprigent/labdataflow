
var mumuxconfig = 
{
    "apiurl": "http://localhost:8888/labdataflow/api/v1/",
    "clienturl": "http://localhost:8888/labdataflow/",
    "homepage": "home",
    "debugmode": true
};

function mumuxGetUrlParameters(){

    url = window.location.href
    var str = url.replace(mumuxconfig.clienturl,"");
    return str.split("/");

}

function mumuxGetLanguage(){
    var lang = navigator.language || navigator.userLanguage;
    return lang;
}