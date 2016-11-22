<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\web\Request;
use frontend\modules\myaccount\Module;

$this->title = 'Preference';
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
        <?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- Company Info Section -->
        <div class="manage-preferences">
            <div class="row">
                <div class="sia-profile-logo">
                    <div class="sia-profile-top clearfix">
                        <div class="pic"><a href="#"><img alt="" src="<?=Module::getInstance()->company_logo?>"></a></div>
                        <div class="compname"><?=Module::getInstance()->company_name?><span>Service Provider</span></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h2 class="title lg spl"><span class="pyr-sprite sprite-preferences"></span> Edit Preferences</h2>
                </div>
            </div>
            <form class="custom" role="form" action="abcd.php" method="post" name="preferences">

                <div class="preferences">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="title"><span class="pyr-sprite sprite-modules"></span> Modules</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input type="checkbox" checked="checked" value="1" name="checkbox" id="checkbox1"><label class="mar-right" for="checkbox1"><span></span> Ezysolare Trusted</label>
                                        <input type="checkbox" value="2" name="checkbox" id="checkbox2"><label for="checkbox2"><span></span> Other</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group inline-select">
                                        <input type="text" placeholder="Size" id="inputlg" class="form-control input-lg">
                                        <div class="select-style">
                                            <select data-width="auto" class="form-control" name="t">
                                                <option value="kVA">kVA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <ul class="custom-img-chkbox">
                                        <li>
                                            <div data-toggle="buttons" class="btn-group">
                                                <label class="btn btn-default">
                                                    <img alt="" src="<?=  Yii::getAlias('@web')?>/images/sui-logo.png">
                                                    <div class="bizcontent">
                                                        <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                                                        <span class="fa fa-check fa-lg"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-toggle="buttons" class="btn-group">
                                                <label class="btn btn-default">
                                                    <img alt="" src="<?=  Yii::getAlias('@web')?>/images/navitas-solar-logo.jpg">
                                                    <div class="bizcontent">
                                                        <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                                                        <span class="fa fa-check fa-lg"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-toggle="buttons" class="btn-group">
                                                <label class="btn btn-default">
                                                    <img alt="" src="<?=  Yii::getAlias('@web')?>/images/schneider-logo.png">
                                                    <div class="bizcontent">
                                                        <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                                                        <span class="fa fa-check fa-lg"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div><hr>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="title"><span class="pyr-sprite sprite-inverters"></span> Inverters</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input type="checkbox" checked="checked" value="3" name="checkbox" id="checkbox3"><label class="mar-right" for="checkbox3"><span></span> Ezysolare Trusted</label>
                                        <input type="checkbox" value="4" name="checkbox" id="checkbox4"><label for="checkbox4"><span></span> Other</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group inline-select">
                                        <input type="text" placeholder="Size" id="inputlg" class="form-control input-lg">
                                        <div class="select-style">
                                            <select data-width="auto" class="form-control" name="t">
                                                <option value="kVA">kVA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <ul class="custom-img-chkbox">
                                        <li>
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <img src="<?=  Yii::getAlias('@web')?>/images/sui-logo.png" alt="">
                                                    <div class="bizcontent">
                                                        <input type="checkbox" value="" autocomplete="off" name="var_id[]">
                                                        <span class="fa fa-check fa-lg"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <img src="<?=  Yii::getAlias('@web')?>/images/navitas-solar-logo.jpg" alt="">
                                                    <div class="bizcontent">
                                                        <input type="checkbox" value="" autocomplete="off" name="var_id[]">
                                                        <span class="fa fa-check fa-lg"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <img src="<?=  Yii::getAlias('@web')?>/images/schneider-logo.png" alt="">
                                                    <div class="bizcontent">
                                                        <input type="checkbox" value="" autocomplete="off" name="var_id[]">
                                                        <span class="fa fa-check fa-lg"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div><hr>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="title"><span class="pyr-sprite sprite-contractors"></span> Contractors</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input type="checkbox" checked="checked" value="5" name="checkbox" id="checkbox5"><label class="mar-right" for="checkbox5"><span></span> Ezysolare Trusted</label>
                                        <input type="checkbox" value="6" name="checkbox" id="checkbox6"><label for="checkbox6"><span></span> Other</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group inline-select">
                                        <input type="text" placeholder="Size" id="inputlg" class="form-control input-lg">
                                        <div class="select-style">
                                            <select data-width="auto" class="form-control" name="t">
                                                <option value="kVA">kVA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <ul class="custom-img-chkbox">
                                        <li>
                                            <div data-toggle="buttons" class="btn-group">
                                                <label class="btn btn-default">
                                                    <img alt="" src="<?=  Yii::getAlias('@web')?>/images/sui-logo.png">
                                                    <div class="bizcontent">
                                                        <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                                                        <span class="fa fa-check fa-lg"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-toggle="buttons" class="btn-group">
                                                <label class="btn btn-default">
                                                    <img alt="" src="<?=  Yii::getAlias('@web')?>/images/navitas-solar-logo.jpg">
                                                    <div class="bizcontent">
                                                        <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                                                        <span class="fa fa-check fa-lg"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-toggle="buttons" class="btn-group">
                                                <label class="btn btn-default">
                                                    <img alt="" src="<?=  Yii::getAlias('@web')?>/images/schneider-logo.png">
                                                    <div class="bizcontent">
                                                        <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                                                        <span class="fa fa-check fa-lg"></span>
                                                    </div>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div><hr>

                            <div class="row">
                                <div class="col-xs-12"><input type="submit" value="Save" class="btn bg-green"></div>
                            </div>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>