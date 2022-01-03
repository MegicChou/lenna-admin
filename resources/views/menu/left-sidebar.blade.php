<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="menu">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    @foreach($menu as $itemMenu)
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="{{ $itemMenu->icon }}"></i>
            <p>
                @if (config('admin.localization', false))
                    {{ $itemMenu->lang_name }}
                @else
                    {{ $itemMenu->name }}
                @endif
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @foreach($itemMenu->item as $item)
            <li class="nav-item">
                <a href="{{ $item->url }}" class="nav-link">
                    <i class="{{ $item->icon }}"></i>
                    <p>
                        @if (config('admin.localization', false))
                            {{ $item->lang_name }}
                        @else
                            {{ $item->name }}
                        @endif
                    </p>
                </a>
            </li>
            @endforeach
        </ul>
    </li>
    @endforeach
</ul>
