<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('includes.head-plugins')
    @include('includes.notices')
</head>
<body>
    <div class="container">
    </div>
        @yield('content')

@include('includes.body-plugins')

@stack('script')
<script>
    var $star_rating = $('.star-rating .fa');

var SetRatingStar = function() {
  return $star_rating.each(function() {
    if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
      return $(this).removeClass('fa-star-0').addClass('fa-star');
    } else {
      return $(this).removeClass('fa-star').addClass('fa-star-o');
    }
  });
};

$star_rating.on('click', function() {
  $star_rating.siblings('input.rating-value').val($(this).data('rating'));
  return SetRatingStar();
});

SetRatingStar();
$(document).ready(function() {

});
    $('.btn-items-decrease').on('click', function () {
        var input = $(this).siblings('.input-items');
        if (parseInt(input.val(), 10) >= 1) {
            input.val(parseInt(input.val(), 10) - 1);
        }
    });

    $('.btn-items-increase').on('click', function () {
        var input = $(this).siblings('.input-items');
        input.val(parseInt(input.val(), 10) + 1);
    });
$('.owl-carousel').owlCarousel({
  loop: true,
  margin: 30,
  dots: true,
  nav: false,
  responsiveClass: true,
  responsive: {
    0: {
      items: 2,
      margin: 10,
      stagePadding: 20,
    },
    600: {
      items: 3,
      margin: 20,
      stagePadding: 50,
    },
    1000: {
      items: 4
    }
  }
});
        $(document).ready(function() {
     
     $("#owl-demo").owlCarousel({
    
         navigation : true, // Show next and prev buttons
         slideSpeed : 300,
         paginationSpeed : 400,
         singleItem:true

    
     });
    
    });
    var g = a(".has-children .sub-menu-toggle");
        a(".offcanvas-menu .offcanvas-submenu .back-btn").on("click", function(b) {
            var c = this
              , d = a(c).parent()
              , e = a(c).parent().parent().siblings().parent()
              , g = a(c).parents(".menu");
            d.removeClass("in-view"),
            e.removeClass("off-view"),
            "menu" === e.attr("class") ? g.css("height", f) : g.css("height", e.height()),
            b.preventDefault()
        }),
        g.on("click", function(b) {
            var c = this
              , d = a(c).parent().parent().parent()
              , e = a(c).parents(".menu");
            return d.addClass("off-view"),
            a(c).parent().parent().find("> .offcanvas-submenu").addClass("in-view"),
            e.css("height", a(c).parent().parent().find("> .offcanvas-submenu").height()),
            b.preventDefault(),
            !1
        });
    </script>
</body>
</html>