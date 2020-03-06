<div class="form-group">

    <label class="control-label">Site URL - Includes (Images, CSS and JS) <small class="example">EX: http://website.com/test.html</small> </label>

    <input type="text" class="form-control" placeholder="URL" ng-model="form.site.url">
	<!--
	<input type="text" class="form-control" placeholder="URL" ng-model="form.site.url">
	-->
    
    <button type="button" class="btn btn-default" ng-click="submit('site')" ng-hide="onrequest" ng-class="{'on-request' : onrequest}">
        <i class="glyphicon glyphicon-send"></i> Submit
    </button>
</div>

<div ng-if="pageinfo.site.title">
    <div class="page-info">
        <div ng-if="pageinfo.site.title">Title: <span>{{ pageinfo.site.title }}</span></div>
        <div ng-if="pageinfo.site.description">Description: <span>{{ pageinfo.site.description }}</span></div>
        <div ng-if="pageinfo.site.keywords">Keywords: <span>{{ pageinfo.site.keywords }}</span></div>
        <div ng-if="pageinfo.site.author">Author: <span>{{ pageinfo.site.author }}</span></div>
    </div>
</div>

<hr>

<div class="link-download text-center" ng-show="results.site.zip">
	<i class="glyphicon glyphicon-download-alt"></i>
	Download File (<a href="<?php echo url('download.php?r={{ results.site.zip }}&type=zip') ?>"><strong>{{ results.site.zip }}.zip</strong></a>):
	<a class="btn btn-success btn-block btn-flat btn-lg" href="<?php echo url('download.php?r={{ results.site.zip }}&type=zip') ?>">DOWNLOAD NOW</a>
</div>

<div style="height: 12px;"></div>
<ul class="tree" style="border: 1px solid #eee;" ng-show="results.site.zip">
    <li class="tree-parent">
        <strong>index.html</strong>
        <ul>
            <li ng-repeat="( fileext, files ) in results.site.files">
            	{{ fileext }}
		        <ul>
		            <li ng-repeat="file in files">
                        <a href="{{ file.link }}" target="_blank">{{ file.basename }}</a>
                    </li>
		        </ul>
            </li>
        </ul>
    </li>
</ul>

<div class="no-record" ng-show="norecord.site">{{ form.site.url }} - Can't scrap this page. Please try again.</div>