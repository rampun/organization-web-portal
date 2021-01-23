<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="/">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Members -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMember" aria-expanded="true" aria-controls="collapseMember">
        <i class="fas fa-users"></i>
    <span>{{ __('Member') }}</span>
    </a>
    <div id="collapseMember" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('member.list') }}">{{ __('All Members') }}</a>
            <a class="collapse-item" href="{{ route('member.create') }}">{{ __('Add Member') }}</a>
        </div>
    </div>
</li>

<!-- Nav Item - Committees -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('committee.list', 'All') }}">
        <i class="fas fa-sitemap"></i>
        <span>{{ __('Committees') }}</span>
    </a>
</li>

<!-- Nav Item - Events -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvent" aria-expanded="true" aria-controls="collapseEvent">
        <i class="far fa-calendar-alt"></i>
        <span>{{ __('Event') }}</span>
    </a>
    <div id="collapseEvent" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('event.list', 'All') }}">{{ __('All Events') }}</a>
            <a class="collapse-item" href="{{ route('event.create') }}">{{ __('Add Event') }}</a>
        </div>
    </div>
</li>

<!-- Nav Item - Activities -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseActivity" aria-expanded="true" aria-controls="collapseActivity">
        <i class="far fa-calendar-check"></i>
        <span>{{ __('Activity') }}</span>
    </a>
    <div id="collapseActivity" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('activity.list', 'All') }}">{{ __('All Activities') }}</a>
            <a class="collapse-item" href="{{ route('activity.create') }}">{{ __('Add Activity') }}</a>
        </div>
    </div>
</li>

<!-- Nav Item - Notices -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNotice" aria-expanded="true" aria-controls="collapseNotice">
        <i class="far fa-clipboard"></i>
        <span>{{ __('Notice') }}</span>
    </a>
    <div id="collapseNotice" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('notice.list', 'All') }}">{{ __('All Notices') }}</a>
            <a class="collapse-item" href="{{ route('notice.create') }}">{{ __('Add Notice') }}</a>
        </div>
    </div>
</li>

<!-- Nav Item - Department -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('department.list', 'All') }}">
        <i class="far fa-building"></i>
        <span>{{ __('Department') }}</span>
    </a>
</li>

<!-- Nav Item - Downloads -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDownload" aria-expanded="true" aria-controls="collapseDownload">
        <i class="fas fa-file-download"></i>
        <span>{{ __('Download') }}</span>
    </a>
    <div id="collapseDownload" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('download.list', 'All') }}">{{ __('All Downloads') }}</a>
            <a class="collapse-item" href="{{ route('download.create') }}">{{ __('Add Download') }}</a>
        </div>
    </div>
</li>


<!-- Nav Item - Suggestions -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('suggestion.list') }}">
        <i class="far fa-edit"></i>
        <span>{{ __('Suggestion') }}</span>
    </a>
</li>