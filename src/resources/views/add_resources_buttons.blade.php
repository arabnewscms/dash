<li class="nav-item dropdown px-2 d-flex align-items-center">
  <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa-solid fa-square-plus fa-2x cursor-pointer"></i>
  </a>
  <ul class="dropdown-menu {{ app()->getLocale()!='ar'?'dropdown-menu-end':'' }} px-2 py-3 me-sm-n4" style="max-height: 300px;overflow-y: auto;" aria-labelledby="dropdownMenuButton">
    @foreach($loadInNavigationMenu as $groups)
    @foreach($groups as $group)
        @if(isset($group['displayInMenu']) && $group['displayInMenu'])
           
        <li class="mb-2">
            <a class="dropdown-item border-radius-md" href="{{ url($DASHBOARD_PATH.'/resource/'.$group['resourceName']) }}/new">
              <div class="d-flex py-1">
                <div class="d-flex flex-column justify-content-center">
                  <h6 class="text-sm font-weight-normal mb-1">
                  <span class="font-weight-bold">
                   <i class="fa fa-plus"></i> {{ $group['customName']??ucfirst($group['group']) }}
                  </span>
                  </h6>
                </div>
              </div>
            </a>
          </li>
       
        @elseif(!isset($group['displayInMenu']))
            @foreach($group as $subgroup)
                @if(isset($subgroups['displayInMenu']) && $subgroups['displayInMenu'])
                <li class="mb-2">
                    <a class="dropdown-item border-radius-md" href="{{ url($DASHBOARD_PATH.'/resource/'.$subgroups['resourceName']) }}/new">
                      <div class="d-flex py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">
                           <i class="fa fa-plus"></i> {{ $subgroups['customName']??ucfirst($subgroups['group']) }}
                          </span>
                          </h6>
                        </div>
                      </div>
                    </a>
                  </li>
                @endif
            @endforeach
        @endif
    @endforeach
@endforeach

    <?php $x = 0;?>
{{--  @foreach($loadInNavigationMenu as $groups)
    @foreach($groups as $group)
    @if($group['displayInMenu'])
    <li class="mb-2">
      <a class="dropdown-item border-radius-md" href="{{ url($DASHBOARD_PATH.'/resource/'.$group['resourceName']) }}/new">
        <div class="d-flex py-1">
          <div class="d-flex flex-column justify-content-center">
            <h6 class="text-sm font-weight-normal mb-1">
            <span class="font-weight-bold">
             <i class="fa fa-plus"></i> {{ $group['customName']??ucfirst($group['group']) }}
            </span>
            </h6>
          </div>
        </div>
      </a>
    </li>

    @endif
    @endforeach
<?php $x = 0;?>
    @endforeach  --}}
  </ul>
</li>
{{--  <li class="nav-item">
  <a class="nav-link {{ request()->segment(3) == $group['resourceName']?'active':'' }}" href="{{ url($DASHBOARD_PATH.'/resource/'.$group['resourceName']) }}">
    <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
    </div>
    <span class="nav-link-text me-1 {{ app()->getLocale()=='ar'?'ps-2':'px-2' }}">
      {{ $group['customName']??ucfirst($group['group']) }}
    </span>
  </a>
</li> --}}
