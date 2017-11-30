var _website = "";
var drowed_html=new Array();

function DrowRating(product_id,rate_id,website,viewmode,lang,type)
{        
     if(type=="local") _website=website;
         
     var newDate = new Date;
     var u = newDate.getTime();     
     var par = "?mode=drow&product_id="+product_id+"&rate_id="+rate_id+"&website="+_website+"&viewmode="+viewmode+"&lang="+lang;          
     $.ajax({
         url: _website+"rating_previewer.php"+par,
         cache: false,
         success: function(html){                                              
            drowed_html[product_id] = new Array();                      
            drowed_html[product_id][rate_id]=html;            
            document.getElementById(product_id).innerHTML=html;
        }     
    });    
}

var full_url ="";
var _product_id = "";
function RateIt(restrict_type,product_id,rate_id,clicked,website,pageX,pageY,lang,error_msg)
{        
     var par = "?mode=rate&product_id="+product_id+"&rate_id="+rate_id+"&lang="+lang+"&clicked="+clicked+"&website="+_website;     
     full_url=_website+"rating_previewer.php"+par;
     _product_id=product_id;

     if(restrict_type=="2")
     {                   
         ShowAjaxLoader(true,product_id);
         ShowLoginBox(rate_id,product_id,pageX,pageY,lang);         
         ShowAjaxLoader(false,product_id);
         return;
     }     
     else if(restrict_type=="3")
     {
         cookie_product_id=GetCookie("product_id"+product_id);
         cookie_rate_id=GetCookie("rate_id"+rate_id);
         
         if(cookie_rate_id==rate_id && cookie_product_id==product_id)
         {
             alert(error_msg);
             return;
         }

         PostData(rate_id,product_id);
         SetCookie("product_id"+product_id,product_id);
         SetCookie("rate_id"+rate_id,rate_id);
     }
     else
     {
         PostData(rate_id,product_id);
     }
}

function ShowAjaxLoader(show,product_id)
{    
    if(show) document.getElementById('imgajaxloader'+product_id).style.display="";
    else document.getElementById('imgajaxloader'+product_id).style.display="none";
}

function PostData(rate_id,product_id)
{
    ShowAjaxLoader(true,product_id);
    $.ajax({
         url:full_url ,
         cache: false,
         success: function(html)
         {
               var data_arr = html.split(';|');
               if(data_arr.length==2)
               {
                   alert(data_arr[1]);                    
               }          
               else
               {
                   drowed_html[product_id][rate_id]=data_arr[0];            
                   document.getElementById(_product_id).innerHTML=data_arr[0];
               }
        }     
        });  
}

function ChangeImage(product_id,que,count,act,inact)
{        
    for(var i=count;i>=que;i--)
    {
       // alert("ratelsimg"+i);
        document.getElementById("ratelsimg"+product_id+''+i).src=_website+"rating_img/"+inact;
    }
    for(y=1;y<=que;y++)
    {
        document.getElementById("ratelsimg"+product_id+''+y).src=_website+"rating_img/"+act;
    }
}

function Rebuild(product_id,rate_id)
{    
    document.getElementById(product_id).innerHTML=drowed_html[product_id][rate_id];
}

var loginBoxCreated=false;

function createDiv()
{
        var divTag = document.createElement("div");        
        divTag.id = "divLoginBox1";
        document.body.appendChild(divTag);        
        loginBoxCreated = true;
}

function ShowLoginBox(rate_id,product_id,pageX,pageY,lang)
{
   
    if(!loginBoxCreated)
    {
            createDiv();            
    }
    

            var template='<div id="templateDiv" ><table width="210px" bgcolor="#767F86" align="center" border="0"><tr><td align="center">';
            template+='<font color="white" face=tahoma size="3"><b>Please,wait</b></font>';
            template+='</td></tr></table></div>';

            MoveObject(pageX,pageY,"divLoginBox1");

            document.getElementById('divLoginBox1').innerHTML=template;
            document.getElementById('divLoginBox1').style.display="";

            $.ajax({
                url: _website+"rating_previewer.php?module=login_box&rate_id="+rate_id+"&product_id="+product_id+"&lang="+lang,
                cache: false,
                success: function(html){             
                    document.getElementById('divLoginBox1').innerHTML=html;
                }     
            });  
}

function Login(rate_id,product_id)
{
    ValueSet('btnLogin', ValueGet('hdnWait'));
    var tlogin =document.getElementById('txtLogin').value;
    var tpassword =document.getElementById('txtPassword').value;
    //alert(full_url);
    ShowAjaxLoader(true,product_id);
    $.post(full_url, {login : tlogin, password : tpassword},
            function(data)
            {
                ValueSet('btnLogin', ValueGet('hdnRate'));
                var data_arr = data.split(';|');
                if(data_arr.length==2)
                {
                    ShowAjaxLoader(false,product_id);
                    alert(data_arr[1]);                    
                }          
                else
                {
                    drowed_html[product_id][rate_id]=data_arr[0];            
                    document.getElementById(_product_id).innerHTML=data_arr[0];    
                    document.getElementById('divLoginBox1').style.display="none";
                }                
            });
    
}

function Cancel()
{
    document.getElementById('divLoginBox1').style.display="none";
}

function ValueSet(id,value)
{
    document.getElementById(id).value=value;
}
function ValueGet(id)
{
    return document.getElementById(id).value;
}

function SetCookie (name, value) 
{ 
		var expDays = 200;
		var exp = new Date(); 
		exp.setTime(exp.getTime() + (expDays*24*60*60*1000));

		var argv = SetCookie.arguments;
		var argc = SetCookie.arguments.length;
		var expires = exp;
		var path = (argc > 3) ? argv[3] : null;
		var domain = (argc > 4) ? argv[4] : null;
		var secure = (argc > 5) ? argv[5] : false;
		document.cookie = name + "=" + escape (value) + 
		((expires == null) ? "" : ("; expires=" + expires.toGMTString())) + 
		((path == null) ? "" : ("; path=" + path)) +  
		((domain == null) ? "" : ("; domain=" + domain)) +  
		((secure == true) ? "; secure" : "");
}
function DeleteCookie (name) 
{ 
		var exp = new Date();  
		exp.setTime (exp.getTime() - 1); 
		var cval = GetCookie (name);  
		document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
}
function GetCookie(name)
{
		var bikky = document.cookie;
		var index = bikky.indexOf(name + "=");
		if (index == -1) return null;
		index = bikky.indexOf("=", index) + 1; // first character
		var endstr = bikky.indexOf(";", index);
		if (endstr == -1) endstr = bikky.length; // last character
		return unescape(bikky.substring(index, endstr));
}

function MoveObject(mx,my,object)
{        
        document.getElementById(object).style.display="";        
        try
        {        
                var mouseX=0;
                var mouseY=0;        
                var y=0;
                var x=0;
                var scroll = 0;
                var top_position=0;
                
                if (navigator.appName == "Microsoft Internet Explorer")
                {                    
                     y=scrollY() ;
                     x=scrollX() ;                     
                     mouseX=event.clientX + x;
                     mouseY=event.clientY + y;                     
                     //top_position=parseInt(y)+parseInt(mouseY);   
                     top_position=scrollY()+event.clientY;   
                     
                }
                else{
                    y=window.pageYOffset;         
                    x=window.pageXOffset;         
                    mouseX=mx + x;
                    mouseY=my;
                    top_position=parseInt(mouseY);
                }
                //alert(mouseX+"---"+mouseY);
                document.getElementById(object).style.position="absolute";       
                document.getElementById(object).style.top=top_position+2+'px';                
                document.getElementById(object).style.left=parseInt(mouseX)+'px';
        }
        catch(e)
        {
            
        }
}

function scrollX() {return window.pageXOffset ? window.pageXOffset : document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft;}
function scrollY() {return window.pageYOffset ? window.pageYOffset : document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;}

