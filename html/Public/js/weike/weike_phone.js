// JavaScript Document
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
			data:{"nu":window.nu,"gid":window.gid},            
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
									var str="<a href='javascript:;' name='w_kecheng' onClick='log_url(event,\""+window.bofang+"id/"+b+"\",\"phone_lec_list\");'> <li><div class='daxiao'><image src='"+window.root+image+"'/></div><p>"+title+"</p></li></a>"+str;
									a=a+1;
						}
						
					document.getElementById('weike_list').innerHTML=g+str;
					if(a!=8)
					{
						document.getElementById('test2').style.display='none';	
						document.getElementById('test').style.display='block';
						return;	
					}
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