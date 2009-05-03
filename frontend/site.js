$(document).ready(function() {
	
	
		$("ul#menu > li a").click(function(){
			
			//alert();
			
			father = $(this).parent();

			//Hides all the siblings
			father.siblings().toggle();
			
			//Shows all the childs "li"
			childs = father.find("li");

			childs.toggle();
		
			//Setups get back content
			//TODO: I hate how this works
			if ($(this)[0].textContent != "<"){
				
				$(this)[0].textContent = "<";
				
			}
			else {
				
				$(this)[0].textContent = childs[0].innerHTML;
				
			}
		
			
		});
		
	
	
});
