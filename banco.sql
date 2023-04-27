CREATE TABLE nutricionista (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  telefone VARCHAR(20),
  celular VARCHAR(20),
  crn VARCHAR(10),
  endereco VARCHAR(150),
  senha VARCHAR(255) NOT NULL,
  horario_inicio TIME,
  horario_fim TIME,
  dias_semana VARCHAR(100)
);


CREATE TABLE paciente (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  senha VARCHAR(255) NOT NULL,
  altura FLOAT NOT NULL,
  peso FLOAT NOT NULL,
  data_nascimento DATE NOT NULL,
  idade INT(11) NOT NULL,
  sexo VARCHAR(20) NOT NULL,
  objetivo VARCHAR(50) NOT NULL,
  nutricionista_id INT(11) UNSIGNED NOT NULL,
  FOREIGN KEY (nutricionista_id) REFERENCES nutricionista(id) ON DELETE CASCADE
);

CREATE TABLE consulta (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  data DATE NOT NULL,
  horario TIME NOT NULL,
  paciente_id INT(11) UNSIGNED NOT NULL,
  nutricionista_id INT(11) UNSIGNED NOT NULL,
  realizada BOOLEAN NOT NULL DEFAULT false,
  descricao VARCHAR(100) NOT NULL,
  FOREIGN KEY (paciente_id) REFERENCES paciente(id) ON DELETE CASCADE,
  FOREIGN KEY (nutricionista_id) REFERENCES nutricionista(id) ON DELETE CASCADE
);

CREATE TABLE info_nutri (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    IMC FLOAT NOT NULL,
    proteinas FLOAT NOT NULL,
    carboidratos FLOAT NOT NULL,
    gorduras FLOAT NOT NULL,
    taxa_metabolica FLOAT NOT NULL,
    GCD FLOAT NOT NULL,
    resultado VARCHAR(255) NOT NULL,
    paciente_id INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (paciente_id) REFERENCES paciente(id) ON DELETE CASCADE,
    data DATE NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE dietas_receitas (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT(11) UNSIGNED NOT NULL,
    nome VARCHAR(255) NOT NULL,
    objetivo VARCHAR(255) NOT NULL,
    data_validade DATE NOT NULL,
    segunda VARCHAR(255),
    terca VARCHAR(255),
    quarta VARCHAR(255),
    quinta VARCHAR(255),
    sexta VARCHAR(255),
    sabado VARCHAR(255),
    domingo VARCHAR(255),
    FOREIGN KEY (paciente_id) REFERENCES paciente(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
