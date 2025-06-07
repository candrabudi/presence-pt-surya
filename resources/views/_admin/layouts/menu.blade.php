<ul class="menu-list flex-grow-1 mt-3">
    <li>
        <a class="m-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            href="{{ route('admin.dashboard') }}">
            <i class="ri-home-4-line fs-5" style="margin-top: -5px; margin-right: 10px;"></i>
            <span>Beranda</span>
        </a>
    </li>

    <li>
        <a class="m-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}"
            href="{{ route('admin.employees.index') }}">
            <i class="ri-user-3-line fs-5" style="margin-top: -5px; margin-right: 10px;"></i>
            <span>Karyawan</span>
        </a>
    </li>

    <li>
        <a class="m-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.attendance.index') ? 'active' : '' }}"
            href="{{ route('admin.attendance.index') }}">
            <i class="ri-calendar-check-line fs-5" style="margin-top: -5px; margin-right: 10px;"></i>
            <span>Absensi</span>
        </a>
    </li>

    <li>
        <a class="m-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.leaves.index') ? 'active' : '' }}"
            href="{{ route('admin.leaves.index') }}">
            <i class="ri-flight-takeoff-line fs-5" style="margin-top: -5px; margin-right: 10px;"></i>
            <span>Pengajuan Cuti</span>
        </a>
    </li>

    <li>
        <a class="m-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.work-schedules.index') ? 'active' : '' }}"
            href="{{ route('admin.work-schedules.index') }}">
            <i class="ri-time-line fs-5" style="margin-top: -5px; margin-right: 10px;"></i>
            <span>Jadwal Kerja</span>
        </a>
    </li>

    <li>
        <a class="m-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.holidays.index') ? 'active' : '' }}"
            href="{{ route('admin.holidays.index') }}">
            <i class="ri-calendar-event-line fs-5" style="margin-top: -5px; margin-right: 10px;"></i>
            <span>Hari Libur</span>
        </a>
    </li>

    <li>
        <a class="m-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.site-settings.edit') ? 'active' : '' }}"
            href="{{ route('admin.site-settings.edit') }}">
            <i class="ri-settings-3-line fs-5" style="margin-top: -5px; margin-right: 10px;"></i>
            <span>Pengaturan Sistem</span>
        </a>
    </li>

    <li>
        <a class="m-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}"
            href="{{ route('admin.profile.edit') }}">
            <i class="ri-user-settings-line fs-5" style="margin-top: -5px; margin-right: 10px;"></i>
            <span>Pengaturan Profil</span>
        </a>
    </li>

</ul>
