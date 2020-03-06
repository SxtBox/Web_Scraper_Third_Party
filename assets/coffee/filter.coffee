

window.ScraperApp

.filter 'startFrom', ->
    return (input, start) ->
        start = +start
        return input.slice(start) if input


.filter 'isObj', ->
    return (str, reverse=false) ->
        if reverse is true
            return not angular.isObject str
        return angular.isObject str
