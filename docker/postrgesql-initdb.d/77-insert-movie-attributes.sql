INSERT INTO public.attributes_type (id,"name") VALUES
                                                   ('2efd3b02-1831-4831-8c2a-043eaca732a6','bool'),
                                                   ('47649fe0-5ab1-4843-950d-08a45b3ef42a','string'),
                                                   ('64966228-bc4b-4216-b123-d10b6fa9fee1','date'),
                                                   ('8e66b882-ff3d-4dc5-ab9b-a1f37f61d488','float'),
                                                   ('f5e5526b-f604-48f9-b1a5-946d1208e0a7','int');


INSERT INTO public.movie_attributes (id,"name",type_id,parent_id) VALUES
                                                                      ('ef588308-98e6-40b5-96db-f73e2dfab694','Премия',NULL,NULL),
                                                                      ('6c9aa14d-3268-4eed-b5f6-3ae0d0125f48','Оскар','2efd3b02-1831-4831-8c2a-043eaca732a6','ef588308-98e6-40b5-96db-f73e2dfab694'),
                                                                      ('29f4acb3-a3ec-4265-ac5e-df50d2a9d94b','Ника','2efd3b02-1831-4831-8c2a-043eaca732a6','ef588308-98e6-40b5-96db-f73e2dfab694'),
                                                                      ('c0f3fa24-7f39-4c8a-b92b-cdd9c43c0363','Служебные даты',NULL,NULL),
                                                                      ('f140113e-5878-4df1-9f35-a5522a062f6a','Начало продажи билетов','64966228-bc4b-4216-b123-d10b6fa9fee1','c0f3fa24-7f39-4c8a-b92b-cdd9c43c0363'),
                                                                      ('b1eac707-7178-47be-800a-1144950749a6','Запуск рекламы на ТВ','64966228-bc4b-4216-b123-d10b6fa9fee1','c0f3fa24-7f39-4c8a-b92b-cdd9c43c0363'),
                                                                      ('57a1197f-5c58-46ef-8299-544de68e3bdf','Важные даты',NULL,NULL),
                                                                      ('3f2d56c0-dd07-4f0a-963a-39bdaea3b411','Мировая премьера','64966228-bc4b-4216-b123-d10b6fa9fee1','57a1197f-5c58-46ef-8299-544de68e3bdf'),
                                                                      ('86ff5d2c-7f23-4244-aa21-a2e45c9efd34','Премьера в РФ','64966228-bc4b-4216-b123-d10b6fa9fee1','57a1197f-5c58-46ef-8299-544de68e3bdf'),
                                                                      ('bc7190e4-2c9e-42e8-ab8f-c3aedb384aac','Рецензии',NULL,NULL),
                                                                      ('5df94c81-0320-415c-b48d-be0a79a6453f','Критиков','47649fe0-5ab1-4843-950d-08a45b3ef42a','bc7190e4-2c9e-42e8-ab8f-c3aedb384aac'),
                                                                      ('f377ab20-ac36-42b7-8822-695375f63db2','Неизвестной киноакадемии','47649fe0-5ab1-4843-950d-08a45b3ef42a','bc7190e4-2c9e-42e8-ab8f-c3aedb384aac'),
                                                                      ('146db9f1-a820-4ad3-823f-20c7486fc96c','Рейтинг','8e66b882-ff3d-4dc5-ab9b-a1f37f61d488',NULL),
                                                                      ('4b7d2536-d700-4afa-805b-3230875814e6','Год','f5e5526b-f604-48f9-b1a5-946d1208e0a7',NULL);
