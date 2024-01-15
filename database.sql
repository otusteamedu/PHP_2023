-- DDL

CREATE TABLE IF NOT EXISTS "articles" (
    "id" SERIAL NOT NULL,
    "title" VARCHAR(200) NOT NULL,
    "text" TEXT NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "tags" (
    "id" SERIAL NOT NULL,
    "name" VARCHAR(50) NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE IF NOT EXISTS "articles_tags" (
    "article_id" INT NOT NULL,
    "tag_id" INT NOT NULL,
    PRIMARY KEY ("article_id", "tag_id"),
    CONSTRAINT "FKat_article_id" FOREIGN KEY ("article_id") REFERENCES "articles" ("id") ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT "FKat_tag_id" FOREIGN KEY ("tag_id") REFERENCES "tags" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);


-- DML

INSERT INTO "articles" VALUES(1, 'Есть ли жизнь на марсе?', 'Текст статьи 1');
INSERT INTO "articles" VALUES(2, 'Как космические корабли бороздят большой театр', 'Текст статьи 2');
INSERT INTO "articles" VALUES(3, 'О чем молчат деревья', 'Текст статьи 3');

INSERT INTO "tags" VALUES (1, 'космос');
INSERT INTO "tags" VALUES (2, 'фантастика');
INSERT INTO "tags" VALUES (3, 'искусство');
INSERT INTO "tags" VALUES (4, 'природа');

INSERT INTO "articles_tags" VALUES(1, 1);
INSERT INTO "articles_tags" VALUES(1, 2);
INSERT INTO "articles_tags" VALUES(2, 1);
INSERT INTO "articles_tags" VALUES(2, 2);
INSERT INTO "articles_tags" VALUES(2, 3);
INSERT INTO "articles_tags" VALUES(3, 3);
INSERT INTO "articles_tags" VALUES(3, 4);
