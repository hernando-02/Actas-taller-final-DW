CREATE DATABASE `taller_actas`;

USE taller_actas;

CREATE TABLE usuarios(
	id int AUTO_INCREMENT NOT NULL,
	username varchar(50) NOT NULL,
	password varchar(50) NOT NULL,
	nombres varchar(200) NOT NULL,
	apellidos varchar(200) NOT NULL,
	tipo_id int,
	primary key(id)

);

ALTER TABLE usuarios MODIFY COLUMN password varchar(255) NOT NULL;

CREATE TABLE actas(
	id int AUTO_INCREMENT NOT NULL,
	creador_id int NOT NULL,
	asunto varchar(200) NOT NULL,
	fecha_creacion varchar(45) NOT NULL,
	hora_inicio time NOT NULL,
	hora_final time NOT NULL,
	responsable_id int NOT NULL,
	orden_del_dia text NOT NULL,
	descripcion_hechos text NOT NULL,
	primary key(id),
	FOREIGN key (creador_id) REFERENCES usuarios(id),
	FOREIGN key (responsable_id) REFERENCES usuarios(id)

);

CREATE TABLE compromisos(
	id int AUTO_INCREMENT NOT NULL,
	acta_id int NOT NULL,
	responsable_id int NOT NULL,
	descripcion text NOT NULL,
	fecha_inicio date NOT NULL,
	fecha_final date NOT NULL,
	primary key(id),
	FOREIGN key (acta_id) REFERENCES actas(id),
	FOREIGN key (responsable_id) REFERENCES usuarios(id)

);

-- se borra foreign key para poder eliminar en cascada
ALTER TABLE compromisos DROP FOREIGN KEY compromisos_ibfk_1;

-- se crea nueva foreign key para poder eliminar  en cascada
ALTER  TABLE compromisos ADD CONSTRAINT compromisos_ibfk_1 FOREIGN KEY(acta_id) REFERENCES actas(id) ON DELETE CASCADE;


CREATE TABLE asistentes(
	id int AUTO_INCREMENT NOT NULL,
	acta_id int NOT NULL,
	asistente_id int NOT NULL,
	primary key(id),
	FOREIGN key(acta_id) REFERENCES actas(id),
	FOREIGN KEY(asistente_id) REFERENCES usuarios(id)
);

-- se borra foreign key para poder eliminar en cascada
ALTER TABLE asistentes DROP FOREIGN KEY asistentes_ibfk_1;

-- se crea nueva foreign key para poder eliminar  en cascada
ALTER TABLE asistentes ADD CONSTRAINT asistentes_ibfk_1 FOREIGN KEY(acta_id) REFERENCES actas(id) ON DELETE CASCADE;

-- ---------------------------------------------------
-- ---------------------------------------------------
-- ---------------------------------------------------
-- poblado de tablas

-- usuarios
INSERT INTO	usuarios (
	username,
	password,
	nombres,
	apellidos,
	tipo_id
	)
VALUES 
(
	'jose',
	'123456',
	'jose manuel',
	'blanco marquez',
	'1'
),
(
	'carla',
	'123456',
	'carla sofia',
	'negro perez',
	'1'
),
(
	'maria',
	'123456',
	'maria salome',
	'caldera quintana',
	'1'
);

-- ----------------------------
-- actas 

INSERT INTO `actas` (`creador_id`, `asunto`, `fecha_creacion`, `hora_inicio`, `hora_final`, `responsable_id`, `orden_del_dia`, `descripcion_hechos`)
VALUES ('1', 'proyectos del programa', '2022-12-12', '17:38:15', '22:38:15', '2', 'debatir proyectos pendientes programa', 'se aclaró dudas acerca de los proyectos pendientes del programa de ingeniería de sistemas.');

INSERT INTO `actas` (`creador_id`, `asunto`, `fecha_creacion`, `hora_inicio`, `hora_final`, `responsable_id`, `orden_del_dia`, `descripcion_hechos`)
VALUES ('2', 'proyectos la facultad', '2022-12-12', '17:38:15', '22:38:15', '2', 'debatir proyectos pendientes facultad', 'se aclaró dudas acerca de los proyectos pendientes de la facultad de Ingenierías.');

INSERT INTO `actas` (`creador_id`, `asunto`, `fecha_creacion`, `hora_inicio`, `hora_final`, `responsable_id`, `orden_del_dia`, `descripcion_hechos`)
VALUES ('2', 'proyectos del semillero', '2022-12-14', '09:28:21', '18:28:25', '2', 'debatir proyectos pendientes semillero', 'se aclaró dudas acerca de los proyectos pendientes del semillero de computación cuántica.');


-- compromisos 
INSERT INTO `compromisos` (`acta_id`, `responsable_id`, `descripcion`, `fecha_inicio`, `fecha_final`)
VALUES ('1', '1', 'llenar la hoja de asistencia', '2022-12-11', '2022-12-12');

INSERT INTO `compromisos` (`acta_id`, `responsable_id`, `descripcion`, `fecha_inicio`, `fecha_final`)
VALUES ('1', '1', 'plantear los nuevos proyectos', '2022-12-12', '2022-12-13');

INSERT INTO `compromisos` (`acta_id`, `responsable_id`, `descripcion`, `fecha_inicio`, `fecha_final`)
VALUES ('2', '2', 'entregar primeros detalles al los profesores', '2022-12-15', '2022-12-19');

-- asistentes 
INSERT INTO `asistentes` (`acta_id`, `asistente_id`) VALUES ('1', '2');
INSERT INTO `asistentes` (`acta_id`, `asistente_id`) VALUES ('2', '2');
INSERT INTO `asistentes` (`acta_id`, `asistente_id`) VALUES ('3', '3');
