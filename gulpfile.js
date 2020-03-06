var elixir = require('laravel-elixir');
    
elixir.config.assetsPath = 'assets';

elixir(function(mix) {
    mix.less('*.less', 'css/app.css')
       .coffee('**/*.coffee', 'js/app.js');
});