
//********************************************************************//
	//Switch Menu
//********************************************************************//

//1. Create popup asking user to decide which side menu icon to be displayed
//2. Store choice in local storage
//3. Menu side can be reset in the navigation panel

//Check to see if local storage set, then apply applicable style for choosen  menu
if(localStorage.menu=='set'){

	$('.overlay').hide();

	if(localStorage.right){
	$('#menu_left').removeClass('fa-navicon').addClass('fa-search').attr("id", "search_right");
	$('#search_left').removeClass('fa-search').addClass('fa-navicon').attr("id", "menu_right");
	$('header~nav').removeClass('left_nav').addClass('right_nav');
	$('#container').removeClass('container_left').addClass('container_right');
	$('header').removeClass('header_left').addClass('header_right');
	}
};

//Pop up 'no' choice - menu stays on the left(default)
$('#no').click(function(){

	$('.overlay').addClass('hide');
	localStorage.setItem('menu','set');

});

//Pop up yes choice - menu goes on the right
$('#yes').click(function(){

	$('#menu_left').removeClass('fa-navicon').addClass('fa-search').attr("id", "search_right");
	$('#search_left').removeClass('fa-search').addClass('fa-navicon').attr("id", "menu_right");
	$('.overlay').addClass('hide');
	$('header~nav').removeClass('left_nav').addClass('right_nav');
	$('#container').removeClass('container_left').addClass('container_right');
	$('header').removeClass('header_left').addClass('header_right');

	localStorage.setItem('menu','set');
	localStorage.setItem('right','set');

});

//Call back function to determine whether content slides to left or right - based on menu side choice.
var checkNavside = function(){


	if($('header~nav').is('.left_nav')){

	$('#container').toggleClass('move-left');
	$('header').toggleClass('move-left');

	}

	if($('header~nav').is('.right_nav')){

	$('#container').toggleClass('move-right');
	$('header').toggleClass('move-right');

	}
};

$('.article_container').click(function(){

	$('#container').removeClass('move-left');
	$('header').removeClass('move-left');
	$('#container').removeClass('move-right');
	$('header').removeClass('move-right');

});


//Toggle classes to slide menu left to right or vice versa.
$('header').on("click", '#menu_left, #menu_right, #header_menu', checkNavside);


//Show and hide search area 
$('header').on("click", '#search_left, #search_right, #header_search', function(){

	$('.search_bar').toggleClass('hide');
	$('.search_results').toggleClass('hide');
	$(this).toggleClass('fa-times');

});

//Reset user decision for menu side
$('header~nav #reset').click(function(){

	localStorage.clear();

});


//********************************************************************//
	//Search
//********************************************************************//

//Ajax Callback
$("#search_bar").submit(function(e){

	var searchterm = $('input[type="search"]').val();

	var searchpost = {'search':searchterm};

	$.ajax({

		url: "get_search_results.php",
		type: 'post',
		data: searchpost,
		dataType: 'json',
		success: results

	});

	function results(data){
            
                $('#search_results_table').html('');

		if(data.length>0){

			$('#search_results_table').append('<tr><td class="td_head"><h3>SEARCH RESULTS FOR:</h3></td><td><h3>'+searchterm+'</h3></td></tr>');

			$('#search_results_table').append('<tr><td><h4>HEADLINE</h4></td><td><h4>DATE</h4></td></tr>');

			$.each(data, function(index, value){

				var olddate = value[2].split(" ");

				var newdate = olddate[0].split("-");

				var date = newdate[2]+"-"+newdate[1]+"-"+newdate[0];

				var datarow = '<tr><td><a href="index_article.php?sports_category='+value[1]+'&article_id='+value[0]+'">'+value[3]+'</a></td>';
				datarow += '<td><p>'+date+'</p></td></tr>';
				
				$('#search_results_table').append(datarow);

			});

			$('.search_results').removeClass('hide');
                        
		}else{
                    
            $('#search_results_table').append('<tr><td><h3>NO SEARCH RESULTS FOR: '+searchterm+'</h3></td></tr>');
                    
           	} 
	};

	e.preventDefault();

});

//********************************************************************//
	//Video
//********************************************************************//

$('.fa-play-circle').click(function(){
   
   var id = $('article.video').attr('id');
   
   $('#video_image').replaceWith('<iframe width="320" src="http://youtube.com/embed/'+id+'?autoplay=1&showinfo=0&controls=1" frameborder="0" id="video" allowfullscreen/>');
    
    var i = document.querySelector('iframe');
    
    if (i.requestFullscreen) {
        
    i.requestFullscreen();
    
    } else if (i.webkitRequestFullscreen) {
        
    i.webkitRequestFullscreen();
    
    } else if (i.mozRequestFullScreen) {
    
    i.mozRequestFullScreen();
    
    } else if (i.msRequestFullscreen) {
        
    i.msRequestFullscreen();
    
    }
    
});
