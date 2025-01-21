<script src="{{ url('dashboard/assets/akit/static/js/app.js') }}"></script>
<!--   Core JS Files   -->
{{--  <script src="{{ url('dashboard/assets/js/core/popper.min.js') }}"></script>
<script src="{{ url('dashboard/assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ url('dashboard/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ url('dashboard/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>  --}}
<script>
    @if (!empty(request('relationField')))
        @foreach (request('relationField') as $rk => $rv)
            $('.{{ $rk }}').val('{{ $rv }}').trigger('change');
        @endforeach
    @endif
</script>

{{--  <script src="{{ url('dashboard/assets/js/dashboard_functions.js') }}"></script>  --}}
<script src="{{ url('dashboard/assets/js/jquery-3.5.1.js') }}"></script>

@if (app()->getLocale() == 'ar')
    <style type="text/css">
        .dt-buttons {
            display: none;
        }
    </style>
@endif

<script src="{{ url('dashboard/assets/select2-4-1-0/js/select2_4.0.13.min.js') }}" defer></script>



    {{--  Settings Start  --}}
    <div class="settings js-settings">
        <div class="settings-toggle js-settings-toggle"> <i class="align-middle" data-feather="sliders"></i> </div>
        <div class="settings-panel">
            <div class="settings-content">
                <div class="settings-title d-flex align-items-center">
                    <button type="button" class="btn-close float-right js-settings-toggle" aria-label="Close"></button>
                    <h4 class="mb-0 ms-2 d-inline-block">
                        Theme Settings
                    </h4>

                </div>

                <div class="settings-body">
                    <div class="alert alert-primary" role="alert">
                        <div class="alert-message"> <strong>
                            Hey there!</strong> Choose the color scheme, sidebar and layout
                            that best fits your project needs.
                        </div>
                    </div>
                    <div class="mb-3">
                        <span class="d-block fw-bold">Color scheme</span> <span class="d-block text-muted mb-2">The perfect
                            color mode for your app.</span>
                        <div class="row g-0 text-center mx-n1 mb-2">

                            <div class="col">

                                <label class="mx-1 d-block mb-1">
                                    <input class="settings-scheme-label" type="radio" name="theme" value="default" />
                                    <div class="settings-scheme">

                                        <div class="settings-scheme-theme settings-scheme-theme-default"></div>

                                    </div>

                                </label>
                                Default
                            </div>

                            <div class="col">

                                <label class="mx-1 d-block mb-1">
                                    <input class="settings-scheme-label" type="radio" name="theme" value="colored" />
                                    <div class="settings-scheme">

                                        <div class="settings-scheme-theme settings-scheme-theme-colored"></div>

                                    </div>

                                </label>
                                Colored
                            </div>
                        </div>
                        <div class="row g-0 text-center mx-n1">
                            <div class="col">

                                <label class="mx-1 d-block mb-1">
                                    <input class="settings-scheme-label" type="radio" name="theme" value="dark" />
                                    <div class="settings-scheme">
                                        <div class="settings-scheme-theme settings-scheme-theme-dark"></div>
                                    </div>
                                </label>
                                Dark
                            </div>
                            <div class="col">
                                <label class="mx-1 d-block mb-1">
                                    <input class="settings-scheme-label" type="radio" name="theme" value="light" />
                                    <div class="settings-scheme">
                                        <div class="settings-scheme-theme settings-scheme-theme-light"></div>
                                    </div>
                                </label>
                                Light
                            </div>
                        </div>

                    </div>

                    <hr />

                    <div class="mb-3">
                        <span class="d-block fw-bold">Sidebar layout</span> <span class="d-block text-muted mb-2">Change the
                            layout of the sidebar.</span>
                        <div>

                            <label>
                                <input class="settings-button-label" type="radio" name="sidebarLayout" value="default" />
                                <div class="settings-button"> Default </div>

                            </label>

                            <label>
                                <input class="settings-button-label" type="radio" name="sidebarLayout" value="compact" />
                                <div class="settings-button"> Compact </div>

                            </label>

                        </div>

                    </div>

                    <hr />

                    <div class="mb-3">
                        <span class="d-block fw-bold">Sidebar position</span> <span class="d-block text-muted mb-2">Toggle
                            the position of the sidebar.</span>
                        <div>

                            <label>
                                <input class="settings-button-label" type="radio" name="sidebarPosition" value="left" />
                                <div class="settings-button"> Left </div>

                            </label>

                            <label>
                                <input class="settings-button-label" type="radio" name="sidebarPosition" value="right" />
                                <div class="settings-button"> Right </div>

                            </label>

                        </div>

                    </div>

                    <hr />

                    <div class="mb-3">
                        <span class="d-block fw-bold">Layout</span> <span class="d-block text-muted mb-2">Toggle container
                            layout system.</span>
                        <div>

                            <label>
                                <input class="settings-button-label" type="radio" name="layout" value="fluid" />
                                <div class="settings-button"> Fluid </div>

                            </label>

                            <label>
                                <input class="settings-button-label" type="radio" name="layout" value="boxed" />
                                <div class="settings-button"> Boxed </div>

                            </label>

                        </div>

                    </div>

                </div>

                <div class="settings-footer">

                </div>
            </div>
        </div>
    </div>

    {{--  Settings End  --}}
