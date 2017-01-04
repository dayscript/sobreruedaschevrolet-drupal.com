<div class="widget" id="widgetUserList">
    <div class="widget-header cover overlay">
        <img class="cover-image height-200" src="{{ asset('images/dashboard-header.jpg') }}"
             alt="..."/>
        <div class="overlay-panel vertical-align overlay-background{{ isset($counter)?$counter:'' }}">
            <div class="vertical-align-middle">
                <a class="avatar avatar-100 pull-left margin-right-20" href="javascript:void(0)">
                    <img src="{{ asset($us->avatar) }}" alt="">
                </a>
                <div class="pull-left">
                    <div class="font-size-20">{{ $us->name }}</div>
                    <p class="margin-bottom-20 text-nowrap">
                        <span class="text-break">{{ $us->email }}</span>
                    </p>
                    <div class="text-nowrap font-size-18">
                        <small>{{ implode(', ',$us->roles->pluck('name')->toArray()) }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="widget-content padding-horizontal-20">
        <ul class="list-group list-group-full list-group-dividered">
            @forelse($us->stats()->take(2)->get() as $stat)
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <a class="avatar avatar-lg" href="javascript:void(0)">
                                <img class="img-responsive" src="{{ asset( $us->avatar ) }}" alt="...">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $stat->label() }}</h4>
                            <small>{!! $stat->description() !!}</small>
                        </div>
                    </div>
                </li>
            @empty
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <a class="avatar avatar-lg" href="javascript:void(0)">
                                <img class="img-responsive" src="{{ asset( $us->avatar ) }}" alt="...">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Sin actividad</h4>
                            <small>Este usuario no tiene actividad en el sistema</small>
                        </div>
                    </div>
                </li>
            @endforelse

        </ul>
        <a href="/users/{{ $us->id }}" type="button" class="btn-raised btn btn-primary btn-floating">
            <i class="icon md-plus" aria-hidden="true"></i>
        </a>
    </div>
</div>
