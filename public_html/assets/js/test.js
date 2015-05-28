function callback(data){

	//alert(data);
	console.log(data);
}

var j = 0;

var httpRequest = new XMLHttpRequest;

httpRequest.onreadystatechange = function(){

	if(httpRequest.readyState===4){

		if(httpRequest.status===200){

			var obj = JSON.parse(httpRequest.responseText);

			//alert(obj[j]['headline']);

		}
	}
};

httpRequest.open("GET","http://rakesh.mistry.yoobee.net.nz/testphp/testphp/cms/phpdata/get-data.php",true);

httpRequest.send(); 

//console.log(blue);

console.log(document.querySelectorAll("#headline_content"));

var array = [ ];

var divs = document.querySelectorAll('#headline_content');

//http://toddmotto.com/a-comprehensive-dive-into-nodelists-arrays-converting-nodelists-and-understanding-the-dom/

for (var i = 0; i < divs.length; i++) {
  // access to individual element:
  var self = divs[i];
  
  array.push(self);
  
}

var lightbox = document.querySelector("#lightbox");

console.log(lightbox.childNodes);

for (var i = 0; i < array.length; i++) {


array[i].addEventListener('click', function(e){
    
    lightbox.classList.remove("hide");
    
    lightbox.classList.add("show");
    
    document.body.classList.add("noscroll");
    
    //headline
    lightbox.childNodes[1].childNodes[3].innerText = this.childNodes[0].innerText;

    //image
    lightbox.childNodes[1].childNodes[5].src = this.childNodes[1].src;

    //text
    lightbox.childNodes[1].childNodes[7].innerText = this.childNodes[3].innerText;
    
});

  
}



var close = document.querySelector("#lightbox").childNodes[1].childNodes[1]; 

close.addEventListener('click', function(e){
    
    this.parentNode.parentNode.classList.remove("show");
    
    this.parentNode.parentNode.classList.add("hide");
    
    document.body.classList.remove("noscroll");
    
}); 





