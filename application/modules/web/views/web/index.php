<?php echo $this->fiky_ddos_protector->protect(); ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OSIN · Log in</title>

  <!-- Tailwind + DaisyUI -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme:{ extend:{ fontFamily:{ sans:['Inter','ui-sans-serif','system-ui'] } } } }
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/fontawesome/css/font-awesome.min.css'); ?>">

  <!-- TinyMCE (opsional) -->
  <script src="<?php echo base_url('assets/js/tinymce/tinymce.min.js');?>"></script>
  <script>if(window.tinymce){ tinymce.init({ selector:'textarea' }); }</script>

  <?php echo isset($_lchecking)?$_lchecking:''; ?>
  <?php echo isset($_checking)?$_checking:''; ?>

  <style>
    html,body{height:100%}
    body{font-family:Inter,ui-sans-serif,system-ui}
  </style>
</head>
<body class="min-h-screen bg-base-200 flex flex-col">

  <?php echo isset($coldown)?$coldown:''; ?>
  <?php echo isset($xvw)?$xvw:''; ?>

  <!-- Header -->
  <header class="pt-5 pb-1">
    <h1 class="text-center text-sm font-semibold tracking-wide md:text-xl">
      ONLINE SYSTEM &amp; MANAGEMENT STOCK
    </h1>
  </header>

  <!-- Main -->
  <main class="flex-1">
    <div class="mx-auto w-full max-w-screen-lg px-4 py-6">
      <!-- Flex mobile (form atas, logo bawah), Grid desktop (logo kiri, form kanan) -->
      <div class="flex flex-col gap-6 md:grid md:grid-cols-2 md:items-center">
        
        <!-- Logo di kiri (desktop), di bawah (mobile) -->
        <div class="order-2 md:order-1 w-full flex items-center justify-center md:justify-start">
          <img
            src="<?php echo base_url('assets/img/desle.png'); ?>"
            alt="Logo"
            class="h-20 w-auto md:h-auto md:max-w-md lg:max-w-lg object-contain rounded-2xl"
          />
        </div>

        <!-- Form login di kanan (desktop), di atas (mobile) -->
        <div class="order-1 md:order-2 w-full">
          <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-4 md:p-6">
              <h2 class="card-title mb-2">Masuk</h2>
              <?php echo $this->session->flashdata('message');?>

              <form action="<?php echo site_url('web/proses');?>" method="post" class="space-y-3">
                <!-- Username -->
                <label class="form-control w-full">
                  <div class="label py-1"><span class="label-text">Username</span></div>
                  <input name="username" type="text" placeholder="Username"
                         class="input input-bordered w-full h-10 md:h-11" required />
                </label>

                <!-- Password -->
                <label class="form-control w-full">
                  <div class="label py-1"><span class="label-text">Password</span></div>
                  <div class="relative">
                    <input id="password" name="password" type="password"
                           placeholder="Password"
                           class="input input-bordered w-full h-10 pr-12 md:h-11 password-input" required />
                    <button type="button" id="togglePass"
                            class="btn btn-ghost btn-xs absolute right-1 top-1/2 -translate-y-1/2">
                      <i class="fa fa-eye-slash text-base"></i>
                    </button>
                  </div>
                </label>

                <!-- Captcha -->
                <div>
                  <div class="mb-2"><?php echo $captcha_img; ?></div>
                  <label class="form-control w-full">
                    <div class="label py-1"><span class="label-text">Kode</span></div>
                    <input type="text" name="captcha"
                           value="<?php echo (strtoupper(ENVIRONMENT)=='DEVELOPMENT'?(isset($cap)?$cap:''):''); ?>"
                           placeholder="Masukkan kode di atas"
                           class="input input-bordered w-full h-10 md:h-11" required />
                  </label>
                  <?php if($this->input->get('cap_error')): ?>
                    <p class="text-error text-xs mt-1">Captcha salah, silakan coba lagi.</p>
                  <?php endif; ?>
                </div>

                <!-- Remember me -->
                <label class="label cursor-pointer justify-start gap-2 py-1">
                  <input type="checkbox" class="checkbox checkbox-sm" />
                  <span class="label-text text-sm">Remember me</span>
                </label>

                <!-- Tombol -->
                <div class="flex flex-col gap-2 pt-2 md:flex-row">
                  <button type="submit" class="btn btn-success w-full md:w-auto">Sign in</button>
                  <button type="reset" class="btn w-full md:w-auto">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- Footer
  <footer class="mt-6">
    <div class="py-4 md:py-6 bg-green-600 text-center">
      <p class="text-white text-sm md:text-base">
        Copyright ©
        <a class="link link-hover text-white font-semibold" href="https://nusaboard.co.id/" target="_blank" rel="noopener">
          IT NUSANTARA
        </a>
        <?php echo isset($currentYear)?$currentYear:date('Y'); ?>
      </p>
    </div>
  </footer> -->

  <!-- Script -->
  <script src="<?php echo base_url('assets/js/jquery.js');?>"></script>
  <?php echo $this->fiky_encryption->getAccessPage('PAGE_LOGIN'); ?>
  <?php echo isset($_checking_)?$_checking_:''; ?>

  <script>
    // Toggle show/hide password
    (function(){
      var btn=document.getElementById('togglePass');
      var input=document.getElementById('password');
      var icon=btn?btn.querySelector('i'):null;
      if(btn){
        btn.addEventListener('click',function(){
          var t=input.getAttribute('type')==='password'?'text':'password';
          input.setAttribute('type',t);
          if(icon){
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
          }
        });
      }
    })();
  </script>
</body>
</html>
