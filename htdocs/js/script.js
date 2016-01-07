
$(function() {
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
});