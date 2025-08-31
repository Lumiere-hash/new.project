<style>
  /* ================================
     THEME OVERRIDES (warna saja)
     Palet:
       --sb-bg:      #0f172a  (navy gelap)
       --sb-hover:   #1f2937
       --sb-border:  #334155
       --sb-text:    #e5e7eb
       --sb-dim:     #9ca3af
       --accent:     #10b981  (emerald)
  ==================================*/
  :root{
    --sb-bg:#0f172a; --sb-hover:#1f2937; --sb-border:#334155;
    --sb-text:#e5e7eb; --sb-dim:#9ca3af; --accent:#10b981;
  }

  /* ===== Sidebar (kiri) ===== */
  .main-sidebar{
    background: var(--sb-bg) !important;
    color: var(--sb-text) !important;
    border-right: 1px solid var(--sb-border);
  }
  .sidebar a{ color: var(--sb-text) !important; }
  .sidebar .user-panel>.info, .sidebar .user-panel>.info a{
    color: var(--sb-text) !important;
  }
  .sidebar-form .form-control{
    background: rgba(255,255,255,.06); border-color: var(--sb-border); color: var(--sb-text);
  }
  .sidebar-form .btn{ background: rgba(255,255,255,.06); color: var(--sb-dim); border-color: var(--sb-border); }
  .sidebar-form .form-control::placeholder{ color: var(--sb-dim); }

  /* Item menu level-1 */
  .sidebar-menu>li>a{
    border-left: 3px solid transparent;
    color: var(--sb-text) !important;
  }
  .sidebar-menu>li:hover>a{ background: var(--sb-hover) !important; }
  .sidebar-menu>li.active>a{
    background: var(--sb-hover) !important;
    border-left-color: var(--accent) !important;
    color: #fff !important;
  }

  /* Submenu (treeview) */
  .treeview-menu{
    background: transparent !important;
    border-left: 1px dashed var(--sb-border);
    margin-left: .5rem;
  }
  .treeview-menu>li>a{
    color: var(--sb-dim) !important;
    padding-left: 20px;
  }
  .treeview-menu>li>a:hover{ color:#fff !important; background: rgba(255,255,255,.04) !important; }

  /* Ikon panah */
  .sidebar-menu .fa-angle-left, .treeview-menu .fa-angle-left{
    color: var(--sb-dim) !important;
  }

  /* Garis pemisah bawah sidebar (opsional) */
  .sidebar .sidebar-menu, .sidebar .user-panel{
    border-color: var(--sb-border) !important;
  }

  /* ===== Header / Navbar =====
     (kalau ingin header senada dark; jika ingin tetap hijau lama, hapus blok ini)
  */
  .skin-green .main-header .navbar,
  .skin-green .main-header .logo{
    background: var(--sb-bg) !important;
    color: var(--sb-text) !important;
    border-bottom: 1px solid var(--sb-border);
  }
  .skin-green .main-header .navbar .nav>li>a{
    color: var(--sb-text) !important;
  }
  .skin-green .main-header .navbar .nav>li>a:hover,
  .skin-green .main-header .navbar .nav>li.open>a{
    background: var(--sb-hover) !important;
  }
  /* badge label biar kontras */
  .label-warning{ background:#f59e0b !important; color:#111827 !important; }

  /* ===== Konten ===== */
  .content-wrapper, .right-side{ background:#f5f7fb !important; } /* abu muda lembut */
</style>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php
                $imgr = trim($user_menu['image']);
                if (!empty($imgr) && file_exists(FCPATH . "assets/img/profile/$imgr")) {
                    $img_src = base_url("assets/img/profile/$imgr");
                } else {
                    $img_src = base_url("assets/img/admin.jpg");
                }
                ?>
                <img width="100%" height="80%" src="<?php echo $img_src; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $user_menu['nmlengkap'];    ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" id="search" name="q" class="form-control" placeholder="Cari...">
                <span class="input-group-btn">
                    <a class="btn btn-flat" style="cursor: default;"><i class="fa fa-search"></i></a>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <?php
            $user_name = $user_menu['username'];
            $timestamp = Date('Y-m-d H:i:s');
            $secret_key = $this->config->item('secret_key');

            $data = [
                'user_name' => $user_name,
                'timestamp' => $timestamp
            ];

            $token = openssl_encrypt(json_encode($data), 'aes-256-cbc', $secret_key, 0, $iv = '1234567890123456');
            $encoded_token = base64_encode($token);

            //url hrms0
            $data['urldcms'] = trim(strtolower($this->m_menu->q_menu_url_dcms()));
            $url = !empty($data['urldcms']) ? $data['urldcms'] : '/dms/login/login_with_token?';

            foreach ($list_menu_main as $lm) { ?>
                <li class="treeview sidebar-link">
                    <a href="<?php if (!empty($lm->linkmenu)) {
                                    echo site_url(trim($lm->linkmenu));
                                } else {
                                    echo '#';
                                } ?>" id="<?= trim($lm->kodemenu) ?>">
                        <i class="fa <?php echo trim($lm->iconmenu); ?>"></i> <span><?php echo trim($lm->namamenu); ?></span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php foreach ($list_menu_sub as $lms) {
                            if (trim($lms->parentmenu) == trim($lm->kodemenu)) {
                        ?>
                                <li class="sidebar-link">
                                    <a href="<?php if (!empty($lms->linkmenu)) {
                                                    echo site_url(trim($lms->linkmenu));
                                                } else {
                                                    echo '#';
                                                } ?>" id="<?= trim($lms->kodemenu) ?>">
                                        <i class="fa <?php if (!empty($lms->iconmenu)) {
                                                            echo trim($lms->iconmenu);
                                                        } else {
                                                            echo 'fa-angle-double-right';
                                                        } ?>"></i> <?php echo trim($lms->namamenu); ?>
                                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php foreach ($list_menu_submenu as $lmp) {
                                            if (trim($lmp->parentmenu) == trim($lm->kodemenu) and trim($lmp->parentsub) == trim($lms->kodemenu)) { ?>
                                                <!--<li><a href='<?php /*if (!empty($lmp->linkmenu)) {echo site_url(trim($lmp->linkmenu));} else { echo '#';}*/ ?>'><i class="fa <?php /*if (!empty($lmp->iconmenu)) { echo trim($lmp->iconmenu);} else { echo 'fa-angle-double-right';}*/ ?>"></i><strong><font face="arial" size="1%"  color="green"><?php /*echo trim($lmp->namamenu);*/ ?></font></strong></p></a>-->
                                                <li class="sidebar-link">
                                                    <a onclick="crutz('<?php echo trim($lmp->kodemenu); ?>')"
                                                        href="<?php if (!empty($lmp->linkmenu) && $lm->urut == "11") {
                                                                    echo $url . "token=$encoded_token" . "&redirect=" . trim($lmp->linkmenu);
                                                                } elseif (!empty($lmp->linkmenu)) {
                                                                    echo site_url(trim($lmp->linkmenu));
                                                                } else {
                                                                    echo '#';
                                                                } ?>"
                                                        id="<?= trim($lmp->kodemenu) ?>">
                                                        <i class="fa <?php if (!empty($lmp->iconmenu)) {
                                                                            echo trim($lmp->iconmenu);
                                                                        } else {
                                                                            echo 'fa-angle-double-right';
                                                                        } ?>">
                                                        </i>
                                                        <?php echo trim($lmp->namamenu); ?>
                                                    </a>
                                                </li>
                                        <?php }
                                        }
                                        ?>
                                    </ul>
                                </li>
                        <?php }
                        } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<script>
    $(document).ready(function() {
        $("#search").on("keyup", function() {
            if (this.value.length > 0) {
                $("li.sidebar-link").hide().filter(function() {
                    return $(this).text().toLowerCase().indexOf($("#search").val().toLowerCase()) != -1;
                }).show();
            } else {
                $("li.sidebar-link").show();
            }
        });
    });
</script>

<script>
    function crutz(xx) {
        console.log(xx);
    }
</script>