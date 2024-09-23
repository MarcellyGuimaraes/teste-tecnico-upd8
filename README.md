<h1>TESTE TÉCNICO UPD8</h1>

SQLS PARA CONSULTA NO BANCO DE DADOS
1. Script SQL para retornar todos os representantes que podem atender a um cliente, dado o ID do cliente:
sql
Copiar código
SELECT r.representante_id, r.rep_nome
FROM representantes r
JOIN representante_cliente rc ON r.representante_id = rc.representante_id
WHERE rc.cliente_id = ?; -- Substitua '?' pelo ID do cliente desejado
2. Script SQL para retornar todos os representantes de uma determinada cidade, dado o ID da cidade:
sql
Copiar código
SELECT r.representante_id, r.rep_nome
FROM representantes r
JOIN representante_cidade rc ON r.representante_id = rc.representante_id
WHERE rc.cidade_id = ?; -- Substitua '?' pelo ID da cidade desejada
3. DDL completo da base de dados:
Aqui está o DDL que você já forneceu, que pode ser salvo em um arquivo:

sql
Copiar código
CREATE TABLE `estados` (
  `estado_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `est_nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est_sigla` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`estado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `representantes` (
  `representante_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rep_nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`representante_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cidades` (
  `cidade_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cid_nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cidade_id`),
  KEY `cidades_estado_id_foreign` (`estado_id`),
  CONSTRAINT `cidades_estado_id_foreign` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`estado_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5571 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `clientes` (
  `cliente_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cli_cpf` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cli_nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cli_nascimento` date NOT NULL,
  `cli_sexo` enum('M','F') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cli_endereco` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade_id` bigint(20) unsigned NOT NULL,
  `estado_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cliente_id`),
  UNIQUE KEY `clientes_cli_cpf_unique` (`cli_cpf`),
  KEY `clientes_cidade_id_foreign` (`cidade_id`),
  KEY `clientes_estado_id_foreign` (`estado_id`),
  CONSTRAINT `clientes_cidade_id_foreign` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`cidade_id`) ON DELETE CASCADE,
  CONSTRAINT `clientes_estado_id_foreign` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`estado_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `representante_cidade` (
  `representante_id` bigint(20) unsigned NOT NULL,
  `cidade_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`representante_id`,`cidade_id`),
  KEY `representante_cidade_cidade_id_foreign` (`cidade_id`),
  CONSTRAINT `representante_cidade_cidade_id_foreign` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`cidade_id`) ON DELETE CASCADE,
  CONSTRAINT `representante_cidade_representante_id_foreign` FOREIGN KEY (`representante_id`) REFERENCES `representantes` (`representante_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `representante_cliente` (
  `representante_id` bigint(20) unsigned NOT NULL,
  `cliente_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`representante_id`,`cliente_id`),
  KEY `representante_cliente_cliente_id_foreign` (`cliente_id`),
  CONSTRAINT `representante_cliente_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE CASCADE,
  CONSTRAINT `representante_cliente_representante_id_foreign` FOREIGN KEY (`representante_id`) REFERENCES `representantes` (`representante_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;