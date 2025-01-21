@if (config('dash.CHECK_VERSION_MODE', 'off') == 'on')
    <!-- Start::header-element -->
    <div class="header-element header-search">
        <!-- Start::header-link -->
        <a href="javascript:void(0);" class="header-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
            aria-controls="offcanvasBottom">
            {{-- fa-2x fa-shake text-danger  --}}
            <i class="fa-solid fa-wrench"></i>
        </a>
        <!-- End::header-link -->
    </div>
    <!-- End::header-element -->

    @push('js')
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
            aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel"> Dash Update Checker <i
                        class="fa checkericon fa-refresh"></i></h5>


                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body small">
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-block dashchecker_start btn-primary my-4 fs-12">Check <i
                                class="fa fa-refresh"></i></button>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div>
                                <h5 class="title mt-0 mb-1 ms-2 font-weight-bold tx-12"></h5>

                                    <a href="https://phpdash.com" target="_blank">
                                        <img src="{{ url('/dashboard/assets/dash/images/dash/PNG/black.png') }}"
                                            class="py-2 text-center mx-auto phpdashlogo" style="width:50px;height:50px"
                                            alt="img">
                                    </a>

                                <a class="btn btn-block text-dark btn-outline fs-12" href="https://phpdash.com/updates"
                                    target="_blank">See history <i class="fa fa-history"></i></a>
                                <p class="subtext dashmsg mt-0 mb-0 ms-2 fs-13 text-center my-2">
                                </p>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    @endpush

    {{--
<div class="Annoucement_card">
    <div class="text-center">
        <div>
            <h5 class="title mt-0 mb-1 ms-2 font-weight-bold tx-12">Dash Update Checker <i class="fa checkericon fa-refresh"></i></h5>
            <div class="bg-layer py-4">
                <a href="https://phpdash.com" target="_blank">
                    <img src="{{ url('/dashboard/assets/img/dash/PNG/blue.png') }}" class="py-2 text-center mx-auto phpdashlogo" style="width:100px;height:100px" alt="img">
                </a>
            </div>
            <p class="subtext dashmsg mt-0 mb-0 ms-2 fs-13 text-center my-2">

            </p>
        </div>
    </div>
    <button class="btn btn-block dashchecker_start btn-primary my-4 fs-12">Check <i class="fa fa-refresh"></i></button>
    <a class="btn btn-block btn-outline fs-12" href="https://phpdash.com/updates" target="_blank">See history <i class="fa fa-history"></i></a>
</div> --}}
    @php
        $dash_current_version_from_composer_file = json_decode(file_get_contents(base_path('dash/composer.json')));
        if (
            !empty($dash_current_version_from_composer_file) &&
            !empty($dash_current_version_from_composer_file->version)
        ) {
            $dash_current_version = $dash_current_version_from_composer_file->version;
        } else {
            $dash_current_version = substr(Composer\InstalledVersions::getVersion('phpanonymous/dash'), 0, -2);
        }
    @endphp
    <script>
        $(document).ready(function() {



            $(document).on('click', '.dashchecker_start', function() {


                @if (!empty(config('dash.DASH_ACCESS_KEY')))

                    $.ajax({
                        url: "https://phpdash.com/api/gui/check/update",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            access_key: "{{ config('dash.DASH_ACCESS_KEY') }}",
                            current_version: "{{ $dash_current_version }}",
                            lang: "{{ request('lang') }}"
                        },
                        beforeSend: function(request) {

                            $('.dashmsg').html(
                                'connecting to server <i class="fa-solid fa-network-wired fa-fade"></i> ...'
                            );
                            $('.dashchecker_start').prop('disabled', true).html(
                                `Checking <i class="fa fa-refresh fa-spin"></i>`);
                            $('.checkericon').addClass('fa-spin');
                            $('.phpdashlogo').addClass('fa-flip');
                        },
                        error: function(jqXHR) {
                            if (jqXHR.status == 0) {
                                $('.dashmsg').html(
                                    'faild to connect to the server <i class="fa-solid fa-person-falling-burst text-danger fa-shake"></i> ...'
                                );
                                $('.dashchecker_start').prop('disabled', false).html(
                                    `Check <i class="fa fa-refresh"></i>`);
                                $('.checkericon').removeClass('fa-spin');
                                $('.phpdashlogo').removeClass('fa-flip');
                            }
                        },
                        success: function(data) {
                            var result = data?.result;
                            if (!result.status) {
                                $('.dashmsg').html(result.message);
                                $('.dashchecker_start').prop('disabled', true).html(
                                    `Check <i class="fa fa-refresh"></i>`);
                                $('.checkericon').removeClass('fa-spin');
                                $('.phpdashlogo').removeClass('fa-flip');
                            } else if (result.status) {
                                $('.dashmsg').html(result.message +
                                    ' <i class="fa fa-refresh fa-spin"></i>');
                                $('.dashchecker_start').removeClass('btn-primary').addClass(
                                    'btn-success').html(
                                    `updating <i class="fa-solid fa-cloud-arrow-down fa-fade"></i>`
                                );
                                $('.checkericon').addClass('fa-spin');
                                $('.phpdashlogo').addClass('fa-flip');
                                $.ajax({
                                    url: '{{ dash('gui/update/now') }}',
                                    dataType: 'json',
                                    type: 'post',
                                    data: {
                                        url: result.url,
                                        _token: '{{ csrf_token() }}',
                                        lang: "{{ request('lang') }}"
                                    },
                                    success: function(data) {
                                        $('.checkericon').removeClass('fa-spin');
                                        $('.phpdashlogo').removeClass('fa-flip');
                                        if (data.status == true) {
                                            $('.dashmsg').html(
                                                'now you have a latest update <i class="fa-solid fa-child-reaching fa-bounce text-success"></i> <br/> run command: $ > composer update '
                                            );
                                            $('.dashchecker_start').prop('disabled',
                                                false).removeClass(
                                                'btn-success').addClass(
                                                'btn-primary').html(
                                                `Check <i class="fa fa-refresh"></i>`
                                            );
                                            setTimeout(function() {
                                                location.reload();
                                            }, 3000);
                                        } else {
                                            $('.dashmsg').html(
                                                'we are sorry something happened please try again <i class="fa-solid fa-face-sad-tear fa-shake fa-2x text-warning"></i>'
                                            );
                                            $('.dashchecker_start').prop('disabled',
                                                false).removeClass(
                                                'btn-success').addClass(
                                                'btn-primary').html(
                                                `Check <i class="fa fa-refresh"></i>`
                                            );
                                        }
                                    }
                                });
                            }
                        }
                    });
                @else
                    toastr.error('you need to add DASH_ACCESS_KEY in your dash config first.');
                @endif




            });
        });
    </script>
@endif
