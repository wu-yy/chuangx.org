// JavaScript Document
function adtag_yiji()
{
		
		var name=document.getElementById('input').value;
		
		if(!(name))
		{
			return;	
		}

		//var ur="{:U('Users/add_group_user')}";
		var obj = {};
		obj.key = "value";
		$.post(window.url+"add_group_user?name="+name+"&gid="+window.gid, obj,
			function(data,status)
				{
					
					var arr=eval(data);

					if(arr[0]==0)
					{
						//alert(data);
						document.getElementById('error').innerHTML=arr[1];
						
					}
					else
					{
						document.getElementById('error').innerHTML='增加群组成员成功';
						setTimeout("window.location.reload();",2000);
					}
					
					setTimeout("document.getElementById('error').innerHTML=''",2000);
				}
			   );
		
		
}