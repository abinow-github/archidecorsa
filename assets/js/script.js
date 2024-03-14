// HERO SLIDER
var menu = [];
jQuery('.swiper-slide').each( function(index){
    menu.push( jQuery(this).find('.slide-inner').attr("data-text") );
});
var interleaveOffset = 0.5;
var swiperOptions = {
    loop: true,
    speed: 1000,
    parallax: true,
    autoplay: {
        delay: 6500,
        disableOnInteraction: false,
    },
    watchSlidesProgress: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    on: {
        progress: function() {
            var swiper = this;
            for (var i = 0; i < swiper.slides.length; i++) {
                var slideProgress = swiper.slides[i].progress;
                var innerOffset = swiper.width * interleaveOffset;
                var innerTranslate = slideProgress * innerOffset;
                swiper.slides[i].querySelector(".slide-inner").style.transform =
                "translate3d(" + innerTranslate + "px, 0, 0)";
            }      
        },

        touchStart: function() {
          var swiper = this;
          for (var i = 0; i < swiper.slides.length; i++) {
            swiper.slides[i].style.transition = "";
          }
        },

        setTransition: function(speed) {
            var swiper = this;
            for (var i = 0; i < swiper.slides.length; i++) {
                swiper.slides[i].style.transition = speed + "ms";
                swiper.slides[i].querySelector(".slide-inner").style.transition =
                speed + "ms";
            }
        }
    }
};

var swiper = new Swiper(".swiper-container", swiperOptions);

// DATA BACKGROUND IMAGE
var sliderBgSetting = $(".slide-bg-image");
sliderBgSetting.each(function(indx){
    if ($(this).attr("data-background")){
        $(this).css("background-image", "url(" + $(this).data("background") + ")");
    }
});


///////////////navbar scroll-y
$(document).ready(function() {
    $(window).scroll(function() {
      if ($(this).scrollTop() > 200) {
        $('#navbar').addClass('scrolled');
      } else {
        $('#navbar').removeClass('scrolled');
      }
    });
  });


  //////navbar onclick in small devices
  function showNav(){
    var nav=document.getElementById('navbarCollapseMd')
    nav.classList.toggle('show');
  }

//////////////////* services hover icon  */
  function addTrigger(element) {
    var lordIcon = element.querySelector('.lordIcon');
    lordIcon.setAttribute('trigger', 'in');
  }
  
  function removeTrigger(element) {
    var lordIcon = element.querySelector('.lordIcon');
    lordIcon.setAttribute('trigger', '');
  }  




  //////projects slider
$(document).ready(function(){
    $('.project-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 1
            }
        }]
    });
  });

  ////social media hyperlink
  function socialMedia(a){
    let link=a
    if(a==1){
        window.location.href='https://www.facebook.com/archidecor.sa/'
    }else if(a==2){
        window.location.href='https://www.instagram.com/archidecor.sa'
    }else if(a==3){
        window.location.href='https://www.youtube.com/channel/UCaWQY56iAAo4gkezyIH5NSA?view_as=subscriber'
    }
  }


  /////////number count
  function visible(partial) {
    var $t = partial,
        $w = jQuery(window),
        viewTop = $w.scrollTop(),
        viewBottom = viewTop + $w.height(),
        _top = $t.offset().top,
        _bottom = _top + $t.height(),
        compareTop = partial === true ? _bottom : _top,
        compareBottom = partial === true ? _top : _bottom;

    return ((compareBottom <= viewBottom) && (compareTop >= viewTop) && $t.is(':visible'));

}

$(window).scroll(function(){

  if(visible($('.count-digit')))
    {
      if($('.count-digit').hasClass('counter-loaded')) return;
      $('.count-digit').addClass('counter-loaded');
      
$('.count-digit').each(function () {
  var $this = $(this);
  jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
    duration: 1500,
    easing: 'swing',
    step: function () {
      $this.text(Math.ceil(this.Counter));
    }
  });
});
    }
})











    