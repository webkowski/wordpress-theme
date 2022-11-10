/**
 * The JavaScript code you place here will be processed by esbuild, and the
 * output file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

 import Splide from '@splidejs/splide';

document.querySelectorAll('.splide').forEach(carousel => {
  const splide = new Splide( carousel, {
    pagination: false,
    autoWidth: true,
    type  : 'fade',
  })
	const bar = splide.root.querySelector('.splide-progress-bar');
	splide.on('mounted move', function () {
		const end = splide.Components.Controller.getEnd() + 1;
		const rate = Math.min((splide.index + 1) / end, 1);
		bar.style.width = String( 100 * rate ) + '%';
  });
  splide.mount()
})
