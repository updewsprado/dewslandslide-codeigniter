<!-- Aether-Custom Required Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/third-party/login-form-Aether.js"></script>

<!-- Aether-Custom Required Scripts -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/third-party/login-form-Aether.css">


<?php
    if (($this->session->userdata('first_name') != "" || is_null($this->session->userdata('first_name'))) && ($this->session->userdata('last_name') != "" || is_null($this->session->userdata('last_name')))) {
        header( "Location: /home" );
    } else {
?>

<div class="bg-cover">
</div>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="http://localhost/home"><span><img src="/images/DEWSL.png" /></span> <strong>DEWS-L Project</strong></a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row main-content-div">
        <div class="col-sm-7">
            <div class="row">
                <div class="col-sm-12">
                    <span class="big-title">DYNASLOPE </span><span class="big-title inverse">PROJECT</span>
                </div>
            </div>
            <div class="row description">
                <div class="col-sm-12">
                    <div class="">
                        <p>The Dynaslope Project is a research program developing an early warning system for deep-seated and catastrophic landslides, through landslide sensor technology and community participation in the Philippines.</p>
                        <br>
                        <p>Formerly called "DEWS-L" and "DRMS" the Dynaslope Project began in the University of the Philippies Diliman and was funded by the Department of Science and Technology. Today It is implemented by the Philippine Institute of Volcanology and Seismology in 50 sites around the Philippines.</p>
                        <br>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="card card-container">
                <img id="profile-img" class="profile-img-card" src="../../../images/dews-l-logo.png" />
                <p id="profile-name" class="profile-name-card greeting-text">Hi! Log-in when ready.</p><br>
                <form class="form-signin" action="http://localhost/lin/validate_credentials" method="POST" accept-charset="utf-8">
                    <input type="username" id="username" class="form-control" name="username" placeholder="Username" required autofocus>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="Login">Sign in</button>
                </form><!-- /form -->
                <span>Don't have an account? </span><a id="no-account" href="#" class="forgot-password">No Account?</a>
                <a id="forgot-link" href="#" class="forgot-password">Forgot the password?</a>
            </div><!-- /card-container -->              
        </div>
    </div>
</div><!-- /container-->

<?php
    }
?>

