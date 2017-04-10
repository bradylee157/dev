function pirefresh(url) {
	var revolve = document.getElementById('pirevolvegif').src;
	document.getElementById('pistudylist').innerHTML = '<div style="text-align: center;"><img style="margin: 50% 50%;" src="'+revolve+'"></div>';
	var container = new Element('div', { 'class': 'meltempcontainer',
                                         'styles': { 'display': 'none'
                                                   }	});	
   var params = piajaxparams();
	var XHRCheckin = new Request.HTML({
	url: url, 
			method: 'post',
            data: params,
			update: container,
			onComplete: function() {
				var response = container.innerHTML;
				var html = response.split("<!-- **pi ajax list break** -->");
				document.getElementById('pistudylist').innerHTML = html[1];
				if (window.addthis) {
                {addthis.toolbox(".addthis_toolbox"); addthis.toolbox(".piaddthis");}
                }
			}
		}).send();
		
}	

function isFunction(possibleFunction) {
  return (typeof(possibleFunction) == typeof(Function));
}

function piajaxparams()
{
                        var getbook = null;
                        var getministry = null;
                        var getseries = null;
                        var getdate = null;
                        var getteacher = null;
                        var getyear = null;
                        var getmonth = null;
                        var getbook2 = null;
                        var gettag = null;
                        var getasmedia = null;
                        var getteacher2 = null;
                        var getministry2 = null;
                        var getseries2 = null;
                        var getlayout = null;
                        var getch = null;
                        
                        var url = 'index.php?option=com_preachit&view=studylist';
                        
                        if (document.getElementById('filter_book'))
                        {getbook = document.getElementById('filter_book').value;
                        }
                        if (document.getElementById('filter_teacher'))
                        {getteacher = document.getElementById('filter_teacher').value;
                        }
                        if (document.getElementById('filter_series'))
                        {getseries = document.getElementById('filter_series').value;
                        }
                        if (document.getElementById('filter_year'))
                        {getdate = document.getElementById('filter_year').value;
                        }
                        if (document.getElementById('filter_ministry'))
                        {getministry = document.getElementById('filter_ministry').value;
                        }
                        if (document.getElementById('year'))
                        {getyear = document.getElementById('year').value;
                        }
                        if (document.getElementById('month'))
                        {getmonth = document.getElementById('month').value;
                        }
                        if (document.getElementById('book'))
                        {getbook2 = document.getElementById('book').value;
                        }
                        if (document.getElementById('tag'))
                        {gettag = document.getElementById('tag').value;
                        }
                        if (document.getElementById('series'))
                        {getseries2 = document.getElementById('series').value;
                        }
                        if (document.getElementById('ministry'))
                        {getministry2 = document.getElementById('ministry').value;
                        }
                        if (document.getElementById('teacher'))
                        {getteacher2 = document.getElementById('teacher').value;
                        }
                        if (document.getElementById('asmedia'))
                        {getasmedia = document.getElementById('asmedia').value;
                        }
                        if (document.getElementById('layout'))
                        {getlayout = document.getElementById('layout').value;
                        }
                        if (document.getElementById('chapter'))
                        {getch = document.getElementById('chapter').value;
                        }
                        var checkvar = document.pimessages.checkvar.value;
                        var item = document.getElementById('piitemid').innerHTML;
                        var params = {filter_book: getbook, filter_teacher: getteacher, filter_series: getseries, filter_year: getdate, filter_ministry: getministry, checkvar: checkvar, Itemid: item, tmpl: 'component', ajax: '1', book: getbook2, year: getyear, month: getmonth, tag: gettag, series: getseries2, ministry: getministry2, teacher: getteacher2, asmedia: getasmedia, layout: getlayout, ch: getch};
                        return params;
}

function getParameterByName(name, href)
{
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(href);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

