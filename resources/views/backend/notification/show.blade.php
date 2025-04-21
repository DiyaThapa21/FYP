@php
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

$user = Auth::user();

// Fetch latest 5 notifications where receiver_id is the current logged-in user
$adminNotifications = Notification::where('receiver_id', $user->id)->latest()->take(5)->get();

// Count of unread notifications for the current user
$notificationCount = Notification::where('receiver_id', $user->id)->where('is_read', 0)->count();
@endphp

<div id="notifications">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <span class="badge badge-danger badge-counter">
            @if($notificationCount > 5)
            <span class="count" data-count="5">5+</span>
            @else
            <span class="count" data-count="{{ $notificationCount }}">{{ $notificationCount }}</span>
            @endif
        </span>
    </a>

    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">Notifications Center</h6>

        @foreach($adminNotifications as $notification)
        <a class="dropdown-item d-flex align-items-center" href="{{ route('notification.read', $notification->id) }}">
            <div class="mr-3">
                <div class="icon-circle {{ $notification->is_read == 1 ? 'bg-secondary' : 'bg-primary' }}">
                    <i class="fas fa-box-open text-white"></i>
                </div>
            </div>
            <div class="{{ $notification->is_read == 1 ? 'text-muted' : '' }}">
                <div class="small text-gray-500">
                    {{ \Carbon\Carbon::parse($notification->created_at)->format('F d, Y h:i A') }}
                </div>
                <span class="{{ $notification->is_read == 1 ? '' : 'font-weight-bold' }}">
                    {{ $notification->data }}
                </span>
            </div>
        </a>

        @endforeach


        <a class="dropdown-item text-center small text-gray-500" href="{{ route('all.notification') }}">Show All
            Notifications</a>
    </div>
</div>