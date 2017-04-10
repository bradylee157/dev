/**
 * @Component - Preachit
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 * adapted and modified from the tamingselect script found at http://icant.co.uk/forreview/tamingselect/
 */


function piselect()
{
	if(!document.getElementById && !document.createTextNode){return;}
	
// Classes for the link and the visible dropdown
	var ts_selectclass='pidropdown'; 	// class to identify selects
	var ts_listclass='turnintoselect';		// class to identify ULs
	var ts_boxclass='dropcontainer'; 		// parent element
	var ts_triggeron='activetrigger'; 		// class for the active trigger link
	var ts_triggeroff='trigger';			// class for the inactive trigger link
	var ts_dropdownclosed='dropdownhidden'; // closed dropdown
	var ts_dropdownopen='dropdownvisible';	// open dropdown

/*
	Turn all selects into DOM dropdowns
*/
	var count=0;
	var toreplace=new Array();
	var sels=document.getElementsByTagName('select');
	for(var i=0;i<sels.length;i++){
		if (ts_check(sels[i],ts_selectclass))
		{
			var hiddenfield=document.createElement('input');
			hiddenfield.name=sels[i].name;
			hiddenfield.type='hidden';
			hiddenfield.id=sels[i].id;

			/* get hidden values to choose which option to display at the top */
			
			if (hiddenfield.id == 'filter_book')
			{
				pioption = document.pimessages.pifbook.value;
				ulid = 'filter_bookul';	
			}
			else if (hiddenfield.id == 'filter_teacher')
			{
				pioption = document.pimessages.pifteach.value;
				ulid = 'filter_teachul';	
			}
			else if (hiddenfield.id == 'filter_series')
			{
				pioption = document.pimessages.pifseries.value;	
				ulid = 'filter_seriesul';
			}
			else if (hiddenfield.id == 'filter_year')
			{
				pioption = document.pimessages.pifyear.value;
				ulid = 'filter_yearul';	
			}
			else if (hiddenfield.id == 'filter_ministry')
			{
				pioption = document.pimessages.pifministry.value;	
				ulid = 'filter_ministryul';
			}
			else
			{
				pioption = 0;	
				ulid = 'generalul';
			}	
			hiddenfield.value=sels[i].options[pioption].value;
			sels[i].parentNode.insertBefore(hiddenfield,sels[i])	
			var trigger=document.createElement('a');
			ts_addclass(trigger,ts_triggeroff);
			trigger.href='#';
			trigger.onclick=function(){
				activeul = this.parentNode.getElementsByTagName('ul')[0];
				clickremove(activeul.id);
				ts_swapclass(this,ts_triggeroff,ts_triggeron);
				ts_swapclass(this.parentNode.getElementsByTagName('ul')[0],ts_dropdownclosed,ts_dropdownopen);
				return false;
			}		
			var trimtext = sels[i].options[pioption].text;
			if (trimtext.length > 12)
			{
			trimtext = trimtext.substring(0,9)+'...';
			}
			trigger.appendChild(document.createTextNode(trimtext));
			sels[i].parentNode.insertBefore(trigger,sels[i]);
			var replaceUL=document.createElement('ul');
			replaceUL.id = ulid;
			for(var j=0;j<sels[i].getElementsByTagName('option').length;j++)
			{
				var newli=document.createElement('li');
				var newa=document.createElement('a');
				newli.v=sels[i].getElementsByTagName('option')[j].value;
				newli.elm=hiddenfield;
				newli.istrigger=trigger;
				newa.href='#';
				newa.appendChild(document.createTextNode(
				sels[i].getElementsByTagName('option')[j].text));
				newli.onclick=function(){ 
					this.elm.value=this.v;
					ts_swapclass(this.istrigger,ts_triggeron,ts_triggeroff);
					ts_swapclass(this.parentNode,ts_dropdownopen,ts_dropdownclosed)
					var checktext = this.firstChild.firstChild.nodeValue;
					if (checktext.length > 12)
					{
					checktext = checktext.substring(0,9)+'...';
					}
					if (this.istrigger.firstChild.nodeValue == checktext)
					{
						this.istrigger.firstChild.nodeValue=checktext;
					}
					else
					{
						this.istrigger.firstChild.nodeValue=checktext;
						pifajaxbuildurl();
					}
					return false;
				}
				newli.appendChild(newa);
				replaceUL.appendChild(newli);
			}
			ts_addclass(replaceUL,ts_dropdownclosed);
			var div=document.createElement('div');
			div.appendChild(replaceUL);
			ts_addclass(div,ts_boxclass);
			sels[i].parentNode.insertBefore(div,sels[i])
			toreplace[count]=sels[i];
			count++;
		}
	}
	
/*
	Turn all ULs with the class defined above into dropdown navigations
*/	

	var uls=document.getElementsByTagName('ul');
	for(var i=0;i<uls.length;i++)
	{
		if(ts_check(uls[i],ts_listclass))
		{
			var newform=document.createElement('form');
			var newselect=document.createElement('select');
			for(j=0;j<uls[i].getElementsByTagName('a').length;j++)
			{
				var newopt=document.createElement('option');
				newopt.value=uls[i].getElementsByTagName('a')[j].href;	
				newopt.appendChild(document.createTextNode(uls[i].getElementsByTagName('a')[j].innerHTML));	
				newselect.appendChild(newopt);
			}
			newselect.onchange=function()
			{
				window.location=this.options[this.selectedIndex].value;
			}
			newform.appendChild(newselect);
			uls[i].parentNode.insertBefore(newform,uls[i]);
			toreplace[count]=uls[i];
			count++;
		}
	}
	for(i=0;i<count;i++){
		toreplace[i].parentNode.removeChild(toreplace[i]);
	}
	function ts_check(o,c)
	{
	 	return new RegExp('\\b'+c+'\\b').test(o.className);
	}
	function ts_swapclass(o,c1,c2)
	{
		var cn=o.className
		o.className=!ts_check(o,c1)?cn.replace(c2,c1):cn.replace(c1,c2);
	}
	function ts_addclass(o,c)
	{
		if(!ts_check(o,c)){o.className+=o.className==''?c:' '+c;}
	}
	
	function clickremove(ulid)
	{
		var ddact = document.getElementsByTagName('ul');
				for(var i=0;i<ddact.length;i++){
					if (ddact[i].className == ts_dropdownopen && ddact[i].id != ulid)
					{ddact[i].className = ts_dropdownclosed;}
				}
		var trigact = document.getElementsByTagName('a');
				for(var i=0;i<trigact.length;i++){
					if (trigact[i].className == ts_triggeron)
					{trigact[i].className = ts_triggeroff;}
				}
	}

}

function closedd()
{		
	var ev = arguments[0] || window.event,
	origEl = ev.target || ev.srcElement;
	if (origEl.tagName != 'A')
		{
				var ddbodyact = document.getElementsByTagName('ul');
				for(var i=0;i<ddbodyact.length;i++){
					if (ddbodyact[i].className == 'dropdownvisible')
					{ddbodyact[i].className = 'dropdownhidden';}
				}
				var trigbodyact = document.getElementsByTagName('a');
				for(var i=0;i<trigbodyact.length;i++){
					if (trigbodyact[i].className == 'activetrigger')
					{trigbodyact[i].className = 'trigger';}
		     }
		 }
}

document.onclick = closedd;

if (window.addEventListener){
 window.addEventListener('load', piselect, false);
} else if (window.attachEvent){
 window.attachEvent('load', piselect);
}
