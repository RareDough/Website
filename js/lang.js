var langs = ["en", "ch", "fr", "gr", "it", "jp", "tr", "hi", "th", "nl", "pt", "es", "ar"];
var langCode = localStorage.getItem("langCode"); //Write the default Value from langs into it
var langJS = null;

function setLanguage(lang) {
  langCode = lang;
  localStorage.setItem("langCode", langCode);
  if ($.inArray(langCode, langs) >= 0) {
    $.getJSON("lang/" + langCode + ".json", translate);
  } else {
    $.getJSON(`./lang/${langCode}.json`, translate);
  }
}
var translate = function (jsdata) {
  $("[tkey]").each(function (index) {
    var strTr = jsdata[$(this).attr("tkey")];
    $(this).html(strTr);
  });
};

if (langCode) {
  $.getJSON(`./lang/${langCode}.json`, translate);
}
