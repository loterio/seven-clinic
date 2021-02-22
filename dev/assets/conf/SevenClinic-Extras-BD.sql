select * from usuarios;
select * from medicos;
select * from pacientes;
select * from consultas;

# DROP TABLE consultas;
INSERT INTO consultas(id_user, data_consulta, hora_inicio, hora_fim, valor, descricao, id_paciente, id_med, estado) VALUES
(1,'2002-07-28',"14:30","15:00",100,"checkup",1,2,true),
(1,'2021-03-02',"17:30","18:30",120,"alinhamento",2,1,true),
(1,'2021-03-08',"08:00","09:00",200,"laser",3,1,true),
(1,'2021-02-28',"07:30","11:15",4000,"rinoplastia",4,1,false);

# DROP VIEW consultas_medico;

CREATE VIEW consultas_medico  
WHERE AS SELECT nome AS "MÉDICO", COUNT(*) as "Nº CONSULTAS"
FROM medicos M
	INNER JOIN consultas CS
    ON id_medico = CS.id_med
WHERE CS.id_med = 2; # Médicos 1 e 2 

SELECT * FROM consultas_medico;

# DROP PROCEDURE relatorio;

DELIMITER $$
	CREATE PROCEDURE relatorio(IN data_inicial DATE, IN data_final DATE, IN id_user INT)
    BEGIN
		SELECT 
			M.nome 			AS NOME_MEDICO, 
			P.nome 			AS NOME_PACIENTE, 
			C.data_consulta AS DATA_CONSULTA, 
			C.hora_inicio 	AS HORA_INICIO_CONSULTA, 
			C.hora_fim 		AS HORA_FIM_CONSULTA, 
			C.valor 		AS VALOR_CONSULTA
		  FROM medicos AS M, consultas AS c, pacientes AS p
		 WHERE M.id_medico  = C.id_medico 
		   AND P.id_paciente = C.id_paciente
		   AND C.id_user = id_user
           AND C.estado = true
		   AND C.data_consulta >= data_inicial
		   AND C.data_consulta <= data_final;
    END $$
$$
DELIMITER ;

CALL relatorio('2021-02-01', '2021-02-01', 1);

END;

DELIMITER $
CREATE TRIGGER hist_cons
AFTER INSERT ON consultas FOR EACH ROW
BEGIN
	INSERT INTO historico_consultas(data_cons,id_med,id_pac)
	VALUES (data_consulta,id_medico,id_paciente);
END $

# index na tabela médicos sobre a coluna especialização
CREATE INDEX med_especializacao
ON medicos(especializacao);
SHOW INDEX FROM medicos;

# index na tabela pacientes sobre as colunas endereço e cidade
CREATE INDEX pac_localizacao
ON pacientes(endereco,cidade);
SHOW INDEX FROM pacientes;


