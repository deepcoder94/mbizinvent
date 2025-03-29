<x-layout>


    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::End Navbar Links-->
            <ul class="navbar-nav ms-auto">
              <!--begin::Navbar Search-->
              <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                  <i class="bi bi-search"></i>
                </a>
              </li>
              <!--end::Navbar Search-->
              <!--begin::Messages Dropdown Menu-->
              <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                  <i class="bi bi-chat-text"></i>
                  <span class="navbar-badge badge text-bg-danger">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                  <a href="#" class="dropdown-item">
                    <!--begin::Message-->
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <img
                          src="assets/img/user1-128x128.jpg"
                          alt="User Avatar"
                          class="img-size-50 rounded-circle me-3"
                        />
                      </div>
                      <div class="flex-grow-1">
                        <h3 class="dropdown-item-title">
                          Brad Diesel
                          <span class="float-end fs-7 text-danger"
                            ><i class="bi bi-star-fill"></i
                          ></span>
                        </h3>
                        <p class="fs-7">Call me whenever you can...</p>
                        <p class="fs-7 text-secondary">
                          <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                        </p>
                      </div>
                    </div>
                    <!--end::Message-->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <!--begin::Message-->
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <img
                          src="assets/img/user8-128x128.jpg"
                          alt="User Avatar"
                          class="img-size-50 rounded-circle me-3"
                        />
                      </div>
                      <div class="flex-grow-1">
                        <h3 class="dropdown-item-title">
                          John Pierce
                          <span class="float-end fs-7 text-secondary">
                            <i class="bi bi-star-fill"></i>
                          </span>
                        </h3>
                        <p class="fs-7">I got your message bro</p>
                        <p class="fs-7 text-secondary">
                          <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                        </p>
                      </div>
                    </div>
                    <!--end::Message-->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <!--begin::Message-->
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <img
                          src="assets/img/user3-128x128.jpg"
                          alt="User Avatar"
                          class="img-size-50 rounded-circle me-3"
                        />
                      </div>
                      <div class="flex-grow-1">
                        <h3 class="dropdown-item-title">
                          Nora Silvester
                          <span class="float-end fs-7 text-warning">
                            <i class="bi bi-star-fill"></i>
                          </span>
                        </h3>
                        <p class="fs-7">The subject goes here</p>
                        <p class="fs-7 text-secondary">
                          <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                        </p>
                      </div>
                    </div>
                    <!--end::Message-->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
              </li>
              <!--end::Messages Dropdown Menu-->
              <!--begin::Notifications Dropdown Menu-->
              <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                  <i class="bi bi-bell-fill"></i>
                  <span class="navbar-badge badge text-bg-warning">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                  <span class="dropdown-item dropdown-header">15 Notifications</span>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <i class="bi bi-envelope me-2"></i> 4 new messages
                    <span class="float-end text-secondary fs-7">3 mins</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <i class="bi bi-people-fill me-2"></i> 8 friend requests
                    <span class="float-end text-secondary fs-7">12 hours</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                    <span class="float-end text-secondary fs-7">2 days</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
                </div>
              </li>
              <!--end::Notifications Dropdown Menu-->
              <!--begin::Fullscreen Toggle-->
              <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                  <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                  <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
              </li>
              <!--end::Fullscreen Toggle-->
              <!--begin::User Menu Dropdown-->
              <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                  <img
                    src="assets/img/user2-160x160.jpg"
                    class="user-image rounded-circle shadow"
                    alt="User Image"
                  />
                  <span class="d-none d-md-inline">Alexander Pierce</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                  <!--begin::User Image-->
                  <li class="user-header text-bg-primary">
                    <img
                      src="assets/img/user2-160x160.jpg"
                      class="rounded-circle shadow"
                      alt="User Image"
                    />
                    <p>
                      Alexander Pierce - Web Developer
                      <small>Member since Nov. 2023</small>
                    </p>
                  </li>
                  <!--end::User Image-->
                  <!--begin::Menu Body-->
                  <li class="user-body">
                    <!--begin::Row-->
                    <div class="row">
                      <div class="col-4 text-center"><a href="#">Followers</a></div>
                      <div class="col-4 text-center"><a href="#">Sales</a></div>
                      <div class="col-4 text-center"><a href="#">Friends</a></div>
                    </div>
                    <!--end::Row-->
                  </li>
                  <!--end::Menu Body-->
                  <!--begin::Menu Footer-->
                  <li class="user-footer">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                    <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
                  </li>
                  <!--end::Menu Footer-->
                </ul>
              </li>
              <!--end::User Menu Dropdown-->
            </ul>
            <!--end::End Navbar Links-->
          </div>
          <!--end::Container-->
        </nav>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
          <!--begin::Sidebar Brand-->
          <div class="sidebar-brand">
            <!--begin::Brand Link-->
            <a href="./index.html" class="brand-link">
              <!--begin::Brand Image-->
              <img
                src="assets/img/AdminLTELogo.png"
                alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow"
              />
              <!--end::Brand Image-->
              <!--begin::Brand Text-->
              <span class="brand-text fw-light">AdminLTE 4</span>
              <!--end::Brand Text-->
            </a>
            <!--end::Brand Link-->
          </div>
          <!--end::Sidebar Brand-->
          <!--begin::Sidebar Wrapper-->
          <div class="sidebar-wrapper">
            <nav class="mt-2">
              <!--begin::Sidebar Menu-->
              <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu"
                data-accordion="false"
              >
                <li class="nav-item menu-open">
                  <a href="#" class="nav-link active">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>
                      Dashboard
                      <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./index.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Dashboard v1</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./index2.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Dashboard v2</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./index3.html" class="nav-link active">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Dashboard v3</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="./generate/theme.html" class="nav-link">
                    <i class="nav-icon bi bi-palette"></i>
                    <p>Theme Generate</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-box-seam-fill"></i>
                    <p>
                      Widgets
                      <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./widgets/small-box.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Small Box</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./widgets/info-box.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>info Box</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./widgets/cards.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Cards</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-clipboard-fill"></i>
                    <p>
                      Layout Options
                      <span class="nav-badge badge text-bg-secondary me-3">6</span>
                      <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./layout/unfixed-sidebar.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Default Sidebar</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./layout/fixed-sidebar.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Fixed Sidebar</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./layout/layout-custom-area.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Layout <small>+ Custom Area </small></p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./layout/sidebar-mini.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Sidebar Mini</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./layout/collapsed-sidebar.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Sidebar Mini <small>+ Collapsed</small></p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./layout/logo-switch.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Sidebar Mini <small>+ Logo Switch</small></p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./layout/layout-rtl.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Layout RTL</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-tree-fill"></i>
                    <p>
                      UI Elements
                      <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./UI/general.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>General</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./UI/icons.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Icons</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./UI/timeline.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Timeline</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-pencil-square"></i>
                    <p>
                      Forms
                      <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./forms/general.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>General Elements</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-table"></i>
                    <p>
                      Tables
                      <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./tables/simple.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Simple Tables</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-box-arrow-in-right"></i>
                    <p>
                      Auth
                      <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-arrow-in-right"></i>
                        <p>
                          Version 1
                          <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="./examples/login.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Login</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="./examples/register.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Register</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-arrow-in-right"></i>
                        <p>
                          Version 2
                          <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="./examples/login-v2.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Login</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="./examples/register-v2.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Register</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a href="./examples/lockscreen.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Lockscreen</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-header">DOCUMENTATIONS</li>
                <li class="nav-item">
                  <a href="./docs/introduction.html" class="nav-link">
                    <i class="nav-icon bi bi-download"></i>
                    <p>Installation</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./docs/layout.html" class="nav-link">
                    <i class="nav-icon bi bi-grip-horizontal"></i>
                    <p>Layout</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./docs/color-mode.html" class="nav-link">
                    <i class="nav-icon bi bi-star-half"></i>
                    <p>Color Mode</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-ui-checks-grid"></i>
                    <p>
                      Components
                      <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./docs/components/main-header.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Main Header</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./docs/components/main-sidebar.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Main Sidebar</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-filetype-js"></i>
                    <p>
                      Javascript
                      <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./docs/javascript/treeview.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Treeview</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="./docs/browser-support.html" class="nav-link">
                    <i class="nav-icon bi bi-browser-edge"></i>
                    <p>Browser Support</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./docs/how-to-contribute.html" class="nav-link">
                    <i class="nav-icon bi bi-hand-thumbs-up-fill"></i>
                    <p>How To Contribute</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./docs/faq.html" class="nav-link">
                    <i class="nav-icon bi bi-question-circle-fill"></i>
                    <p>FAQ</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./docs/license.html" class="nav-link">
                    <i class="nav-icon bi bi-patch-check-fill"></i>
                    <p>License</p>
                  </a>
                </li>
                <li class="nav-header">MULTI LEVEL EXAMPLE</li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-circle-fill"></i>
                    <p>Level 1</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-circle-fill"></i>
                    <p>
                      Level 1
                      <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Level 2</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>
                          Level 2
                          <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-record-circle-fill"></i>
                            <p>Level 3</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-record-circle-fill"></i>
                            <p>Level 3</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-record-circle-fill"></i>
                            <p>Level 3</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Level 2</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-circle-fill"></i>
                    <p>Level 1</p>
                  </a>
                </li>
                <li class="nav-header">LABELS</li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-circle text-danger"></i>
                    <p class="text">Important</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-circle text-warning"></i>
                    <p>Warning</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-circle text-info"></i>
                    <p>Informational</p>
                  </a>
                </li>
              </ul>
              <!--end::Sidebar Menu-->
            </nav>
          </div>
          <!--end::Sidebar Wrapper-->
        </aside>
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
          <!--begin::App Content Header-->
          <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
              <!--begin::Row-->
              <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Dashboard v3</h3></div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard v3</li>
                  </ol>
                </div>
              </div>
              <!--end::Row-->
            </div>
            <!--end::Container-->
          </div>
          <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
              <!--begin::Row-->
              <div class="row">
                <div class="col-lg-6">
                  <div class="card mb-4">
                    <div class="card-header border-0">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title">Online Store Visitors</h3>
                        <a
                          href="javascript:void(0);"
                          class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                          >View Report</a
                        >
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex">
                        <p class="d-flex flex-column">
                          <span class="fw-bold fs-5">820</span> <span>Visitors Over Time</span>
                        </p>
                        <p class="ms-auto d-flex flex-column text-end">
                          <span class="text-success"> <i class="bi bi-arrow-up"></i> 12.5% </span>
                          <span class="text-secondary">Since last week</span>
                        </p>
                      </div>
                      <!-- /.d-flex -->
                      <div class="position-relative mb-4"><div id="visitors-chart"></div></div>
                      <div class="d-flex flex-row justify-content-end">
                        <span class="me-2">
                          <i class="bi bi-square-fill text-primary"></i> This Week
                        </span>
                        <span> <i class="bi bi-square-fill text-secondary"></i> Last Week </span>
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->
                  <div class="card mb-4">
                    <div class="card-header border-0">
                      <h3 class="card-title">Products</h3>
                      <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm"> <i class="bi bi-download"></i> </a>
                        <a href="#" class="btn btn-tool btn-sm"> <i class="bi bi-list"></i> </a>
                      </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                      <table class="table table-striped align-middle">
                        <thead>
                          <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Sales</th>
                            <th>More</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <img
                                src="assets/img/default-150x150.png"
                                alt="Product 1"
                                class="rounded-circle img-size-32 me-2"
                              />
                              Some Product
                            </td>
                            <td>$13 USD</td>
                            <td>
                              <small class="text-success me-1">
                                <i class="bi bi-arrow-up"></i>
                                12%
                              </small>
                              12,000 Sold
                            </td>
                            <td>
                              <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <img
                                src="assets/img/default-150x150.png"
                                alt="Product 1"
                                class="rounded-circle img-size-32 me-2"
                              />
                              Another Product
                            </td>
                            <td>$29 USD</td>
                            <td>
                              <small class="text-info me-1">
                                <i class="bi bi-arrow-down"></i>
                                0.5%
                              </small>
                              123,234 Sold
                            </td>
                            <td>
                              <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <img
                                src="assets/img/default-150x150.png"
                                alt="Product 1"
                                class="rounded-circle img-size-32 me-2"
                              />
                              Amazing Product
                            </td>
                            <td>$1,230 USD</td>
                            <td>
                              <small class="text-danger me-1">
                                <i class="bi bi-arrow-down"></i>
                                3%
                              </small>
                              198 Sold
                            </td>
                            <td>
                              <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <img
                                src="assets/img/default-150x150.png"
                                alt="Product 1"
                                class="rounded-circle img-size-32 me-2"
                              />
                              Perfect Item
                              <span class="badge text-bg-danger">NEW</span>
                            </td>
                            <td>$199 USD</td>
                            <td>
                              <small class="text-success me-1">
                                <i class="bi bi-arrow-up"></i>
                                63%
                              </small>
                              87 Sold
                            </td>
                            <td>
                              <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                  <div class="card mb-4">
                    <div class="card-header border-0">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title">Sales</h3>
                        <a
                          href="javascript:void(0);"
                          class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                          >View Report</a
                        >
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex">
                        <p class="d-flex flex-column">
                          <span class="fw-bold fs-5">$18,230.00</span> <span>Sales Over Time</span>
                        </p>
                        <p class="ms-auto d-flex flex-column text-end">
                          <span class="text-success"> <i class="bi bi-arrow-up"></i> 33.1% </span>
                          <span class="text-secondary">Since Past Year</span>
                        </p>
                      </div>
                      <!-- /.d-flex -->
                      <div class="position-relative mb-4"><div id="sales-chart"></div></div>
                      <div class="d-flex flex-row justify-content-end">
                        <span class="me-2">
                          <i class="bi bi-square-fill text-primary"></i> This year
                        </span>
                        <span> <i class="bi bi-square-fill text-secondary"></i> Last year </span>
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">Online Store Overview</h3>
                      <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-tool"> <i class="bi bi-download"></i> </a>
                        <a href="#" class="btn btn-sm btn-tool"> <i class="bi bi-list"></i> </a>
                      </div>
                    </div>
                    <div class="card-body">
                      <div
                        class="d-flex justify-content-between align-items-center border-bottom mb-3"
                      >
                        <p class="text-success fs-2">
                          <svg
                            height="32"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3"
                            ></path>
                          </svg>
                        </p>
                        <p class="d-flex flex-column text-end">
                          <span class="fw-bold">
                            <i class="bi bi-graph-up-arrow text-success"></i> 12%
                          </span>
                          <span class="text-secondary">CONVERSION RATE</span>
                        </p>
                      </div>
                      <!-- /.d-flex -->
                      <div
                        class="d-flex justify-content-between align-items-center border-bottom mb-3"
                      >
                        <p class="text-info fs-2">
                          <svg
                            height="32"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
                            ></path>
                          </svg>
                        </p>
                        <p class="d-flex flex-column text-end">
                          <span class="fw-bold">
                            <i class="bi bi-graph-up-arrow text-info"></i> 0.8%
                          </span>
                          <span class="text-secondary">SALES RATE</span>
                        </p>
                      </div>
                      <!-- /.d-flex -->
                      <div class="d-flex justify-content-between align-items-center mb-0">
                        <p class="text-danger fs-2">
                          <svg
                            height="32"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"
                            ></path>
                          </svg>
                        </p>
                        <p class="d-flex flex-column text-end">
                          <span class="fw-bold">
                            <i class="bi bi-graph-down-arrow text-danger"></i>
                            1%
                          </span>
                          <span class="text-secondary">REGISTRATION RATE</span>
                        </p>
                      </div>
                      <!-- /.d-flex -->
                    </div>
                  </div>
                </div>
                <!-- /.col-md-6 -->
              </div>
              <!--end::Row-->
            </div>
            <!--end::Container-->
          </div>
          <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        <footer class="app-footer">
          <!--begin::To the end-->
          <div class="float-end d-none d-sm-inline">Anything you want</div>
          <!--end::To the end-->
          <!--begin::Copyright-->
          <strong>
            Copyright &copy; 2014-2024&nbsp;
            <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
          </strong>
          All rights reserved.
          <!--end::Copyright-->
        </footer>
        <!--end::Footer-->
      </div>
      <!--end::App Wrapper-->
      


</x-layout>