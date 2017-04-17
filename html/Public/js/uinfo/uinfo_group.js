// JavaScript Document
function sum()
{
	var input=document.getElementById("input").value;	
	if(!input){return;}
	//alert(input);
	$.post(window.url+'check_code', {'code': input},
			function(data,status)
				{
					//alert(data);
					var arr=eval(data);
					if(arr[0]==1)
					{
						//alert(1);
						//alert(arr[1]);
						document.getElementById("error").innerHTML=arr[1];
						setTimeout("window.location.reload();",2000);
						
					}
					else
					{
						document.getElementById("error").innerHTML=arr[1];	
					}
					
					
					
					setTimeout("document.getElementById('error').innerHTML=''",2000);
				}
			   );
}
function sum1()
{
	var input=document.getElementById("text").value;	
	if(!input){return;}
	//alert(input);
	$.post(window.url+'recharge', {'code': input},
			function(data,status)
				{
					//alert(data);
					var arr=eval(data);
					if(arr[0]==1)
					{
						//alert(1);
						//alert(arr[1]);
						document.getElementById("error1").innerHTML=arr[1];
						document.getElementById("font").innerHTML=arr[2];
						
						//setTimeout("window.location.reload();",2000);
						
					}
					else
					{
						document.getElementById("error1").innerHTML=arr[1];	
					}
					
					
					
					setTimeout("document.getElementById('error1').innerHTML=''",2000);
				}
			   );
}
function phone_sum1()
{
	var input=document.getElementById("text").value;	
	if(!input){alert('请填写积分充值码');return;}
	//alert(input);
	$.post(window.url+'recharge', {'code': input},
			function(data,status)
				{
					//alert(data);
					var arr=eval(data);
					if(arr[0]==1)
					{
						//alert(1);
						//alert(arr[1]);
						alert(arr[1]);
						//document.getElementById("error1").innerHTML=arr[1];
						//document.getElementById("font").innerHTML=arr[2];
						
						setTimeout("window.location.reload();",2000);
						
					}
					else
					{
						alert(arr[1]);
						//document.getElementById("error1").innerHTML=arr[1];	
					}
					
				}
			   );
}