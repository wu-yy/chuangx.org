
(function($) {
    $.fn.jquizzy = function(settings) {
        var defaults = {
            questions: null,                        
            resultComments: {
                type1: '<div style="color:#5B5B5B;margin-left:10px;margin-right:10px;font-size:24px"><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp恭喜你！你的天性是NASA定义的<span style="color:#32CD32"><b>绿色</b></span>性格（亲和型）。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp你的行为特点是：热情好客、喜欢交际、乐观开朗、想象丰富、创意十足、情感充沛、追求自由、率真坦诚、善于沟通、喜欢表现。</p><p style="margin-bottom:25px">在创业团队中，</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp1.你应当注意：感情用事、想法多变、惧怕压力、放弃原则、浅尝辄止、缺乏聚焦。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp2.你适合扮演的主要管理角色：激发创意、贡献快乐、营销客户、塑造品牌。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp3.你最需要的合作伙伴是<span style="color:#FF4500"><b>橙色</b></span>性格，他的行为特点是：严谨务实、有条不紊、计划周密、遵守规则、善于组织、认真负责、注重细节、追求完美、关注结果、勤奋好学。</p></div>',
                type2: '<div style="color:#5B5B5B;margin-left:10px;margin-right:10px;font-size:24px"><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp恭喜你！你的天性是NASA定义的<span style="color:#0000CD"><b>蓝色</b></span>性格（创新型）。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp你的行为特点是：雄心抱负、目的明确、喜欢冒险、乐于尝试、大局思维、开拓创新、果敢坚毅、内驱力强、勇于担当、追求卓越。</p><p style="margin-bottom:25px">在创业团队中，</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp1.你应当注意：过于理想、过度乐观、好大喜功、独断专行、孤芳自赏、缺乏包融。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp2.你适合扮演的主要管理角色：战略规划、产品创新、管理创新、市场开拓。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp3.你最需要的合作伙伴是<span style="color:#FFA500"><b>黄色</b></span>性格，他的行为特点是：重视和谐、团结合作、忠诚奉献、深思熟虑、耐心细致、成熟稳重、热情包融、责任心强、善于组织、值得信赖。</p></div>',
                type3: '<div style="color:#5B5B5B;margin-left:10px;margin-right:10px;font-size:24px"><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp恭喜你！你的天性是NASA定义的<span style="color:#FFA500"><b>黄色</b></span>性格（包融型）。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp你的行为特点是：重视和谐、团结合作、忠诚奉献、深思熟虑、耐心细致、成熟稳重、热情包融、责任心强、善于组织、值得信赖。</p><p style="margin-bottom:25px">在创业团队中，</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp1.你应当注意：过度包融、委屈求全、按部就班、拒绝创新、害怕冲突、被动适应。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp2.你适合扮演的主要管理角色：凝聚团队、化解冲突、忠于使命、坚守文化。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp3.你最需要的合作伙伴是<span style="color:#0000CD"><b>蓝色</b></span>性格，他的行为特点是：雄心抱负、目的明确、喜欢冒险、乐于尝试、大局思维、开拓创新、果敢坚毅、内驱力强、勇于担当、追求卓越。</p></div>',
                type4: '<div style="color:#5B5B5B;margin-left:10px;margin-right:10px;font-size:24px"><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp恭喜你！你的天性是NASA定义的<span style="color:#FF4500"><b>橙色</b></span>性格（执行型）。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp你的行为特点是：严谨务实、有条不紊、计划周密、遵守规则、善于组织、认真负责、注重细节、追求完美、关注结果、勤奋好学。</p><p style="margin-bottom:25px">在创业团队中，</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp1.你应当注意：待人冷漠、追求完美、僵化固执、缺乏灵活、拒绝尝试、过度悲观。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp2.你适合扮演的主要管理角色：制定计划、绩效考核、督导执行、遵章守纪。</p><p style="margin-bottom:25px">&nbsp&nbsp&nbsp&nbsp3.你最需要的合作伙伴是<span style="color:#32CD32"><b>绿色</b></span>性格，他的行为特点是：热情好客、喜欢交际、乐观开朗、想象丰富、创意十足、情感充沛、追求自由、率真坦诚、善于沟通、喜欢表现。</p></div>'
            }
        };
        var config = $.extend(defaults, settings);
        var superContainer = $(this),
        answers = [],        
        exitFob = '<div class="results-container"><div class="result-keeper"></div></div>',
        finishFob='<div class="center" ><input style="width:170px; height:45px; font-size:26px" type="button" id="finish" value="查看结果"/></div>',
        contentFob = '<div class="description"><p style="color:#5B5B5B;margin-top:15px;margin-bottom:20px;font-size:130%;">&nbsp&nbsp&nbsp&nbsp这是美国宇航局开发的测评领导者天生性格的有效工具，一共14道题，3分钟即可完成测试，并查看到结果。</br>&nbsp&nbsp&nbsp&nbsp请想象自己<B>正值20岁左右</B>。让自己在放松和自然的状态下快速完成对以下问题的选择。</p></div>',
        questionsIteratorIndex,
        answersIteratorIndex;
        superContainer.addClass('main-quiz-holder');
        for (questionsIteratorIndex = 0; questionsIteratorIndex < config.questions.length; questionsIteratorIndex++) {
            contentFob += '<div class="slide-container"> <div class="question">' + (questionsIteratorIndex + 1) + '.' + config.questions[questionsIteratorIndex].question + '</div><ul class="answers">';
            for (answersIteratorIndex = 0; answersIteratorIndex < config.questions[questionsIteratorIndex].items.length; answersIteratorIndex++) {
                contentFob += '<li><label><input name="item'+questionsIteratorIndex+'" type="radio" value="'+answersIteratorIndex+'">' + config.questions[questionsIteratorIndex].items[answersIteratorIndex] + '</label></li>';
            }
            contentFob += '</ul><div class="nav-container">';

            contentFob += '</div></div>';            
        }
        superContainer.html(contentFob + exitFob+finishFob);
        var userAnswers = [],
        questionLength = config.questions.length,
        slidesList = superContainer.find('.slide-container');
                
        superContainer.find('li').click(function() {
            $(this).parents(".slide-container").addClass("completed");            
        });
        
        superContainer.find('#finish').click(function() {
        		var oD = $(".slide-container");
            for(var i=1;i<$(".slide-container").length;i++){
                if(!$(oD[i]).hasClass("completed")){
                    alert('您还有题目没有作答');
              			return false;                   
                }
            }
        		var tep=0,ded=0,req=0,type_string="";
        		
            $(".slide-container").each(function(i,e){
            	tep = $(this).find("input:radio:checked").val();
            	if(i<7){            		
            		if(tep==0)
            			ded+=1;
            		if(tep==1)
            			ded-=1;	            		
            	}else{
            		if(tep==0)
            			req+=1;
            		if(tep==1)
            			req-=1;	
            	}            	            			            		 
            });
            if(ded>0&&req>0)
			{
              type_string=config.resultComments.type1;
			  
			}  
            else if(ded<0 && req>0)
			{
            	type_string=config.resultComments.type2;
				
			}
            else if(ded>0 && req<0)
			{
            	type_string=config.resultComments.type3;
					
			}
			else if(ded<0 && req<0)   
            { 
			  type_string=config.resultComments.type4;
			  
			}
            superContainer.find('.result-keeper').html(type_string);
       
            superContainer.find('.slide-container').hide();
			superContainer.find('.description').hide();
            superContainer.find('.results-container').show();
            $(this).hide();
			
            return false;
        });
    };
})(jQuery);