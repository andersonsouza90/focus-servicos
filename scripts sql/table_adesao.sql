create table adesao(
	id_adesao int NOT NULL AUTO_INCREMENT,
    id_usuario int NOT NULL,
    id_plano int NOT NULL,
    dt_adesao timestamp default now(),
    dt_termino timestamp null,
    primary key (id_adesao),
    foreign key (id_usuario) references users(id_usuario),
    foreign key (id_plano) references planos(id_plano)
);

