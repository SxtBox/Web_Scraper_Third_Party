
<div class="form-group">

    <label class="control-label">Link URL : <small class="example">EX. http://website.com/test.html</small></label>

    <input type="text" class="form-control" placeholder="URL" ng-model="form.website.url">
    
    <button type="button" class="btn btn-default" ng-click="submit('website')" ng-hide="onrequest" ng-class="{'on-request' : onrequest}">
        <i class="glyphicon glyphicon-send"></i> Submit
    </button>
</div>

<div ng-if="pageinfo.website.title">
    <div class="page-info">
        <div ng-if="pageinfo.website.title">Title: <span>{{ pageinfo.website.title }}</span></div>
        <div ng-if="pageinfo.website.description">Description: <span>{{ pageinfo.website.description }}</span></div>
        <div ng-if="pageinfo.website.keywords">Keywords: <span>{{ pageinfo.website.keywords }}</span></div>
        <div ng-if="pageinfo.website.author">Author: <span>{{ pageinfo.website.author }}</span></div>
    </div>
</div>

<ul ng-show="form.website.datacount > 0" class="tree">
    <li ng-repeat="(linkkey, links) in results.links track by $index" class="tree-parent">
        <strong ng-if="linkkey == 'z__Z'">Anchor Links</strong>
        <strong ng-if="linkkey != 'z__Z'">{{ linkkey }}</strong>
        <ul>
            <li ng-repeat="link in links track by $index">
                <a ng-if="linkkey != 'z__Z'" href="<?php echo url('download.php?r={{ link }}') ?>" tooltip="Download" class="site-download">
                    <i class="glyphicon glyphicon-download-alt"></i>
                </a>
                <a ng-if="linkkey != 'z__Z'" href="{{ link }}"  target="_blank" class="site-link">
                    <i class="glyphicon glyphicon-link"></i> {{ link }}
                </a>
                <a ng-if="linkkey == 'z__Z'" target="_blank" href="{{ link }}" class="site-link">
                    <i class="glyphicon glyphicon-link"></i> {{ link }}
                </a>

            </li>
        </ul>
    </li>
</ul>

<div class="no-record" ng-show="norecord.website">{{ form.website.url }} - Can't scrap this page. Please try again.</div>