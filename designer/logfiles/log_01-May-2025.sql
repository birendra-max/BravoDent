INSERT INTO orders_stl_files(orderid,filename,created_at,userid) VALUES('1000','Alexandra E.stl','01-May-2025 12:23:52am','BravoDent@gmail.com');
INSERT INTO orders_finished(orderid,finished_file,created_at,userid) VALUES('1000','Alexandra E.zip','01-May-2025 12:24:39am','BravoDent@gmail.com');
UPDATE orders SET status='Completed',status_ch_date='01-May-2025 12:24:39am' where orderid ='1000';
