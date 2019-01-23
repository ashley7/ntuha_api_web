const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

elixir(function(mix){

	mix.styles([
    	'./public/css/app.css',
    	'./pulic/css/style.css',   
    	],'./public/css/main_auth.css')

       .scripts([
       	    './public/js/jquery.min.js',
			'./public/js/jquery.flexslider-min.js',
			'./public/js/kupon.js',
			'./public/js/countdown.js',
			'./public/js/bootstrap.min.js',
			'./public/js/jquery.animsition.min.js',
			'./public/js/star-rating.js',
			'./public/js/plugins.js',
			'./public/js/jquery.lazy.min.js',
			'./public/js/custom.js',
       	],'./public/js/main_auth.js');
})
