create function tr_dinas_after() returns trigger
    language plpgsql
as
$$
declare
     
     vr_nomor char(30);
     
begin
--vr_status:=trim(coalesce(status,'')) from sc_tmp.cuti where branch=new.branch and kddokumen=new.kddokumen for update;
--vr_nomor

delete from sc_mst.penomoran where userid=new.nodok; 
insert into sc_mst.penomoran 
        (userid,dokumen,nomor,errorid,partid,counterid,xno)
        values(new.nodok,'DINAS-LUAR',' ',0,' ',1,0);

vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;
 if (trim(vr_nomor)!='') or (not vr_nomor is null) then
	INSERT INTO sc_trx.dinas(
		nik,nodok,tgl_dok,nmatasan,tgl_mulai,tgl_selesai,status,keperluan,tujuan,input_date,input_by,approval_date,approval_by,delete_date,delete_by,update_by,update_date,cancel_by,cancel_date
	    )
	SELECT nik,vr_nomor,tgl_dok,nmatasan,tgl_mulai,tgl_selesai,'I' as status,keperluan,tujuan,input_date,input_by,approval_date,approval_by,delete_date,delete_by,update_by,update_date,cancel_by,cancel_date
	from sc_tmp.dinas where nodok=new.nodok and nik=new.nik;
       
delete from sc_tmp.dinas where nodok=new.nodok and nik=new.nik;

end if;

return new;

end;
$$;

alter function tr_dinas_after() owner to postgres;

