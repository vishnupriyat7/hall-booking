<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('visitor_mangement_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/people*") ? "menu-open" : "" }} {{ request()->is("admin/visitor-passes*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/people*") ? "active" : "" }} {{ request()->is("admin/visitor-passes*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-address-book">

                            </i>
                            <p>
                                {{ trans('cruds.visitorMangement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('person_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.people.index") }}" class="nav-link {{ request()->is("admin/people") || request()->is("admin/people/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-address-book">

                                        </i>
                                        <p>
                                            {{ trans('cruds.person.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('visitor_pass_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.visitor-passes.index") }}" class="nav-link {{ request()->is("admin/visitor-passes") || request()->is("admin/visitor-passes/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.visitorPass.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('database_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/id-types*") ? "menu-open" : "" }} {{ request()->is("admin/recommending-office-categories*") ? "menu-open" : "" }} {{ request()->is("admin/recommending-offices*") ? "menu-open" : "" }} {{ request()->is("admin/visiting-office-categories*") ? "menu-open" : "" }} {{ request()->is("admin/visiting-offices*") ? "menu-open" : "" }} {{ request()->is("admin/members*") ? "menu-open" : "" }} {{ request()->is("admin/self-registrations*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/id-types*") ? "active" : "" }} {{ request()->is("admin/recommending-office-categories*") ? "active" : "" }} {{ request()->is("admin/recommending-offices*") ? "active" : "" }} {{ request()->is("admin/visiting-office-categories*") ? "active" : "" }} {{ request()->is("admin/visiting-offices*") ? "active" : "" }} {{ request()->is("admin/members*") ? "active" : "" }} {{ request()->is("admin/self-registrations*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.database.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('id_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.id-types.index") }}" class="nav-link {{ request()->is("admin/id-types") || request()->is("admin/id-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.idType.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('recommending_office_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.recommending-office-categories.index") }}" class="nav-link {{ request()->is("admin/recommending-office-categories") || request()->is("admin/recommending-office-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.recommendingOfficeCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('recommending_office_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.recommending-offices.index") }}" class="nav-link {{ request()->is("admin/recommending-offices") || request()->is("admin/recommending-offices/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.recommendingOffice.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('visiting_office_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.visiting-office-categories.index") }}" class="nav-link {{ request()->is("admin/visiting-office-categories") || request()->is("admin/visiting-office-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.visitingOfficeCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('visiting_office_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.visiting-offices.index") }}" class="nav-link {{ request()->is("admin/visiting-offices") || request()->is("admin/visiting-offices/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.visitingOffice.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('member_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.members.index") }}" class="nav-link {{ request()->is("admin/members") || request()->is("admin/members/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.member.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('self_registration_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.self-registrations.index") }}" class="nav-link {{ request()->is("admin/self-registrations") || request()->is("admin/self-registrations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-address-book">

                                        </i>
                                        <p>
                                            {{ trans('cruds.selfRegistration.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>