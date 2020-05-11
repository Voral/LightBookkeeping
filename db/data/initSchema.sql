create table account_group
(
    id   int         not null auto_increment primary key,
    name varchar(64) not null
) engine = InnoDB
  default charset = utf8;
create table account
(
    id              int         not null auto_increment primary key,
    left_margin     int         not null default -1,
    right_margin    int         not null default -1,
    parent_id       int,
    name            varchar(64) not null,
    short_name      varchar(5)  not null,
    group_id        int,
    type_id         int         not null default 0,
    default_partner int,
    constraint account_parent_id
        FOREIGN KEY (parent_id) REFERENCES account (id) on update RESTRICT on delete cascade,
    constraint account_group
        foreign key (group_id) references account_group (id) on update CASCADE on delete set null
) engine = InnoDB
  DEFAULT CHARSET = utf8;
create table planned
(
    id int not null auto_increment primary key,
    account_src_id int not null,
    account_dst_id int not null,
    relation_id int,
    relation_type int,
    relation_param numeric(14,2),
    description varchar(250),
    total numeric(14,2),
    constraint planned_src_id
        FOREIGN KEY (account_src_id) REFERENCES account (id) on update RESTRICT on delete RESTRICT,
    constraint planned_dst_id
        FOREIGN KEY (account_dst_id) REFERENCES account (id) on update RESTRICT on delete RESTRICT
) engine = InnoDB
  default charset = utf8;

create table journal
(
    id int not null auto_increment primary key,
    account_src_id int not null,
    account_dst_id int not null,
    timestamp_x datetime not null,
    relation_id int,
    relation_type int,
    relation_param numeric(14,2),
    description varchar(250),
    total numeric(14,2),
    planned int not null default 0,
    planned_id int,
    constraint journal_relation_id
        FOREIGN KEY (relation_id) REFERENCES journal (id) on update RESTRICT on delete cascade,
    constraint journal_src_id
        FOREIGN KEY (account_src_id) REFERENCES account (id) on update RESTRICT on delete RESTRICT,
    constraint journal_dst_id
        FOREIGN KEY (account_dst_id) REFERENCES account (id) on update RESTRICT on delete RESTRICT,
    constraint journal_planned_id
        FOREIGN KEY (planned_id) REFERENCES planned (id) on update RESTRICT on delete set null
) engine = InnoDB
  default charset = utf8;
ALTER TABLE planned
    ADD constraint planned_relation_id
    FOREIGN KEY (relation_id) REFERENCES journal (id) on update RESTRICT on delete cascade;
