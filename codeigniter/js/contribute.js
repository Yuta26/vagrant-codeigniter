
function timeChange(tweetTime) {
  var registTime = new Date(tweetTime);
  var tweetChangeTime = registTime.getTime();

  var myNow = new Date();
  var changeTime =  myNow.getTime();

  var time = changeTime - tweetChangeTime;
  var hourTime = Math.floor(time/ 1000 / 60 / 60);
  if (hourTime >= 24) {
    var dayTime = Math.floor(hourTime / 24);
    return dayTime + "日前";
  }
  if (hourTime == 0) {
    return "１時間以内";
  }
  return hourTime + "時間前";
}

$(function() {
  var limit = $("#limit").val();
  $("#add_wrapper").hide();
  //　時刻変換処理の記述
  $(".right").each(function() {
    var tweetTime = $(this).text();
    $(this).html(timeChange(tweetTime));
  });

  // ツイート投稿時
  $("#tweet_button").click(function() {
    var offset = $("#offset").val();
    var text = $("#form_text").val();
    if (!text) {
      $("#alert").html("何も入力されていません");
    } else {
      var str = $("#tweet_form").serialize();
      $.post("tweet/insert",str, function(result) {
        var div = $("#add_wrapper").children().clone().prependTo("#tweet_list"); 
        $(".left",div).text(result.name);
        $(".right",div).text(timeChange(result.time));
        $(".tweet-sentence",div).text(result.content);
      },"json");
      $("#form_text").attr("value", "");
      offset++;
      $("#offset").attr("value", offset);
    }
  });

  //　「もっと見る」ボタンの実装
  $("#read_button").click(function() {
    var offset = $("#offset").val();
    offset = Number(offset) + Number(limit);
    $("#offset").attr("value", offset);
    $.getJSON("tweet/read", {"offset": offset, "limit" : limit}, function(response) {
      for (var i = 0 ; i < response.length ; i++) {
        var div = $("#add_wrapper").children().clone().appendTo("#tweet_list");
        $(".left",div).text(response[i].name);
        $(".right",div).text(timeChange(response[i].time));
        $(".tweet-sentence",div).text(response[i].content);
      }
      if (response.length < limit) {
        $("#tweetRead").before("<p>読み込めるツイートはありません</p>");
        $("#read_button").hide();
      }
    },"json")
    .error(function(json) {
      console.log("失敗");
    });
  });
});
