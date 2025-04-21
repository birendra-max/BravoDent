INSERT INTO orders_stl_files(orderid,filename,created_at,userid) VALUES('547459','2104740256_20250303_0921_Virginia_Himoff_29-31_0.stl','03-Mar-2025 09:45:56pm','BravoDent@gmail.com');
INSERT INTO orders_finished(orderid,finished_file,created_at,userid) VALUES('547459','2104740256_20250303_0921_Virginia_Himoff_29-31.zip','03-Mar-2025 09:45:57pm','BravoDent@gmail.com');
UPDATE orders SET status='Completed',status_ch_date='03-Mar-2025 09:45:57pm' where orderid ='547459';
INSERT INTO orders_stl_files(orderid,filename,created_at,userid) VALUES('847461','Judy_Burnett_Remake__98998_20250303_20_0.stl','03-Mar-2025 11:19:14pm','BravoDent@gmail.com');
INSERT INTO orders_finished(orderid,finished_file,created_at,userid) VALUES('847461','Judy_Burnett_Remake__98998_20250303.zip','03-Mar-2025 11:19:21pm','BravoDent@gmail.com');
UPDATE orders SET status='Completed',status_ch_date='03-Mar-2025 11:19:21pm' where orderid ='847461';
INSERT INTO orders_finished(orderid,finished_file,created_at,userid) VALUES('847461','Judy_Burnett_Remake__98998_20250303.zip','03-Mar-2025 11:59:31pm','BravoDent@gmail.com');
UPDATE orders SET status='Completed',status_ch_date='03-Mar-2025 11:59:31pm' where orderid ='847461';
