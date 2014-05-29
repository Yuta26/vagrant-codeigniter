
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
  var compiled = _.template($("#addWrapper").text());

  //　時刻変換処理の記述
  $(".right").each(function() {
    var tweetTime = $(this).text();
    $(this).html(timeChange(tweetTime));
  });

  var buttonAppear = $("#button").val();
  if (buttonAppear == "false") {
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
          result['time'] = timeChange(result['time']);
          $("#addTweet").after(compiled(result));
        },"json");
      $("#formText").attr("value", "");
      page++;
      $("#page").attr("value", page);
    }
  });

  //　「もっと見る」ボタンの実装
  $("#readButton").click(function() {
    var page = $("#page").val();
    $.getJSON("tweet/read", {"page": page}, function(response) {
      for (var i = 0 ; i < response['tweet'].length ; i++) {
        response['tweet'][i]['time'] = timeChange(response['tweet'][i]['time']);
        $("#readTweet").before(compiled(response['tweet'][i]));
      }
      if (response['button'] == "false") {
        $("#tweetRead").before("<div class='not-tweet'><p>読み込めるツイートはありません<p></div>");
        $("#readButton").hide();
      }
      $("#page").attr("value", response['page']);
    }, "json");
  });
});