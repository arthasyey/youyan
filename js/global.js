function userLogout(){
  $.ajax({
    type:"POST",
  url:"http://uyan.cc/index.php/youyan_login/userLogout",
  dataType:"json",
  cache:false,
  success: function(data){
    location.href="http://uyan.cc";
  },
  error:function(){
          alert("由于网络不稳定,登录失败,请稍候再试。");
        }
  });	
}
