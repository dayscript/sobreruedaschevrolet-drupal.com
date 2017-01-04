@extends('layouts.app',['classes'=>'app-projects app-taskboard'])

@section('title') Programas @parent @endsection

@section('styles')
        <!-- Stylesheets -->
<link rel="stylesheet" href="/remark/material/global/css/bootstrap.min.css">
<link rel="stylesheet" href="/remark/material/global/css/bootstrap-extend.min.css">
<link rel="stylesheet" href="/remark/material/base/assets/css/site.min.css">
<!-- Plugins -->
<link rel="stylesheet" href="/remark/material/global/vendor/animsition/animsition.css">
<link rel="stylesheet" href="/remark/material/global/vendor/asscrollable/asScrollable.css">
<link rel="stylesheet" href="/remark/material/global/vendor/switchery/switchery.css">
<link rel="stylesheet" href="/remark/material/global/vendor/intro-js/introjs.css">
<link rel="stylesheet" href="/remark/material/global/vendor/slidepanel/slidePanel.css">
<link rel="stylesheet" href="/remark/material/global/vendor/flag-icon-css/flag-icon.css">
<link rel="stylesheet" href="/remark/material/global/vendor/waves/waves.css">
<link rel="stylesheet" href="/remark/material/global/vendor/jquery-selective/jquery-selective.css">
<link rel="stylesheet" href="/remark/material/global/vendor/dropify/dropify.css">
<link rel="stylesheet" href="/remark/material/base/assets/examples/css/apps/projects.css">
<link rel="stylesheet" href="/remark/material/base/assets/examples/css/apps/taskboard.css">
<link rel="stylesheet" href="/remark/material/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
<link rel="stylesheet" href="/remark/material/global/vendor/bootstrap-tokenfield/bootstrap-tokenfield.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/basic.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">



<!-- Fonts -->
<link rel="stylesheet" href="/remark/material/global/fonts/material-design/material-design.min.css">
<link rel="stylesheet" href="/remark/material/global/fonts/brand-icons/brand-icons.min.css">
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
<!--[if lt IE 9]>
<script src="/remark/material/global/vendor/html5shiv/html5shiv.min.js"></script>
<![endif]-->
<!--[if lt IE 10]>
<script src="/remark/material/global/vendor/media-match/media.match.min.js"></script>
<script src="/remark/material/global/vendor/respond/respond.min.js"></script>
<![endif]-->
<!-- Scripts -->
<script src="/remark/material/global/vendor/modernizr/modernizr.js"></script>
<script src="/remark/material/global/vendor/breakpoints/breakpoints.js"></script>
<script>
    Breakpoints();
</script>
@endsection

@section('scripts')
        <!-- Core  -->
<script src="/remark/material/global/vendor/jquery/jquery.js"></script>
<script src="/remark/material/global/vendor/bootstrap/bootstrap.js"></script>
<script src="/remark/material/global/vendor/animsition/animsition.js"></script>
<script src="/remark/material/global/vendor/asscroll/jquery-asScroll.js"></script>
<script src="/remark/material/global/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="/remark/material/global/vendor/asscrollable/jquery.asScrollable.all.js"></script>
<script src="/remark/material/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
<script src="/remark/material/global/vendor/waves/waves.js"></script>
<!-- Plugins -->
<script src="/remark/material/global/vendor/switchery/switchery.min.js"></script>
<script src="/remark/material/global/vendor/intro-js/intro.js"></script>
<script src="/remark/material/global/vendor/screenfull/screenfull.js"></script>
<script src="/remark/material/global/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="/remark/material/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>
<script src="/remark/material/global/vendor/jquery-selective/jquery-selective.min.js"></script>
<script src="/remark/material/global/vendor/bootstrap-tokenfield/bootstrap-tokenfield.min.js"></script>
<script src="/remark/material/global/vendor/bootbox/bootbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>

<!-- Scripts -->
<script src="/remark/material/global/js/core.js"></script>
<script src="/remark/material/base/assets/js/site.js"></script>
<script src="/remark/material/base/assets/js/sections/menu.js"></script>
<script src="/remark/material/base/assets/js/sections/menubar.js"></script>
<script src="/remark/material/base/assets/js/sections/gridmenu.js"></script>
<script src="/remark/material/base/assets/js/sections/sidebar.js"></script>
<script src="/remark/material/global/js/configs/config-colors.js"></script>
<script src="/remark/material/base/assets/js/configs/config-tour.js"></script>
<script src="/remark/material/global/js/components/asscrollable.js"></script>
<script src="/remark/material/global/js/components/animsition.js"></script>
<script src="/remark/material/global/js/components/slidepanel.js"></script>
<script src="/remark/material/global/js/components/switchery.js"></script>
<script src="/remark/material/global/js/components/tabs.js"></script>
<script src="/remark/material/global/js/components/animate-list.js"></script>
<script src="/remark/material/global/js/components/bootbox.js"></script>
<script src="/remark/material/global/js/components/jquery-placeholder.js"></script>
<script src="/remark/material/global/js/components/material.js"></script>
<script src="/remark/material/global/js/components/bootstrap-tokenfield.js"></script>
{{--<script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script src="/remark/material/base/assets/js/app.js"></script>
{{--<script src="/remark/material/global/js/components/dropify.js"></script>--}}

<script>
    /*!
     * remark (http://getbootstrapadmin.com/remark)
     * Copyright 2015 amazingsurge
     * Licensed under the Themeforest Standard Licenses
     */
    (function (document, window, $) {
        'use strict';

        window.AppProjects = App.extend({
            handleSelective: function () {
                var members = [{
                            id: 'uid_1',
                            name: 'Herman Beck',
                            img: '/remark/material/global/portraits/1.jpg'
                        }, {
                            id: 'uid_2',
                            name: 'Mary Adams',
                            img: '/remark/material/global/portraits/2.jpg'
                        }, {
                            id: 'uid_3',
                            name: 'Caleb Richards',
                            img: '/remark/material/global/portraits/3.jpg'
                        }, {
                            id: 'uid_4',
                            name: 'June Lane',
                            img: '/remark/material/global/portraits/4.jpg'
                        }],
                        selected = [{
                            id: 'uid_1',
                            name: 'Herman Beck',
                            img: '/remark/material/global/portraits/1.jpg'
                        }, {
                            id: 'uid_2',
                            name: 'Caleb Richards',
                            img: '/remark/material/global/portraits/2.jpg'
                        }];

                $('[data-plugin="jquery-selective"]').selective({
                    namespace: 'addMember',
                    local: members,
                    selected: selected,
                    buildFromHtml: false,
                    tpl: {
                        optionValue: function (data) {
                            return data.id;
                        },
                        frame: function () {
                            return '<div class="' + this.namespace + '">' +
                                    this.options.tpl.items.call(this) +
                                    '<div class="' + this.namespace + '-trigger">' +
                                    this.options.tpl.triggerButton.call(this) +
                                    '<div class="' + this.namespace + '-trigger-dropdown">' +
                                    this.options.tpl.list.call(this) +
                                    '</div>' +
                                    '</div>' +
                                    '</div>'
                        },
                        triggerButton: function () {
                            return '<div class="' + this.namespace + '-trigger-button"><i class="md-plus"></i></div>';
                        },
                        listItem: function (data) {
                            return '<li class="' + this.namespace + '-list-item"><img class="avatar" src="' + data.img + '">' + data.name + '</li>';
                        },
                        item: function (data) {
                            return '<li class="' + this.namespace + '-item"><img class="avatar" src="' + data.img + '">' +
                                    this.options.tpl.itemRemove.call(this) +
                                    '</li>';
                        },
                        itemRemove: function () {
                            return '<span class="' + this.namespace + '-remove"><i class="md-minus-circle"></i></span>';
                        },
                        option: function (data) {
                            return '<option value="' + this.options.tpl.optionValue.call(this, data) + '">' + data.name + '</option>';
                        }
                    }
                });
            },

            handleProject: function () {
                $(document).on('click', '[data-tag=project-delete]', function (e) {
                    bootbox.dialog({
                        message: "¿Estás seguro que quieres eliminar este programa?",
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'btn-primary'
                            },
                            success: {
                                label: "Eliminar",
                                className: "btn-primary",
                                callback: function () {
                                    var id = $(e.target).data('id');
                                    $.post('/programs/' + id, {'_token': '{{ csrf_token() }}', '_method': 'DELETE'}, function (data) {
                                        $(e.target).closest('li').remove();
                                        toastr.success('Programa eliminado!', '', {});
                                    });
                                }
                            }
                        }
                    });
                });
            },

            run: function (next) {
                this.handleSelective();
                this.handleProject();

                next();
            }
        });

        $(document).ready(function () {
            AppProjects.run();
        });
    })(document, window, jQuery);

</script>


@endsection

@section('content')
    @include('navbar.complete')
    @include('menubar.complete')
    <div class="page animsition">
        <div class="page-header">
            <h1 class="page-title">Programas</h1>
            <div class="page-header-actions">
                <form>
                    <div class="input-search input-search-dark">
                        <i class="input-search-icon md-search" aria-hidden="true"></i>
                        <input type="text" class="form-control" name="" placeholder="Search...">
                    </div>
                </form>
            </div>
        </div>
        <div class="page-content">
            <div class="projects-sort">
                <span class="projects-sort-label">Ordenar por : </span>
                <div class="inline-block dropdown">
          <span class="dropdown-toggle" id="projects-menu" data-toggle="dropdown" aria-expanded="false"
                role="button">
            Nombre
            <i class="icon md-chevron-down" aria-hidden="true"></i>
          </span>
                    <ul class="dropdown-menu animation-scale-up animation-top-left animation-duration-250"
                        aria-labelledby="projects-menu" role="menu">
                        <li role="presentation">
                            <a href="javascript:void(0)" role="menuitem" tabindex="-1">Fecha</a>
                        </li>
                        <li class="active" role="presentation">
                            <a href="javascript:void(0)" role="menuitem" tabindex="-1">Nombre</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="projects-wrap">
                <ul class="blocks blocks-100 blocks-xlg-5 blocks-md-4 blocks-sm-3 blocks-xs-2"
                    data-plugin="animateList" data-child=">li">
                    @foreach($programs as $program)
                        <li>
                            <div class="panel">
                                <div class=""><h5>{{ $program->name }}<br>
                                        <small class="time">{{ $program->created_at }}</small></h5></div>

                                <figure class="overlay overlay-hover animation-hover">
                                    @if( ($medias = $program->getMedia()) && $medias->count() > 0)
                                        <img class="caption-figure" src="{{ $medias->first()->getUrl() }}">

                                    @else
                                        <img class="caption-figure" src="/remark/material/global/photos/placeholder.png">
                                    @endif


                                    <figcaption class="overlay-panel overlay-background overlay-fade text-center vertical-align">
                                        <div class="btn-group btn-group-flat">
                                            <button type="button" class="btn btn-icon btn-pure btn-danger" title="Eliminar"
                                                    data-tag="project-delete" data-id="{{ $program->id }}"><i data-id="{{ $program->id }}"
                                                                                                              class="icon md-delete"
                                                                                                              aria-hidden="true"></i></button>
                                        </div>
                                        <button data-toggle="slidePanel" data-url="{{ url('programs/'.$program->id . '/edit') }}" type="button"
                                                class="btn btn-primary project-button">Editar Programa
                                        </button>
                                    </figcaption>
                                </figure>
                                <div>{{ $program->description }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <nav>
                {{ $programs->links() }}
            </nav>
        </div>
    </div>
    <!-- Site Action -->
    <button class="site-action btn-raised btn btn-success btn-floating" data-target="#addProjectForm"
            data-toggle="modal" type="button">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
    <!-- End Site Action -->
    <!-- Add Project Form -->
    <div class="modal fade" id="addProjectForm" aria-hidden="true" aria-labelledby="addProjectForm"
         role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Crear Nuevo Programa</h4>
                </div>
                <form action="/programs" method="post" role="form">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group form-material empty floating">
                            <input type="text" class="form-control" name="name" />
                            <div class="hint">Escriba un nombre para este programa</div>
                            <label class="floating-label margin-bottom-15" for="name">Nombre del programa</label>
                        </div>
                        <div class="form-group form-material floating">
                            <textarea class="form-control maxlength-textarea mb-sm"  rows="3" name="description" maxlength="225" data-plugin="maxlength"></textarea>
                            <div class="hint">Descripción corta del objetivo de este programa.</div>
                            <label class="floating-label margin-bottom-15" for="description">Descripción</label>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label class="control-label margin-bottom-15" for="name">Escoja administradores para este programa:</label>--}}
                            {{--<select multiple="multiple" data-plugin="jquery-selective"></select>--}}
                        {{--</div>--}}

                    </div>
                    <div class="modal-footer text-right">
                        <button class="btn btn-primary" type="submit">Crear</button>
                        <a class="btn btn-sm btn-primary btn-pure" data-dismiss="modal" href="javascript:void(0)">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add Project Form -->
    @include('footer.complete')
@endsection
