var breakpoint = {
  large: 1140, // desktop and large screens
  medium: 1024, // tablets
  small: 768, // mobile phones
};

$(function(){
  initSlickCarousel();
  initCountUp();  
  initFancyBoxy();
  initLayoutSwitcher();
  
  // Initialize range slider
});
/**
 * http://www.daterangepicker.com/
 */
function initRangeDatepicker(startDate,endDate){
  $('input[name="daterange"]').daterangepicker(
  {
      locale: {
        format: 'YYYY-MM-DD'
      },
      startDate: startDate,
      endDate: endDate
  },
  function(start, end, label) { // callback
    // alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
}

function initSlickCarousel(){
  $('.grid-carousel').css('visibility','visible');

  $('.slick-carousel-4').slick({
    infinite: false,
    nextArrow: '<i class="fa fa-chevron-right slick-next" aria-hidden="true"></i>',
    prevArrow: '<i class="fa fa-chevron-left slick-prev" aria-hidden="true"></i>',
    slidesToShow: 4,
    responsive: [
      {
        breakpoint: breakpoint.large,
        settings: {
          slidesToShow: 4,
        }
      },
      {
        breakpoint: breakpoint.medium,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: breakpoint.small,
        settings: {
          slidesToShow: 2,
        }
      },
    ]
  });

  $('.slick-carousel-3').slick({
    infinite: false,
    nextArrow: '<i class="fa fa-chevron-right slick-next" aria-hidden="true"></i>',
    prevArrow: '<i class="fa fa-chevron-left slick-prev" aria-hidden="true"></i>',
    slidesToShow: 3,
    responsive: [
      {
        breakpoint: breakpoint.large,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: breakpoint.medium,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: breakpoint.small,
        settings: {
          slidesToShow: 1,
        }
      },
    ]
  });
}

function initCountUp(){
  countUp();
  $(window).on('scroll',function(){
    countUp();
  });
}

function countUp(){
  $('[data-count-up]').each(function() {
    if( isVisible(this) ){
      var $this = $(this);
      var countTo = $this.data('count-up');

      $({ countNum: $this.text()}).animate({
        countNum: countTo
      },
      {
        duration: 1000,
        easing:'linear',
        step: function() {
          $this.text(Math.floor(this.countNum));
        },
        complete: function() {
          $this.text(this.countNum);
        }
      });
    }
  });
}

function initRangeSlider(id)
{
  var sliderID = $('#'+id);
  
  if( sliderID.length ){
    var container = sliderID.closest('.rangeSliderWrap'),
        minText = container.find('.rangeMinText'),
        maxText = container.find('.rangeMaxText'),
        minValue = container.find('.rangeMinValue'),
        maxValue = container.find('.rangeMaxValue');

    var slider = new Slider(document.getElementById(id), {
      isDate: false,
      min: sliderID.data('initial-start'),
      max: sliderID.data('initial-end'),
      start: sliderID.data('start'),
      end: sliderID.data('end'),
      overlap: true,

    });

    slider.subscribe('moving', function(data) {
      var dataLeft = roundTo(data.left,'down'),
          dataRight = roundTo(data.right, 'up');
      minText.text( dataLeft );
      maxText.text( dataRight );
      minValue.val( dataLeft );
      maxValue.val( dataRight );
    });

    slider.subscribe('stop', function(data) {
    	jQuery(minValue).submit();
    });
    var dataLeft = roundTo(slider.getInfo().left, 'down'),
        dataRight = roundTo(slider.getInfo().right, 'up');

    minText.text( dataLeft );
    maxText.text( dataRight );
    minValue.val( dataLeft );
    maxValue.val( dataRight );
  }
}

/**
 * A method to round number to the nearest up or down based on number of digits 
 * author: Anas Abudayah <anas.abudayah@gmail.com>
 * date:   Aug 2017
 * @param  {[integer]}  integer [any number]
 * @param  {[string]}   near    [it can be up or down]
 * @return {[integer]}          [returns the nearest number based on number of digits]
 */
function roundTo(integer, near){
 integer = parseInt(Math.round(integer));
 var digits = parseInt(integer.toString().length);
 
 if( integer > 0 ){
    if( integer > 99 ){
      var zeroDigits = '';
        for (i = 0; i < digits - 2; i++) {
         zeroDigits += '0';
      }
      nearest = parseInt('1' + zeroDigits);
   } else {
     nearest = 5;
   }
   
   if( near === 'up' )
   return Math.floor( integer / nearest ) * nearest;
   else
   return Math.ceil( integer / nearest ) * nearest;
   
 } else
 return integer;
}

function isVisible(element){
  if( $(element).length ){
    var win = $(window);
    var pageTop = (win.scrollTop() + ~~(isNaN($(element).customHeight)?0:$(element).customHeight));
    var pageBottom = pageTop + win.height();
    var elementTop = $(element).offset().top;
    var elementBottom = elementTop + $(element).height();

    if($(element).threshold && typeof $(element).threshold === 'number'){
      elementBottom = elementBottom - $(element).threshold;
    }
    if ($(element).fullyInView === true) {
      return ((pageTop < elementTop) && (pageBottom > elementBottom));
    } else {
      return ((elementTop <= pageBottom) && (elementBottom >= pageTop));
    }
  }
}

function initFancyBoxy(){
  if( $('.fancybox').length )
    $('.fancybox').fancybox();
}

function initLayoutSwitcher(){
  var layoutSwitcher = $('[data-layout-switcher]');
  
  if( layoutSwitcher.length ){
    $(document).on('click','[data-layout]:not(.active)',function(){
      var layout = $(this).data('layout');
      
      $( "[data-thumb-class]" ).each(function( index ) {
        $(this).removeClass( $(this).data('thumb-class') );
        $(this).removeClass( $(this).data('list-class') );
        $(this).addClass( $(this).data(layout+'-class') );
      });
      
      $('[data-layout]').removeClass('active');
      $(this).addClass('active');
    });
  }
}
