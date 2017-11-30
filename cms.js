   function MoveLoadingMessage(objectID)
   {       
        try
        {        
            var y=0;
                if (navigator.appName == "Microsoft Internet Explorer")
                    {y=document.documentElement.scrollTop ;}
                else{
                    y=window.pageYOffset;         
                }
               
                document.getElementById(objectID).style.position="absolute";       
                document.getElementById(objectID).style.top=parseInt(y)+10+'px';
                document.getElementById(objectID).style.left=parseInt(screen.width)-150+'px';                
        }
        catch(e)
        {
            
        }   
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
       function DeleteCookie (name) { 
		var exp = new Date();  
		exp.setTime (exp.getTime() - 1); 
		var cval = GetCookie (name);  
		document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
	}
	function GetCookie(name) {
		var bikky = document.cookie;
		var index = bikky.indexOf(name + "=");
		if (index == -1) return null;
		index = bikky.indexOf("=", index) + 1; // first character
		var endstr = bikky.indexOf(";", index);
		if (endstr == -1) endstr = bikky.length; // last character
		return unescape(bikky.substring(index, endstr));
	  }
