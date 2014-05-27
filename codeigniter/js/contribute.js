
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
  $("#addWrapper").hide();

  //　時刻変換処理の記述
  $(".right").each(function() {
    var tweetTime = $(this).text();
    $(this).html(timeChange(tweetTime));
  });

  $.getJSON("tweet/button", function(result) {
    var tweetNum = $(".wrapper").length;
    if (tweetNum < result['limit']) {
      $("#readButton").hide();
    } else {
      $.getJSON("tweet/tweet_num", function(result) {
        if(result['tweet_num'] == result['limit']) {
          $("#readButton").hide();
        }
      },"json");
    }

    // ツイート投稿時
    $("#tweetButton").click(function() {
      var offset = $("#offset").val();
      var text = $("#formText").val();
      if (!text) {
        $("#alert").html("何も入力されていません");
      } else {
        var str = $("#tweetForm").serialize();
        $.post("tweet/insert",str, function(result) {
          var div = $("#addWrapper").children().clone().prependTo("#tweetList");
          $(".left",div).text(result.name);
          $(".right",div).text(timeChange(result.time));
          $(".tweet-sentence",div).text(result.content);
        },"json");
        $("#formText").attr("value", "");
        offset++;
        $("#page").attr("value", offset);
      }
    });

    //　「もっと見る」ボタンの実装
    $("#readButton").qclick(function() {
      var page = $("#page").val();
      // limitを送信する必要はあない
      $.getJSON("tweet/read", {"page": page}, function(response) {
        for (var i = 0 ; i < response.length ; i++) {
          var div = $("#addWrapper").children().clone().appendTo("#tweetList");
          $(".left",div).text(response[i].name);
          $(".right",div).text(timeChange(response[i].time));
          $(".tweet-sentence",div).text(response[i].content);
        }

          if (response.length < result['limit']) {
            $("#tweetRead").before("<div class='not-tweet'><p>読み込めるツイートはありません<p></div>");
            $("#readButton").hide();
          }
      },"json");
      $.getJSON("tweet/page",{"page":page}, function(pages) {
        $("#page").attr("value", pages['page']);
      }, "json");
    });
  }, "json");
});
