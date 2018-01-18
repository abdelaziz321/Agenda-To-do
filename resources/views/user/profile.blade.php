
        <!-- Start Edit Profile -->
        <section class="profile">
            <!-- Edit Form -->
            <div class="profile_form">
                <div class="header">
                    <h3><i class="icon ion-android-contact"></i> Edit My Profile</h3>
                    <button type="button" class="btn_close" id="profile_close"><i class="icon ion-close"></i></button>
                </div>
                <div class="edit_form">
                    <form method="post" action="{{ url('user/update') }}" enctype="multipart/form-data">
                        <div class="form-group has-feedback">
                            <label for="name">Change my Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" value="{{ $user->name }}">
                            <i class="icon ion-person form-control-feedback"></i>
                        </div>
                        <label>Change my photo: </label>
                        <div class="form-control file_input has-feedback">
                            <input type="file" name="photo" id="photo" />
                            <i class="icon ion-ios-camera form-control-feedback"></i>
                        </div>
                        <button type="submit" class="btn btn-primary" id="update_profile">Save</button>
                        <span class="clearfix"></span>
                    </form>
                </div>

                <!-- Reset -->
                <div class="panel reset_section">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="#" id="reset_toggle"><i class="icon ion-loop"></i>Reset my password</a></h3>
                    </div>
                    <div class="panel-body">
                        <div class="reset_form">
                            <form method="post" action="{{ route('password.email') }}">
                                <label>Send me message to reset My Passowrd</label>
                                <div class="form-group has-feedback">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                                    <i class="icon ion-email form-control-feedback"></i>
                                </div>
                                <button type="submit" class="btn btn-primary" id="send_email">Send</button>
                                <span class="clearfix"></span>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Skin -->
                <div class="panel skin_section">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="#" id="skin_toggle"><i class="icon ion-tshirt"></i>Change My Skin</a></h3>
                    </div>
                    <div class="panel-body">
                        <div class="skin_form">
                            <form method="get" action="{{ url('user/skin') }}">
                                <div class="skin_palette" data-new="true" data-bcolor="#012">
                                    <span data-color="#159"></span>
                                    <i class="icon ion-plus"></i>
                                    <span data-color="#135"></span>
                                </div>
                                <div class="skin_palette checked" data-bcolor="#012">
                                    <span data-color="#159"></span>
                                    <span data-color="#135"></span>
                                </div>
                                <div class="skin_palette" data-bcolor="#051c39">
                                    <span data-color="#0057ae"></span>
                                    <span data-color="#013c77"></span>
                                </div>
                                <div class="skin_palette" data-bcolor="#001811">
                                    <span data-color="#0e272c"></span>
                                    <span data-color="#002230"></span>
                                </div>
                                <div class="skin_palette" data-bcolor="#080018">
                                    <span data-color="#23013c"></span>
                                    <span data-color="#180a27"></span>
                                </div>

                                <input type="hidden" name="color1" id="color1" />
                                <input type="hidden" name="color2" id="color2" />
                                <input type="hidden" name="bcolor" id="bcolor" />
                                <span class="clearfix"></span>
                                <button type="submit" id="change_skin" class="btn btn-primary">Change</button>
                                <span class="clearfix"></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Edit Form -->
        </section>
        <!-- /End Edit Profile -->
