<footer class="footer">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">

                @if (!empty(config('dash.copyright')))
                    <a href="{{ config('dash.copyright.link') }}" class="font-weight-bold"
                        target="_blank">{!! config('dash.copyright.copyright_text') !!}</a>
                @else
                    @php
                        $dash_current_version_from_composer_file = json_decode(
                            file_get_contents(base_path('dash/composer.json')),
                        );
                        if (
                            !empty($dash_current_version_from_composer_file) &&
                            !empty($dash_current_version_from_composer_file->version)
                        ) {
                            $dash_current_version_footer = $dash_current_version_from_composer_file->version;
                        } else {
                            $dash_current_version_footer = substr(
                                Composer\InstalledVersions::getVersion('phpanonymous/dash'),
                                0,
                                -2,
                            );
                        }
                    @endphp
                    Copyright © {{ date('Y') }},
                    Dashboard <span class="fa fa-heart text-danger"></span> by
                    <a href="https://phpdash.com" class="font-weight-bold" target="_blank">Dash V:
                        {{ $dash_current_version_footer }} , phpdash.com
                    </a>
                @endif
            </div>
        </div>
    </div>
</footer>
