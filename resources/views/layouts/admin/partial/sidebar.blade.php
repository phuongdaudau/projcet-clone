<div class="navbar nav_title" style="border: 0;">
    <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span> Dashboard </span></a>
</div>

<div class="clearfix"></div>
<div class="profile clearfix">
    <div class="profile_info">
        <span>Welcome,</span>
        <h2> {{ auth()->user()->name ??  'Admin'}} </h2>
    </div>
</div>
<br />
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.product.index') }}">List Product</a></li>
                </ul>
            </li>
            {{-- <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="form.html">General Form</a></li>
                    <li><a href="form_advanced.html">Advanced Components</a></li>
                    <li><a href="form_validation.html">Form Validation</a></li>
                    <li><a href="form_wizards.html">Form Wizard</a></li>
                    <li><a href="form_upload.html">Form Upload</a></li>
                    <li><a href="form_buttons.html">Form Buttons</a></li>
                </ul>
            </li> --}}
        </ul>
    </div>
</div>
