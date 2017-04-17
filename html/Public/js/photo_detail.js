$(".in").on("click",function () {
  $(this).addClass("active").siblings().removeClass("active");

  $(".in_con1").show()
  $(".i_list1").hide()
})
$(".couse").on("click",function () {
  $(this).addClass("active").siblings().removeClass("active");
  $(".i_list1").show()
  $(".in_con1").hide()
})
