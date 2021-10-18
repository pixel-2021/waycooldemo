

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="<?php echo BASE_URL;?>static/js/jquery.validate.js"></script>
	<script src="<?php echo BASE_URL;?>static/js/additional-methods.js"></script>		  
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
	<script src="<?php echo BASE_URL;?>static/js/jquery.countup.js"></script>	
	<script src="https://use.fontawesome.com/9ad0804c94.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
	<script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>
	<script src="<?php echo BASE_URL; ?>static/js/easy-responsive-tabs.js"></script>	
    <script src="<?php echo BASE_URL; ?>static/js/jquery.easing.min.js"></script>
    <script src="<?php echo BASE_URL; ?>static/js/main.js"></script>
	<script src="<?php echo BASE_URL;?>static/js/grid.js"></script>   
	
	<script>
	
	/*--/ Navbar Menu Reduce /--*/
  $(window).trigger('scroll');
  $(window).bind('scroll', function() {
    var pixels = 50;
    var top = 1200;
    if ($(window).scrollTop() > pixels) {
      $('.navbar-default').addClass('navbar-reduce');
      $('.navbar-default').removeClass('navbar-trans');
    } else {
      $('.navbar-default').addClass('navbar-trans');
      $('.navbar-default').removeClass('navbar-reduce');
    }
    if ($(window).scrollTop() > top) {
      $('.scrolltop-mf').fadeIn(1000, "easeInOutExpo");
    } else {
      $('.scrolltop-mf').fadeOut(1000, "easeInOutExpo");
    }
  }); 
  

$('.produsts-lists').slick({
    dots: false,
    arrows: true,
    infinite: false,
    autoplay: true,
    autoplaySpeed: 3000,
    slidesToShow: 3,
    adaptiveHeight: true,
    responsive: [
    {
      breakpoint: 1100,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
		arrows: false,
        dots: true
      }
    },
    {
      breakpoint: 999,
      settings: {
        slidesToShow: 2, 		
        slidesToScroll: 1,
		arrows: false,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
		arrows: false,
		dots: true
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow:1,
        slidesToScroll: 1,
		arrows: false,
		dots: true
      }
    }
 
  ]
  }); 
  

$('.vde-sldr').slick({
    dots: false,
    arrows: true,
	fade: true,
    infinite: false,
    autoplay: true,
    autoplaySpeed: 3000,
    slidesToShow: 1,
    adaptiveHeight: true,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 999,
      settings: {
        slidesToShow: 1,
		arrows: true,		
        slidesToScroll: 1,
		dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
		dots: true
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow:1,
        slidesToScroll: 1,
		dots: true
      }
    }
 
  ]
  }); 
  

$('.testimonials-lists').slick({
    dots: false,
    arrows: true,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 3000,
    slidesToShow: 2,
    adaptiveHeight: true,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 999,
      settings: {
        slidesToShow: 1,
		arrows: true,		
        slidesToScroll: 1,
		dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
		dots: true
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow:1,
        slidesToScroll: 1,
		dots: true
      }
    }
 
  ]
  }); 
  
  
	</script>
	
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
	//triger:'hover';
	});   
});
</script>	 
	
	
<script>
$( document ).ready(function() {
  new WOW().init();
});
</script>
	

<a href="#" class="back-to-top">
<i class="fa fa-chevron-up"></i>
</a>


</body>

</html>