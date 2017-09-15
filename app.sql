CREATE TABLE en_count(
  id_count BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  tipo LONGTEXT NOT NULL,
  data TIMESTAMP NOT NULL,
  ip TEXT,
  id_referencia INT
);

CREATE TABLE audit_en_request(
  id_request BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  request_method TEXT NOT NULL,
  content LONGTEXT,
  url LONGTEXT NOT NULL,
  content_type TEXT,
  ip TEXT NOT NULL,
  token LONGTEXT,
  id_usuario INTEGER,
  origin LONGTEXT,
  user_agent LONGTEXT,
  headers LONGTEXT,
  data TIMESTAMP NOT NULL
);

CREATE TABLE en_contato(
  id_contato INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome TEXT NOT NULL,
  email TEXT NOT NULL,
  mensagem LONGTEXT NOT NULL,
  lido BOOLEAN DEFAULT FALSE,
  ip_endereco TEXT,
  status TEXT NOT NULL,
  data_criacao TIMESTAMP NOT NULL
);

#05-02-2017
ALTER TABLE en_count ADD COLUMN referrer TEXT;
ALTER TABLE en_count ADD COLUMN code TEXT;

CREATE TABLE en_count_code(
  id_count_code INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  code TEXT NOT NULL,
  nome TEXT NOT NULL,
  descricao TEXT
);