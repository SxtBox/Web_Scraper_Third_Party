

<div class="form-group">
    <label class="control-label">Tag URL : <small class="example">EX: http://website.com/test.html</small></label>
    <input type="text" class="form-control" id="urlscrap" placeholder="URL" ng-model="form.tag.url">

    <label for="urlscrap" class="control-label">Element/Tag :  <small class="example">e.g. img</small></label>
    <input type="text" class="form-control" id="urlscrap" placeholder="Element/Tag" ng-model="form.tag.type">

    <button type="button" class="btn btn-default" ng-click="submit('tag')" ng-hide="onrequest" ng-class="{'on-request' : onrequest}">
        <i class="glyphicon glyphicon-send"></i> Submit
    </button>
</div>

<div ng-if="pageinfo.tag.title">
    <div class="page-info">
        <div ng-if="pageinfo.tag.title">Title: <span>{{ pageinfo.tag.title }}</span></div>
        <div ng-if="pageinfo.tag.description">Description: <span>{{ pageinfo.tag.description }}</span></div>
        <div ng-if="pageinfo.tag.keywords">Keywords: <span>{{ pageinfo.tag.keywords }}</span></div>
        <div ng-if="pageinfo.tag.author">Author: <span>{{ pageinfo.tag.author }}</span></div>
    </div>
</div>

<div style="list-style: none;padding: 0;" ng-show="results.tags.length > 0">

    <hr style="margin-bottom: 10px;">
    
    <div class="select-pages">
        Per page: 
        <select ng-options="perpage for perpage in perpages" ng-model="pagination.tag.pagesize" class="form-control" ng-change="numberOfPages('tag', 'tags')"></select>
    </div>

    <div class="pagination">
        <ul>
            <li><a href="javascript:void(0)" ng-class="{'a-disabled' : pagination.tag.currentpage == 0}" ng-click="pagination.tag.currentpage = pagination.tag.currentpage - 1">&lt;</a></li>
            <li>
                <ol>
                    <li ng-class="{'active' : pagination.tag.currentpage == page}" ng-click="pagination.tag.currentpage = page" ng-repeat="page in pagination.tag.pages"><a>{{ page + 1 }}</a></li>
                </ol>
            </li>
            <li><a href="javascript:void(0)" ng-class="{'a-disabled' : pagination.tag.currentpage >= results.tags.length/pagination.tag.pagesize - 1}" ng-click="pagination.tag.currentpage = pagination.tag.currentpage + 1">&gt;</a></li>
        </ul>
    </div>

    <div class="clearfix"></div>



    <div class="tag-collections" ng-repeat="tag in results.tags | startFrom : pagination.tag.currentpage * pagination.tag.pagesize | limitTo : pagination.tag.pagesize">
        <div class="count-label">{{ ( pagination.tag.currentpage * pagination.tag.pagesize ) + $index + 1 }}</div>
        <ul>
            <li ng-repeat="(key, value) in tag track by $index">
                <span class="tag-label">{{ key }}:</span>

                <span ng-if="key == 'contents' && value" class="tag-content">
                    <pre>{{ value }}</pre>
                </span>
                <span ng-if="keyval != 'contents'">
                    <span ng-show="value | isObj">
                        <span class="tag-content">
                            <ul>
                                <li ng-repeat="(keyval, val) in value track by $index" ng-if="val">
                                    <span class="tag-label">> {{ keyval }}: </span>
                                    <span class="tag-content tag-content-border">{{ val }}</span>
                                </li>
                            </ul>
                        </span>

                    </span>
                    <span ng-show="value | isObj:true" class="tag-content tag-content-border">
                        {{ value }}
                    </span>
                </span>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>



    <div class="pagination">
        <ul>
            <li><a href="javascript:void(0)" ng-class="{'a-disabled' : pagination.tag.currentpage == 0}" ng-click="pagination.tag.currentpage = pagination.tag.currentpage - 1">&lt;</a></li>
            <li>
                <ol>
                    <li ng-class="{'active' : pagination.tag.currentpage == page}" ng-click="pagination.tag.currentpage = page" ng-repeat="page in pagination.tag.pages"><a>{{ page + 1 }}</a></li>
                </ol>
            </li>
            <li><a href="javascript:void(0)" ng-class="{'a-disabled' : pagination.tag.currentpage >= results.tags.length/pagination.tag.pagesize - 1}" ng-click="pagination.tag.currentpage = pagination.tag.currentpage + 1">&gt;</a></li>
        </ul>
    </div>

</div>

<div class="no-record" ng-show="norecord.tag">{{ form.tag.url }} - Can't scrap this page. Please try again.</div>