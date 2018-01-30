@include('layouts.head')

    <div class="main">

        @yield('message')

        <!-- Start To Do list -->
        <div class="todo">


            @yield('addtask')

            <div class="rows">
                <div class="col-md-6">
                    <div class="list past today">
                        @yield('today')
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="list future tomorrow">
                        @yield('tomorrow')
                    </div>
                </div>
            </div>

            <div class="rows">
                <div class="col-md-6">
                    <div class="list future comming">
                        @yield('comming')
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="list past overdue">
                        @yield('overdue')
                    </div>
                </div>
            </div>
            <div id="draggable_helper"></div>
        </div>
        <!-- /End To Do list -->

        @yield('sidebar')

        @yield('register')

    </div>

@include('layouts.footer')
