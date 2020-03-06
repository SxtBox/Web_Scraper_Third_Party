
<!-- Page Content -->
<div class="container main-container" ng-app="ScraperApp" ng-controller="ScraperController" ng-cloak>

    <div class="row">
        <div class="col-lg-12">

            <div>
                <pre ng-repeat="imgattr in imgattrs track by $index">
                    {{ imgattr }}
                </pre>
            </div>

        </div>
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">

            <div class="nav">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#website" data-toggle="tab" aria-expanded="false"><i class="glyphicon glyphicon-link"></i> Get Links</a></li>
                    <li><a href="#image" data-toggle="tab" aria-expanded="true"><i class="glyphicon glyphicon-picture"></i> Get Images</a></li>
                    <li><a href="#tag" data-toggle="tab" aria-expanded="false"><i class="glyphicon glyphicon-indent-left"></i> Tag with Attribute Details</a></li>
                    <li><a href="#fullsite" data-toggle="tab" aria-expanded="false"><i class="glyphicon glyphicon-download-alt"></i> Full Site Download</a></li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane active" id="website">
                        <?php include_once('website.php'); ?>
                    </div>
                    <div class="tab-pane" id="image">
                        <?php include_once('image.php'); ?>
                    </div>
                    <div class="tab-pane" id="tag">
                        <?php include_once('tag.php'); ?>
                    </div>
                    <div class="tab-pane" id="fullsite">
                        <?php include_once('fullsite.php'); ?>
                    </div>

                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="onrequest">
                        <img src="<?php echo url('img/preloader.gif'); ?>">
                    </div>
                    <div class="clearfix"></div>
                    
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>

</div>
<!-- /.container -->