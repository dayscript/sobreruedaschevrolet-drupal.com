@if (session()->has('flash_notification.message'))
    @if (session()->has('flash_notification.overlay'))
        @include('flash::modal', [
            'modalClass' => 'flash-modal', 
            'title'      => session('flash_notification.title'), 
            'body'       => session('flash_notification.message')
        ])
    @else
        <script>
            $(document).ready(function () {
                var options = {}
                var message = "{!! Session::get('flash_notification.message') !!}";
                var title = "{!! Session::get('flash_notification.title') !!}";
                var type = "{{ session('flash_notification.level') }}";

                switch (type) {
                    case "success":
                        toastr.success(message, title, options);
                        break;
                    case "warning":
                        toastr.warning(message, title, options);
                        break;
                    case "error":
                    case "danger":
                        toastr.error(message, title, options);
                        break;
                    case "info":
                        toastr.info(message, title, options);
                        break;
                    default:
                        toastr.info(message, title, options);
                }
            });
        </script>
        {{--<div class="alert alert-{{ session('flash_notification.level') }}">--}}
        {{--<button type="button" --}}
        {{--class="close" --}}
        {{--data-dismiss="alert" --}}
        {{--aria-hidden="true">&times;</button>--}}

        {{--{!! session('flash_notification.message') !!}--}}
        {{--</div>--}}
    @endif
@elseif (count($errors) > 0)

    <script>
        $(document).ready(function () {
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', '', {});
            @endforeach
        });
    </script>

@endif

