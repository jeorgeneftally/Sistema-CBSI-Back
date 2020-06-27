CREATE DATABASE IF NOT EXISTS DBCBSI;
USE DBCBSI;

CREATE TABLE compañias(
id                  int(255) auto_increment NOT NULL,
nombre              varchar(255),
descripcion         varchar(255),
lema                varchar(255),
fecha_fundacion     date,
imagen_logo         varchar(255),
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_compañias PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE roles(
id                  int(255) auto_increment NOT NULL,
rol                 varchar(255),
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_roles PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE mallas(
id                  int(255) auto_increment NOT NULL,
nombre              varchar(255),
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_mallas PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE conductores(
id                  int(255) auto_increment NOT NULL,
habilitado          int(255),
nomeclatura         int(255),    
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_conductores PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE users(
id                  int(255) auto_increment NOT NULL,
name                varchar(50) NOT NULL,
surname             varchar(100),
email               varchar(255) NOT NULL,
password            varchar(255) NOT NULL,
image               varchar(255),
profesion           varchar(255),
rut                 varchar(255) NOT NULL,
fecha_nacimiento    date,
fecha_ingreso       date,
direccion           varchar(255),
telefono            varchar(255),
talla_calzado       varchar(255),
talla_ropa          varchar(255), 
cargo               varchar(255), 
numero_registro     int(255),  
servicio            varchar(50) NOT NULL,
estado              varchar(50) NOT NULL,
rol_id              int(255) NOT NULL,
compañia_id         int(255) NOT NULL,
malla_id            int(255) NOT NULL,
conductor_id        int(255) NOT NULL,
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
remember_token      varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id),
CONSTRAINT fk_user_compañia FOREIGN KEY(compañia_id) REFERENCES compañias(id),
CONSTRAINT fk_user_rol FOREIGN KEY(rol_id) REFERENCES roles(id),
CONSTRAINT fk_user_malla FOREIGN KEY(malla_id) REFERENCES mallas(id),
CONSTRAINT fk_user_conductor FOREIGN KEY(conductor_id) REFERENCES conductores(id)
)ENGINE=InnoDb;



CREATE TABLE materialmenors(
id                  int(255) auto_increment NOT NULL,
nombre              varchar(255),
descripcion         varchar(255),
compañia_id         int(255) NOT NULL,
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_materialmenors PRIMARY KEY(id),
CONSTRAINT fk_materialmenor_compañia FOREIGN KEY(compañia_id) REFERENCES compañias(id)
)ENGINE=InnoDb;

CREATE TABLE bodegas(
id                  int(255) auto_increment NOT NULL,
nombre              varchar(255),
descripcion         varchar(255),
compañia_id         int(255),
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_bodegas PRIMARY KEY(id),
CONSTRAINT fk_bodega_compañia FOREIGN KEY(compañia_id) REFERENCES compañias(id)
)ENGINE=InnoDb;

CREATE TABLE materialmayors(
id                  int(255) auto_increment NOT NULL,
nombre              varchar(255),
descripcion         varchar(255),
fecha_creacion      varchar(255),
capacidad           varchar(255),
chasis              varchar(255),
motor               varchar(255),
patente             varchar(255),
marca               varchar(255),
modelo              varchar(255),
estado              varchar(255),
imagen              varchar(255),
compañia_id         int(255), 
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_materialmayors PRIMARY KEY(id),
CONSTRAINT fk_materialmayor_compañia FOREIGN KEY(compañia_id) REFERENCES compañias(id)
)ENGINE=InnoDb;

CREATE TABLE autorizados(
id                  int(255) auto_increment NOT NULL,
fecha               date,
materialmayor_id    int(255) NOT NULL,
user_id             int(255) NOT NULL,
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_autorizados PRIMARY KEY(id),
CONSTRAINT fk_autorizado_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_autorizado_materialmayor FOREIGN KEY(materialmayor_id) REFERENCES materialmayors(id)

)ENGINE=InnoDb;

CREATE TABLE detallesbs(
id                  int(255) auto_increment NOT NULL,
talla               varchar(255),
estado              varchar(255),      
user_id             int(255),    
materialmenor_id    int(255),    
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_detallesbs PRIMARY KEY(id),
CONSTRAINT fk_detallesb_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_detallesb_materialmenor FOREIGN KEY(materialmenor_id) REFERENCES materialmenors(id)
)ENGINE=InnoDb;

CREATE TABLE detallesmats(
id                  int(255) auto_increment NOT NULL,
talla               varchar(255),
estado              varchar(255),      
materialmayor_id    int(255),    
materialmenor_id    int(255),    
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_detallesmats PRIMARY KEY(id),
CONSTRAINT fk_detallesmat_materialmayor FOREIGN KEY(materialmayor_id) REFERENCES materialmayors(id),
CONSTRAINT fk_detallesmat_materialmenor FOREIGN KEY(materialmenor_id) REFERENCES materialmenors(id)
)ENGINE=InnoDb;


CREATE TABLE detallesbods(
id                  int(255) auto_increment NOT NULL,
talla               varchar(255),
estado              varchar(255),      
bodega_id           int(255),    
materialmenor_id    int(255),    
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_detallesbods PRIMARY KEY(id),
CONSTRAINT fk_detallesbod_bodega FOREIGN KEY(bodega_id) REFERENCES bodegas(id),
CONSTRAINT fk_detallesbod_materialmenor FOREIGN KEY(materialmenor_id) REFERENCES materialmenors(id)
)ENGINE=InnoDb;


CREATE TABLE mantenciones(
id                  int(255) auto_increment NOT NULL,
descripcion         varchar(255),
taller              varchar(255),
nombre_mecanico     varchar(255),
fecha               date,
proxima_fecha       date,
materialmayor_id    int(255),    
user_id             int(255),    
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_mantenciones PRIMARY KEY(id),
CONSTRAINT fk_mantencion_materialmayor FOREIGN KEY(materialmayor_id) REFERENCES materialmayors(id),
CONSTRAINT fk_mantencion_user FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

CREATE TABLE revisiones(
id                  int(255) auto_increment NOT NULL,
descripcion         varchar(255),
ubicacion           varchar(255),
nombre              varchar(255),
fecha               date,
proxima_fecha       date,
materialmayor_id    int(255),    
user_id             int(255),    
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_revisiones PRIMARY KEY(id),
CONSTRAINT fk_revision_materialmayor FOREIGN KEY(materialmayor_id) REFERENCES materialmayors(id),
CONSTRAINT fk_revision_user FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;





