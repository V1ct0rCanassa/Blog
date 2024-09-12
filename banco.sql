drop database blog;

create database blog;

USE blog;

CREATE TABLE usuario (
    id_usuario int not null auto_increment,
    nome varchar(50) not null,
	email varchar(225) not null,
    senha varchar(60) not null,
    data_criacao datetime not null default current_timestamp,
    ativo tinyint not null default '0',
    adm tinyint not null default '0',
    primary key (id_usuario)
);

CREATE TABLE post (
    id_post int not null auto_increment,
    titulo varchar(225) not null,
	texto text not null,
    usuario_id int not null,
    data_criacao datetime not null default current_timestamp,
    data_postagem datetime not null default current_timestamp,
    primary key (id_post),
    key fk_post_usuario_idx (usuario_id),
    constraint fk_post_usuario foreign key (usuario_id) references usuario (id_usuario)
);


