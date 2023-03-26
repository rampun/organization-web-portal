@php
use App\Helpers\Helper;

if(auth()->check())
{
$user = auth()->user();

$userMeta = App\Models\UserMeta::where('user_id', $user->id)->first();
}

@endphp

<!-- Nav Item - User Information -->
@guest
{{-- <li class="nav-item dropdown no-arrow">
            <a class="nav-link" href="/login">
                Login
            </a>
        </li> --}}
@else

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    @if(!empty($user->name))
                    {{ $user->name }}
                    @endif
                </span>

                @if (!empty($userMeta->member_photo))
                <img class="img-profile rounded-circle" src="<?php echo URL::to('/') . '/uploads/members/' . $user->id . '/' . $userMeta->member_photo; ?>" width="150px">
                @else
                <img class="img-profile rounded-circle" src="{!! Helper::getPlaceholderImage() !!}" width="150px">
                @endif
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!-- <a class="dropdown-item" href="{{ route('profile.update') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a> -->
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>

    </ul>

</nav>
@endguest