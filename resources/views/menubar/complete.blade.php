<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu">
                    <li class="site-menu-category">General</li>
                    <li class="site-menu-item {{ Request::is('home') || Request::is('/')?'active':'' }}">
                        <a class="animsition-link" href="/">
                            <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
                            <span class="site-menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="site-menu-category">Administrador</li>
                    @can('list',new \App\Manager\Programs\Program)
                    <li class="site-menu-item {{ Request::is('programs')?'active':'' }}">
                        <a class="animsition-link" href="/programs">
                            <i class="site-menu-icon md-apps" aria-hidden="true"></i>
                            <span class="site-menu-title">Programas</span>
                        </a>
                    </li>
                    @endcan
                    <li class="site-menu-item has-sub {{ Request::is('users')
                    || Request::is('users/trashed')
                    || Request::is('users/project*')
                    || Request::is('roles')
                    || Request::is('roles/trashed')
                    || Request::is('roles/project*')
                    || Request::is('permissions')
                    ?'active open':'' }}">
                        <a href="javascript:void(0)">
                            <i class="site-menu-icon md-accounts-list" aria-hidden="true"></i>
                            <span class="site-menu-title">Usuarios</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            @can('list',new App\User)
                            <li class="site-menu-item {{ Request::is('users') || Request::is('users/trashed') || Request::is('users/project*')?'active':'' }}">
                                <a class="animsition-link" href="/users">
                                    <span class="site-menu-title">Usuarios</span>
                                </a>
                            </li>
                            @endcan
                            @can('list',new App\Manager\User\Role)
                            <li class="site-menu-item {{ Request::is('roles') || Request::is('roles/trashed') || Request::is('roles/project*')?'active':'' }}">
                                <a class="animsition-link" href="/roles">
                                    <span class="site-menu-title">Roles</span>
                                </a>
                            </li>
                            @endcan
                            @can('list',new App\Manager\User\Permission)
                            <li class="site-menu-item {{ Request::is('permissions')?'active':'' }}">
                                <a class="animsition-link" href="/permissions">
                                    <span class="site-menu-title">Permisos</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @can('list',new \App\Manager\Challenges\Variable)
                    <li class="site-menu-item {{ Request::is('variables')?'active':'' }}">
                        <a class="animsition-link" href="/variables">
                            <i class="site-menu-icon md-code-setting" aria-hidden="true"></i>
                            <span class="site-menu-title">Variables</span>
                        </a>
                    </li>
                    @endcan
                    @can('list',new \App\Manager\Challenges\Goal)
                    <li class="site-menu-item {{ Request::is('goals')?'active':'' }}">
                        <a class="animsition-link" href="/goals">
                            <i class="site-menu-icon md-check-circle" aria-hidden="true"></i>
                            <span class="site-menu-title">Metas</span>
                        </a>
                    </li>
                    @endcan
                    @can('list',new \App\Manager\Challenges\Challenge)
                    <li class="site-menu-item {{ Request::is('challenges')?'active':'' }}">
                        <a class="animsition-link" href="/challenges">
                            <i class="site-menu-icon md-chart" aria-hidden="true"></i>
                            <span class="site-menu-title">Desafíos</span>
                        </a>
                    </li>
                    @endcan
                    @can('list',new \App\Manager\User\ImportTemplate)
                    <li class="site-menu-item {{ Request::is('import_templates')?'active':'' }}">
                        <a class="animsition-link" href="/import_templates">
                            <i class="site-menu-icon md-upload" aria-hidden="true"></i>
                            <span class="site-menu-title">Plantillas de carga</span>
                        </a>
                    </li>
                    @endcan
                    <li class="site-menu-category">Reportes</li>
                    <li class="site-menu-item {{ Request::is('reports/goals*')?'active':'' }}">
                        <a class="animsition-link" href="/reports/goals">
                            <i class=" text-info site-menu-icon md-check-circle" aria-hidden="true"></i>
                            <span class="site-menu-title">Reporte de Metas</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="site-menubar-footer">
        <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip"
           data-original-title="Configuración">
            <span class="icon md-settings" aria-hidden="true"></span>
        </a>
        <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Bloquear">
            <span class="icon md-eye-off" aria-hidden="true"></span>
        </a>
        <a href="{{ url('logout') }}" data-placement="top" data-toggle="tooltip" data-original-title="Salir">
            <span class="icon md-power" aria-hidden="true"></span>
        </a>
    </div>
</div>
<div class="site-gridmenu">
    <div>
        <div>
            <ul>
                <li>
                    <a href="apps/mailbox/mailbox.html">
                        <i class="icon md-email"></i>
                        <span>Mailbox</span>
                    </a>
                </li>
                <li>
                    <a href="apps/calendar/calendar.html">
                        <i class="icon md-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </li>
                <li>
                    <a href="apps/contacts/contacts.html">
                        <i class="icon md-account"></i>
                        <span>Contacts</span>
                    </a>
                </li>
                <li>
                    <a href="apps/media/overview.html">
                        <i class="icon md-videocam"></i>
                        <span>Media</span>
                    </a>
                </li>
                <li>
                    <a href="apps/documents/categories.html">
                        <i class="icon md-receipt"></i>
                        <span>Documents</span>
                    </a>
                </li>
                <li>
                    <a href="apps/projects/projects.html">
                        <i class="icon md-image"></i>
                        <span>Project</span>
                    </a>
                </li>
                <li>
                    <a href="apps/forum/forum.html">
                        <i class="icon md-comments"></i>
                        <span>Forum</span>
                    </a>
                </li>
                <li>
                    <a href="index.html">
                        <i class="icon md-view-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
