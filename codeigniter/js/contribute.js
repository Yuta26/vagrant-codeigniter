
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

  // 読み込みツイート件数を取得する
  $.getJSON("tweet/tweet_num", function(result) {
    var tweetNum = $(".wrapper").length;
    var allTweetNum = result['all_tweet_num'];

    // 表示されてるツイート件数よりと読み込みツイート件数の比較
    if (tweetNum < result['tweet_read_num']) {
      $("#readButton").hide();
    }

    if (allTweetNum == result['tweet_read_num']) {
      $("#readButton").hide();
    }

    // ツイート投稿時
    $("#tweetButton").click(function() {
      var page = $("#page").val();
      var text = $("#formText").val();

      if (!text) {
        $("#alert").html("何も入力されていません");
      } else {
        var str = $("#tweetForm").serialize();
        $.post("tweet/insert",str, function(result) {
          if (result == null) {
            return;
          }
          var div = $("#addWrapper").children().clone().prependTo("#tweetList");
          $(".left",div).text(result.name);
          $(".right",div).text(timeChange(result.time));
          $(".tweet-sentence",div).html(result.content);
        },"json");
        $("#formText").attr("value", "");
        page++;
        allTweetNum++;
        $("#page").attr("value", page);
      }
    });

    //　「もっと見る」ボタンの実装
    $("#readButton").click(function() {
      var page = $("#page").val();
      $.getJSON("tweet/read", {"page": page}, function(response) {
        for (var i = 0 ; i < response.length ; i++) {
          var div = $("#addWrapper").children().clone().appendTo("#tweetList");
          $(".left",div).text(response[i].name);
          $(".right",div).text(timeChange(response[i].time));
          $(".tweet-sentence",div).text(response[i].content);
        }

        //　取得ツイート数と読み込みツイート件数の比較
        if (response.length < result['tweet_read_num']) {
          $("#tweetRead").before("<div class='not-tweet'><p>読み込めるツイートはありません<p></div>");
          $("#readButton").hide();
        }
      },"json");

      $.getJSON("tweet/page",{"page":page}, function(pages) {
        //　ちょうど10件読み込んだ際に、ツイート数を削除する
        if (allTweetNum == pages['page']) {
          $("#tweetRead").before("<div class='not-tweet'><p>読み込めるツイートはありません<p></div>");
          $("#readButton").hide();
        }
        $("#page").attr("value", pages['page']);
      }, "json");
    });
  }, "json");
});
