"http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"


var num = 0;
var contribute_num = 0;
//　追加ツイート数
var add_tweet = 10;

function timeChange(tweetTime) {
  var registTime = new Date(tweetTime);
  var tweetChangeTime = registTime.getTime();

  var myNow = new Date();
  var changeTime =  myNow.getTime();

  var time = changeTime - tweetChangeTime;
  var hour_time = Math.floor(time/ 1000 / 60 / 60);
  if (hour_time >= 24) {
    var day_time = Math.floor(hour_time / 24);
    return (day_time + "日前");
  } else if (hour_time == 0) {
    return ("１時間以内");
  } else {
    return (hour_time + "時間前");
  }
};

$(function() {
  $("#add_wrapper").hide();
  //　時刻変換処理の記述
  $(".right").each(function() {
    var tweetTime = $(this).text();
    resultTime = timeChange(tweetTime);
    $(this).html(resultTime);
  });

  // ツイート投稿時
  $("#tweet_button").click(function() {
    var text = $("#form_text").val();
    if (text == "") {
      $("#alert").html("何も入力されていません");
    } else {
      var str = $("#tweet_form").serialize();
      $.post("tweetadd",str, function(result) {
        result.time = timeChange(result.time);
        var div = $("#add_wrapper").children().clone().prependTo("#tweet_list"); 
        $(".left",div).text(result.name);
        $(".right",div).text(result.time);
        $(".tweet-sentence",div).text(result.content);
      },"json");
      $("#form_text").attr("value", "");
      contribute_num++;
    }
  });

  //　「もっと見る」ボタンの実装
  $("#read_button").click(function() {
    num++;
    $.getJSON("tweetadd/read", {"num" : num, "contribute_num" : contribute_num}, function(response) {
      for (var i = 0 ; i < response.length ; i++) {
        response[i].time = timeChange(response[i].time);
        var div = $("#add_wrapper").children().clone().appendTo("#tweet_list");
        $(".left",div).text(response[i].name);
        $(".right",div).text(response[i].time);
        $(".tweet-sentence",div).text(response[i].content);
      }
      if (response.length < add_tweet) {
        $("#tweetRead").before("<p>読み込めるツイートはありません</p>");
        $("#read_button").hide();
      }
    },"json")
    .error(function(json) {
      console.log("失敗");
    });
  });
});
