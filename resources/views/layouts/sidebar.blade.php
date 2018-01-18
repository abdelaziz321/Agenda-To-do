
<!-- Start Sidbar -->
<aside class="sidebar">
    <!--  Navbar Button -->
    <div class="navbar_btn">
        <button type="button" id="navbar_btn" class="btn btn-bar">
            <i class="icon ion-close"></i>
        </button>
    </div>

    <!--  Profile Info -->
    <div class="profile_info">
        <div class="img_responsive">
            <img src="{{ URL::asset('images/uploads/profile/' . $user->photo) }}" alt="profile_picture"/>
        </div>
        <h4>{{ $user->name }}</h4>
        <a href="{{ url('user/index') }}" id="edit-profile" class="btn btn-primary"><i class="icon ion-edit"></i> Edit Profile</a>
        <a href="{{ url('authanticate/logout') }}" id="logout" class="btn btn-danger"><i class="icon ion-locked"></i> Logout</a>
    </div>

    <!-- Notes -->
    <div class="notes">
        <h4><i class="ion ion-compose"></i> My Notes:</h4>
        <ul>
            @foreach ($notes as $note)
                @include('todo.note')
            @endforeach
        </ul>
        <a href="{{ url('notes/dialog') }}" id="add_note" class="btn btn-primary"><i class="icon ion-plus-round"></i> Create New</a>
    </div>

    <!-- Developer -->
    <footer class="developer">
        <p>Developed By <span class="name">Abdelaziz Selim</span></p>
        <div class="social">
            <a href="#" title="Github"><i class="icon ion-social-github" aria-hidden="true"></i></a>
            <a href="#" title="Codepen"><i class="icon ion-social-codepen" aria-hidden="true"></i></a>
            <a href="#" title="Linkedin"><i class="icon ion-social-linkedin" aria-hidden="true"></i></a>
            <a href="#" title="Twitter"><i class="icon ion-social-twitter" aria-hidden="true"></i></a>
            <a href="#" title="Facebook"><i class="icon ion-social-facebook" aria-hidden="true"></i></a>
        </div>
    </footer>
</aside>
<!-- /End Sidbar -->
