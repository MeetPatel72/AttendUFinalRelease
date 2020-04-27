$(document).ready(function(){

	//alert("hello");
	$(".two_answer").on("click", function(){
		$(".two_answer").removeClass("selected");
		$( this ).addClass("selected");
      var answer=$( this ).data("answer");
      $(".ans").val(answer);
});
});