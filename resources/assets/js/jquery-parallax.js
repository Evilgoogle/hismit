$.fn.parallax = function ( resistance, mouse, none )
{
	$el = $( this );
	if (none == 'y') {
        TweenLite.to( $el, 0.2,
            {
                x : -(( mouse.clientX - (window.innerWidth/2) ) / resistance ),
            });
	} else {
        TweenLite.to( $el, 0.5,
            {
                x : -(( mouse.clientX - (window.innerWidth/2) ) / resistance ),
                y : -(( mouse.clientY - (window.innerHeight/2) ) / resistance )
            });
	}

};
