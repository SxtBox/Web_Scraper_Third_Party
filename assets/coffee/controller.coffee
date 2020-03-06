###*
# @class ScraperApp
# @author Insert Your Name As Author <trc4@usa.com>
###

window.ScraperApp.controller "ScraperController",
[
    '$scope'
    '$window'
    'routeApi'
    '$timeout'
    (
        $scope
        $window
        $routeapi
        $timeout
    ) ->

        class ScrapController
            
            constructor : () ->

                url = $window.Url + 'test.html'

                $scope.perpages = [ 10, 20, 50, 100 ]

                $scope.pageinfo = {}

                $scope.form =
                    image : 
                        url : url
                    tag : 
                        url  : url
                        type : 'img'
                    website : 
                        url       : url
                        datacount : 0
                    site : 
                        url : url

                $scope.results = 
                    images      : []
                    tags        : []
                    links       : []
                    site        : {}

                $scope.norecord = 
                    image : false
                    tag   : false
                    link  : false
                    site  : false

                $scope.pagination = {}

                $scope.onrequest  = false


            $scope.numberOfPages = (type, collection) ->

                if $scope.form[type]

                    if not $scope.pagination[type]
                        $scope.pagination[type] =
                            currentpage : 0
                            pagesize    : 10
                            pagetotal   : 0
                            pages       : []

                    $scope.pagination[type].currentpage = 0
                    $scope.pagination[type].pages = []

                    $scope.pagination[type].pagetotal = Math.ceil $scope.results[collection]?.length / $scope.pagination[type].pagesize 

                    for i in [ 0...$scope.pagination[type].pagetotal ]
                        $scope.pagination[type].pages.push i


            $scope.submit = (type) ->

                collection = ''
                collection = 'images' if type is 'image'
                collection = 'tags'   if type is 'tag'
                collection = 'links'  if type is 'website'
                collection = 'site'   if type is 'site'

                if $scope.form[type]?.url and collection isnt ''

                    $scope.onrequest = true

                    data = $scope.form[type]
                    data.action = type
                    
                    $scope.norecord[type] = false

                    route = $window.Url + 'scraper.php'

                    $scope.results[collection] = []
                    $scope.pageinfo[type]      = {}

                    $routeapi.send route, data, 'POST'
                    .then ( response ) ->

                        res = response.data

                        $scope.pageinfo[type].title       = res.title       if res.title
                        $scope.pageinfo[type].description = res.description if res.description
                        $scope.pageinfo[type].keywords    = res.keywords    if res.keywords
                        $scope.pageinfo[type].author      = res.author      if res.author

                        if res.type is 'image'
                            $scope.results.images = res.data

                        if res.type is 'tag'
                            $scope.results.tags = res.data     
                            $scope.numberOfPages 'tag', 'tags'

                        if res.type is 'website'
                            $scope.form.website.datacount = _.size res.data
                            $scope.results.links = res.data

                        $scope.norecord[type] = true if _.size(res.data) is 0

                        if res.type is 'site'
                            $scope.results.site = res.data
                            console.log _.size(res.data.zip)
                            $scope.norecord[type] = true if _.size(res.data.zip) is 0

                        $scope.onrequest = false


                        return
                        

                return

        new ScrapController()

]