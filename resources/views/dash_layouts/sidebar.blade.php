<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
{{--    <a href="" class="brand-link">--}}
{{--        <img src="{{ asset('logo.jpg') }}" alt="AdminLTE Logo"--}}
{{--             class="brand-image img-circle elevation-3" style="opacity: .8">--}}
{{--        <span class="brand-text font-weight-light">Real Victory  </span>--}}
{{--    </a>--}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
{{--                <img src="{{asset('asset/images/jevarMahalLogo.png')}}" class="img-circle elevation-2" alt="User Image">--}}
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
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Numbers
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @role('admin|super_admin')
                            <li class="nav-item">
                                <a href="{{route('number.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Numbers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('number.notAssigned')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Not Assigned</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('number.upload')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Upload Numbers</p>
                                </a>
                            </li>
                        @endrole

                        <li class="nav-item">
                            <a href="{{route('number.assigned')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Assigned Numbers</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @role('admin|super_admin')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{route('user.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('user.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create User</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Role & Permission
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{--                        @role('admin|super_admin')--}}
                            <li class="nav-item">
                                <a href="{{route('role.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('role.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create Role</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('permission.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permission </p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        @php
                            $callingTeam = App\Models\User::role('calling team')->get();
                        @endphp
                        <ul class="nav nav-treeview">
                            {{--                        @role('admin|super_admin')--}}
                            @foreach($callingTeam as $member)
                                <li class="nav-item">
                                    <a href="{{route('report.user', ['user' => $member->id])}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{$member->name}}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endrole

                <li class="nav-item">
                    <a href="{{route('logout')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Logout</p>
                    </a>
                </li>

{{--                <li class="nav-item">--}}
{{--                    <a href="{{route('update.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fas fa-sync"></i>--}}
{{--                        <p>--}}
{{--                            Updates--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li class="nav-item">--}}
{{--                    <a href="{{route('bank.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fas fa-home"></i>--}}
{{--                        <p>--}}
{{--                            Banks--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li class="nav-item">--}}
{{--                    <a href="{{route('contact.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fas fa-comment-dots"></i>--}}
{{--                        <p>--}}
{{--                            Contact--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li class="nav-item">--}}
{{--                    <a href="{{route('discount.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fas fa-tags"></i>--}}
{{--                        <p>--}}
{{--                            Discount--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                     <a href="{{route('about.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon 	fa fa-address-book"></i>--}}
{{--                        <p>--}}
{{--                            About--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                     <a href="{{route('inquiry.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fa fa-american-sign-language-interpreting"></i>--}}
{{--                        <p>--}}
{{--                            Inquiry--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li class="nav-item">--}}
{{--                     <a href="{{route('price.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon 	fa fa-bullseye"></i>--}}
{{--                        <p>--}}
{{--                            Price--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li class="nav-item">--}}
{{--                    <a href="{{route('plan.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon 	fa fa-anchor"></i>--}}
{{--                        <p>--}}
{{--                            Services Plans--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="{{route('testimonial.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon 	fa fa-fax"></i>--}}
{{--                        <p>--}}
{{--                            Testimonials--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                     <a href="{{route('coin.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fa fa-group"></i>--}}
{{--                        <p>--}}
{{--                            Coin--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li class="nav-item">--}}
{{--                     <a href="{{route('blogs.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fa fa-asterisk"></i>--}}
{{--                        <p>--}}
{{--                            Blog--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                     <a href="{{route('blog.create')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fa fa-cog"></i>--}}
{{--                        <p>--}}
{{--                            Blog Article--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li class="nav-item">--}}
{{--                    --}}{{-- <a href="{{route('faq.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon 	fa fa-fan"></i>--}}
{{--                        <p>--}}
{{--                            FAQs--}}
{{--                        </p>--}}
{{--                    </a> --}}
{{--                </li>--}}



{{--                <li class="nav-item">--}}
{{--                    --}}{{-- <a href="{{route('client.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fa fa-podcast"></i>--}}
{{--                        <p>--}}
{{--                            Client Logo--}}
{{--                        </p>--}}
{{--                    </a> --}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                     <a href="{{route('product.index')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fa fa-bug"></i>--}}
{{--                        <p>--}}
{{--                          Product--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li class="nav-item">--}}
{{--                    <a href="{{route('logout')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fa fa-support"></i>--}}
{{--                        <p>--}}
{{--                           Logout--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}




            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
