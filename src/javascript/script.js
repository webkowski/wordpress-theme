/**
 * The JavaScript code you place here will be processed by esbuild, and the
 * output file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

 import Splide from '@splidejs/splide';

 //var elms = document.getElementsByClassName( 'splide' );

 //var navs = document.querySelectorAll( '.splide__arrows' );
 //var bars = document.getElementsByClassName( 'my-carousel-progress-bar' );
//var splides = []

document.querySelectorAll('.splide').forEach(carousel => {
  const splide = new Splide( carousel, {
    pagination: false,
    autoWidth: true,
    type  : 'fade',
  } )

  var bar    = splide.root.querySelector( '.splide-progress-bar' );
  splide.on( 'mounted move', function () {
    var end  = splide.Components.Controller.getEnd() + 1;
    var rate = Math.min( ( splide.index + 1 ) / end, 1 );
    bar.style.width = String( 100 * rate ) + '%';
  } ); 
  splide.mount()
})





//  for ( var i = 0; i < elms.length; i++ ) {

// //console.log('ELEM', navs[i].getElementsByClassName('splide__arrow--prev'))

//   splides[i] = new Splide( elms[ i ], {
//     //arrows: true,
//     //pagiation: false,
//     autoWidth: true,
//     //perPage: 1,
//     type  : 'fade',
//     classes: {
//       // /arrow: 'splide__arrows mt-1',
//       //page : 'opacity-100 splide__pagination__page border-slate-400 w-5 h-5 block justify-center items-center bg-slate-400 rounded-full m-0',
//     }
//     // {
//     //   prev:  navs[ i ].getElementsByClassName('splide__arrow--prev')[0],
//     //   next:  navs[ i ].getElementsByClassName('splide__arrow--next')[0],
//     // }
//    } )
   
//    splides[i].bar = bars[i]
// var current = splides[i]
// // Updates the bar width whenever the carousel moves:
// splides[i].on( 'mounted move', function () {
// console.log('this', Splide.splides)
//   // var end  = splide.Components.Controller.getEnd() + 1;
//   // var rate = Math.min( ( splide.index + 1 ) / end, 1 );

//   // console.log('BAR', i, splide.bar )
//   // splide.bar.style.width = String( 100 * rate ) + '%';
// } );
   
   
// splides[i].mount();
  
//  }