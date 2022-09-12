create table planos(
	id_plano int NOT NULL AUTO_INCREMENT,
    descricao varchar(100),
    valor varchar(100),
    primary key (id_plano)
);
insert into planos values(1, 'Período Teste', 'R$ 00,00');
insert into planos values(2, 'Adesão', 'R$ 50,00');
insert into planos values(3, 'Assinatura mensal', 'R$ 25,00');	
insert into planos values(4, 'Assinatura semestral', 'R$ 120,00 (R$ 20/mês)');
insert into planos values(5, 'Assinatura anual', 'R$ 200,00 (R$ 15/mês)');

select * from planos;