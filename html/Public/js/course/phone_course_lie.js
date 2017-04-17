// JavaScript Document
function log_url2(Jump_page,head)
{
	var url=window.location.href;
		$.post(window.lo, {'head': head,'Jump_page':Jump_page,'url':url},
			function(data,status)
				{
					window.top.location=Jump_page; 	
				}
			   );
			   
}
function jiazai()
{	
		var g=document.getElementById('weike_list').innerHTML;
		document.getElementById('test1').style.display='none';
		document.getElementById('test2').style.display='block';
		var dd;
		 $.ajax({
            url:window.url,
            async:false, 
			type:'post',
			data:{"nu":window.nu},            
            success:function(data) {
				
				if(data)
				{
					var str="";
					var data = eval('('+data+')');
					var a=0;
					for(var x in data)
						{
									var image = data[x]['image'];
									var b = data[x]['id'];
									var title = data[x]['title'];
									var teacher_name=data[x]['brief'];
									var str=str+"<a href='javascript:;' name='w_kecheng' onClick='log_url2(\""+window.bofang+"cid/"+b+"\",\"phone_course_list\");'> <li><image src='"+window.root+image+"'/><div class='w_right'><p>"+title+"</p><p style='color:#999;'>"+teacher_name+"</p></div></li></a>";
									a=a+1;
						}
						
					document.getElementById('weike_list').innerHTML=g+str;
					
//					if(a!=8)
//					{
//						document.getElementById('test2').style.display='none';	
//						document.getElementById('test').style.display='block';
//						return;	
//					}
					window.nu=nu+1;	
					document.getElementById('test2').style.display='none';
					document.getElementById('test1').style.display='block';
		
				}
           		else
				{
					document.getElementById('test2').style.display='none';	
					document.getElementById('test').style.display='block';
				}
             }
		 });     
}