<?php
/* @var $this yii\web\View */

//use Yii;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$this->title = Yii::$app->name;
?>
<div class="row">    
    <?php
    echo \frontend\widgets\banner\Banner::widget();
    ?>
</div>        

<?php
echo '<div class="row">' . Alert::widget() . '</div>';
?>

<div class="row">
    <div id="philosophy-block" class="clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="text-center"><span>Delivery you can rely on</span>Our Services & Records</h2>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <img src="<?php echo AppAsset::register($this)->baseUrl; ?>/images/springfield.jpg" alt="" class="img-responsive track-graph">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="offer-block" class="clearfix">
        <h2 class="text-center"><span>Get Right Advice !</span>What We Offer</h2>
        <div class="hidden-xs hidden-sm col-md-1 col-lg-1"></div>
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="block">
                    <span class="icon icon01"></span>
                    <div class="title">Web development</div>
                    <p>Our motivation for creating web application service is to provide an opportunity for users worldwide to know about you at an affordable cost.</p>
                    <a href="#" class="btn btn-default subscribe">Subscribe</a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="block">
                    <span class="icon icon03"></span>
                    <div class="title">Development and Enhancements</div>
                    <p>We provide customized development and dynamic enhancement services. </p>
                    <a href="<?php echo AppAsset::register($this)->baseUrl; ?>/site/contactus" class="btn btn-default contact">Contact</a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="block">
                    <span class="icon icon02"></span>
                    <div class="title">Project upgrading</div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book..</p>
                    <a href="#" class="btn btn-default buy">Buy</a>
                </div>
            </div>
        </div>
        <div class="hidden-xs hidden-sm col-md-1 col-lg-1"></div>
    </div>
</div>
<div class="row" id="choose-us-block">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 left-block">
        <?= \frontend\widgets\testimonial\Testimonial::widget() ?>    
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 right-block">
        <div class="block-inner">
            <h2><span>Best of our services !</span>Why People Choose Us</h2>
            <ul>
                <li>
                    <div class="sprite-icon"><span class="icon icon01"></span></div>    
                    <div class="title">Project Review</div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </li>
                <li>
                    <div class="sprite-icon"><span class="icon icon02"></span></div>    
                    <div class="title">Maintenance</div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </li>
                <li>
                    <div class="sprite-icon"><span class="icon icon03"></span></div>    
                    <div class="title">Free Documention</div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </li>
            </ul>
        </div>
    </div>    
</div>

<script>
    $(document).ready(function () {
        $('.feedback-slider').bxSlider({
            mode: 'fade', pager: true, controls: false
        });
    });
</script>