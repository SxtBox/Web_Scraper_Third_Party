###*
# @class ScraperApp
# @author Insert Your Name As Author <trc4@usa.com>
###

window.ScraperApp.factory "routeApi",
[
	'$http',
	'$rootScope'
	'$q'
	'$window'
	(
		$http,
		$rootScope,
		$q
		$window
	) ->
			
		send : (url, data={}, method='GET') ->

			@$$additionalHTTPHeader()
			data._token = $window.csrf if _.size(data) > 0 and $window.csrf and method.toLowerCase() is 'post'

			httpDataRequest =
				method: method
				url: url
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8' }
				data: $.param data

			return $http.get url if method == 'GET'
			return $http httpDataRequest

		###
		#   Authentication   = Site Authentication Token
		#   X-Requested-With = Set Http Request to AJAX FORMAT
		###
		$$additionalHTTPHeader : ( ) ->
			$http.defaults.headers.common['Authentication']   = 'YOUR_USER_NAME'
			$http.defaults.headers.common['X-Requested-With'] = "XMLHttpRequest"

			return
]
