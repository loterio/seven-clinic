DROP DATABASE equipe1;
CREATE DATABASE equipe1;
use equipe1;
 
CREATE TABLE usuarios (
id INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(200) NOT NULL,
email VARCHAR(100) NOT NULL,
senha VARBINARY(128) NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE pacientes (
id_user INT NOT NULL,
id_paciente INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(45) NOT NULL,
CPF VARCHAR(14) NOT NULL, 
altura FLOAT NOT NULL,
peso FLOAT NOT NULL,
data_nascimento DATE NOT NULL,
email VARCHAR(60) NOT NULL,
telefone VARCHAR(14) NOT NULL,
endereco VARCHAR(100) NOT NULL,
cidade VARCHAR(100) NOT NULL,
observacoes VARCHAR(200),
PRIMARY KEY (id_paciente),
FOREIGN KEY (id_user) REFERENCES usuarios(id)
);


CREATE TABLE medicos (
id_user INT NOT NULL,
id_medico INT NOT NULL AUTO_INCREMENT,
CRM VARCHAR(14) NOT NULL,
nome VARCHAR(45) NOT NULL,
telefone VARCHAR(14) NOT NULL,
especializacao VARCHAR(45) NOT NULL,
PRIMARY KEY (id_medico),
FOREIGN KEY (id_user) REFERENCES usuarios(id)
);

CREATE TABLE consultas (
id_user INT NOT NULL,
id_consulta INT NOT NULL AUTO_INCREMENT,
data_consulta DATE NOT NULL,
hora_inicio TIME NOT NULL,
hora_fim TIME NOT NULL,
valor FLOAT NOT NULL,
descricao VARCHAR(100) NOT NULL,
id_paciente INT NOT NULL,
id_medico INT NOT NULL,
estado BOOLEAN NOT NULL,
PRIMARY KEY (id_consulta),
FOREIGN KEY (id_user) REFERENCES usuarios(id),
FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente) ON DELETE CASCADE,
FOREIGN KEY (id_medico) REFERENCES medicos(id_medico) ON DELETE CASCADE
);

-- select SUM(valor) as valorTotal from consultas where id_medico = 1 AND id_user = 1 AND estado = 0 AND data_consulta >= '2020-10-14' AND data_consulta <= '2020-11-13';
-- select * from consultas where data_consulta >= '2020-10-13' AND data_consulta <= '2020-11-11' order by data_consulta;


-- select SUM(valor) as valorTotal from consultas where id_paciente = 1 AND id_user = 1 AND estado = 0 AND data_consulta >= '2020-10-14' AND data_consulta <= '2020-11-13';
