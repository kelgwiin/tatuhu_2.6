		function getUrlVars() {
			var vars = {};
			var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
				vars[key] = value;
			});
			return vars;
		}
		
function loadScript(path){ 
    script = document.createElement('script'); 
    script.type = 'text/javascript'; 
    script.src = path; 
    document.getElementsByTagName('head')[0].appendChild(script); 
	return true;
} 