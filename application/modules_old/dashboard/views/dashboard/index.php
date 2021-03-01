<?php 
/*
	@author : Junis pusaba
	@email	: junis_pusaba@mail.ugm.ac.id
	7-9-2014
*/
?>
<div class="col-md-3">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        Homepage
                                    </h3>
                                    <p>
                                        www.nusaboard.co.id
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-home"></i>
                                </div>
                                <a href="http://www.nusaboard.co.id" class="small-box-footer">
                                    Browse <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                    </div><!-- ./col -->
					<div class="col-md-3">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner">
                                   <h3>
                                        Total : <?php echo $jumlah_pensiun;?>
                                    </h3>
                                    <p>
                                        Reminder Karyawan Pensiun  
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="<?php echo site_url('trans/stspeg/list_karpen');?>" class="small-box-footer">
                                    Browse <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                    </div><!-- ./col -->
					<!--
                    <div class="col-md-3">
                             
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        Laporan
                                    </h3>
                                    <p>
                                        Lihat Laporan
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="<?php echo site_url('laporan');?>" class="small-box-footer">
                                    Browse <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
						-->
                    <div class="col-md-3">
                           
                            <div class="small-box bg-yellow">
							   <div class="inner">
                                    <h3>
                                        Total : <?php echo $jumlah_karyawan;?>
                                    </h3>
                                    <p>
                                        Reminder Karyawan Kontrak  
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-calendar"></i>
                                </div>
                                <a href="<?php echo site_url('trans/stspeg/list_karkon');?>" class="small-box-footer">
                                    Browse <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                    </div><!-- ./col -->