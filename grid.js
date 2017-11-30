function jsPostGrid(evt_arg,evt_mode, page,control_name)
{
    
    document.getElementById('hdnEventArgs').value = evt_arg;
    document.getElementById('hdnEventMode').value = evt_mode;
 
    $.post(page, { hdnEventArgs: evt_arg, hdnEventMode: evt_mode, ajax: "yes" },
         function(data){             
             document.getElementById(control_name).innerHTML=data;
        });
}

function jsProcessCommand(id,page,control_name,command_name)
{
  jsPostGrid(id,command_name,page,control_name);
}

function jsProcessDelete(msg,id,page,control_name)
{
    if(confirm(msg))
        {
            jsPostGrid(id,"delete",page,control_name);
        }
}

function grd_select_all(theForm, cName, status) {

		for (i=0,n=theForm.elements.length;i<n;i++)
		  if (theForm.elements[i].className.indexOf(cName) !=-1) {
		  
		    if(theForm.elements[i].checked) theForm.elements[i].checked ="" ;
			else theForm.elements[i].checked ="checked";
		  }
		}
