create database lotoplusdb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

use lotoplusdb;

/*
usuarios. Se almacenarán los datos de los usuarios registrados en la aplicación. Los datos relevantes para cada usuario serán:
======================================================
idusuario: Identificador de usuario (valor auto-incremental, clave primaria)
nombre: Nombre real del usuario
apellidos: Apellidos del usuario
nomusu: Nombre de usuario del usuario 
clave: Contraseña (se debe almacenar encriptada, con la función password_hash() y comprobada con password_verify())
email: Email del usuario
tel: teléfono móvil del usuario
ganancias: Importe inicial de las ganancias del usuario en el momento de darse de alta en la plataforma
fechanac: Fecha de nacimiento
imgusu: Imagen de perfil del usuario
tipocu: Tipo de cuenta (Gratuita | Suscripción)
marketing: Permite marketing (S | N)
tipousu: Tipo de usuario (normal | administrador)
validada: Indica si la cuenta está validada (S | N)

*/
create table usuarios(
idusuario int unsigned primary key auto_increment,
nombre varchar(40) NOT NULL,
apellidos varchar(60) NOT NULL,
nomusu varchar(30) NOT NULL UNIQUE, 
clave varchar(255) NOT NULL,
email varchar(100) NOT NULL,
tel varchar(9) NOT NULL,
ganancias decimal DEFAULT 0,
fechanac date NOT NULL,
imgusu varchar(200),
tipocu varchar(20) DEFAULT "Gratuita",
marketing char(1) DEFAULT "S",
tipousu char(1) DEFAULT "n",
validada char(1) DEFAULT 'S'
) engine=innodb;

INSERT into usuarios(nombre, apellidos, nomusu, clave, email, tel, ganancias, fechanac, imgusu, tipocu, marketing, tipousu, validada) values("Administrador", "", "Administrador", "$2y$10$zgqn1T/ggxybdqes8muVCOHfYlE0oAuTjVGxXIGQCsDzw5pDXkbui", "administracionlotoplus@gmail.com", "968578433", 0, "1970-01-01", "Sin foto", "Suscripción", "S", "A", "S");

/*
sorteos. Se almacenará la información de los sorteos
======================================================
idsorteo: Identificador de sorteo (valor auto-incremental, clave primaria)
nsorteo: Identificador público del sorteo. Será el identificador que se empleará en el documento XML que debe procesar la aplicación para gestionar las participaciones premiadas
fsorteo: Fecha en la que se celebra el sorteo
descrip: Descripción del sorteo

*/
create table sorteos(
idsorteo int unsigned primary key auto_increment,
nsorteo varchar(100) NOT NULL unique,
fsorteo date NOT NULL,
descrip VARCHAR(300)
) engine=innodb;

/*
premios. Se almacenará la información de los premios
=====================================================
idpremio: Identificador del premio (valor auto-incremental, clave primaria)
idsorteo: Identificador de sorteo (clave ajena que apunta a la tabla sorteos)
numero: número premiado
premio: Importe correspondiente al número premiado, por euro (por ejemplo, si el premio es de 10 € por euro, a una participación de 5 € que resulte premiada,  le corresponderá un premio de 5x10 = 50€)
 
*/
create table premios(
idpremio int unsigned primary key auto_increment,
idsorteo int unsigned,
numero int unsigned NOT NULL,
premio decimal DEFAULT 0,
FOREIGN KEY (idsorteo) References sorteos(idsorteo)
) engine=innodb;

/*
participaciones. Se almacenará la información de las participaciones de los usuarios (por simplificación, la información relevante de una participación será sólo el número, no teniendo en cuenta la serie ni la fracción)
=====================================================================================
idpart: Identificador de la participación (valor auto-incremental, clave primaria)
idprop: Identificador del usuario al que pertenece la participación (clave ajena que apunta a la tabla usuarios)
idsorteo: Identificador del sorteo al que pertenece la participación (clave ajena que apunta a la tabla sorteos)
numero: número de la participación (con la que se participa en el sorteo)
importe: Importe jugado en la participación
captura: Imagen (nombre del fichero) fotografiada o escaneada de la participación. El alumno puede decidir si aceptar distintos formatos o sólo uno (PDF, PNG, JPG, GIF, etc.)
*/
create table participaciones(
idpart int unsigned primary key auto_increment,
idprop int unsigned NOT NULL,
idsorteo int unsigned NOT NULL,
numero int unsigned NOT NULL,
importe decimal DEFAULT 0,
captura VARCHAR(200),
FOREIGN KEY (idprop) References usuarios(idusuario),
FOREIGN KEY (idsorteo) References sorteos(idsorteo)
) engine=innodb;