// pagination処理
$(function($) {
    $('.time_line').pagination({
        pager        : $('.pager'),
        prevText     : '＜',
        nextText     : '＞',
        firstText    : '≪',
        lastText     : '≫',
        viewNum      : 20,
        pagerNum     : 3,
        ellipsis     : true,
        linkInvalid  : true,
        goTop        : true,
        firstLastNav : true,
        prevNextNav  : false
    });
});

// todo: 画像変更の時だけという条件処理に変える必要がある
$(function() {
	if ($('#getfile').val() !== undefined) {
		// 画像を表示する
		var file = document.querySelector('#getfile');

		file.onchange = function (){
		  var fileList = file.files;
		  //読み込み
		  var reader = new FileReader();
		  reader.readAsDataURL(fileList[0]);

		  //読み込み後
		  reader.onload = function  () {
		    document.querySelector('#preview').src = reader.result;
		  };
		};
	}
});