
<!-- Start Register System -->
        <div class="register_system">
            <div class="clearfix container">
                <h2><i class="icon ion-clipboard"></i> Agenda <small>Smart task management software</small></h2>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Start Sign in | up section -->
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation">
                                    <a href="#signin" aria-controls="signin" role="tab" data-toggle="tab"><i class="icon ion-locked"></i> Sign in</a>
                                </li>
                                <li role="presentation" class="active">
                                    <a href="#signup" aria-controls="signup" role="tab" data-toggle="tab"><i class="icon ion-person-add"></i> Sign up</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane" id="signin">
                                    <!-- Sign in  -->
                                    <div class="signin">
                                        <h3><i class="icon ion-locked"></i> Sign in</h3>
                                        <form method="post" action="{{ url('authanticate/login') }}">
                                            <div class="feedback"></div>
                                            {{ csrf_field() }}
                                            <div class="form-group has-feedback">
                                                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                                                <i class="icon ion-email form-control-feedback"></i>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <input type="password" class="form-control" name="password" placeholder="Enter your password" required data-parsley-minlength="6">
                                                <i class="icon ion-key form-control-feedback"></i>
                                            </div>
                                            <div class="remember">
                                                <input type="checkbox" name="rememberme" id="rememberme" class="css-checkbox" checked />
                                                <label for="rememberme" class="css-label">Remember me</label>
                                            </div>
                                            <button type="submit" class="btn btn-primary" id="signin_btn">Sign in</button>
                                            <span class="clearfix"></span>
                                        </form>
                                        <a href="{{ route('password.request') }}" class="reset_link">Reset password</a>
                                    </div>
                                    <!-- /Sign in -->
                                </div>
                                <div role="tabpanel" class="tab-pane active" id="signup">
                                    <!-- Sign up -->
                                    <div class="signup">
                                        <h3><i class="icon ion-person-add"></i> Sign up</h3>
                                        <form method="post" action="{{ url('authanticate/register') }}" enctype="multipart/form-data">
                                            <div class="feedback"></div>
                                            {{ csrf_field() }}
                                            <div class="form-group has-feedback">
                                                <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
                                                <i class="icon ion-person form-control-feedback"></i>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                                                <i class="icon ion-email form-control-feedback"></i>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" minlength="6" required>
                                                <i class="icon ion-key form-control-feedback"></i>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <input type="password" class="form-control" name="password_confirm" data-parsley-equalto="#password" placeholder="Confirm your password" minlength="6" required>
                                                <i class="icon ion-android-done form-control-feedback"></i>
                                            </div>
                                            <div class="form-control file_input">
                                                <label>your photo: </label>
                                                <input type="file" name="photo" />
                                            </div>
                                            <button type="submit" class="btn btn-primary" id="signup_btn">Sign up</button>
                                            <span class="clearfix"></span>
                                        </form>
                                    </div>
                                    <!-- /Sign up -->
                                </div>
                            </div>

                        </div>
                        <!-- /End Sign in | up section -->

                    </div>
                    <div class="col-md-6">
                        <!-- Start Features Section-->
                        <section id="features" class="features">
                            <h2>Agenda Features. <span class="label label-danger">{{ $users }} users</span></h2>
                            <div class="widget">
                                <div class="features_icon">
                                    <div class="bag">
                                        <i class="icon ion-heart" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="features_info">
                                    <h3>User friendly</h3>
                                    <p>Easy to use. drag from today section => drop into tomorrow.</p>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="widget">
                                <div class="features_icon">
                                    <div class="bag">
                                        <i class="icon ion-compose" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="features_info">
                                    <h3>Saving notes</h3>
                                    <p>saving your important Notes in your account, read/write online</p>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="widget">
                                <div class="features_icon">
                                    <div class="bag">
                                        <i class="icon ion-levels" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="features_info">
                                    <h3>Multiple priorities</h3>
                                    <p>adding pariority to each task and change it anytime.</p>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                            <div class="widget">
                                <div class="features_icon">
                                    <div class="bag">
                                        <i class="icon ion-tshirt" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="features_info">
                                    <h3>Choose Your Board</h3>
                                    <p>Choose between beautiful boards or create your own style.</p>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- Developer -->
                            <footer class="developer">
                                <p>Developed By <span class="name">Abdelaziz Selim</span></p>
                                <div class="social">
                                    <a href="https://github.com/abdelaziz321" title="Github"><i class="icon ion-social-github" aria-hidden="true"></i></a>
                                    <a href="#" title="Codepen"><i class="icon ion-social-codepen" aria-hidden="true"></i></a>
                                    <a href="#" title="Linkedin"><i class="icon ion-social-linkedin" aria-hidden="true"></i></a>
                                    <a href="#" title="Twitter"><i class="icon ion-social-twitter" aria-hidden="true"></i></a>
                                    <a href="#" title="Facebook"><i class="icon ion-social-facebook" aria-hidden="true"></i></a>
                                </div>
                            </footer>
                        </section>
                        <!-- /End Features Section-->
                    </div>
                </div>
            </div>
        </div>
        <!-- /End Register System -->
