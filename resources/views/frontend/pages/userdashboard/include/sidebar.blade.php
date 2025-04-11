<div class="col-md-3">
    <div class="card shadow-sm rounded-lg">
        <div class="card-body text-center">
            <img src="{{ asset('images/user.png') }}" alt="User Image" class="rounded-circle img-thumbnail mx-auto mb-3"
                width="100">

            <h5 class="mb-0">{{ auth()->user()->name }}</h5>
            <p class="text-muted small mb-2">{{ auth()->user()->email }}</p>

            @php
            $tiers = ['Primary', 'Silver', 'Gold'];
            $tierColors = ['info', 'primary', 'success'];
            @endphp

            <p class="mb-1">
                <span class="text-success fw-bold">Reward Points:</span>
                <span class="fw-semibold">{{ $reward }}</span>
            </p>

            <p class="mb-0">
                <span class="text-success fw-bold">Type:</span>
                <span class="badge bg-{{ $tierColors[$type ?? 0] }} px-3 py-1 rounded-pill">
                    {{ $tiers[$type ?? 0] }}
                </span>
            </p>

            <hr>
            <ul class="list-group">
                <li class="list-group-item"><a href="{{ route('dashboard') }}" class="text-dark"><i
                            class="ti-dashboard"></i> Dashboard</a></li>
                <li class="list-group-item"><a href="{{ route('user-profile') }}" class="text-dark"><i
                            class="ti-user"></i> Profile</a></li>
                <li class="list-group-item"><a href="{{ route('user.order.index') }}" class="text-dark"><i
                            class="ti-shopping-cart"></i> My Orders</a></li>
                <li class="list-group-item"><a href="#" class="text-dark"><i class="ti-heart"></i> My WishList</a></li>
                <li class="list-group-item"><a href="{{ route('logout') }}" class="text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ti-power-off"></i> Logout</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>