<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{--    <a href="" class="brand-link"> --}}
    {{--        <img src="{{ asset('logo.jpg') }}" alt="AdminLTE Logo" --}}
    {{--             class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
    {{--        <span class="brand-text font-weight-light">Real Victory  </span> --}}
    {{--    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{--                <img src="{{asset('asset/images/jevarMahalLogo.png')}}" class="img-circle elevation-2" alt="User Image"> --}}
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>

            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->


                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon material-icons">dashboard</i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon material-icons">dialpad</i>
                        <p>
                            Numbers
                            <i class="material-icons right">chevron_left</i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('show all numbers')
                            <li class="nav-item">
                                <a href="{{ route('number.index') }}" class="nav-link">
                                    <i class="nav-icon material-icons">format_list_numbered</i>
                                    <p>All Numbers</p>
                                </a>
                            </li>
                        @endcan
                        @can('show not assigned number')
                            <li class="nav-item">
                                <a href="{{ route('number.notAssigned') }}" class="nav-link">
                                    <i class="nav-icon material-icons">assignment_late</i>
                                    <p>Not Assigned</p>
                                </a>
                            </li>
                        @endcan
                        @can('upload numbers')
                            <li class="nav-item">
                                <a href="{{ route('number.upload') }}" class="nav-link">
                                    <i class="nav-icon material-icons">upload_file</i>
                                    <p>Upload Numbers</p>
                                </a>
                            </li>
                        @endcan
                        {{--                        @can('add number') --}}
                        <li class="nav-item">
                            <a href="{{ route('number.add') }}" class="nav-link">
                                <i class="nav-icon material-icons">add_circle</i>
                                <p>Add Number</p>
                            </a>
                        </li>
                        {{--                        @endcan --}}
                        @can('show assign numbers')
                            <li class="nav-item">
                                <a href="{{ route('number.assigned') }}" class="nav-link">
                                    <i class="nav-icon material-icons">assignment_turned_in</i>
                                    <p>Assigned Numbers</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('number.callBack') }}" class="nav-link">
                                <i class="nav-icon material-icons">call_return</i>
                                <p>Call Back</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @can('show all users')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon material-icons">person</i>
                            <p>
                                Users
                                <i class="material-icons right">chevron_left</i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('user.index') }}" class="nav-link">
                                    <i class="nav-icon material-icons">group</i>
                                    <p>All Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.create') }}" class="nav-link">
                                    <i class="material-icons me-2">person_add</i>
                                    <p class="mb-0">Create User</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan



                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon material-icons">security</i>
                        <p>
                            Role & Permission
                            <i class="material-icons right">chevron_left</i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{--                        @role('admin|super_admin') --}}
                        @can('show role')
                            <li class="nav-item">
                                <a href="{{ route('role.index') }}" class="nav-link">
                                    <i class="material-icons nav-icon">assignment</i>
                                    <p>Roles</p>
                                </a>
                            </li>
                        @endcan
                        @can('create role')
                            <li class="nav-item">
                                <a href="{{ route('role.create') }}" class="nav-link">
                                    <i class="material-icons nav-icon">add_circle_outline</i>
                                    <p>Create Role</p>
                                </a>
                            </li>
                        @endcan
                        @can('show permission')
                            <li class="nav-item">
                                <a href="{{ route('permission.index') }}" class="nav-link">
                                    <i class="material-icons nav-icon">lock_open</i>
                                    <p>Permission</p>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>

                @can('show report')

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon material-icons">assessment</i>
                            <p>
                                Reports
                                <i class="material-icons right">chevron_left</i>
                            </p>
                        </a>
                        @php

                            $callingTeam = App\Models\User::whereDoesntHave('roles', function ($query) {
                                $query->where('name', 'super_admin');
                            })->get();

                        @endphp
                        <ul class="nav nav-treeview">
                            {{--                        @role('admin|super_admin') --}}

                            @role('super_admin|admin')
                                @foreach ($callingTeam as $member)
                                    <li class="nav-item">
                                        <a href="{{ route('report.user', ['user' => $member->id]) }}" class="nav-link">
                                            <i class="material-icons nav-icon">person</i>
                                            <p>{{ $member->name }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('report.user', ['user' => auth()->user()->id]) }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ auth()->user()->name }}</p>
                                    </a>
                                </li>
                            @endrole

                        </ul>
                    </li>
                @endcan

                @can('show demo')

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon material-icons">slideshow</i>
                        <p>
                            Demoes
                            <i class="material-icons right">chevron_left</i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('demo.index') }}" class="nav-link">
                                <i class="material-icons nav-icon">home</i>
                                <p>Index</p>
                            </a>

                        </li>


                        <li class="nav-item">
                            <a href="{{ route('demo.create') }}" class="nav-link">
                                <i class="material-icons nav-icon">add</i>

                        @can('create demo')
                            <li class="nav-item">
                            <a href="{{route('demo.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>

                                <p>Create</p>
                            </a>
                        </li>
                        @endcan

                        @can('show demo records')
                        <li class="nav-item">
                            <a href="{{ route('demo.records') }}" class="nav-link">
                                <i class="material-icons nav-icon">list</i>
                                <p>Records</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan


                @can('show message')

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon material-icons">message</i>
                        <p>
                            Messages
                            <i class="material-icons right">chevron_left</i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('message.index') }}" class="nav-link">
                                <i class="material-icons nav-icon">home</i>
                                <p>Index</p>
                            </a>
                        </li>

                        @can('create message')

                        <li class="nav-item">
                            <a href="{{ route('message.create') }}" class="nav-link">
                                <i class="material-icons nav-icon">add</i>
                                <p>Create</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>

                @endcan




                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon material-icons">exit_to_app</i>
                        <p>Logout</p>
                    </a>
                </li>




            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
