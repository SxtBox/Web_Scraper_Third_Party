<div class="form-group">

    <label class="control-label">Image URL : <small class="example">EX: http://website.com/test.html</small></label>

    <input type="text" class="form-control" placeholder="URL" ng-model="form.image.url">
    
    <button type="button" class="btn btn-default" ng-click="submit('image')" ng-hide="onrequest" ng-class="{'on-request' : onrequest}">
        <i class="glyphicon glyphicon-send"></i> Submit
    </button>
</div>

<div ng-if="pageinfo.image.title">
    <div class="page-info">
        <div ng-if="pageinfo.image.title">Title: <span>{{ pageinfo.image.title }}</span></div>
        <div ng-if="pageinfo.image.description">Description: <span>{{ pageinfo.image.description }}</span></div>
        <div ng-if="pageinfo.image.keywords">Keywords: <span>{{ pageinfo.image.keywords }}</span></div>
        <div ng-if="pageinfo.image.author">Author: <span>{{ pageinfo.image.author }}</span></div>
    </div>
</div>

<ul style="list-style: none;padding: 0;" ng-show="results.images.length > 0">
    <li ng-repeat="image in results.images track by $index" style="float: left;margin: 4px;position: relative;">
        <div class="image-center-vh">
            <img ng-src="{{ image }}">
        </div>
        <div class="button-links">
            <div class="col-xs-6 icon-link">
                <a href="{{ image }}" target="_blank" tooltip="Link"><i class="glyphicon glyphicon-link"></i></a>
            </div>
            <div class="col-xs-6 icon-download">
                <a href="<?php echo url('download.php?r={{ image }}') ?>" tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a>
            </div>

        </div>
    </li>
</ul>

<div class="no-record" ng-show="norecord.image">{{ form.image.url }} - Can't scrap this page. Please try again.</div>