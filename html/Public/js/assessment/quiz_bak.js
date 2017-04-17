(function($) {
    $.fn.jquizzy = function(settings) {
        var defaults = {
            questions: null,                        
            resultComments: {
                type1: '<div style="margin-left:10px;margin-right:10px;font-size:24px"><p style="margin-bottom:25px">你是<span style="color:#32CD32"><b>绿色</b></span>性格：“培养型”–“以人为本者”</p><p style="margin-bottom:25px">你擅长欣赏与感激他人，乐于表达，积极达观，开朗正向。</p><p style="margin-bottom:25px">你尊重人的价值，有同理心、关心他人。</p><p style="margin-bottom:25px">你是创业团队中的积极氛围创造者！</p></div>',
                type2: '<div style="margin-left:10px;margin-right:10px;font-size:24px"><p style="margin-bottom:25px">你是<span style="color:#0000CD"><b>蓝色</b></span>性格：“展望型”–“创意创造者”</p><p style="margin-bottom:25px">你擅长思考与想像，能够自然地产生创意。</p><p style="margin-bottom:25px">你以创意相聚，崇尚自由，争做最好。</p><p style="margin-bottom:25px">你是创业团队中的先行者和创意者！</p></div>',
                type3: '<div style="margin-left:10px;margin-right:10px;font-size:24px"><p style="margin-bottom:25px">你是<span style="color:#FFA500"><b>黄色</b></span>性格：“包融型”–“团队的凝聚者”</p><p style="margin-bottom:25px">你喜欢交际，自然地给人以归属感、包容感。</p><p style="margin-bottom:25px">你能够营造融洽的关系，追求和谐的团队合作。</p><p style="margin-bottom:25px">你是创业团队中的融合剂！</p></div>',
                type4: '<div style="margin-left:10px;margin-right:10px;font-size:24px"><p style="margin-bottom:25px">你是<span style="color:#FF4500"><b>橙色</b></span>性格：“指导型”–“体系的构建者”</p><p style="margin-bottom:25px">你注重流程和组织架构，追求结果的确定性。</p><p style="margin-bottom:25px">你能够规范地管理人，将工作有条不紊地推向你的预期。</p><p style="margin-bottom:25px">你是创业团队中的扎实推进者！</p></div>'
            }
        };
        var config = $.extend(defaults, settings);
        var superContainer = $(this),
        answers = [],        
        exitFob = '<div class="results-container"><div class="result-keeper"></div></div>',
        finishFob='<div class="center" ><input style="width:170px; height:45px; font-size:26px" type="button" id="finish" value="查看结果"/></div>',
        contentFob = '<div class="description"><p style="color:#5B5B5B;margin-top:15px;margin-bottom:20px;font-size:130%;">&nbsp&nbsp&nbsp&nbsp这是美国宇航局开发的测评领导者天生性格的有效工具，一共14道题，3分钟即可完成测试，并查看到结果。</br>&nbsp&nbsp&nbsp&nbsp请想象自己正值20岁左右。让自己在放松和自然的状态下快速完成对以下问题的选择。</p></div>',
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
              type_string=config.resultComments.type1;
            else if(ded<0 && req>0)
            	type_string=config.resultComments.type2;
            else if(ded>0 && req<0)
            	type_string=config.resultComments.type3;	
            else if(ded<0 && req<0)   
              type_string=config.resultComments.type4;
                  
            superContainer.find('.result-keeper').html(type_string);
       
            superContainer.find('.slide-container').hide();
			superContainer.find('.description').hide();
            superContainer.find('.results-container').show();
            $(this).hide();
            return false;
        });
    };
})(jQuery);