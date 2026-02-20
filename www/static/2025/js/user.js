function reloadcode(){newcode=$('#showcode').prop("src")+'?'+Math.random();$('#showcode').prop("src",newcode);}
function login_check(){if($('#username').val()===""){layer.tips('用户名必须填写!','#username',{tips:[3,'#0FA6D8']});return false;}
if($('#userpass').val()===""){layer.tips('密码必须填写!','#userpass',{tips:[3,'#0FA6D8']});return false;}
return true;}
function register_check(){if($('#regname').val()===""){layer.tips('用户名必须填写!','#regname',{tips:[3,'#0FA6D8']});return false;}
if($('#regpass').val()===""){layer.tips('密码必须填写!','#regpass',{tips:[3,'#0FA6D8']});return false;}
if($('#repass').val()===""){layer.tips('请重复一次密码!','#repass',{tips:[3,'#0FA6D8']});return false;}
if($('#regemail').val()===""){layer.tips('邮箱必须填写!','#regemail',{tips:[3,'#0FA6D8']});return false;}
if($('#regpass').val()!==$('#repass').val()){layer.tips('两次输入的密码不一致!','#repass',{tips:[3,'#0FA6D8']});return false;}
return true;}
function addbookcase(aid,name,cid,cname){if(readCookies('ss_userid')&&readCookies('PHPSESSID')!=-1){rico_data={articleid:aid,articlename:name,chapterid:cid,chaptername:cname},$.ajax({type:"post",url:"/addbookcase/",data:rico_data,success:function(data){layer.msg(data);}});}else{layer.confirm('永久书架需要登录才能使用，转到登录页面吗？',{title:'提示信息',btn:['登录','取消']},function(index){window.location.href="/login/";},function(index){layer.close(index);});}}
function delbookcase(aid){layer.confirm('确定要删除吗？',{title:'提示信息',btn:['删除','取消']},function(index){if(readCookies('ss_userid')&&readCookies('PHPSESSID')!=-1){rico_data={articleid:aid,},$.ajax({type:"post",url:"/delbookcase/",data:rico_data,success:function(data){layer.msg(data,function(){window.location.reload();});}});}},function(index){layer.close(index);});}