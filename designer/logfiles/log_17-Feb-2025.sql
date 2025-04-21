INSERT INTO orders_stl_files(orderid,filename,created_at,userid) VALUES('145820','20250210_1241_Roxana_Romero_0.stl','17-Feb-2025 02:34:26pm','BravoDent@gmail.com');
INSERT INTO orders_finished(orderid,finished_file,created_at,userid) VALUES('145820','20250210_1241_Roxana_Romero.zip','17-Feb-2025 02:34:26pm','BravoDent@gmail.com');
UPDATE orders SET status='Completed',status_ch_date='17-Feb-2025 02:34:26pm' where orderid ='145820';
