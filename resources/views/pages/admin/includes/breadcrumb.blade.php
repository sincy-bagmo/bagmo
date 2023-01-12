@if (! empty($breadcrumbs))
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">{{ $title }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        @foreach ($breadcrumbs as $key => $url)
                            @if ('home' != $key)
                                @if ($loop->first)
                                    <li class="breadcrumb-item"><a href="{{ url($url) }}">{{ ucfirst(str_replace(['_', '-'], ' ', $key))  }}</a></li>
                                @elseif(! is_numeric($key))
                                    <li class="breadcrumb-item active"><a href="{{ (! $loop->last)? url($url) : 'javascript:;' }}">{{ ucfirst(str_replace(['_', '-'], ' ', $key))  }}</a></li>
                                @endif
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endif
