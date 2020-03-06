(function() {
  window.ScraperApp = angular.module('ScraperApp', ['ui.router']);

}).call(this);


/**
 * @class ScraperApp
 * @author Insert Your Name As Author <trc4@usa.com>
 */

(function() {
  window.ScraperApp.controller("ScraperController", [
    '$scope', '$window', 'routeApi', '$timeout', function($scope, $window, $routeapi, $timeout) {
      var ScrapController;
      ScrapController = (function() {
        function ScrapController() {
          var url;
          url = $window.Url + 'test.html'; // MAIN TEST
          $scope.perpages = [10, 20, 50, 100];
          $scope.pageinfo = {};
          $scope.form = {
            image: {
              url: url
            },
            tag: {
              url: url,
              type: 'img'
            },
            website: {
              url: url,
              datacount: 0
            },
            site: {
              url: url
            }
          };
          $scope.results = {
            images: [],
            tags: [],
            links: [],
            site: {}
          };
          $scope.norecord = {
            image: false,
            tag: false,
            link: false,
            site: false
          };
          $scope.pagination = {};
          $scope.onrequest = false;
        }

        $scope.numberOfPages = function(type, collection) {
          var i, j, ref, ref1, results;
          if ($scope.form[type]) {
            if (!$scope.pagination[type]) {
              $scope.pagination[type] = {
                currentpage: 0,
                pagesize: 10,
                pagetotal: 0,
                pages: []
              };
            }
            $scope.pagination[type].currentpage = 0;
            $scope.pagination[type].pages = [];
            $scope.pagination[type].pagetotal = Math.ceil(((ref = $scope.results[collection]) != null ? ref.length : void 0) / $scope.pagination[type].pagesize);
            results = [];
            for (i = j = 0, ref1 = $scope.pagination[type].pagetotal; 0 <= ref1 ? j < ref1 : j > ref1; i = 0 <= ref1 ? ++j : --j) {
              results.push($scope.pagination[type].pages.push(i));
            }
            return results;
          }
        };

        $scope.submit = function(type) {
          var collection, data, ref, route;
          collection = '';
          if (type === 'image') {
            collection = 'images';
          }
          if (type === 'tag') {
            collection = 'tags';
          }
          if (type === 'website') {
            collection = 'links';
          }
          if (type === 'site') {
            collection = 'site';
          }
          if (((ref = $scope.form[type]) != null ? ref.url : void 0) && collection !== '') {
            $scope.onrequest = true;
            data = $scope.form[type];
            data.action = type;
            $scope.norecord[type] = false;
            route = $window.Url + 'scraper.php';
            $scope.results[collection] = [];
            $scope.pageinfo[type] = {};
            $routeapi.send(route, data, 'POST').then(function(response) {
              var res;
              res = response.data;
              if (res.title) {
                $scope.pageinfo[type].title = res.title;
              }
              if (res.description) {
                $scope.pageinfo[type].description = res.description;
              }
              if (res.keywords) {
                $scope.pageinfo[type].keywords = res.keywords;
              }
              if (res.author) {
                $scope.pageinfo[type].author = res.author;
              }
              if (res.type === 'image') {
                $scope.results.images = res.data;
              }
              if (res.type === 'tag') {
                $scope.results.tags = res.data;
                $scope.numberOfPages('tag', 'tags');
              }
              if (res.type === 'website') {
                $scope.form.website.datacount = _.size(res.data);
                $scope.results.links = res.data;
              }
              if (_.size(res.data) === 0) {
                $scope.norecord[type] = true;
              }
              if (res.type === 'site') {
                $scope.results.site = res.data;
                console.log(_.size(res.data.zip));
                if (_.size(res.data.zip) === 0) {
                  $scope.norecord[type] = true;
                }
              }
              $scope.onrequest = false;
            });
          }
        };

        return ScrapController;

      })();
      return new ScrapController();
    }
  ]);

}).call(this);


/**
 * @class ScraperApp
 * @author Insert Your Name As Author <trc4@usa.com>
 */

(function() {
  window.ScraperApp.factory("routeApi", [
    '$http', '$rootScope', '$q', '$window', function($http, $rootScope, $q, $window) {
      return {
        send: function(url, data, method) {
          var httpDataRequest;
          if (data == null) {
            data = {};
          }
          if (method == null) {
            method = 'GET';
          }
          this.$$additionalHTTPHeader();
          if (_.size(data) > 0 && $window.csrf && method.toLowerCase() === 'post') {
            data._token = $window.csrf;
          }
          httpDataRequest = {
            method: method,
            url: url,
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            data: $.param(data)
          };
          if (method === 'GET') {
            return $http.get(url);
          }
          return $http(httpDataRequest);
        },

        /*
        		 *   Authentication   = Site Authentication Token
        		 *   X-Requested-With = Set Http Request to AJAX FORMAT
         */
        $$additionalHTTPHeader: function() {
          $http.defaults.headers.common['Authentication'] = 'YOUR_USER_NAME';
          $http.defaults.headers.common['X-Requested-With'] = "XMLHttpRequest";
        }
      };
    }
  ]);

}).call(this);

(function() {
  window.ScraperApp.filter('startFrom', function() {
    return function(input, start) {
      start = +start;
      if (input) {
        return input.slice(start);
      }
    };
  }).filter('isObj', function() {
    return function(str, reverse) {
      if (reverse == null) {
        reverse = false;
      }
      if (reverse === true) {
        return !angular.isObject(str);
      }
      return angular.isObject(str);
    };
  });

}).call(this);

//# sourceMappingURL=app.js.map
