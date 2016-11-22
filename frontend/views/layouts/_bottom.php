<?php
use yii\helpers\Html;
?>
<div class="row">
    <div class="footer-top clearfix">
        <div class="col-lg-12">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <h4>About Us</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                <ul class="social-media">
                    <ul class="social-media">
                        <li class="fb-icon"><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li class="tw-icon"><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="linkedin-icon"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li class="youtube-icon"><a href="#"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <h4>Latest Blogs</h4>
                <div class="media border-none clearfix">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" src="<?php echo $bundle->baseUrl; ?>/images/anshi.jpg" alt="">
                        </a>
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading">To Sell Or Not To Sell</h6>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <div class="date">May 25, 2016</div>
                    </div>
                </div>
                <div class="media clearfix">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" src="<?php echo $bundle->baseUrl; ?>/images/anshita.png" alt="">
                        </a>
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading">Anshita Housing Limited</h6>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                        <div class="date">May 25, 2016</div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <h4>Contact Us</h4>
                <address>22 Ida Lane, Maple Shade, NJ 08000</address>
                <ul class="list2">
                    <li>Main Email : <a href="mailto:anshi.patel4@gmail.com">anshi.patel4@gmail.com</a></li>
                    <li>Inquiries : <a href="mailto:anshi.patel4@gmail.com">Info@anshita.com</a></li>
                </ul>
                <ul class="list2">
                    <li>Telephone : <a href="#">215-530-7010 </a></li>
                    <li>Mobile : <a href="#">215-530-7010</a></li>
                </ul>
            </div>
        </div>    
    </div>
    <div class="footer-bottom clearfix">
        <div class="col-xs-12 col-sm-8 col-md-6">
            <div class="copyright">Copyright &copy; <?php echo date('Y'); ?> <?php echo Yii::$app->name; ?>  |  All rights reserved.</div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-6">
            <div class="designed-by">Designed by <a href="#" target="_blank">Anshita</a></div>
        </div>
    </div>
</div>
