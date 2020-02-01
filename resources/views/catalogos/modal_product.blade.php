<div class="row">
	<div class="col-md-6 col-lg-7 p-b-30">
		<div class="p-l-25 p-r-30 p-lr-0-lg">
			<div class="wrap-slick3 flex-sb flex-w">
				<div class="wrap-slick3-dots"></div>
				<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

				<!-- /Carrousel galery -->
				<div class="slick3 gallery-lb">
					@foreach ($imagenes as $img)
					<!-- Imagen carrousel -->
					<div class="item-slick3" data-thumb="{{ url('imagen/'.$img->id) }}">
						<div class="wrap-pic-w pos-relative">
							<img src="{{ url('imagen/'.$img->id) }}" alt="IMG-PRODUCT">

							<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ url('imagen/'.$img->id) }}">
								<i class="fa fa-expand"></i>
							</a>
						</div>
					</div>
					<!-- /Imagen carrousel -->
					@endforeach
				</div>
				<!-- /Carrousel galery -->								

			</div>
		</div>
	</div>
	
	<div class="col-md-6 col-lg-5 p-b-30">
		<div class="p-r-50 p-t-5 p-lr-0-lg">
			<h4 class="mtext-105 cl2 js-name-detail p-b-14">
				{{ $producto->nombre }}
			</h4>

			<span class="mtext-106 cl2">
				${{ number_format($producto->precio_minimo) }}
				@if ($producto->precio > $producto->precio_minimo)
					&nbsp<small class="text-secondary"><s>{{ $producto->precio }}</s></small>
				@endif
			</span>

			<p class="stext-102 cl3 p-t-23">				
			</p>
			
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.wrap-slick3').each(function(){
	    $(this).find('.slick3').slick({
	        slidesToShow: 1,
	        slidesToScroll: 1,
	        fade: true,
	        infinite: true,
	        autoplay: false,
	        autoplaySpeed: 6000,

	        arrows: true,
	        appendArrows: $(this).find('.wrap-slick3-arrows'),
	        prevArrow:'<button class="arrow-slick3 prev-slick3"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
	        nextArrow:'<button class="arrow-slick3 next-slick3"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',

	        dots: true,
	        appendDots: $(this).find('.wrap-slick3-dots'),
	        dotsClass:'slick3-dots',
	        customPaging: function(slick, index) {
	            var portrait = $(slick.$slides[index]).data('thumb');
	            return '<img src=" ' + portrait + ' "/><div class="slick3-dot-overlay"></div>';
	        },  
	    });
	});
</script>

<script>
	$('.gallery-lb').each(function() { // the containers for all your galleries
		$(this).magnificPopup({
	        delegate: 'a', // the selector for gallery item
	        type: 'image',
	        gallery: {
	        	enabled:true
	        },
	        mainClass: 'mfp-fade'
	    });
	});
</script>