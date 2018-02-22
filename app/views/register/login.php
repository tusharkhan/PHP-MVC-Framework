<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/19/2018
 * Time : 4:18 AM
 * File : login.php
 */

?>

<?php $this->start('head'); ?>
<?php $this->setSiteTitle('Login'); ?>
<?php $this->end() ?>
<?php $this->start('head'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" >
            <div class="loginForm" >
                <h3 class="text-center">Login</h3>

                <form action="<?=PROOT?>register/login" method="post">

                    <?php echo $this->displayErrors; ?>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input name="email" type="email" class="form-control " id="email" />
                    </div>

                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" name="password" class="form-control" id="pwd" autocomplete="" />
                    </div>

                    <div class="checkbox">
                        <label><input type="checkbox" name="rememberMe"> Remember me </label>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block login-hover" value="Login" />
                    </div>

                </form>

                <h4 class="text-center ">Don't have account ??</h4>

                <div class="form-group">
                    <a href="<?=PROOT?>register/register" class="btn btn-success btn-block register-hover" >Register</a>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->end() ?>
