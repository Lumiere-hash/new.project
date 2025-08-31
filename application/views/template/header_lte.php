<!-- ====== HEADER DENGAN WARNA OVERRIDE ====== -->
<style>
  :root{
    --hdr-bg:#0f172a; --hdr-hover:#1f2937;
    --hdr-text:#e5e7eb; --hdr-border:#334155;
    --accent:#10b981;
  }
  header.main-header.skin-green .logo{
    background: var(--hdr-bg) !important;
    color: var(--hdr-text) !important;
    border-right: 1px solid var(--hdr-border) !important;
  }
  header.main-header.skin-green .navbar{
    background: var(--hdr-bg) !important;
    border-bottom: 1px solid var(--hdr-border) !important;
  }
  header.main-header.skin-green .navbar .nav>li>a{
    color: var(--hdr-text) !important;
  }
  header.main-header.skin-green .navbar .nav>li>a:hover,
  header.main-header.skin-green .navbar .nav>.open>a{
    background: var(--hdr-hover) !important;
    color: #fff !important;
  }
  header.main-header.skin-green .navbar-nav>.notifications-menu>.dropdown-menu,
  header.main-header.skin-green .navbar-nav>.user-menu>.dropdown-menu{
    background: var(--hdr-bg) !important;
    border: 1px solid var(--hdr-border) !important;
  }
  header.main-header.skin-green .navbar-nav>.notifications-menu>.dropdown-menu>li.header,
  header.main-header.skin-green .navbar-nav>.user-menu>.dropdown-menu>li.user-header>p{
    color: var(--hdr-text) !important;
  }
  header.main-header.skin-green .navbar-nav>.notifications-menu .menu>li>a,
  header.main-header.skin-green .navbar-nav>.user-menu .dropdown-menu>li.user-footer a{
    color: var(--hdr-text) !important;
  }
  header.main-header.skin-green .navbar-nav>.user-menu .user-header{
    background: var(--hdr-hover) !important;
    color: #fff !important;
  }
  .label-warning{ background:#f59e0b !important; color:#111827 !important; }
  header.main-header.skin-green .navbar-nav>.user-menu .dropdown-menu>li.user-footer a{
    background: var(--hdr-hover) !important;
    border-color: var(--hdr-border) !important;
  }
  header.main-header.skin-green .navbar-nav>.user-menu .dropdown-menu>li.user-footer a:hover{
    background: var(--accent) !important;
    color:#fff !important;
  }
</style>

<header class="main-header skin-green">
    <!-- Logo -->
    <a href="<?php echo site_url('dashboard');?>" class="logo">
        <span class="logo-mini">
          <img src="<?php echo base_url('assets/img/desle.png');?>" width="60%" height="50%" class="img-rounded">
        </span>
        <span class="logo-lg">
          <img src="<?php echo base_url('assets/img/desle_full.png');?>" width="100%" height="20%" class="img-rounded">
        </span>
    </a>

    <!-- Navbar -->
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Online -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-smile-o"></i>
                        <span class="label label-warning"><?php echo $jumlah_online;?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">User Online</li>
                        <li>
                            <ul class="menu">
                                <?php foreach ($user_online as $ull){?>
                                <li>
                                    <a href="#">
                                      <div class="row">
                                        <div class="col-xs-2 col-md-2 text-nowrap">
                                          <img src="<?php
                                            $imo=trim($ull->image);
                                            if (!empty($imo) && file_exists(FCPATH . "assets/img/profile/$imo")) {
                                                echo base_url("assets/img/profile/$imo");
                                            } else {
                                                echo base_url("assets/img/admin.jpg");
                                            }
                                          ?>" width="45" height="45">
                                        </div>
                                        <div class="col-xs-2 col-md-5 text-nowrap"><strong><?php echo $ull->userid;?></strong></div>
                                        <div class="col-xs-5 col-md-5 text-nowrap"><strong><?php echo $ull->nik;?></strong></div>
                                      </div>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Last Login -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="ion-ios-people info"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">5 User Online Terakhir</li>
                        <li>
                            <ul class="menu">
                                <?php foreach ($list_login as $ab){ ?>
                                <li>
                                    <a href="#"><i class="ion ion-ios7-people info"></i> <?php echo $ab->tgl.' | '.$ab->username;?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- User Account -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                          $imgr = trim($user_menu['image']);
                          if (!empty($imgr) && file_exists(FCPATH . "assets/img/profile/$imgr")) {
                              $img_url = base_url("assets/img/profile/$imgr");
                          } else {
                              $img_url = base_url("assets/img/admin.jpg");
                          }
                        ?>
                        <img src="<?php echo $img_url; ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $user_menu['username']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="<?php echo $img_url; ?>" class="img-circle" alt="User Image">
                            <p><?php echo $user_menu['username']; ?></p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php $nik=trim($user_menu['nik']); $username=trim($user_menu['username']); echo site_url('master/user/editprofile/'.$nik.'/'.$username);?>" class="btn btn-default btn-flat">Ubah Password</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo site_url('dashboard/logout');?>" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-off"></i> Log out</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <?php if(trim($user_menu["level_akses"])=="A" && in_array($_SERVER["REMOTE_ADDR"],["127.0.0.1","::1"])) { ?>
                    <li><a href="<?php echo site_url('update');?>" title="Cek Update"><i class="fa fa-gears"></i></a></li>
                <?php } else { ?>
                    <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>
