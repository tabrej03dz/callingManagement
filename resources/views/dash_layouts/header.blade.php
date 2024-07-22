<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3 w-100" action="{{ route('number.assigned') }}">
        <div class="d-flex w-100 align-items-center">
            <div class="input-group input-group-sm mr-2">
                <input class="form-control form-control-navbar" name="number" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-navbar btn-sm">Clear</a>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            @php
                use Carbon\Carbon;
                use App\Models\CallRecord;
                if (auth()->user()->hasRole('calling team')) {
                    $recentCalls = CallRecord::whereDate('have_to_call', Carbon::today())
                        ->where('recalled', null)
                        ->where('user_id', auth()->user()->id)
                        ->get();
                } else {
                    $recentCalls = CallRecord::whereDate('have_to_call', Carbon::today())
                        ->where('recalled', null)
                        ->get();
                }
            @endphp
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">{{ $recentCalls->count() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @forelse($recentCalls as $call)
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    {{ $call->number->phone_number }}
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">{{ $call->number->business_name }}</p>
                                <p class="text-sm text-muted">
                                    <i class="far fa-clock mr-1"></i>{{ Carbon::parse($call->have_to_call)->diffForHumans(Carbon::now()) }}
                                </p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                @empty
                    <a href="#" class="dropdown-item dropdown-footer">No recent call</a>
                @endforelse
            </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        @php
            use App\Models\UserNumber;
            if (auth()->user()->hasRole('calling team')) {
                $todayAssignedNumbers = UserNumber::whereDate('created_at', Carbon::today())
                    ->where('user_id', auth()->user()->id)
                    ->get();
            } else {
                $todayAssignedNumbers = UserNumber::whereDate('created_at', Carbon::today())->get();
            }
        @endphp
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{ $todayAssignedNumbers->count() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="{{ route('number.assigned') }}" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> {{ $todayAssignedNumbers->count() }} new assigned numbers
                    <span class="float-right text-muted text-sm"></span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('number.callBack') }}" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> {{ $recentCalls->count() }} Call backs
                    <span class="float-right text-muted text-sm"></span>
                </a>
            </div>
        </li>
    </ul>
</nav>
