<!DOCTYPE html>
<html>
  <head>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  </head>
  <body>
    <p><font face="Times New Roman, Times, serif">Yang Terhormat, <br>
      </font> </p>
    <blockquote><font face="Times New Roman, Times, serif">
        <?Php echo $send_to ?><br>
      </font> </blockquote>
    <font face="Times New Roman, Times, serif"> </font>
    <blockquote> </blockquote>
    <font face="Times New Roman, Times, serif"><br>
      Dijadwalkan Undangan untuk<b> : <?Php echo $transaction['Nama_Agenda'] ?><br> </b>
       yang akan dilaksanakan pada :<br>
    </font>
    <table width="643" height="107" cellspacing="0" cellpadding="0"
      border="0">
      <tbody>
         <tr style="mso-height-source:userset;height:20.1pt" height="26">
          <td class="xl67" style="height:20.1pt;width:48pt" width="64"
            height="26"><font face="Times New Roman, Times, serif">Tipe agenda </font></td>
          <td class="xl68" style="width:293pt" width="390"><font
              face="Times New Roman, Times, serif">: <?php $transaction['Tipe_Agenda'] ?><br>
            </font></td>
        </tr>
        <tr style="mso-height-source:userset;height:20.1pt" height="26">
          <td class="xl67" style="height:20.1pt;width:48pt" width="64"
            height="26"><font face="Times New Roman, Times, serif">Tanggal mulai </font></td>
          <td class="xl68" style="width:293pt" width="390"><font
              face="Times New Roman, Times, serif">: <?php $transaction['Tanggal_Mulai'] ?><br>
            </font></td>
        </tr>
        <tr style="mso-height-source:userset;height:20.1pt" height="26">
          <td class="xl67" style="height:20.1pt;width:90pt" width="64"
            height="26"><font face="Times New Roman, Times, serif">Tanggal Selesai </font></td>
          <td class="xl68" style="width:293pt" width="390"><font
              face="Times New Roman, Times, serif">: <?php $transaction['Tanggal_Selesai'] ?><br>
            </font></td>
        </tr>
         <tr style="mso-height-source:userset;height:20.1pt" height="26">
          <td class="xl67" style="height:20.1pt;width:90pt" width="64"
            height="26"><font face="Times New Roman, Times, serif">Lokasi </font></td>
          <td class="xl68" style="width:293pt" width="390"><font
              face="Times New Roman, Times, serif">: <?php $transaction['Lokasi'] ?><br>
            </font></td>
        </tr>
        <?php if ($transaction['Link'] != '') { ?>
            <tr style="mso-height-source:userset;height:20.1pt" height="26">
              <td class="xl67" style="height:20.1pt" height="26"><font
                  face="Times New Roman, Times, serif">Tempat </font></td>
              <td class="xl68"><font face="Times New Roman, Times, serif">:
                <a class="moz-txt-link-freetext"
                href="<?php echo $transaction['Link']; ?>"><?php echo $transaction['Link']; ?></a><br>
                </font></td>
            </tr>
        <?php } ?>
      </tbody>
    </table>
    <br>
    <font face="Times New Roman, Times, serif"> Demikian informasi ini
      kami sampaikan. Atas perhatian dan kerjasama Bapak/Ibu, kami
      ucapkan terima kasih.</font>
    <p></p>
    <pre class="moz-signature" cols="72">-- 
Best Regards,


PT. Nusa Unggul Sarana Adicipta
Jl. Margomulyo Indah II Blok A No. 15 Surabaya - Jawa Timur 
Phone : 0896 2694 1650 | Telp : (031) 7491856-58 | Email : <a class="moz-txt-link-abbreviated" href="mailto:odtraining.nusa@nusantarajaya.co.id">odtraining.nusa@nusantarajaya.co.id</a> |</pre>
  </body>
</html>